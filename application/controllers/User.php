<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['logged_in'])) {
			redirect('');
		}
	}

	public function index()
	{
		$searchtxt = array();
		/*$user_fullname = "";
		$user_email = "";
		$user_mob = "";
		$user_type = "";
		$search =  $this->input->post();
		if(isset($search["clearall"])){
			$session_data = array(
				'user_fullname' => '',
				'user_email' => '',
				'user_mob' => '',
				'user_type' => ''
			);
			$searchtxt['user_fullname'] = "";
			$searchtxt['user_email'] = "";
			$searchtxt['user_mob'] = "";
			$searchtxt['user_type'] = "";
			// Add user data in session
			$this->session->set_userdata('user', $session_data);

		}else if(isset($search["submit"])){
			if(!empty($search["user_fullname"])){
				$user_fullname = StringRepair($search["user_fullname"]);
				$searchtxt['user_fullname'] = $user_fullname;
			}
			if(!empty($search["user_email"])){
				$user_email = StringRepair($search["user_email"]);
				$searchtxt['user_email'] = $user_email;
			}
			if(!empty($search["user_mob"])){
				$user_mob = StringRepair($search["user_mob"]);
				$searchtxt['user_mob'] = $user_mob;
			}
			if(!empty($search["user_type"])){
				$user_type = StringRepair($search["user_type"]);
				$searchtxt['user_type'] = $user_type;
			}
		}else {
			if(!empty($this->session->userdata['user']['user_fullname'])){
				$user_fullname = StringRepair($this->session->userdata['user']['user_fullname']);
				$searchtxt['user_fullname'] = $user_fullname;
			}
			if(!empty($this->session->userdata['user']['user_email'])){
				$user_email = StringRepair($this->session->userdata['user']['user_email']);
				$searchtxt['user_email'] = $user_email;
			}
			if(!empty($this->session->userdata['user']['user_mob'])){
				$user_mob = StringRepair($this->session->userdata['user']['user_mob']);
				$searchtxt['user_mob'] = $user_mob;
			}
			if(!empty($this->session->userdata['user']['user_type'])){
				$user_type = StringRepair($this->session->userdata['user']['user_type']);
				$searchtxt['user_type'] = $user_type;
			}

		}*/


		// init params
		$params = array();
		$limit_per_page = 100000000;
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$total_records = $this->Queries->getUserCount($searchtxt);
		$params['user'] = $this->Queries->getUser($searchtxt, $limit_per_page, $start_index);
		$params['page'] = $start_index;
		$query = "select * from " . TBL_USERROLE . "";
		$params['userrole'] = $this->Queries->get_tab_list($query, 'id', 'user_role');
		$session_data = array(
			'pageuri' => $start_index
		);
		// Add user data in session
		$this->session->set_userdata('user', $session_data);
		if ($total_records > 0) {
			$config = PageConfig(base_url() . 'User/index', $total_records, $limit_per_page, '3');
			$this->pagination->initialize($config);
			// build paging links
			$params["links"] = $this->pagination->create_links();
		}

		$this->load->view('User/index', $params);
	}

	public function add($id = 0)
	{

		try {
			$user = "";
			if ($id != "" and $id != 0) {
				$query = "select * from " . TBL_USERINFO . " where id=" . $id;
				$user = $this->Queries->getSingleRecord($query);
			}
			$this->load->view('User/add', ['id' => $id, 'user' => $user]);
		} catch (Exception $e) {
			echo $e;
		}
	}

	public function save()
	{

		$this->form_validation->set_rules('user_email', 'User Email', 'required');
		$this->form_validation->set_rules('user_mob', 'User Mobile No.', 'required');
		$this->form_validation->set_rules('user_fullname', 'User Fullname', 'required');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$user_email = StringRepair($this->input->post('user_email'));
			$user_mob = StringRepair($this->input->post('user_mob'));
			$user_password = StringRepair($this->input->post('user_password'));
			$user_fullname = StringRepair($this->input->post('user_fullname'));
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



			$id = $this->input->post('id');
			$acti = $this->input->post('activate');
			if ($acti != "") {
				$act = 1;
			} else {
				$act = 0;
			}
			$today = date('Y-m-d H:i:s');
			if ($id != 0 and $id != "") {
				$query = "select * from " . TBL_USERINFO . " where user_email='" . $user_email . "' and id!=" . $id;
				$res = $this->Queries->getSingleRecord($query);
				if ($res > 0) {
					$this->session->set_flashdata('error_msg', 'User Email ID Already Exists...');
					return redirect('User/add/' . $id);
				}

				if ($user_password != "") {
					$form_data = array(
						'user_password' => $user_password,
						'updated_on' => $today
					);
					$this->Queries->updateRecord(TBL_USERINFO, $form_data, $id);
				}

				if ($filename != "") {

					$form_data = array(
						'company_logo' => $filename
					);
					$this->Queries->updateRecord(TBL_USERINFO, $form_data, $id);
				}

				$form_data = array(
					'user_email' => $user_email,
					'user_fullname' => $user_fullname,
					'user_mob' => $user_mob,
					'company_name' => $company_name,
					'company_address' => $company_address,
					'company_panno' => $company_panno,
					'company_gstno' => $company_gstno,
					'user_blocked' => $act,
					'updated_on' => $today
				);
				if ($this->Queries->updateRecord(TBL_USERINFO, $form_data, $id)) :
					$this->session->set_flashdata('success_msg', 'User Updated Successfully');
				else :
					$this->session->set_flashdata('error_msg', 'Failed To Update User');
				endif;
			} else {
				$query = "select * from " . TBL_USERINFO . " where user_email='" . $user_email . "'";
				$res = $this->Queries->getSingleRecord($query);
				if ($res > 0) {
					$this->session->set_flashdata('error_msg', 'User Email ID Already Exists...');
					$this->session->set_flashdata($data);
					return redirect('User/add');
				}
				$form_data = array(
					'user_email' => $user_email,
					'user_fullname' => $user_fullname,
					'user_mob' => $user_mob,
					'user_password' => $user_password,
					'company_name' => $company_name,
					'company_address' => $company_address,
					'company_panno' => $company_panno,
					'company_gstno' => $company_gstno,
					'company_logo' => $filename,
					'user_blocked' => $act,
					'user_image' => 'assets/img/profile.png',
					'updated_on' => $today
				);
				if ($this->Queries->addRecord(TBL_USERINFO, $form_data)) :
					$this->session->set_flashdata('success_msg', 'User Added Successfully');
				else :
					$this->session->set_flashdata('error_msg', 'Failed To Add User');
				endif;
			}

		}
		$page = "";
		if ($this->session->userdata["user"]["pageuri"] > 0) {
			$page = $this->session->userdata["user"]["pageuri"];
		}
		return redirect('User/index/' . $page);

	}
	public function delete($id)
	{
		$today = date('Y-m-d H:i:s');
		$form_data = array(
			'isdelete' => 1,
			'updated_on' => $today
		);
		if ($this->Queries->updateRecord(TBL_USERINFO, $form_data, $id)) :
			$this->session->set_flashdata('success_msg', 'User Deleted Successfully');
		else :
			$this->session->set_flashdata('error_msg', 'Failed To Delete User');
		endif;

		return redirect('User');
	}
}
