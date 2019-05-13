<?php
/**
 * Created by PhpStorm.
 * User: volgopoint.com
 * Date: 2/25/2019
 * Time: 1:05 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Model extends CI_Model
{

	private $table_name = 'b2b_users';

	public function add_user_from_facebook($email, $name, $id, $access_token, $access_token_metadata)
	{

		$name_arr = explode(' ', $name);

		if (count($name_arr) > 1 && isset($name_arr[0], $name_arr[1])) {
			$firstname = $name_arr[0];
			$lastname = $name_arr[1];
		} else if (isset($name_arr[0])) {
			$firstname = $name_arr[0];
			$lastname = '';
		} else {
			$firstname = $name_arr[0];
			$lastname = '';
		}

		$password = volgo_get_random_string(14);
		$this->session->set_userdata('facebook_user_password', $password);

		$data = array(
			'username' => $email,
			'firstname' => $firstname,
			'lastname ' => $lastname,
			'email' => $email,
			'password' => password_hash(($password), PASSWORD_BCRYPT),
			'is_deleted' => '0',
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s"),
		);


		$this->db->set($data);
		$is_inserted = $this->db->insert($this->table_name);

		if (!$is_inserted) {
			return false;
		} else {
			$user_insert_id = $this->db->insert_id();

			$meta_data = [
				'facebook_id' => $id,
				'facebook_token' => $access_token,
				'facebook_token_metadata'	=> serialize($access_token_metadata)
			];

			foreach ($meta_data as $key => $value) {

				$data2 = array(
					'meta_key' => $key,
					'meta_value' => $value,
					'user_id' => $user_insert_id
				);

				//save data in database

				$this->db->set($data2);
				$is_inserted = $this->db->insert('b2b_user_meta');
				if (!$is_inserted) {
					break;
				}
			}
			return $is_inserted;
		}
	}

	public function get_user_by_email($email)
	{
		$this->db->cache_on();
		$this->db->select('id, email');
		$this->db->from($this->table_name);
		$this->db->where('email', $email);
		$this->db->limit(1);
		$result = $this->db->get()->result();
		$this->db->cache_off();


		return ($result);

	}

	public function user_signup($input_data)
	{

		$username = $this->input->post('username');
		$firstname = $this->input->post('firstname');
		$lastname = $this->input->post('lastname');
		$email = $this->input->post('email');
		$password = $this->input->post('password');


		unset($input_data['username']);
		unset($input_data['firstname']);
		unset($input_data['lastname']);
		unset($input_data['email']);
		unset($input_data['password']);

		$data = array(
			'username' => $username,
			'firstname' => $firstname,
			'lastname ' => $lastname,
			'email' => $email,
			'password' => password_hash($password, PASSWORD_BCRYPT),
			'is_deleted' => '0',
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s"),
		);

		$this->db->set($data);
		$is_inserted = $this->db->insert($this->table_name);

		if (!$is_inserted) {

			$data = [
				'validation_errors' => 'Data Not Inserted Something happened Kindly Retry',
				'success_msg' => '',
			];

			$this->load->view('frontend/users/user_signup', $data);
			return false;
		} else {
			$user_insert_id = $this->db->insert_id();

			if (!empty($input_data)) {

				foreach ($input_data as $key => $value) {

					$data2 = array(
						'meta_key' => $key,
						'meta_value' => $value,
						'user_id' => $user_insert_id
					);

					//save data in database

					$this->db->set($data2);

					$is_inserted = $this->db->insert('b2b_user_meta');
					if (!$is_inserted) {
						break;
					}
				}
				return $is_inserted;
			} else {
				return true;
			}
		}
	}

	public function verify_user_signup($email)
	{
		$this->db->cache_on();
		$this->db->select('id');
		$this->db->from('b2b_users');
		$this->db->where('email', $email);
		$this->db->limit(1);

		$user = $this->db->get()->row();
		$this->db->cache_off();


		$id = $user->id;


		$this->db->where('meta_key', 'status');
		$this->db->where('user_id', intval($id));

		$this->db->set('meta_value', 'verified');
		return $this->db->update('b2b_user_meta');
	}

	public function verfiy_user_login($data)
	{
		$condition = "email=" . "'" . $data['form_data']['user_email'] . "'";
		$password = $data['form_data']['user_password'];

//		$this->db->cache_on();
		$this->db->select('email,password,id');
		$this->db->from('b2b_users');
		$this->db->where($condition);
		$this->db->limit(1);

		$query = $this->db->get();
//		$this->db->cache_off();


		$row = $query->row();

		if (empty($row))
			return false;

		if ($row->email === $data['form_data']['user_email'] && password_verify($password, $row->password))
			return true;

		return false;
	}

	public function verfiy_user_email($data)
	{
		$condition = "email=" . "'" . $data['form_data']['user_email'] . "'";

		$this->db->cache_on();
		$this->db->select('email,id');
		$this->db->from('b2b_users');
		$this->db->where($condition);
		$this->db->limit(1);

		$query = $this->db->get();
		$this->db->cache_off();


		$row = $query->row();

		if (empty($row))
			return false;

		if ($row->email === $data['form_data']['user_email'])
			return true;

		return false;
	}

	public function update_user_password($user_email, $password)
	{
		$this->db->set('password', password_hash($password, PASSWORD_BCRYPT));
		$this->db->where('email', $user_email);
		$this->db->update('b2b_users');
		return true;
	}

}

