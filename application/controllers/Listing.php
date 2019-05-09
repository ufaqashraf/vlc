<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 2/28/2019
 * Time: 1:38 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Listing extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();


		$this->load->model('Blocks_Model');

		$this->load->model('Listingquery_Model');
		$this->load->model('Listingfilterquery_Model');
		$this->load->model('Dashboard_Model');

		$this->load->model('Listings_Model');
		$this->load->library('form_validation');
		$this->load->library('pagination');

	}

	public function show_listing()
	{

		$listing = [
			'listing_detail' => $this->Listings_Model->get_listing_by_slug($slug),
			'listing_meta' => $this->Listings_Model->get_listings(),

		];

		$this->load->view('frontend/listing', $listing);
	}


	public function show_by_slug($slug = '')
	{

		$get_data = $this->input->get();

		if (isset($get_data['select_state'])) {
			$state = $get_data['select_state'];
		} else {
			$state = '';
		};
		if (isset($get_data['parent_cat_select'])) {
			$parent_cat = $get_data['parent_cat_select'];
		} else {
			$parent_cat = '';
		};
		if (isset($get_data['child_cats'])) {
			$child_cat = $get_data['child_cats'];
		} else {
			$child_cat = '';
		};
		if (isset($get_data['search_query'])) {
			$search_query = $get_data['search_query'];
		} else {
			$search_query = '';
		};

		unset ($get_data['select_state']);
		unset ($get_data['parent_cat_select']);
		unset ($get_data['child_cats']);
		unset ($get_data['search_query']);

		$metas = $get_data;
		unset($get_data);
		$page = $this->input->get('per_page', TRUE);
		if (isset($page)) {
			$page = $page;
		} else {
			$page = '';
		}

		$listings = $this->Listings_Model->header_advance_search($state, $parent_cat, $child_cat, $search_query, $metas, $page, $per_page_limit = 5);

		$cat_name = $this->Listingquery_Model->get_category_name($parent_cat);

		$total_count_row = [];
		$sub_childs_cats = $this->Listingquery_Model->sub_child_cats($parent_cat);
		foreach ($sub_childs_cats as $single_id) {
			$elements = $this->Listingquery_Model->total_listing_get($single_id->id);
			if (empty($elements)) {
				$total_count_row[] = (object)[
					'subcat_id' => $single_id->id,
					'name' => $single_id->name,
					'total' => 0,
				];
			} else {
				$total_count_row[] = (object)[
					'subcat_id' => $single_id->id,
					'name' => $single_id->name,
					'total' => count($elements),
				];
			}
		}

		$country_id = volgo_get_country_info_from_session();
		$country_id = $country_id['country_id'];
		if (isset($country_id)) {
			$country_id = $country_id;
		} else {
			$country_id = 166;
		}

		if (!empty($_SESSION['volgo_user_login_data'])) {
			$session_data = volgo_decrypt_message($_SESSION['volgo_user_login_data']);
			$session_data = explode(',', $session_data);
			$logedin_user_email = $session_data[0];
			$user_detail = $this->Dashboard_Model->get_curent_user_detail($logedin_user_email);

			if (!empty($user_detail)) {

				$loged_in_user_id = $user_detail[0]->id;
				

			} else {
				$loged_in_user_id = 'nologedin';
			}
		} else {
			$loged_in_user_id = 'nologedin';
		}
		$detail = $this->Listings_Model->get_listing_by_slug($slug);
		if(!empty($cat_name)){
			$cat_name = $cat_name;
		}else{
			$cat_name = $detail['info'][0]->category_slug;
		}

		
		$listing = [
			'listing_detail' => $detail,
			'listing_meta' => $this->Listings_Model->get_listings(),
			'loged_in_user_id' => $loged_in_user_id,
			'sub_childs_cats' => $total_count_row,
			'all_cuntry' => $this->Listingfilterquery_Model->get_all_countries(),
			'listing_by_cat_featured' => $listings,
			'all_cats' => $this->Listingfilterquery_Model->get_all_categories(),
			'cat_name' => $cat_name,
            'listing_follow' => $this->Listings_Model->get_follow_listing($loged_in_user_id),
			'listing_fav' => $this->Listings_Model->get_favlisting($loged_in_user_id),
			'popular_searches' => $this->Listings_Model->popular_searches($country_id,$detail['info'][0]->category_id),
			'nearby' => $this->Listings_Model->nearby($country_id,$detail['info'][0]->category_id)
		];

		$related_post_id = $listing['listing_detail']['info'][0]->category_id;
		$next_previous = $listing['listing_detail']['info'][0]->category_id;
		$related_post_current_id = $listing['listing_detail']['info'][0]->listing_id;

		$listing['related_listing'] = $this->Listings_Model->get_autos_related_posts($related_post_current_id, $related_post_id);
		$listing['next_previous_listing'] = $this->Listings_Model->get_next_previous_posts($related_post_current_id, $next_previous);

		$cat_name = volgo_make_slug(strtolower($listing['listing_detail']['info'][0]->category_name));
		$parent_cat_name = $this->Listingquery_Model->get_name_of_paent_cat($listing['listing_detail']['info'][0]->category_id);
		
		// var_dump($parent_cat_name);die;
		/*  Detail Pages */
		if ($cat_name === 'autos') {
			$this->load->view('frontend/listing_detail_pages/listingdetailautos', $listing);
		} else if ($cat_name === 'classified') {
			$this->load->view('frontend/listing_detail_pages/listingdetailclassified', $listing);
		} else if ($cat_name === 'services') {
			$this->load->view('frontend/listing_detail_pages/listingdetailservices', $listing);
		} else if ($cat_name === 'property-for-sale' || $cat_name === 'property-for-rent') {
			$this->load->view('frontend/listing_detail_pages/listingproperty', $listing);
		} else if ($cat_name === 'jobs') {
			$this->load->view('frontend/listing_detail_pages/listingjobs', $listing);
		}else if($cat_name === 'buying-leads' || $parent_cat_name === 'buying-leads' || $cat_name === 'seller-leads' || $parent_cat_name === 'seller-leads'){
			if(!empty($loged_in_user_id)){
				$listing['parent_cat_name'] = $parent_cat_name;
				$listing['user_membership'] = $this->Listings_Model->user_membership_check($loged_in_user_id);
			}
			$this->load->view('frontend/listing_detail_pages/listingleads', $listing);
		}else {
			$this->load->view('frontend/listing_detail_pages/default-listing', $listing);
		}

		// @ todo: Pending
		//		echo '<h1>Write functionality for single page.</h1>';
		//		var_export($listing);
	}

	public function buying_leads()
	{
		$data = [
			'buying_leads' => $this->Categories_Model->get_buying_leads()
		];

		$country_name = $this->input->get('cc');
		if (!empty($country_name) && !is_null($country_name)) {
			$data ['cc'] = $country_name;
		}

		$this->load->view('frontend/buying-lead/view', $data);
	}

	public function seller_leads()
	{
		$data = [
			'selling_leads' => $this->Categories_Model->get_selling_leads()
		];

		$country_name = $this->input->get('cc');
		if (!empty($country_name) && !is_null($country_name)) {
			$data ['cc'] = $country_name;
		}

		$this->load->view('frontend/seller-lead/view', $data);
	}

	public function send_reply($id, $slug)
	{

		$user_data = $this->Listings_Model->seller_send_reply($id);

		foreach ($user_data as $seller_email) {
		}

		$input_data = filter_input_array(INPUT_POST);

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('message', 'Message', 'required');

		if ($this->form_validation->run() !== false) {

			$data = [
				'validation_errors' => '',
				'success_msg' => '<strong>Congratulation!</strong><br /> Message successfull.',
				'email' => '',
				'name' => '',
				'message' => ''
			];
			// send verification mail to buyer

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
				$mail->Subject = 'received your mail to seller' . SITE_NAME;
				// Set email format to HTML
				$mail->isHTML(true);
				$mail->addAddress($input_data['email'], $input_data['name']);

				$mail->Body = $input_data['message'];
				//@todo: redirect email verification page
				$mail->send();

				$this->session->set_flashdata('success_msg', 'Your account has been successfully verified');
			} catch (Exception $e) {
				log_message('error', $mail->ErrorInfo);
			}

			// send verification mail to seller

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
				$mail->Subject = 'Buyr received your email' . SITE_NAME;
				// Set email format to HTML
				$mail->isHTML(true);
				$mail->addAddress($seller_email->email);

				$mail->Body = $input_data['message'];
				//@todo: redirect email verification page
				$mail->send();

				$this->session->set_flashdata('success_msg', 'Message Sent Successfully!');
			} catch (Exception $e) {
				log_message('error', $mail->ErrorInfo);
			}

			//$this->load->view($slug, $data);
			redirect($slug);
		} else {
			$data = [
				'validation_errors' => validation_errors(),
				'success_msg' => '',
			];
			$this->load->view('frontend/listing_page/listingdetail', $data);
		}
	}

	public function chat_with_seller($id, $slug)
	{

		$user_data = $this->Listings_Model->seller_send_reply($id);

		foreach ($user_data as $seller_email) {
		}

		$input_data = filter_input_array(INPUT_POST);

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('message', 'Message', 'required');

		if ($this->form_validation->run() !== false) {

			$data = [
				'chat_validation_errors' => '',
				'chat_success_msg' => '<strong>Congratulation!</strong><br /> Message successfull.',
				'email' => '',
				'name' => '',
				'message' => ''
			];
			// send verification mail to buyer

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
				$mail->Subject = 'received your mail to seller' . SITE_NAME;
				// Set email format to HTML
				$mail->isHTML(true);
				$mail->addAddress($input_data['email'], $input_data['name']);

				$mail->Body = $input_data['message'];
				//@todo: redirect email verification page
				$mail->send();

				$this->session->set_flashdata('chat_success_msg', 'Your account has been successfully verified');
			} catch (Exception $e) {
				log_message('error', $mail->ErrorInfo);
			}

			// send verification mail to seller

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
				$mail->Subject = 'Buyr received your email' . SITE_NAME;
				// Set email format to HTML
				$mail->isHTML(true);
				$mail->addAddress($seller_email->email);

				$mail->Body = $input_data['message'];
				//@todo: redirect email verification page
				$mail->send();

				$this->session->set_flashdata('chat_success_msg', 'Message Sent Successfully!');
			} catch (Exception $e) {
				log_message('error', $mail->ErrorInfo);
			}

			//$this->load->view($slug, $data);
			redirect($slug);
		} else {
			$data = [
				'chat_validation_errors' => validation_errors(),
				'chat_success_msg' => '',
			];
			$this->load->view('frontend/listing_page/listingdetail', $data);
		}
	}

	public function index()
	{
		$this->view();

	}

	public function get_state_ajax()
	{


		if (!empty($_POST["country_id"])) {

			$selected_state_id = $this->input->post('country_id');
			$states = $this->Listingfilterquery_Model->get_state_by_id($selected_state_id);


			echo json_encode($states);
			exit();
		}
	}

	public function get_formdb_ajax()
	{
		if (!empty($_POST["subcat_id"])) {

			$selected_subcat_id = $this->input->post('subcat_id');


			$states = $this->Listingfilterquery_Model->get_formdb_by_id($selected_subcat_id);

			echo json_encode($states);
			exit();
		}
	}

	public function get_formdb_ajax2()
	{


		if (!empty($_POST["subcat_id"])) {

			$selected_subcat_id = $this->input->post('subcat_id');


			$states = $this->Listingfilterquery_Model->get_form_db_retrival_advance($selected_subcat_id);

			echo json_encode($states);
			exit();
		}
	}

	public function get_city_ajax()
	{


		if (!empty($_POST["state_id"])) {

			$selected_state_id = $this->input->post('state_id');


			$states = $this->Listingfilterquery_Model->get_city_by_id($selected_state_id);

			echo json_encode($states);
			exit();
		}
	}

	public function get_subchild_ajax()
	{


		if (!empty($_POST["parent_cat_id"])) {

			$selected_parent_id = $_POST["parent_cat_id"];
			$child_cats = $this->Listingfilterquery_Model->get_child_cat_integrate($selected_parent_id);
			echo json_encode($child_cats);
			exit();
		}
	}

	public function get_ajax_made()
	{


		if (!empty($_POST["subcat_id"])) {

			$selected_sub_cat_id = $_POST["subcat_id"];

			$models = $this->Listingfilterquery_Model->get_make_models($selected_sub_cat_id);


			echo json_encode($models);
			exit();
		}
	}

	public function search()
	{
		//select_country=166
		//&selected_city=5755
		//&make=acura
		//&model=
		//&phone=phone
		//&listedby=
		//&currency_code=PKR
		//&price=
		//&kilometers=kilometers
		//&bodycondition=0
		//&mechanicalcondition=0
		//&color=0
		//&year=
		//&cylinder=0
		//&transmission=0
		//&doors=0
		//&horspower=0
		//&warranty=0
		//&fueltype=0
		//&search_query=

		$get_data = $this->input->get();


		$state = isset($get_data['select_state']) ? $get_data['select_state'] : '';
		$parent_cat = isset($get_data['parent_cat_select']) ? $get_data['parent_cat_select'] : '';
		$child_cat = isset($get_data['child_cats']) ? $get_data['child_cats'] : '';
		$search_query = isset($get_data['search_query']) ? $get_data['search_query'] : '';

		unset ($get_data['select_state']);
		unset ($get_data['child_cats']);
		unset ($get_data['search_query']);


		if (!isset($get_data['parent_cat_select'])) {


			$page = $this->input->get('per_page', TRUE);
			if (isset($page)) {
				$page = $page;
			} else {
				$page = '';
			}

			$listings = $this->Listings_Model->header_search($search_query, $page, $per_page_limit = 10);

			$totalcounts = $listings['total_record'];

			unset ($listings['total_record']);


			$config = array();
			$config['page_query_string'] = TRUE;
			$config["base_url"] = base_url('/listing/search?search_query=') . $search_query . $this->input->get('?search', true);

			$config['display_pages'] = TRUE;
			$config["total_rows"] = $totalcounts;
			$config["per_page"] = $per_page_limit;
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = 10;
			$config['uri_segment'] = 4;


			$config['full_tag_open'] = "<ul class='pagination dynamic_pagination'>";
			$config['full_tag_close'] = '</ul>';
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active page-link"><a href="#" class="page-link">';
			$config['cur_tag_close'] = '</a></li>';


			$config['attributes'] = array('class' => 'page-link');
			$config['prev_link'] = '<';
			$config['prev_tag_open'] = '<li class="page-link ">';
			$config['prev_tag_close'] = '</li>';


			$config['next_link'] = '>';
			$config['next_tag_open'] = '<li class="page-link page-link-next">';
			$config['next_tag_close'] = '</li>';


			$this->pagination->initialize($config);

			$str_links = $this->pagination->create_links();
			$total_count_row = '';
			$loged_in_user_id = volgo_get_logged_in_user_id();
			if (!empty($loged_in_user_id)) {
				$loged_in_user_id = $loged_in_user_id;
			} else {
				$loged_in_user_id = "nologedin";
			}
			$data = [
				'sub_childs_cats' => $total_count_row,
				'all_cuntry' => $this->Listingfilterquery_Model->get_all_countries(),
				'listing_by_cat_featured' => $listings,
				'all_cats' => $this->Listingfilterquery_Model->get_all_categories(),
				'cat_namelisting_by_cat_id_recommended' => '',
				'total_add' => $totalcounts,
				'listing_fav' => $this->Listings_Model->get_favlisting($loged_in_user_id),
				'listing_save_search' => $this->Listings_Model->get_save_search($loged_in_user_id),
                'listing_follow' => $this->Listings_Model->get_follow_listing($loged_in_user_id),
                'newest_to_old' => $this->Listings_Model->get_latest_listings(),
			];

			if (isset($str_links))
				$data["links"] = explode('&nbsp;', $str_links);


			$this->load->view('frontend/listing_page/default-listing', $data);
		} else {

			unset ($get_data['parent_cat_select']);
			$page = $this->input->get('per_page', TRUE);
			if (isset($page)) {
				$page = $page;
			} else {
				$page = '';
			}
			$metas = $get_data;

			$listings = $this->Listings_Model->header_advance_search($state, $parent_cat, $child_cat, $search_query, $metas, $page, $per_page_limit = 10);


			$totalcounts = $listings['total_record'];

			unset ($listings['total_record']);


			$config = array();
			$config['page_query_string'] = TRUE;
			$config["base_url"] = base_url('/listing/search?search_query=') . $search_query . $this->input->get('?search', true);

			$config['display_pages'] = TRUE;
			$config["total_rows"] = $totalcounts;
			$config["per_page"] = $per_page_limit;
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = 10;
			$config['uri_segment'] = 4;


			$config['full_tag_open'] = "<ul class='pagination dynamic_pagination'>";
			$config['full_tag_close'] = '</ul>';
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active page-link"><a href="#" class="page-link">';
			$config['cur_tag_close'] = '</a></li>';


			$config['attributes'] = array('class' => 'page-link');
			$config['prev_link'] = '<';
			$config['prev_tag_open'] = '<li class="page-link ">';
			$config['prev_tag_close'] = '</li>';


			$config['next_link'] = '>';
			$config['next_tag_open'] = '<li class="page-link page-link-next">';
			$config['next_tag_close'] = '</li>';


			$this->pagination->initialize($config);

			$str_links = $this->pagination->create_links();
			$total_count_row = '';

			$data = [
				'sub_childs_cats' => $total_count_row,
				'all_cuntry' => $this->Listingfilterquery_Model->get_all_countries(),
				'listing_by_cat_featured' => $listings,
				'all_cats' => $this->Listingfilterquery_Model->get_all_categories(),
				'cat_name' => '',
				'total_add' => $totalcounts,0
			];

			if (isset($str_links))
				$data["links"] = explode('&nbsp;', $str_links);


			$this->load->view('frontend/listing_page/default-listing', $data);


		}


	}
	// property search
	public function propertysearch(){
		// parse_str($_POST['data'], $get_data);
		$get_data = $this->input->get();
		// var_dump(http_build_query(array_merge($_GET)));die;
		// $cat_name = $this->input->get('parent_cat');
		$parent_cat = $this->Listingquery_Model->get_id_of_cat($get_data['parent_cat']);
		if(isset($get_data['child_cats']) && !empty($get_data['child_cats'])){
			$child_cat = $this->Listingquery_Model->get_id_of_cat($get_data['child_cats']);
		}
		$state = isset($get_data['select_state']) ? $get_data['select_state'] : '';
		$parent_cat = isset($parent_cat) ? $parent_cat[0]->id : '';
		$child_cat = isset($child_cat) ? $child_cat[0]->id : '';
		$search_query = isset($get_data['search_query']) ? $get_data['search_query'] : '';

		$parent_cat_name = $get_data['parent_cat'];
		
		$cat_id = $parent_cat;
		$cat_id_for = $cat_id;
		// var_dump($nearby_cat);die;
		// countries
		$country_id = volgo_get_country_info_from_session();
		$country_id = $country_id['country_id'];
		if (isset($country_id)) {
			$country_id = $country_id;
		} else {
			$country_id = 166;
		}

		$total_sub_count_row = [];
		$sub_childs_cats = $this->Listingquery_Model->sub_child_cats($cat_id);

		foreach ($sub_childs_cats as $single_id) {
			$elements = $this->Listingquery_Model->total_listing_get($single_id->id, $country_id);
			if (empty($elements)) {
				$total_sub_count_row[] = (object)[
					'subcat_id' => $single_id->id,
					'name' => $single_id->name,
					'slug' => $single_id->slug,
					'total' => 0,
				];
			} else {
				$total_sub_count_row[] = (object)[
					'subcat_id' => $single_id->id,
					'slug' => $single_id->slug,
					'name' => $single_id->name,
					'total' => $elements,
				];
			}
		}
		if(isset($child_cat) && !empty($child_cat)){
			$cat_name = $this->Listingquery_Model->get_category_name($child_cat);
			$parent_name = $this->Listingquery_Model->get_category_name($cat_id);
		}else{
			$cat_name = $this->Listingquery_Model->get_category_name($cat_id);
		}
		

		// var_dump($cat_name);die;
		if(!empty($get_data)) {
			$page = $this->input->get('per_page', TRUE);
			if (isset($page)) {
				$page = $page;
			} else {
				$page = '';
			}
			$metas = $get_data;

			$listings = $this->Listings_Model->propertysearch($state, $parent_cat, $child_cat, $search_query, $metas, $page, $per_page_limit = 15);
			$totalcounts = $listings['total_record'];

			unset ($listings['total_record']);


			$config = array();
			$config['page_query_string'] = TRUE;
			$config["base_url"] = base_url('/listing/propertysearch?') . http_build_query(array_merge($_GET));

			$config['display_pages'] = TRUE;
			$config["total_rows"] = $totalcounts;
			$config["per_page"] = $per_page_limit;
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = 10;
			$config['uri_segment'] = 4;


			$config['full_tag_open'] = "<ul class='pagination dynamic_pagination'>";
			$config['full_tag_close'] = '</ul>';
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active page-link"><a href="#" class="page-link">';
			$config['cur_tag_close'] = '</a></li>';


			$config['attributes'] = array('class' => 'page-link');
			$config['prev_link'] = '<';
			$config['prev_tag_open'] = '<li class="page-link ">';
			$config['prev_tag_close'] = '</li>';


			$config['next_link'] = '>';
			$config['next_tag_open'] = '<li class="page-link page-link-next">';
			$config['next_tag_close'] = '</li>';


			$this->pagination->initialize($config);

			$str_links = $this->pagination->create_links();

			$total_count_row = '';
			
			$recommended_listing_id = [];
			$featured_listing = [];
			if(!isset($listings['result'])){
				foreach ($listings as $row) {
					$cat_id = $row['listing_details']['listing_id'];
					$featured_listing[$cat_id]['listing_details'] = [
						'id' => $row['listing_details']['listing_id'],
						'title' => $row['listing_details']['title'],
						'slug' => $row['listing_details']['slug'],
						'created_at' => $row['listing_details']['created_at'],
						'category_id' => $row['listing_details']['category_id'],
						'category_name' => $row['listing_details']['parent_category'],
						'listing_meta_id' => $row['listing_details']['category_id'],
						'country_name' => $row['listing_details']['country'],
						'city_name' => $row['listing_details']['city_name'],
						'subcat_name' => $row['listing_details']['sub_category'],
						'state_name' => $row['listing_details']['state_name'],
					];
	
					foreach ($row['metas'] as $single_meta) {
						$featured_listing[$cat_id]['metas'][] = [
							'meta_key' => $single_meta['meta_key'],
							'meta_value' => $single_meta['meta_value'],
						];
						if($single_meta['meta_value'] == 'Premium'){
							$recommended_listing_id['listing_id']['id'] = $row['listing_details']['listing_id'];	
						}
					}
				}
			}
			$featured_listing = array_values($featured_listing);

			// var_dump($recommended_listing_id);die;
			$recommended_listing = [];
			if(!empty($recommended_listing_id)){
				foreach($recommended_listing_id['listing_id'] as $recommended){
					foreach ($listings as $row) {
						if($recommended['id'] == $row['listing_details']['listing_id']){
							$cat_id = $row['listing_details']['listing_id'];
							$recommended_listing[$cat_id]['listing_details'] = [
								'id' => $row['listing_details']['listing_id'],
								'title' => $row['listing_details']['title'],
								'slug' => $row['listing_details']['slug'],
								'created_at' => $row['listing_details']['created_at'],
								'category_id' => $row['listing_details']['category_id'],
								'category_name' => $row['listing_details']['parent_category'],
								'listing_meta_id' => $row['listing_details']['category_id'],
								'country_name' => $row['listing_details']['country'],
								'city_name' => $row['listing_details']['city_name'],
								'subcat_name' => $row['listing_details']['sub_category'],
								'state_name' => $row['listing_details']['state_name'],
							];
			
							foreach ($row['metas'] as $single_meta) {
								$recommended_listing[$cat_id]['metas'][] = [
									'meta_key' => $single_meta['meta_key'],
									'meta_value' => $single_meta['meta_value'],
								];
							}
						}
					}
				}
			}
			$recommended_listing = array_values($recommended_listing); 


			$loged_in_user_id = volgo_get_logged_in_user_id();
			if (!empty($loged_in_user_id)) {
				$loged_in_user_id = $loged_in_user_id;
			} else {
				$loged_in_user_id = "nologedin";
			}

			

			$data = [
				'footer_block' => $this->Blocks_Model->get_block('footer_block'),
				'sub_childs_cats' => $total_sub_count_row,
				'all_cuntry' => $this->Listingfilterquery_Model->get_all_countries(),
				'listing_by_cat_recommended' => $recommended_listing,
				'listing_by_cat_featured' => $featured_listing,
				'all_cats' => $this->Listingfilterquery_Model->get_all_categories(),
				'parent_cat_name' => isset($parent_name) ?$parent_name : '',
				'cat_name' => $cat_name,
				'total_add' => $totalcounts,
				'listing_fav' => $this->Listings_Model->get_favlisting($loged_in_user_id),
				'loged_in_user_id' => $loged_in_user_id,
				'listing_follow' => $this->Listings_Model->get_follow_listing($loged_in_user_id),
				'all_cities' => $this->Listings_Model->selected_city_name(isset($get_data['select_state']) ? $get_data['select_state'] : 0),
				'popular_searches' => $this->Listings_Model->popular_searches($country_id,$cat_id_for),
				'nearby' => $this->Listings_Model->nearby($country_id,$cat_id_for)
			];

			if (isset($str_links))
				$data["links"] = explode('&nbsp;', $str_links);


			$this->load->view('frontend/listing_page/listingproperty', $data);
	
		} 
	}

	// save search
	public function savesearch(){
		parse_str($_POST['data'], $data);
		$raw_data = $this->input->post('data');
		$parent_cat = $this->Listingquery_Model->get_id_of_cat($data['parent_cat']);
		$parent_cat = isset($parent_cat) ? $parent_cat[0]->id : '';
		$loged_in_user_id = volgo_get_logged_in_user_id();
		if(!empty($loged_in_user_id)){
			$result = $this->Listings_Model->savesearch($raw_data,$loged_in_user_id,$parent_cat);
			if($result){
				$response = [
					'success' => true,
					'msg' => 'Your search have been saved',
				];
			}else{
				$response = [
					'success' => false,
					'msg' => 'Something went wrong',
				];
			}
		}else{
			$response = [
				'success' => false,
				'redirect' => 1,
				'msg' => 'Please login/register first to save search',
			];
		}
		
		echo json_encode($response);
		exit(); 
	}
	// remove search
	public function removesearch(){
		parse_str($_POST['data'], $data);
		$raw_data = $this->input->post('data');
		$parent_cat = $this->Listingquery_Model->get_id_of_cat($data['parent_cat']);
		$parent_cat = isset($parent_cat) ? $parent_cat[0]->id : '';
		$loged_in_user_id = volgo_get_logged_in_user_id();
		if(!empty($loged_in_user_id)){
			$result = $this->Listings_Model->removesearch($raw_data,$loged_in_user_id,$parent_cat);
			if($result){
				$response = [
					'success' => true,
					'msg' => 'Your search have been remove',
				];
			}else{
				$response = [
					'success' => false,
					'msg' => 'Something went wrong',
				];
			}
		}
		
		echo json_encode($response);
		exit(); 
	}



	/*
	 * view function started
	 * */


	public function view($cat_name = '', $per_page_limit = 10, $page = 1)
	{
		if ($this->uri->segment(2)) {
			$cat_name = $this->uri->segment(2);
		}

		$cat_id = $this->Listingquery_Model->get_id_of_cat($cat_name);

		if (!empty($cat_id)) {
			$parent_cat_name = $this->Listingquery_Model->get_name_of_paent_cat($cat_id[0]->id);
		}else{
			$parent_cat_name = '';
		}


		if (empty($cat_id))
			redirect('sorry');

		$cat_id = $cat_id[0]->id;
		$nearby_cat = $cat_id;

		$country_id = volgo_get_country_info_from_session();
		$country_id = $country_id['country_id'];
		if (isset($country_id)) {
			$country_id = $country_id;
		} else {
			$country_id = 166;
		}

		$total_row = $this->Listingquery_Model->record_count_listing($cat_id, $country_id);
		$total_row2 = $this->Listingquery_Model->record_count_listing2($cat_id, $country_id);

		if (is_null($total_row))
			$total_row = 0;
		if (is_null($total_row2))
			$total_row2 = 0;

		$total_row3 = '<b>' . number_format(intval($total_row)) . '</b> Featured & <b>' . number_format(intval($total_row2)) . '</b>  Recommended';


		$config = array();
		$config["base_url"] = base_url('category/') . $cat_name . '/' . $per_page_limit;

		$config['display_pages'] = TRUE;
		$config["total_rows"] = $total_row;
		$config["per_page"] = $per_page_limit;
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = 5;
		$config['uri_segment'] = 4;


		$config['full_tag_open'] = "<ul class='pagination dynamic_pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active page-link"><a href="#" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';


		$config['attributes'] = array('class' => 'page-link');
		$config['prev_link'] = '<';
		$config['prev_tag_open'] = '<li class="page-link ">';
		$config['prev_tag_close'] = '</li>';


		$config['next_link'] = '>';
		$config['next_tag_open'] = '<li class="page-link page-link-next">';
		$config['next_tag_close'] = '</li>';


		$this->pagination->initialize($config);
		if (intval($this->uri->segment(4))) {
			$page = intval(($this->uri->segment(4)));
		}

		$str_links = $this->pagination->create_links();

		$total_count_row = [];
		$sub_childs_cats = $this->Listingquery_Model->sub_child_cats($cat_id);
		foreach ($sub_childs_cats as $single_id) {
			$count = $this->Listingquery_Model->total_listing_get($single_id->id, $country_id);
			if (empty($count)) {
				$total_count_row[] = (object)[
					'subcat_id' => $single_id->id,
					'name' => $single_id->name,
					'slug' => $single_id->slug,
					'total' => 0,
				];
			} else {
				$total_count_row[] = (object)[
					'subcat_id' => $single_id->id,
					'slug' => $single_id->slug,
					'name' => $single_id->name,
					'total' => $count,
				];
			}
		}


		$cat_name = $this->Listingquery_Model->get_category_name($cat_id);
		$parent_name = $this->Listingquery_Model->get_parent_category_name($cat_id);

		$listing_by_cat_fetured = $this->Listingquery_Model->listing_by_cat_id_featured($cat_id, $per_page_limit, $page, $country_id, 'featured');
		$listing_by_cat_recommend = $this->Listingquery_Model->listing_by_cat_id_recommended($cat_id, 3, 1, $country_id, 'recommended');


		$new_arr = [];
		foreach ($listing_by_cat_recommend as $row) {
			if (empty($cat_id) || (intval($cat_id) !== $row['lisitng_info']->id)) {
				$cat_id = $row['lisitng_info']->id;
				$new_arr[$cat_id]['listing_details'] = [
					'id' => $row['lisitng_info']->id,
					'title' => $row['lisitng_info']->title,
					'slug' => $row['lisitng_info']->slug,
					'created_at' => $row['lisitng_info']->created_at,
					'category_id' => $row['lisitng_info']->category_id,
					'category_name' => $row['lisitng_info']->catgory_name,
					'listing_meta_id' => $row['lisitng_info']->listingcatid,
					'country_name' => $row['lisitng_info']->country_name,
					'city_name' => $row['lisitng_info']->city_name,
					'subcat_name' => $row['lisitng_info']->subcategoryname,
					'state_name' => $row['lisitng_info']->state_name,
				];
			}
			foreach ($row['meta_info'] as $single_meta) {
				$new_arr[$cat_id]['metas'][] = [
					'meta_key' => $single_meta->meta_key,
					'meta_value' => $single_meta->meta_value,
				];
			}
		}
		$new_arr = array_values($new_arr);

		$new_arr2 = [];
		foreach ($listing_by_cat_fetured as $row) {
			if (empty($cat_id) || (intval($cat_id) !== $row['lisitng_info']->id)) {
				$cat_id = $row['lisitng_info']->id;
				$new_arr2[$cat_id]['listing_details'] = [
					'id' => $row['lisitng_info']->id,
					'title' => $row['lisitng_info']->title,
					'slug' => $row['lisitng_info']->slug,
					'created_at' => $row['lisitng_info']->created_at,
					'category_id' => $row['lisitng_info']->category_id,
					'category_name' => $row['lisitng_info']->catgory_name,
					'listing_meta_id' => $row['lisitng_info']->listingcatid,
					'country_name' => $row['lisitng_info']->country_name,
					'city_name' => $row['lisitng_info']->city_name,
					'subcat_name' => $row['lisitng_info']->subcategoryname,
					'state_name' => $row['lisitng_info']->state_name,
				];
			}
			foreach ($row['meta_info'] as $single_meta) {
				$new_arr2[$cat_id]['metas'][] = [
					'meta_key' => $single_meta->meta_key,
					'meta_value' => $single_meta->meta_value,
				];
			}
		}
		$new_arr2 = array_values($new_arr2);
		$loged_in_user_id = volgo_get_logged_in_user_id();
		if (!empty($loged_in_user_id)) {
			$loged_in_user_id = $loged_in_user_id;
		} else {
			$loged_in_user_id = "nologedin";
		}
		$data = [
			'footer_block' => $this->Blocks_Model->get_block('footer_block'),
			'sub_childs_cats' => $total_count_row,
			'all_cuntry' => $this->Listingfilterquery_Model->get_all_countries(),
			'listing_by_cat_recommended' => $new_arr,
			'listing_by_cat_featured' => $new_arr2,
			'all_cats' => $this->Listingfilterquery_Model->get_all_categories(),
			'parent_cat_name' => $parent_cat_name,
			'cat_name' => $cat_name,
			'total_add' => $total_row3,
			'listing_fav' => $this->Listings_Model->get_favlisting($loged_in_user_id),
            'listing_save_search' => $this->Listings_Model->get_save_search($loged_in_user_id),
			'loged_in_user_id' => $loged_in_user_id,
			'listing_follow' => $this->Listings_Model->get_follow_listing($loged_in_user_id),
			'popular_searches' => $this->Listings_Model->popular_searches($country_id,$nearby_cat),
			'nearby' => $this->Listings_Model->nearby($country_id,$nearby_cat)
		];

		$data["links"] = explode('&nbsp;', $str_links);
		if ($cat_name === 'autos' || $parent_name === 'autos') {
			$this->load->view('frontend/listing_page/listingautos', $data);
		} else if ($cat_name === 'classified' || $parent_name === 'classified') {
			$this->load->view('frontend/listing_page/listingclassified', $data);
		} else if ($cat_name === 'services' || $parent_name === 'services') {
			$this->load->view('frontend/listing_page/listingservices', $data);
		} else if ($cat_name === 'property-for-sale' || $cat_name === 'property-for-rent' || $parent_name === 'property-for-sale' || $parent_name === 'property-for-rent') {
			$this->load->view('frontend/listing_page/listingproperty', $data);
		} else if ($cat_name === 'jobs' || $cat_name === 'jobs-wanted' || $parent_name === 'jobs' || $parent_name === 'jobs-wanted') {
			$this->load->view('frontend/listing_page/listingjobs', $data);
		} else if($cat_name === 'buying-lead' || $parent_name === 'buying-lead'){
            $this->load->view('frontend/buying-lead/view', $data);
            $this->load->view('frontend/buying-lead/all', $data);
		}else if($cat_name === 'seller-lead' || $parent_name === 'seller-lead'){
            $this->load->view('frontend/seller-lead/view', $data);
            $this->load->view('frontend/seller-lead/all', $data);
        }else{
            $this->load->view('frontend/listing_page/default-listing', $data);
        }


	}



	// check membership
	public function user_membership_check(){
		$loged_in_user_id = volgo_get_logged_in_user_id();
		if(!empty($loged_in_user_id)){
			$data = $this->Listings_Model->user_membership_check($loged_in_user_id);
			if(!empty($data)){
				if($data[0]->available_connect != 0){
					$this->Listings_Model->update_connects($data[0]->id,$data[0]->packages_id,$data[0]->available_connect);
					$response = [
						'success' => true,
					];
				}else{
					$response = [
						'success' => 3,
						'msg' => 'Your membership connects per day limits has been reached'
					];
				}
			}else{
				$response = [
					'success' => false,
					'redirect' => 1,
				];
			}
		}
		echo json_encode($response);
		exit();
	}

	// reset membership
	public function reset_membership(){
		$this->Listings_Model->reset_membership();
	}
}
