<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
    function __construct() {
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('Users_Model');
		$this->load->model('Categories_Model');
		$this->load->model('Listings_Model');
		$this->load->library('image_lib');
    }

    private function check_login($location = ''){
		if (volgo_front_is_logged_in() && empty($location)) {
			$this->session->set_flashdata('volgo_redirecting', true);

			header('Location: ' . base_url());
		}else if (! empty($location) && volgo_front_is_logged_in()){
			$this->session->set_flashdata('volgo_redirecting', true);

			header('Location: ' . $location);
		}else if (! empty($location)){
			redirect('login?redirected_to=' . $location);
		}else {
			redirect('login');
		}
	}


    public function index()
    {
        $this->check_login();
    }

	public function ajax__get_states_by_country_id()
	{
		$posted_data = filter_input_array(INPUT_POST);

		if (! $this->input->is_ajax_request() || !isset($posted_data['country_id'])) {
			exit('No direct script access allowed');
		}

		if (! intval($posted_data['country_id'])){
			echo json_encode(
				[
					'status' => 'error'
				]
			);
			exit;
		}

		$states_std_arr = volgo_get_states_by_country_id($posted_data['country_id']);
		$states = [];
		foreach ($states_std_arr as $state){
			$states[] = (array) $state;
		}

		echo json_encode($states);
		exit;
    }
	public function ajax__get_cityes_by_country_id()
	{
		$posted_data = filter_input_array(INPUT_POST);

		if (! $this->input->is_ajax_request() || !isset($posted_data['country_id'])) {
			exit('No direct script access allowed');
		}

		if (! intval($posted_data['country_id'])){
			echo json_encode(
				[
					'status' => 'error'
				]
			);
			exit;
		}

		$states_std_arr = volgo_get_states_by_country_id($posted_data['country_id']);
		$states = [];
		foreach ($states_std_arr as $state){
			$states[] = (array) $state;
		}

		echo json_encode($states);
		exit;
	}
	public function ajax__get_cities_by_state_id()
	{
		$posted_data = filter_input_array(INPUT_POST);

		if (! $this->input->is_ajax_request() || !isset($posted_data['state_id'])) {
			exit('No direct script access allowed');
		}

		if (! intval($posted_data['state_id'])){
			echo json_encode(
				[
					'status' => 'error'
				]
			);
			exit;
		}

		$cities_std_arr = volgo_get_cities_by_state_id($posted_data['state_id']);
		$cities = [];
		foreach ($cities_std_arr as $city){
			$cities[] = (array) $city;
		}

		echo json_encode($cities);
		exit;
    }

	public function ajax__get_form_by_sub_cat()
	{
		$posted_data = filter_input_array(INPUT_POST);

		if (! $this->input->is_ajax_request() || !isset($posted_data['sub_cat_id'])) {
			exit('No direct script access allowed');
		}

		if (! intval($posted_data['sub_cat_id'])){
			echo json_encode(
				[
					'status' => 'error'
				]
			);
			exit;
		}


		$categories_std_arr = $this->Categories_Model->get_form_by_sub_cat_id($posted_data['sub_cat_id']);
		if (empty($categories_std_arr))
			$categories = [];
		else
			$categories = $categories_std_arr->meta_value;

		echo json_encode($categories);
		exit;
    }

	public function ajax__get_sub_cats_by_category_id()
	{
		$posted_data = filter_input_array(INPUT_POST);

		if (! $this->input->is_ajax_request() || !isset($posted_data['cat_id'])) {
			exit('No direct script access allowed');
		}

		if (! intval($posted_data['cat_id'])){
			echo json_encode(
				[
					'status' => 'error'
				]
			);
			exit;
		}

		$cats_std_arr = $this->Categories_Model->get_child_cats_by_parent_id($posted_data['cat_id'], 'name');
		$categories = [];
		foreach ($cats_std_arr as $cats){
			$categories[] = (array) $cats;
		}

		echo json_encode($categories);
		exit;
    }

	public function add_post()
	{

		if (! volgo_front_is_logged_in()){
			redirect('login?redirected_to=' . base_url('ad-post'));
		}

		$data = [
			'countries'	=> volgo_get_countries(),
			'states'	=> volgo_get_states_by_country_id(volgo_get_country_id_from_session()),
			'post_categories'	=> $this->Categories_Model->get_parent_categories_for_add_post('name')
		];

		$posted_data = filter_input_array(INPUT_POST);

		if (! empty($posted_data)){

			$this->load->library('upload');
			$dataInfo = array();
			$files = $_FILES;

			$is_error_occurr = false;
			if (isset($_FILES['input_images']) && !empty($_FILES['input_images']['name'][0])) {
				$cpt = count($_FILES['input_images']['name']);

				for ($i = 0; $i < $cpt; $i++) {
					$_FILES['userfile']['name'] = $files['input_images']['name'][$i];
					$_FILES['userfile']['type'] = $files['input_images']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['input_images']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['input_images']['error'][$i];
					$_FILES['userfile']['size'] = $files['input_images']['size'][$i];

					$this->upload->initialize($this->set_upload_options());
					$this->upload->do_upload();
					$dataInfo[] = $this->upload->data();
				}
				/*
                 *
                 * CHECK IF ANY IMAGE HAS ISSUE WITH HEIGHT AND WIDTH
                 *
                 * */
				foreach ($dataInfo as $key => $value) {

					if ($value['image_width'] === null || ($value['image_height'] === null)) {
						$is_error_occurr = true;
						break;
					}
				}
				if ($is_error_occurr) {
					$data ['validation_errors'] = '<strong>Sorry: </strong>Image height and width should be 400 X 400. Try Again';
					$this->load->view('frontend/postform/post_form', $data);

					return;
				}

				/*
                 *
                 * PUT WATER MARK ON ALL IMAGES.
                 *
                 * */
				foreach ($dataInfo as $key => $value) {
					$return_val = $this->overlayWatermark($value['full_path']);
					if (is_array($return_val)) {
						$is_error_occurr = true;
						break;
					}
				}
				if ($is_error_occurr) {
					$data ['validation_errors'] = '<strong>Sorry: </strong> ' . $return_val['errors'];
					$this->load->view('frontend/postform/post_form', $data);

					return;
				}
			}

			$imagesname = [];
			foreach ($dataInfo as $key => $value) {
				$imagesname[] = $value['file_name'];
			}

			$posted_data['images_from'] = serialize($imagesname);

			$this->form_validation->set_rules('input_title', 'Title', 'required|min_length[3]|max_length[255]');
			$this->form_validation->set_rules('input_description', 'Description', 'required');

			$this->form_validation->set_rules('input_country', 'Select Country', 'required|min_length[1]');
			$this->form_validation->set_rules('input_state', 'Select State', 'required|min_length[1]');
			$this->form_validation->set_rules('input_city', 'Select City', 'required|min_length[1]');
			$this->form_validation->set_rules('input_category', 'Select Category', 'required|min_length[1]');
			$this->form_validation->set_rules('input_subcategory', 'Select Sub Category', 'required|min_length[1]');
			$this->form_validation->set_rules('listing_type', 'Listing Type', 'required');

			if ($this->form_validation->run() !== FALSE){

				// Defaults
				$cv_data_info = [];
				$posted_data['cv_upload'] = '';
				$posted_data['cv_upload_full_info'] = serialize([]);


				if (isset($_FILES['cv_upload']) && !empty($_FILES['cv_upload'])){

					$_FILES['userfile']['name'] = $_FILES['cv_upload']['name'];
					$_FILES['userfile']['type'] = $_FILES['cv_upload']['type'];
					$_FILES['userfile']['tmp_name'] = $_FILES['cv_upload']['tmp_name'];
					$_FILES['userfile']['error'] = $_FILES['cv_upload']['error'];
					$_FILES['userfile']['size'] = $_FILES['cv_upload']['size'];

					$path = BACKEND_PATH . 'uploads/cvs/';
					$config['allowed_types'] = 'pdf|doc|docx';
					$config['upload_path'] = $path;
					$config['max_size']    = '15000000';

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					$this->upload->do_upload();


					if ( ! $this->upload->do_upload()) {
						$data ['validation_errors'] = '<strong>Sorry: </strong> Unable to upload CV. Kindly Try Again.';
						$this->load->view('frontend/postform/post_form', $data);

						return;
					}else {
						/*
						 * array (
								  'file_name' => 'javed_wasim.doc',
								  'file_type' => 'application/msword',
								  'file_path' => 'D:/development/laragon/www/B2BClassified-Local/admin2/uploads/cvs/',
								  'full_path' => 'D:/development/laragon/www/B2BClassified-Local/admin2/uploads/cvs/javed_wasim.doc',
								  'raw_name' => 'javed_wasim',
								  'orig_name' => 'javed_wasim.doc',
								  'client_name' => 'javed_wasim.doc',
								  'file_ext' => '.doc',
								  'file_size' => 60.5,
								  'is_image' => false,
								  'image_width' => NULL,
								  'image_height' => NULL,
								  'image_type' => '',
								  'image_size_str' => '',
								)
						 *
						 *
						 * */
						$cv_data_info = $this->upload->data();

						$posted_data['cv_upload'] = $cv_data_info['file_name'];
						$posted_data['cv_upload_full_info'] = serialize($cv_data_info);
					}
				}

				// SET CURRENCY
                $row = $this->db->select('unit')->from('currencies')->where('country_id', intval($posted_data['input_country']))->get()->row();

                if(!empty($row)){
                    $posted_data['currency_code'] =  $row->unit;
                }else {
                    $posted_data['currency_code'] =  '';
                }


				$is_saved = $this->Listings_Model->save_lisiting_and_meta($posted_data);

				if ($is_saved){
					$this->session->set_flashdata('success_msg', '<p><strong>Thank You! </strong><br />Your ad has been successfully submitted</p>');
					$this->session->set_flashdata('warning_msg', '<p><strong>Note! </strong><br />Your ad is pending for approval.</p>');
					redirect('ad-post');
				}else {
					$data ['validation_errors']	= '<strong>Error: </strong><br />Unable to save the ad. Kindly retry. If problem persists then kindly contact to administrator. Thank You';
					$this->load->view('frontend/postform/post_form', $data);
				}
			}else {
				$data ['validation_errors']	= validation_errors();
				$this->load->view('frontend/postform/post_form', $data);
			}
		}else {
			$this->load->view('frontend/postform/post_form', $data);
		}
    }

	private
	function set_upload_options()
	{
		//upload an image options
		$config = array();
		$config['upload_path'] = BACKEND_PATH . 'uploads/listing_images/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['min_width'] = '290';
		$config['min_height'] = '200';

		return $config;
	}

	public function overlayWatermark($source_image)
	{
		$config['image_library'] = 'gd2';
		$config['source_image'] = $source_image;
		$config['wm_type'] = 'overlay';
		//$config['wm_padding'] = '5';
		$config['wm_overlay_path'] = BACKEND_PATH . 'assets/img/watermark-logo.png';
		//the overlay image
		$config['wm_opacity'] = 80;
		$config['wm_vrt_alignment'] = 'bottom';
		$config['wm_hor_alignment'] = 'right';

		$this->image_lib->initialize($config);
		if (!$this->image_lib->watermark()) {
			return [
				'status' => 'error',
				'errors' => $this->image_lib->display_errors()
			];
		}

		return true;
	}

	public function add_buying_lead()
	{
		if (! volgo_front_is_logged_in()){
			redirect('login?redirected_to=' . base_url('add-buying-lead'));
			exit;
		}

		$data = [
			'countries'	=> volgo_get_countries(),
			'states'	=> volgo_get_states_by_country_id(volgo_get_country_id_from_session()),
			'buying_lead_parent_cats'	=> $this->Categories_Model->get_buying_lead_parent_cats('name')
		];

		$posted_data = filter_input_array(INPUT_POST);

		if (! empty($posted_data)){

			$this->load->library('upload');
			$dataInfo = array();
			$files = $_FILES;

			$is_error_occurr = false;
			if (isset($_FILES['input_images']) && !empty($_FILES['input_images']['name'])) {
				$cpt = count($_FILES['input_images']['name']);
				for ($i = 0; $i < $cpt; $i++) {
					$_FILES['userfile']['name'] = $files['input_images']['name'][$i];
					$_FILES['userfile']['type'] = $files['input_images']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['input_images']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['input_images']['error'][$i];
					$_FILES['userfile']['size'] = $files['input_images']['size'][$i];

					$this->upload->initialize($this->set_upload_options());
					$this->upload->do_upload();
					$dataInfo[] = $this->upload->data();
				}
				/*
                 *
                 * CHECK IF ANY IMAGE HAS ISSUE WITH HEIGHT AND WIDTH
                 *
                 * */
				foreach ($dataInfo as $key => $value) {

					if ($value['image_width'] === null || ($value['image_height'] === null)) {
						$is_error_occurr = true;
						break;
					}
				}
				if ($is_error_occurr) {
					$data ['validation_errors'] = '<strong>Sorry: </strong>Unable to get height and width of image. Try Again';
					$this->load->view('frontend/buying-lead/add', $data);

					return;
				}

				/*
                 *
                 * PUT WATER MARK ON ALL IMAGES.
                 *
                 * */
				foreach ($dataInfo as $key => $value) {
					$return_val = $this->overlayWatermark($value['full_path']);
					if (is_array($return_val)) {
						$is_error_occurr = true;
						break;
					}
				}
				if ($is_error_occurr) {
					$data ['validation_errors'] = '<strong>Sorry: </strong> ' . $return_val['errors'];
					$this->load->view('frontend/buying-lead/add', $data);

					return;
				}
			}

			$imagesname = [];
			foreach ($dataInfo as $key => $value) {
				$imagesname[] = $value['file_name'];
			}

			$posted_data['images_from'] = serialize($imagesname);
			$posted_data['listing_type'] = 'buying_lead';


			$this->form_validation->set_rules('input_title', 'Title', 'required|min_length[3]|max_length[255]');
			$this->form_validation->set_rules('input_description', 'Description', 'required');
			$this->form_validation->set_rules('input_country', 'Select Country', 'required|min_length[1]');
			$this->form_validation->set_rules('input_state', 'Select State', 'required|min_length[1]');
			$this->form_validation->set_rules('input_city', 'Select City', 'required|min_length[1]');
			$this->form_validation->set_rules('input_category', 'Select Category', 'required|min_length[1]');
			$this->form_validation->set_rules('input_subcategory', 'Select Sub Category', 'required|min_length[1]');

			if ($this->form_validation->run() !== FALSE){
				$is_saved = $this->Listings_Model->save_lisiting_and_meta($posted_data);

				if ($is_saved){
					$this->session->set_flashdata('success_msg', '<p><strong>Thank You! </strong><br />Your ad has been successfully submitted</p>');
					$this->session->set_flashdata('warning_msg', '<p><strong>Note! </strong><br />Your ad is pending for approval.</p>');
					redirect('add-buying-lead');
				}else {
					$data ['validation_errors']	= '<strong>Error: </strong><br />Unable to save the ad. Kindly retry. If problem persists then kindly contact to administrator. Thank You';
					$this->load->view('frontend/buying-lead/add', $data);
				}
			}else {
				$data ['validation_errors']	= validation_errors();
				$this->load->view('frontend/buying-lead/add', $data);
			}
		}else {
			$this->load->view('frontend/buying-lead/add', $data);
		}
	}

	public function add_seller_lead()
	{
		if (! volgo_front_is_logged_in()){
			redirect('login?redirected_to=' . base_url('add-seller-lead'));
			exit;
		}

		$data = [
			'countries'	=> volgo_get_countries(),
			'states'	=> volgo_get_states_by_country_id(volgo_get_country_id_from_session()),
			'buying_lead_parent_cats'	=> $this->Categories_Model->get_seller_lead_parent_cats('name')
		];

		$posted_data = filter_input_array(INPUT_POST);

		if (! empty($posted_data)){

			$this->load->library('upload');
			$dataInfo = array();
			$files = $_FILES;

			$is_error_occurr = false;
			if (isset($_FILES['input_images']) && !empty($_FILES['input_images']['name'][0])) {
				$cpt = count($_FILES['input_images']['name']);
				for ($i = 0; $i < $cpt; $i++) {
					$_FILES['userfile']['name'] = $files['input_images']['name'][$i];
					$_FILES['userfile']['type'] = $files['input_images']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['input_images']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['input_images']['error'][$i];
					$_FILES['userfile']['size'] = $files['input_images']['size'][$i];

					$this->upload->initialize($this->set_upload_options());
					$this->upload->do_upload();
					$dataInfo[] = $this->upload->data();
				}
				/*
                 *
                 * CHECK IF ANY IMAGE HAS ISSUE WITH HEIGHT AND WIDTH
                 *
                 * */
				foreach ($dataInfo as $key => $value) {

					if ($value['image_width'] === null || ($value['image_height'] === null)) {
						$is_error_occurr = true;
						break;
					}
				}
				if ($is_error_occurr) {
					$data ['validation_errors'] = '<strong>Sorry: </strong>Unable to get height and width of image. Try Again';
					$this->load->view('frontend/seller-lead/add', $data);

					return;
				}

				/*
                 *
                 * PUT WATER MARK ON ALL IMAGES.
                 *
                 * */
				foreach ($dataInfo as $key => $value) {
					$return_val = $this->overlayWatermark($value['full_path']);
					if (is_array($return_val)) {
						$is_error_occurr = true;
						break;
					}
				}
				if ($is_error_occurr) {
					$data ['validation_errors'] = '<strong>Sorry: </strong> ' . $return_val['errors'];
					$this->load->view('frontend/seller-lead/add', $data);

					return;
				}
			}

			$imagesname = [];
			foreach ($dataInfo as $key => $value) {
				$imagesname[] = $value['file_name'];
			}

			$posted_data['images_from'] = serialize($imagesname);
			$posted_data['listing_type'] = 'seller_lead';


			$this->form_validation->set_rules('input_title', 'Title', 'required|min_length[3]|max_length[255]');
			$this->form_validation->set_rules('input_description', 'Description', 'required');
			$this->form_validation->set_rules('input_country', 'Select Country', 'required|min_length[1]');
			$this->form_validation->set_rules('input_state', 'Select State', 'required|min_length[1]');
			$this->form_validation->set_rules('input_city', 'Select City', 'required|min_length[1]');
			$this->form_validation->set_rules('input_category', 'Select Category', 'required|min_length[1]');
			$this->form_validation->set_rules('input_subcategory', 'Select Sub Category', 'required|min_length[1]');

			if ($this->form_validation->run() !== FALSE){
				$is_saved = $this->Listings_Model->save_lisiting_and_meta($posted_data);

				if ($is_saved){
					$this->session->set_flashdata('success_msg', '<p><strong>Thank You! </strong><br />Your ad has been successfully submitted</p>');
					$this->session->set_flashdata('warning_msg', '<p><strong>Note! </strong><br />Your ad is pending for approval.</p>');
					redirect('add-seller-lead');
				}else {
					$data ['validation_errors']	= '<strong>Error: </strong><br />Unable to save the ad. Kindly retry. If problem persists then kindly contact to administrator. Thank You';
					$this->load->view('frontend/seller-lead/add', $data);
				}
			}else {
				$data ['validation_errors']	= validation_errors();
				$this->load->view('frontend/seller-lead/add', $data);
			}
		}else {
			$this->load->view('frontend/seller-lead/add', $data);
		}
	}



	public function handle_fb_login()
	{
		$fb = new \Facebook\Facebook([
			'app_id' => FACEBOOK_APP_API,
			'app_secret' => FACEBOOK_APP_SECRET,
			'default_graph_version' => 'v3.2'
		]);

		$helper = $fb->getRedirectLoginHelper();
		if (isset($_GET['state'])) {
			$helper->getPersistentDataHandler()->set('state', $_GET['state']);
		}

		try {
			$accessToken = $helper->getAccessToken();
			$logout = $helper->getLogoutUrl($accessToken, base_url('login'));
			$data ['fb_logout_url'] = $logout;

		} catch (Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			log_message('error', ('Graph returned an error: ' . $e->getMessage()));
			redirect('404');
			exit;

		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			log_message('error', ('Facebook SDK returned an error: ' . $e->getMessage()));
			redirect('404');
			exit;
		}

		if (!isset($accessToken)) {
			if ($helper->getError()) {
				header('HTTP/1.0 401 Unauthorized');


				log_message('error', ("Error: " . $helper->getError()));
				log_message('error', ("Error Code: " . $helper->getErrorCode()));
				log_message('error', ("Error Reason: " . $helper->getErrorReason()));
				log_message('error', ("Error Description: " . $helper->getErrorDescription()));

				redirect('404');
			} else {
				header('HTTP/1.0 400 Bad Request');
				log_message('error', 'FB - Bad Request');
				redirect('404');
			}
			exit;
		}

		// Logged in

		// The OAuth 2.0 client handler helps us manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);

		try {
			// Get the \Facebook\GraphNodes\GraphUser object for the current user.
			// If you provided a 'default_access_token', the '{access-token}' is optional.
			$response = $fb->get('/me?fields=id,name,email', $accessToken);
		} catch(\Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		$me = $response->getGraphUser();
		$fb_user_name = $me->getName();
		$fb_user_email = $me->getEmail();
		$fb_user_id = $me->getId();

		$user = $this->Users_Model->get_user_by_email($fb_user_email);

		// Create User, Send welcome email and send password email.
		if (empty($user)){
			$is_created = $this->Users_Model->add_user_from_facebook($fb_user_email, $fb_user_name, $fb_user_id, $accessToken->getValue(), $tokenMetadata);
			if (! $is_created){

				log_message('error', '------------------------------------------------');
				log_message('error', 'Unable to create (Insert User) into database at time of facebook registration');
				log_message('error', '------------------------------------------------');

				redirect(404);
				return false;
			}

			$user_password = $this->session->userdata('facebook_user_password');
			if (!empty($user_password)){

				$mail = new \PHPMailer\PHPMailer\PHPMailer();
				// SMTP configuration
				try {
					$mail->isSMTP();
					$mail->Host = PHPMAILER_SENDER_HOST;
					$mail->SMTPAuth = PHPMAILER_SENDER_SMTPAUTH;
					$mail->Username = PHPMAILER_SENDER_USERNAME;
					$mail->Password = PHPMAILER_SENDER_PASSWORD;
					$mail->SMTPSecure = PHPMAILER_SENDER_SMTP_SECURE;
					$mail->Port = PHPMAILER_SENDER_PORT;

					$mail->setFrom(NEWSLETTER_FROM_EMAIL);
					// Email subject
					$mail->Subject = 'Your temporary Password |' . SITE_NAME;
					// Set email format to HTML
					$mail->isHTML(true);
					$mail->addAddress($fb_user_email, $fb_user_name);

					// @todo: create settings in Admin (Dashboard) Settings for dynamically.

					$html = "Hi, You are successfully registered with " . SITE_NAME . ' <br />';
					$html .= "Your password is : " . $user_password. ' <br />';
					$html .= "It is highly recommended that change the password.";
					$mail->Body = $html;

					$mail->send();
				} catch (Exception $e) {
					log_message('error', $mail->ErrorInfo);

					redirect(404);

					return false;
				}

				// Welcome Email

				$mail = new \PHPMailer\PHPMailer\PHPMailer();
				// SMTP configuration
				try {
					$mail->isSMTP();
					$mail->Host = PHPMAILER_SENDER_HOST;
					$mail->SMTPAuth = PHPMAILER_SENDER_SMTPAUTH;
					$mail->Username = PHPMAILER_SENDER_USERNAME;
					$mail->Password = PHPMAILER_SENDER_PASSWORD;
					$mail->SMTPSecure = PHPMAILER_SENDER_SMTP_SECURE;
					$mail->Port = PHPMAILER_SENDER_PORT;

					$mail->setFrom(NEWSLETTER_FROM_EMAIL);
					// Email subject
					$mail->Subject = 'Welcome |' . SITE_NAME;
					// Set email format to HTML
					$mail->isHTML(true);
					$mail->addAddress($fb_user_email, $fb_user_name);
					$mail->Body = EMAIL_NEW_USER_WELCOME_EMAIL;
					$mail->send();
				} catch (Exception $e) {
					log_message('error', $mail->ErrorInfo);
					redirect(404);
					return false;
				}

			}
		}


		$user_data = array(
			'username'	=> $fb_user_email,
			'login_from'	=> 'facebook',
			'access_token'	=> $accessToken->getValue(),
			'access_token_metadata'	=> $tokenMetadata,
			'is_logged_in'	=> true,
			'login_time'	=> time()
		);
		$sess_enc_data = volgo_encrypt_message($user_data);
		$this->session->set_userdata('volgo_user_login_data', $sess_enc_data);


		header('Location: ' . base_url());

    }

	private function get_facebook_login_url()
	{
		$fb = new \Facebook\Facebook([
			'app_id' => FACEBOOK_APP_API,
			'app_secret' => FACEBOOK_APP_SECRET,
			'default_graph_version' => 'v3.2'
		]);

		$helper = $fb->getRedirectLoginHelper();
		if (isset($_GET['state'])) {
			$helper->getPersistentDataHandler()->set('state', $_GET['state']);
		}


		$permissions = ['public_profile','email']; // Optional permissions
		return ($helper->getLoginUrl(base_url('users/handle_fb_login'), $permissions));
    }

    public function login()
    {
		$redirected_to = $this->input->get('redirected_to');



		$data = [
			'fb_login_url'	=> $this->get_facebook_login_url(),
			'fb_logout_url'	=> '#'

		];


		if (volgo_front_is_logged_in() && (volgo_get_cookie(VOLGO_COOKIE_BEFORE_PURCHASING_PACKAGE_INFO) !== NULL) && !empty($redirected_to)) {
            header('Location: ' . $redirected_to);
        }else if (volgo_front_is_logged_in() && !empty($redirected_to)) {
			header('Location: ' . $redirected_to);
		}else if (volgo_front_is_logged_in()){
			header('Location: ' . base_url());
        }else
			$this->load->view('frontend/users/user_login', $data);
    }

    public function forget_password()
    {
        if (volgo_front_is_logged_in()) {
            header('Location: ' . base_url());
        }else {
            $this->load->view('frontend/users/forget_password');
        }
    }

    public function logout()
    {
		$this->check_login();

        $this->session->unset_userdata('volgo_user_login_data');

		$this->session->set_flashdata('success_msg', "You are successfully loged out");
		redirect('login');
    }


    public function create_user()
    {
        if (volgo_front_is_logged_in()) {
            header('Location: ' . base_url());
        } else {
            $data = array(
                'validation_errors' => '',
                'success_msg' => '',
            );
            $input_data = filter_input_array(INPUT_POST);

            $this->form_validation->set_rules('username', 'User Name already exist', 'required|min_length[1]|is_unique[b2b_users.username]');
            $this->form_validation->set_rules('email', 'Email already exist', 'required|min_length[1]|max_length[255]|is_unique[b2b_users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[1]|max_length[255]');

            if ($this->form_validation->run() !== false) {


                $input_data['status'] = 'pending';

                $user_meta_save = $this->Users_Model->user_signup($input_data);

                $data = [
                    'validation_errors' => '',
                    'success_msg' => '<strong>Congratulation! </strong>signup successfull. <br/>Kindly verify your account! verification link sent on you mail id',
                    'username' => '',
                    'firstname' => '',
                    'lastname' => '',
                    'email' => '',
                    'password' => '',
                    'mobile-number' => ''
                ];
                // account verification email after signup

                $mail = new \PHPMailer\PHPMailer\PHPMailer();
                // SMTP configuration
                try {
                    $mail->isSMTP();
                    $mail->Host = PHPMAILER_SENDER_HOST;
                    $mail->SMTPAuth = PHPMAILER_SENDER_SMTPAUTH;
                    $mail->Username = PHPMAILER_SENDER_USERNAME;
                    $mail->Password = PHPMAILER_SENDER_PASSWORD;
                    $mail->SMTPSecure = PHPMAILER_SENDER_SMTP_SECURE;
                    $mail->Port = PHPMAILER_SENDER_PORT;

                    $mail->setFrom(NEWSLETTER_FROM_EMAIL);
                    // Email subject
                    $mail->Subject = 'Verify Your Account |' . SITE_NAME;
                    // Set email format to HTML
                    $mail->isHTML(true);
                    $mail->addAddress($input_data['email'], $input_data['username']);
                    $html = 'email:' . $input_data['email'] . '|||status:' . 'email_pending_verifications';
                    $mail->Body = EMAIL_NEW_USER_VERIFY_EMAIL . ' ' . base_url('users/verify_user_account/') . volgo_encrypt_message($html);
                    //@todo: redirect email verification page
                    $mail->send();
                } catch (Exception $e) {
                    log_message('error', $mail->ErrorInfo);
                }
                // Welcom email after signup

                $mail = new \PHPMailer\PHPMailer\PHPMailer();
                // SMTP configuration
                try {
                    $mail->isSMTP();
                    $mail->Host = PHPMAILER_SENDER_HOST;
                    $mail->SMTPAuth = PHPMAILER_SENDER_SMTPAUTH;
                    $mail->Username = PHPMAILER_SENDER_USERNAME;
                    $mail->Password = PHPMAILER_SENDER_PASSWORD;
                    $mail->SMTPSecure = PHPMAILER_SENDER_SMTP_SECURE;
                    $mail->Port = PHPMAILER_SENDER_PORT;

                    $mail->setFrom(NEWSLETTER_FROM_EMAIL);
                    // Email subject
                    $mail->Subject = 'Welcome |' . SITE_NAME;
                    // Set email format to HTML
                    $mail->isHTML(true);
                    $mail->addAddress($input_data['email'], $input_data['username']);
                    $mail->Body = EMAIL_NEW_USER_WELCOME_EMAIL;
                    //@todo: redirect to welcome page
                    $mail->send();
                } catch (Exception $e) {
                    log_message('error', $mail->ErrorInfo);
                }

                $this->load->view('frontend/users/user_signup', $data);
            } else {
                $data = [
                    'validation_errors' => validation_errors(),
                    'success_msg' => '',
                ];
                $this->load->view('frontend/users/user_signup', $data);
            }
        }
    }

    public function verify_user_account($token)
    {
    	$result = volgo_decrypt_message($token);
        $data = explode("|||", $result, 2);
        $user_email = explode(':', $data[0], 2);
        $user_status = explode(':', $data[1], 2);
        $user_email = $user_email[1];
        $user_status = $user_status[1];

		$redirected_to = '';
        if (volgo_get_cookie(VOLGO_COOKIE_BEFORE_PURCHASING_PACKAGE_INFO) !== null){
        	$pkg_cookie = volgo_decrypt_message( (volgo_get_cookie(VOLGO_COOKIE_BEFORE_PURCHASING_PACKAGE_INFO)) );
        	$pkg_arr = explode('&&', $pkg_cookie);

        	if (isset($pkg_arr[0], $pkg_arr[1])){
				$pkg_id = trim($pkg_arr[0], 'package_id=');
				$enc_token = trim($pkg_arr[1], 'enc_method=');
				$redirected_to = base_url('purchase/' . intval($pkg_id) . '/' . $enc_token);
			}
		}

		$is_updated = $this->Users_Model->verify_user_signup($user_email);

		if ($is_updated){
			// send email
			$mail = new \PHPMailer\PHPMailer\PHPMailer();

			// SMTP configuration
			try {
				$mail->isSMTP();
				$mail->Host = PHPMAILER_SENDER_HOST;
				$mail->SMTPAuth = PHPMAILER_SENDER_SMTPAUTH;
				$mail->Username = PHPMAILER_SENDER_USERNAME;
				$mail->Password = PHPMAILER_SENDER_PASSWORD;
				$mail->SMTPSecure = PHPMAILER_SENDER_SMTP_SECURE;
				$mail->Port = PHPMAILER_SENDER_PORT;

				$mail->setFrom(NEWSLETTER_FROM_EMAIL);

				//          Email subject
				$mail->Subject = 'Congratulations!';
				// Set email format to HTML
				$mail->isHTML(true);
				$mail->addAddress($user_email);
				$mail->Body = 'Congratulations! Signup successfully';
				//@todo: redirect to congratulation page

				$mail->send();

				$this->session->set_flashdata('success_msg', 'Your account has been successfully verified');

				if (! empty($redirected_to))
					redirect(base_url('login?redirected_to=' . $redirected_to));
				else
					redirect(base_url('login'));
			}catch (Exception $e){
				log_message('error', $mail->ErrorInfo);
			}

		}else {
			// display error/log error
			log_message('error', "Unable to update the user meta at time of verification email.");
			redirect(base_url());
		}
    }

    public function user_login()
    {
        $data = array(
            'validation_errors' => '',
        );

        $posted_data = filter_input_array(INPUT_POST);
        if (!empty($posted_data)){

            $this->form_validation->set_rules('user_email', 'Username', 'trim|required');
            $this->form_validation->set_rules('user_password', 'Password', 'trim|required');

            if ($this->form_validation->run() === FALSE) {
                $data = array(
                    'validation_errors' => validation_errors(),
                );
            } else {
                $data = array(
                    'form_data'	=> array(
                        'user_email' => $this->input->post('user_email'),
                        'user_password' => $this->input->post('user_password')
                    ),
                    'validation_errors' => '',
                );
                $is_ok = $this->Users_Model->verfiy_user_login($data);

                if ($is_ok){

                    $user_data = array(
                        'username'	=> $data['form_data']['user_email'],
                        'is_logged_in'	=> true,
                        'login_time'	=> time()
                    );
                    $sess_enc_data = volgo_encrypt_message($user_data);
                    $this->session->set_userdata('volgo_user_login_data', $sess_enc_data);


					$redirected_to = $this->input->get('redirected_to');

					if (volgo_front_is_logged_in() && (volgo_get_cookie(VOLGO_COOKIE_BEFORE_PURCHASING_PACKAGE_INFO) !== NULL) && !empty($redirected_to)) {
						header('Location: ' . $redirected_to);
					}else if (volgo_front_is_logged_in() && !empty($redirected_to)) {
						header('Location: ' . $redirected_to);
					}else{
						header('Location: ' . base_url());
					}
                }else {
                    $data = array(
                        'validation_errors' => '<strong>Sorry</strong><br />Login username/password is wrong.',
						'fb_login_url'	=> $this->get_facebook_login_url(),
						'fb_logout_url'	=> '#'
                    );

                    $this->load->view('frontend/users/user_login', $data);
                }
            }
        }else{
        	$data = [
				'fb_login_url'	=> $this->get_facebook_login_url(),
				'fb_logout_url'	=> '#'
			];

            $this->load->view('frontend/users/user_login', $data);
        }
    }

    public function user_password_reset()
    {
        $data = array(
            'validation_errors' => '',
            'success_msg' => '',
        );
        $input_data = filter_input_array(INPUT_POST);
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required');
        if ($this->form_validation->run() !== false) {
            $data = array(
                'form_data'	=> array(
                    'user_email' => $this->input->post('user_email')
                ),
                'validation_errors' => '',
            );
            $is_ok = $this->Users_Model->verfiy_user_email($data);

            if ($is_ok){

                $user_data = array(
                    'user_email'	=> $data['form_data']['user_email']
                );
                $this->session->set_userdata('volgo_user_login_data');
                $this->session->set_flashdata('success_msg', '<strong>Congratulation!</strong><br /> password reset link sent to your mail id.');
            }else {
                $data = array(
                    'validation_errors' => '<strong>Sorry</strong><br />Invalid Email Id.',
                );
            }
            // password reset email
            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            // SMTP configuration
            try {
                $mail->isSMTP();
                $mail->Host = PHPMAILER_SENDER_HOST;
                $mail->SMTPAuth = PHPMAILER_SENDER_SMTPAUTH;
                $mail->Username = PHPMAILER_SENDER_USERNAME;
                $mail->Password = PHPMAILER_SENDER_PASSWORD;
                $mail->SMTPSecure = PHPMAILER_SENDER_SMTP_SECURE;
                $mail->Port = PHPMAILER_SENDER_PORT;

                $mail->setFrom(NEWSLETTER_FROM_EMAIL);
                // Email subject
                $mail->Subject = 'Password Reset |' . SITE_NAME;
                // Set email format to HTML
                $mail->isHTML(true);
                $mail->addAddress($input_data['user_email']);
                $html = 'email:' . $input_data['user_email'];
                $mail->Body = EMAIL_PASSWORD_RESET_EMAIL . ' ' . base_url('users/verify_reset_password/') . volgo_encrypt_message($html);

                $mail->send();

            } catch (Exception $e){
                log_message('error', $mail->ErrorInfo);
            }
            $this->load->view('frontend/users/forget_password', $data);
        } else {
            $data = [
                'validation_errors' => validation_errors(),
                'email' => ''
            ];

            $this->load->view('frontend/users/forget_password', $data);
        }

    }

    public function reset_password($token){
        $result['token'] = $token;
        $this->load->view('frontend/users/reset_password', $result);
    }

    public function verify_reset_password($token)
    {
        $newtoken['token'] = $token;
        $result = volgo_decrypt_message($token);

        $data = explode("|||", $result, 2);
        $user_email = explode(':', $data[0], 2);
        $user_email = $user_email[1];

        $data = array(
            'validation_errors' => '',
            'success_msg' => ''
        );
        $input_data = filter_input_array(INPUT_POST);
        if (!empty($input_data)) {

            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm-password', 'Confirm Password', 'required|matches[password]');


            if ($this->form_validation->run() !== false) {

                $password = $this->input->post('password');
                $is_updated = $this->Users_Model->update_user_password(
                    $user_email, $password
                );
                if ($is_updated) {
                    $data = array(
                        'validation_errors' => validation_errors(),
                        'password' => $password
                    );

                        $mail = new \PHPMailer\PHPMailer\PHPMailer();

                        // SMTP configuration
                        try {
                            $mail->isSMTP();
                            $mail->Host = PHPMAILER_SENDER_HOST;
                            $mail->SMTPAuth = PHPMAILER_SENDER_SMTPAUTH;
                            $mail->Username = PHPMAILER_SENDER_USERNAME;
                            $mail->Password = PHPMAILER_SENDER_PASSWORD;
                            $mail->SMTPSecure = PHPMAILER_SENDER_SMTP_SECURE;
                            $mail->Port = PHPMAILER_SENDER_PORT;

                            $mail->setFrom(NEWSLETTER_FROM_EMAIL);

//                     Email subject
                            $mail->Subject = 'Your password has been updated |' . SITE_NAME;
                            // Set email format to HTML
                            $mail->isHTML(true);
                            $mail->addAddress($user_email);
                            $mail->Body = EMAIL_PASSWORD_RESET_SUCCESS_EMAIL;
                            //@todo: redirect to thank you page
                            $mail->send();
                        }catch (Exception $e){
                            log_message('error', $mail->ErrorInfo);
                        }

                        $this->session->set_flashdata('success_msg', 'Password updated successfully! login you account');
                        redirect('login');

                }else {

                    $this->session->set_flashdata('validation_errors', 'password update error 1');
                    $this->load->view('frontend/users/reset_password', $newtoken);
                }

                $this->session->set_flashdata('success_msg', 'Password Update successfully');
                $this->load->view('frontend/users/reset_password', $newtoken);
            } else {
                $this->session->set_flashdata('validation_errors', 'password field is required');
                $this->load->view('frontend/users/reset_password', $newtoken);
            }

        } else {
            $this->session->set_flashdata('validation_errors', '');
            $this->load->view('frontend/users/reset_password', $newtoken);
        }

    }

	public function additional_filters()
	{

		$posted_data = filter_input_array(INPUT_POST);

		if (! $this->input->is_ajax_request() || !isset($posted_data['filter_name']) || !isset($posted_data['cat_slug'])) {
			exit('No direct script access allowed');
		}

		$category_id = volgo_get_cat_id_by_slug($posted_data['cat_slug']);

		if (empty($category_id)){
			echo json_encode('');
			exit;
		}


		if ( strtolower($posted_data['filter_name']) === 'price_only'){
			$data = [
				'price_only' => true,
				'listing_type'	=> 'featured'
			];
			$featured_results = $this->Listings_Model->header_advance_search('', $category_id, '', '', $data, 1, 10);


			$data = [
				'price_only' => true,
				'listing_type'	=> 'recommended'
			];
			$recommended_result = $this->Listings_Model->header_advance_search('', $category_id, '', '', $data, 1, 3);


			$data = [
				'featured_listings'	=> $featured_results,
				'recommended_listings'	=> $recommended_result
			];

			ob_start();
			$this->load->view('frontend/listing_page/ajax/listingautos', $data);
			$html = ob_get_clean();

			echo json_encode($html);
			exit;

		}

		if ( strtolower($posted_data['filter_name']) === 'photo_only'){
			$data = [
				'photo_only' => true,
				'listing_type'	=> 'featured'
			];
			$featured_results = $this->Listings_Model->header_advance_search('', $category_id, '', '', $data, 0, 10);


			$data = [
				'photo_only' => true,
				'listing_type'	=> 'recommended'
			];
			$recommended_result = $this->Listings_Model->header_advance_search('', $category_id, '', '', $data, 0, 3);

			$data = [
				'featured_listings'	=> $featured_results,
				'recommended_listings'	=> $recommended_result
			];

			ob_start();
			$this->load->view('frontend/listing_page/ajax/listingautos', $data);
			$html = ob_get_clean();

			echo json_encode($html);
			exit;

		}

	}




}
