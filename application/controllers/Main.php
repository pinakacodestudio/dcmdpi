<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('login');
	}

	// Check for user login process
	public function login_process()
	{

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == false) {
			if (isset($this->session->userdata['logged_in'])) {
				redirect('dashboard');
			} else {
				redirect('');
			}
		} else {
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);
			$result = $this->Queries->login($data);

			if ($result == true) {

				$username = $this->input->post('username');
				$result = $this->Queries->read_user_information($username);
				if ($result != false) {
					if ($result[0]->user_blocked == 1) {
						$session_data = array(
							'username' => $result[0]->user_name,
							'userid' => $result[0]->id,
							'user_image' => $result[0]->user_image,
							'user_fullname' => $result[0]->user_fullname,
							'user_type' => $result[0]->user_type
						);
						// Add user data in session
						$this->session->set_userdata('logged_in', $session_data);
						redirect('dashboard');
					} else {
						$this->session->set_flashdata('error_msg', 'Your Account Had been Blocked! Please Contact Administrator.');
						redirect('');
					}
				}
			} else {
				$this->session->set_flashdata('error_msg', 'Invalid Username & Password');
				redirect('');
			}
		}
	}

	public function editprofile()
	{
		$query = "select * from " . TBL_USERINFO . " where id=" . $this->session->userdata['logged_in']['userid'];
		$res = $this->Queries->getSingleRecord($query);
		if ($res == null) {
			$this->session->set_flashdata('error_msg', 'No Such User');
			redirect('');
		}
		$params['user'] = $res;
		$this->load->view('editprofile', $params);
	}

	function saveprofile()
	{
		$this->form_validation->set_rules('user_fullname', 'User Fullname', 'required');
		if ($this->form_validation->run()) {
			$user_fullname = StringRepair($this->input->post('user_fullname'));
			$user_mobile = StringRepair($this->input->post('user_mobile'));
			$userid = $this->session->userdata['logged_in']['userid'];
			$company_name = StringRepair($this->input->post('company_name'));
			$company_address = StringRepair($this->input->post('company_address'));
			$company_panno = StringRepair($this->input->post('company_panno'));
			$company_gstno = StringRepair($this->input->post('company_gstno'));

			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'jpeg|jpg|png';
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('filename')) {
				$this->session->set_flashdata('error', $this->upload->display_errors());
			} else {
				$data = array('upload_data' => $this->upload->data());
				$filename = "uploads/" . $data["upload_data"]["file_name"];
			}

			if (!$this->upload->do_upload('filename2')) {
				$this->session->set_flashdata('error', $this->upload->display_errors());
			} else {
				$data = array('upload_data' => $this->upload->data());
				$filename2 = "uploads/" . $data["upload_data"]["file_name"];
			}

			if ($filename != "") {

				$form_data = array(
					'user_image' => $filename
				);
				$this->Queries->updateRecord(TBL_USERINFO, $form_data, $userid);
				$this->session->userdata["logged_in"]["user_image"] = $filename;
			}


			if ($filename2 != "") {

				$form_data = array(
					'company_logo' => $filename2
				);
				$this->Queries->updateRecord(TBL_USERINFO, $form_data, $userid);
			}

			$today = date('Y-m-d H:i:s');
			$form_data = array(
				'user_fullname' => $user_fullname,
				'user_mob' => $user_mobile,
				'company_name' => $company_name,
				'company_address' => $company_address,
				'company_panno' => $company_panno,
				'company_gstno' => $company_gstno
			);


			if ($this->Queries->updateRecord(TBL_USERINFO, $form_data, $userid)) :
				$this->session->userdata["logged_in"]["user_fullname"] = $user_fullname;

				$this->session->set_flashdata('success_msg', 'Profile Updated Successfully');
			else :
				$this->session->set_flashdata('error_msg', 'Failed To Update Profile');
			endif;
		}

		redirect('Main/editprofile/');
	}
}
