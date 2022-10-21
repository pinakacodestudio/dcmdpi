<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller
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
		$total_records = $this->Queries->getCustomerCount($searchtxt);
		$params['customer'] = $this->Queries->getCustomer($searchtxt, $limit_per_page, $start_index);
		$params['page'] = $start_index;
		$session_data = array(
			'pageuri' => $start_index
		);
		// Add user data in session
		$this->session->set_userdata('customer', $session_data);
		if ($total_records > 0) {
			$config = PageConfig(base_url() . 'Customer/index', $total_records, $limit_per_page, '3');
			$this->pagination->initialize($config);
			// build paging links
			$params["links"] = $this->pagination->create_links();
		}

		$this->load->view('Customer/index', $params);
	}

	public function add($id = 0)
	{
		try {
			$customer = "";
			if ($id != "" and $id != 0) {
				$query = "select * from " . TBL_CUSTOMER . " where id=" . $id;
				$customer = $this->Queries->getSingleRecord($query);
			}
			$this->load->view('Customer/add', ['id' => $id, 'customer' => $customer]);
		} catch (Exception $e) {
			echo $e;
		}
	}
	public function save()
	{

		$this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
		$this->form_validation->set_rules('customer_email', 'Customer Email', 'required');
		$this->form_validation->set_rules('customer_mobile', 'Customer Mobile', 'required');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$customer_name = StringRepair($data['customer_name']);
			$company_name = StringRepair($data['company_name']);
			$customer_mobile = StringRepair($data['customer_mobile']);
			$customer_email = StringRepair($data['customer_email']);
			$customer_address = StringRepair($data['customer_address']);
			$contract_rate = StringRepair($data['contract_rate']);
			$gstno = StringRepair($data['gstno']);
			$id = $this->input->post('id');
			$today = date('Y-m-d H:i:s');
			if ($id != 0 and $id != "") {
				/*
				$query = "select * from ".TBL_CUSTOMER." where customer_email='".$customer_email."' and id!=".$id;
				$res = $this->Queries->getSingleRecord($query);
				if($res > 0){
					$this->session->set_flashdata('error_msg','Customer Email ID Already Exists...');
					return redirect('Customer/add/'.$id);
				}
				 */
				$form_data = array(
					'customer_email' => $customer_email,
					'customer_name' => $customer_name,
					'customer_mobile' => $customer_mobile,
					'company_name' => $company_name,
					'customer_address' => $customer_address,
					'contract_rate' => $contract_rate,
					'gstno' => $gstno,
					'updated_on' => $today
				);
				if ($this->Queries->updateRecord(TBL_CUSTOMER, $form_data, $id)) :
					$this->session->set_flashdata('success_msg', 'Customer Updated Successfully');
				else :
					$this->session->set_flashdata('error_msg', 'Failed To Update Customer');
				endif;
			} else {
				$query = "select * from " . TBL_CUSTOMER . " where customer_email='" . $customer_email . "'";
				$res = $this->Queries->getSingleRecord($query);
				if ($res > 0) {
					$this->session->set_flashdata('error_msg', 'Customer Email ID Already Exists...');
					$this->session->set_flashdata($data);
					return redirect('Customer/add');
				}
				$form_data = array(
					'customer_email' => $customer_email,
					'customer_name' => $customer_name,
					'customer_mobile' => $customer_mobile,
					'company_name' => $company_name,
					'customer_address' => $customer_address,
					'contract_rate' => $contract_rate,
					'gstno' => $gstno,
					'updated_on' => $today
				);
				if ($this->Queries->addRecord(TBL_CUSTOMER, $form_data)) :
					$this->session->set_flashdata('success_msg', 'Customer Added Successfully');
				else :
					$this->session->set_flashdata('error_msg', 'Failed To Add Customer');
				endif;
			}

		}
		$page = "";
		if ($this->session->userdata["customer"]["pageuri"] > 0) {
			$page = $this->session->userdata["customer"]["pageuri"];
		}
		return redirect('Customer/index/' . $page);

	}
	public function delete($id)
	{
		$today = date('Y-m-d H:i:s');
		$form_data = array(
			'isdelete' => 1,
			'updated_on' => $today
		);
		if ($this->Queries->updateRecord(TBL_CUSTOMER, $form_data, $id)) :
			$this->session->set_flashdata('success_msg', 'Customer Deleted Successfully');
		else :
			$this->session->set_flashdata('error_msg', 'Failed To Delete Customer');
		endif;

		return redirect('Customer');
	}
}
