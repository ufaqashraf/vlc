<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 2/28/2019
 * Time: 1:38 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();


		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('Blocks_Model');
		$this->load->model('Dashboard_Model');
		$this->load->model('Categories_Model');
		$this->load->model('Listings_Model');
		$this->load->model('Listingfilterquery_Model');
		$this->load->model('Basic_Model');
		$this->load->model('Categories_Model');
		$this->load->library('user_agent');
		$this->load->library('session');
		$this->load->helper('functions_helper');


	}


	public function index()
	{

		$session_data = volgo_decrypt_message($_SESSION['volgo_user_login_data']);
		$session_data = explode(',', $session_data);
		$logedin_user_email = $session_data[0];
		$user_detail = $this->Dashboard_Model->get_curent_user_detail($logedin_user_email);


		if (!empty($user_detail)) {

			$user_meta = $this->Dashboard_Model->get_user_meta($user_detail[0]->id);

			foreach ($user_meta as $single_meta) {
				if ($single_meta->meta_key == 'nationality') {
					$countryid = $single_meta->meta_value;
				}
				if ($single_meta->meta_key == 'states') {
					$state_id = $single_meta->meta_value;
				}
			}
		}


		if (volgo_front_is_logged_in()) {
			$country = volgo_get_countries();
			if (isset($countryid)) {
				$states = volgo_get_states_by_country_id($countryid);
			} else {
				$states = '';
			}
			if (isset($state_id)) {
				$city = volgo_get_cities_by_state_id($state_id);
			} else {
				$city = '';
			}

			if (!empty($user_detail[0]->id)) {
				$logedin_user_id = $user_detail[0]->id;
			} else {
				$logedin_user_id = '';
			}
			$followers = $this->Dashboard_Model->get_followers($logedin_user_id);
			if (!empty($followers)) {
				$user_detail_of_followers = [];
				foreach ($followers as $single_user_id) {
					$user_detail_of_followers[] = $this->Dashboard_Model->get_users_detail($single_user_id);
				}

			} else {
				$user_detail_of_followers = '';
			}

			$following = $this->Dashboard_Model->get_followings($logedin_user_id);
			if (!empty($following)) {
				$user_detail_of_followings = [];
				foreach ($following as $single_user_id) {
					$user_detail_of_following[] = $this->Dashboard_Model->get_users_detail($single_user_id);
				}
			} else {
				$user_detail_of_following = '';
			}


			$loged_in_userid = volgo_get_logged_in_user_id();

			$get_all_fav_listings_ids = $this->Dashboard_Model->get_save_listing_ids($loged_in_userid);

			if (!empty($get_all_fav_listings_ids)) {

				$get_all_fav_listings = $this->Dashboard_Model->get_saved_listings($get_all_fav_listings_ids);

			} else {
				$get_all_fav_listings = 'nolisitng';
			}

			$get_user_listing = $this->Dashboard_Model->get_user_listing($loged_in_userid);
			if (!empty($get_user_listing)) {

				$get_user_listing = $get_user_listing;

			} else {
				$get_user_listing = 'nolisitng';
			}

			//show saved search
			$responseArray=[];
			$search_data = $this->Basic_Model->basicSelect('b2b_user_meta','meta_key','save_search');
			if (!empty($search_data)) {
				$saved_search = $search_data->result();

				foreach($saved_search as $row){
					$singleResp=[];
					$rowMetaValue=json_decode($row->meta_value);
					if($rowMetaValue && $rowMetaValue->link){
						$get_array= [];
						if (strchr($rowMetaValue->link, "?")) {
							$split_url = explode('?', $rowMetaValue->link);
							parse_str($split_url[1], $get_array);
							$get_array=(array)$get_array;
							//get cat name
							$cat_id = $get_array['parent_cat_select'];
							$cat_name =$this->Categories_Model->get_category_by_id($cat_id);
							$get_array['parent_cat_select']=$cat_name[0]->name;
							//get subcat name
							$subcat_id = $get_array['child_cats'];
							$subcat_name =$this->Categories_Model->get_category_by_id($subcat_id);
							$get_array['child_cats']=$subcat_name[0]->name;
						}
						else
						{
							$split_url = explode('/', $rowMetaValue->link);
							$get_array['cat_name']=$split_url[1];
//							$get_array['select_state']="";
//							$get_array['selected_city']="";
//							$get_array['parent_cat_select']="";
//							$get_array['child_cats']="";
//							$get_array['search_query']="";
						}

						$singleResp['id']=$row->id;
						$singleResp['full_url']=$rowMetaValue->link;
						$singleResp['user_id']=$row->user_id;
						$singleResp['link']=$get_array;
						$singleResp['time']=$this->time_elapsed_string($rowMetaValue->time);
						$responseArray[]=$singleResp;
					}

				}

			}

			$data = [
				'footer_block' => $this->Blocks_Model->get_block('footer_block'),
				'main_categories' => $this->Categories_Model->get_main_cats_for_homepage_search(),
				'user_detail' => $user_detail,
				'user_meta_detail' => $user_meta,
				'all_country' => $country,
				'states' => $states,
				'city' => $city,
				'followers' => $user_detail_of_followers,
				'following' => $user_detail_of_following,
				'fav_adds' => $get_all_fav_listings,
				'all_cats' => $this->Listingfilterquery_Model->get_all_categories(),
				'user_adds' => $get_user_listing,
				'saved_search' => $responseArray,
			];

			$this->load->view('frontend/dashboard/dashboard.php', $data);


		} else {

			redirect('login?redirected_to=' . base_url('dashboard'));
		}
	}

	public function insert()
	{

		$session_data = volgo_decrypt_message($_SESSION['volgo_user_login_data']);
		$session_data = explode(',', $session_data);
		$logedin_user_email = $session_data[0];
		$user_detail = $this->Dashboard_Model->get_curent_user_detail($logedin_user_email);

		if (!empty($user_detail)) {

			$user_meta = $this->Dashboard_Model->get_user_meta($user_detail[0]->id);

		}

		$input_data = filter_input_array(INPUT_POST);


		$firstname = $input_data['firstname'];
		unset($input_data['firstname']);
		$lastname = $input_data['lastname'];
		unset($input_data['lastname']);

		if (isset($_FILES['cv']) && !empty($_FILES['cv']['name'][0])) {

			$config['upload_path'] = './uploads/cv';
			$config['allowed_types'] = 'pdf|doc|docx|txt';
			$config['max_size'] = '4096';

			$this->load->library('upload', $config);
			$this->upload->display_errors('', '');

			if (!$this->upload->do_upload("cv")) {
				echo $this->upload->display_errors();
				die();
				$this->data['error'] = array('error' => $this->upload->display_errors());
			} else {
				$upload_result = $this->upload->data();
				$cv = $upload_result['file_name'];
			}


		} else {
			foreach ($user_meta as $single_meta) {
				if ($single_meta->meta_key == 'user_cv') {
					$cv = $single_meta->meta_value;
				}


			}

		}


		if (!empty($firstname)) {
			$update_firstname = $this->Dashboard_Model->update_firstname($firstname, $user_detail[0]->id);
		}
		if (!empty($lastname)) {
			$update_lastname = $this->Dashboard_Model->update_lastname($lastname, $user_detail[0]->id);
		}
		$input_data['user_cv'] = $cv;
		$dbinsertdata = $this->Dashboard_Model->insert_metas_for_user($input_data, $user_detail[0]->id);


		if ($dbinsertdata) {
			if (volgo_front_is_logged_in()) {
				$this->session->set_flashdata('success_msg', 'Data inserted successfully.');
				redirect('dashboard');
			} else {
				redirect('login');
			}
		} else {

			if (volgo_front_is_logged_in()) {
				$this->session->set_flashdata('validation_errors', 'Some Error Occur Try Agian.');
				redirect('dashboard');
			} else {
				redirect('login');
			}

		}


	}

	public function follow($user_id_of_user, $slug)
	{
		if (!empty($_SESSION['volgo_user_login_data'])) {

			$session_data = volgo_decrypt_message($_SESSION['volgo_user_login_data']);
			$session_data = explode(',', $session_data);
			$logedin_user_email = $session_data[0];
			$user_detail = $this->Dashboard_Model->get_curent_user_detail($logedin_user_email);

			if (!empty($user_detail)) {

				$user_meta = $this->Dashboard_Model->get_user_meta($user_detail[0]->id);
				$loged_in_user_id = $user_detail[0]->id;

			}
		} else {
			redirect('login?redirected_to=' . base_url($slug));
		}


		$followers = $this->Dashboard_Model->store_followers($user_id_of_user, $user_detail[0]->id);


		if ($followers) {


			redirect('' . base_url($slug));

		} else {
			redirect('' . base_url($slug));
		}


	}

	public function unfollow($user_id_of_user, $slug)
	{


		if (!empty($_SESSION['volgo_user_login_data'])) {

			$session_data = volgo_decrypt_message($_SESSION['volgo_user_login_data']);
			$session_data = explode(',', $session_data);
			$logedin_user_email = $session_data[0];
			$user_detail = $this->Dashboard_Model->get_curent_user_detail($logedin_user_email);

			if (!empty($user_detail)) {

				$user_meta = $this->Dashboard_Model->get_user_meta($user_detail[0]->id);
				$loged_in_user_id = $user_detail[0]->id;

			}
		} else {
			redirect('login?redirected_to=' . base_url($slug));
		}

		$unfollowers = $this->Dashboard_Model->unstore_followers($user_id_of_user, $user_detail[0]->id);

		if ($unfollowers) {

			redirect('' . base_url($slug));

		}


	}

	public function unfollow_dashboard($user_id_of_user)
	{
		if (!empty($_SESSION['volgo_user_login_data'])) {

			$session_data = volgo_decrypt_message($_SESSION['volgo_user_login_data']);
			$session_data = explode(',', $session_data);
			$logedin_user_email = $session_data[0];
			$user_detail = $this->Dashboard_Model->get_curent_user_detail($logedin_user_email);

			if (!empty($user_detail)) {

				$user_meta = $this->Dashboard_Model->get_user_meta($user_detail[0]->id);
				$loged_in_user_id = $user_detail[0]->id;

			}
		} else {
			redirect('login?redirected_to=' . base_url($slug));
		}


		$unfollowers = $this->Dashboard_Model->unstore_followers($user_id_of_user, $user_detail[0]->id);

		if ($unfollowers) {

			redirect('dashboard#followers');

		} else {

			"contact administrator";
		}

	}


	public function unfollowing_dashboard($user_id_of_user)
	{

		if (!empty($_SESSION['volgo_user_login_data'])) {

			$session_data = volgo_decrypt_message($_SESSION['volgo_user_login_data']);
			$session_data = explode(',', $session_data);
			$logedin_user_email = $session_data[0];
			$user_detail = $this->Dashboard_Model->get_curent_user_detail($logedin_user_email);

			if (!empty($user_detail)) {

				$user_meta = $this->Dashboard_Model->get_user_meta($user_detail[0]->id);
				$loged_in_user_id = $user_detail[0]->id;

			}
		} else {
			redirect('login?redirected_to=' . base_url($slug));
		}


		$unfollowers = $this->Dashboard_Model->unstore_followings($user_id_of_user, $user_detail[0]->id);

		if ($unfollowers) {

			redirect('dashboard#followers');

		} else {

			"contact administrator";
		}

	}


	public function deactivateacuton($id)
	{

		$soft_delete = $this->Dashboard_Model->soft_delete($id);

		if ($soft_delete) {
			$this->session->sess_destroy();
			redirect("home");
		}


	}


	public function fav_add()
	{

		if ($_POST["userid"] == 0) {

			echo json_encode("nolog");
			exit();
		}
		if (!empty($_POST["listing_id"]) && !empty($_POST["userid"])) {


			$listing_id = $this->input->post('listing_id');
			$loged_in_userid = $this->input->post('userid');

			$fav_adss = $this->Dashboard_Model->fav_add($listing_id, $loged_in_userid);

			echo json_encode($fav_adss);
			exit();
		}

	}
	public function follow_add()
	{

		if ($_POST["userid"] == 0) {

			echo json_encode("nolog");
			exit();
		}
		if (!empty($_POST["listing_id"]) && !empty($_POST["userid"])) {


			$listing_id = $this->input->post('listing_id');
			$loged_in_userid = $this->input->post('userid');

			$follow_adss = $this->Dashboard_Model->follow_add($listing_id, $loged_in_userid);

			echo json_encode($follow_adss);
			exit();
		}

	}
	public function remove_fav()
	{

		if ($_POST["userid"] == 0) {

			return "nolog";
		}
		if (!empty($_POST["listing_id"]) && !empty($_POST["userid"])) {


			$listing_id = $this->input->post('listing_id');
			$loged_in_userid = $this->input->post('userid');

			$remove = $this->Dashboard_Model->remove_fav_add($listing_id, $loged_in_userid);

			echo json_encode($remove);
			exit();
		}

	}

	public function remove_follow()
	{

		if ($_POST["userid"] == 0) {

			return "nolog";
		}
		if (!empty($_POST["listing_id"]) && !empty($_POST["userid"])) {


			$listing_id = $this->input->post('listing_id');
			$loged_in_userid = $this->input->post('userid');

			$remove = $this->Dashboard_Model->remove_follow_add($listing_id, $loged_in_userid);

			echo json_encode($remove);
			exit();
		}

	}


	public function search_fav_add($listing_id, $slug, $slug2)
	{

		$loged_in_userid = volgo_get_logged_in_user_id();
		if (empty($loged_in_userid)) {
			redirect('login?redirected_to=' . base_url($slug));
		}

		$fav_adss = $this->Dashboard_Model->save_search_add($listing_id, $loged_in_userid);

		if ($fav_adss) {

			redirect('' . base_url($slug . '/' . $slug2));
		}


	}

	public function remove_search_fav_add($listing_id, $slug, $slug2)
	{

		$loged_in_userid = volgo_get_logged_in_user_id();
		if (empty($loged_in_userid)) {
			redirect('login?redirected_to=' . base_url($slug));
		}

		$removfav_adss = $this->Dashboard_Model->remove_save_search_add($listing_id, $loged_in_userid);

		if ($removfav_adss) {

			redirect('' . base_url($slug . '/' . $slug2));
		}


	}


	public function remove_fav_add($listing_id, $slug)
	{

		$loged_in_userid = volgo_get_logged_in_user_id();
		if (empty($loged_in_userid)) {
			redirect('login?redirected_to=' . base_url($slug));
		}

		$removfav_adss = $this->Dashboard_Model->remove_fav_add($listing_id, $loged_in_userid);

		if ($removfav_adss) {

			redirect('' . base_url($slug));
		}


	}

	public function del_listing($id)
	{

		$soft_delete = $this->Dashboard_Model->listing_delete($id);

		if ($soft_delete) {

			redirect("dashboard");
		} else {
			echo "Contact Administrator";
		}


	}

	public function save_search_history(){

		$loged_in_user_id = volgo_get_logged_in_user_id();
		$url = $this->agent->referrer();
		$link = str_replace(base_url(), '', $url);
		$meta_array = [
			'link' => $link,
			'time' => date("Y-m-d H:i:s"),
		];
		$meta_value = json_encode($meta_array);
		//save search
		$insert_id = $this->Dashboard_Model->save_search($loged_in_user_id, $meta_value);
		$this->session->set_userdata('search_history_id',$insert_id);
		$data = [
			'loged_in_user_id' => $loged_in_user_id,
			'insert_id' => $insert_id,
		];
		echo json_encode($data);
		exit();

	}

	public function remove_search_history(){
		if($this->session->userdata('search_history_id') != ''){
			$delete_id = $this->session->userdata('search_history_id');
			$this->Basic_Model->basicDelete('b2b_user_meta','id',$delete_id);
			$this->session->unset_userdata('search_history_id');
			echo ("removed");
			exit;
		}
	}

	public function test(){

		$search_data = $this->Basic_Model->basicSelect('b2b_user_meta','meta_key','save_search');
//		print_r($search_data->result());exit;
		if (!empty($search_data)) {
			$saved_search = $search_data->result();

			$responseArray=[];

			foreach($saved_search as $row){
				$singleResp=[];
				$rowMetaValue=json_decode($row->meta_value);
//				print_r($rowMetaValue); exit;
				if($rowMetaValue && $rowMetaValue->link){
					$get_array= [];
					if (strchr($rowMetaValue->link, "?")) {
						$split_url = explode('?', $rowMetaValue->link);
						parse_str($split_url[1], $get_array);
						$get_array=(array)$get_array;
						//get cat name
						$cat_id = $get_array['parent_cat_select'];
						$cat_name =$this->Categories_Model->get_category_by_id($cat_id);
						$get_array['parent_cat_select']=$cat_name[0]->name;
						//get subcat name
						$subcat_id = $get_array['child_cats'];
						$subcat_name =$this->Categories_Model->get_category_by_id($subcat_id);
						$get_array['child_cats']=$subcat_name[0]->name;
//						print_r($get_array);exit;
					}
					else
					{
						$split_url = explode('/', $rowMetaValue->link);
						$get_array['cat_name']=$split_url[1];
						$get_array['select_state']="";
						$get_array['selected_city']="";
						$get_array['parent_cat_select']="";
						$get_array['child_cats']="";
						$get_array['search_query']="";
					}

					$singleResp['id']=$row->id;
					$singleResp['full_url']=$rowMetaValue->link;
					$singleResp['user_id']=$row->user_id;
					$singleResp['link']=$get_array;
					$singleResp['time']=$this->time_elapsed_string($rowMetaValue->time);
					$responseArray[]=$singleResp;
				}

			}
			print_r($responseArray);
						exit;

		}
	}
	public	function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

}
