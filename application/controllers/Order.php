<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller
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
		$sdate = "";
		$edate = "";
		$itemno = "";
		$parttype = "";
		$challanno = "";
		$customerid = "";
		$sortbycol = "";
		$sortby = "";
		$search = $this->input->post();
		if (isset($search["clearall"])) {
			$session_data = array(
				'sortbycol' => '',
				'sortby' => '',
				'itemno' => '',
				'parttype' => '',
				'challanno' => '',
				'customerid' => '',
				'sdate' => '',
				'edate' => ''
			);
            // Add user data in session
			$this->session->set_userdata('orders', $session_data);
		} else if (isset($search["submit"])) {
			if (!empty($search["sdate"])) {
				$sdate = $search["sdate"];
				$date = new DateTime($sdate);
				$searchtxt["sdate"] = $date->format('Y-m-d');
			}

			if (!empty($search["edate"])) {
				$edate = $search["edate"];
				$date = new DateTime($edate);
				$searchtxt["edate"] = $date->format('Y-m-d');
			}
			if (!empty($search["itemno"])) {
				$itemno = $search["itemno"];
				$searchtxt["itemno"] = $itemno;
			}
			if (!empty($search["parttype"])) {
				$parttype = $search["parttype"];
				$searchtxt["parttype"] = $parttype;
			}
			if (!empty($search["challanno"])) {
				$challanno = $search["challanno"];
				$searchtxt["challanno"] = $challanno;
			}
			if (!empty($search["customerid"])) {
				$customerid = $search["customerid"];
				$searchtxt["customerid"] = $customerid;
			}
			if (!empty($search["sortby"])) {
				$sortby = $search["sortby"];
				$searchtxt["sortby"] = $sortby;
			}
			if (!empty($search["sortbycol"])) {
				$sortbycol = $search["sortbycol"];
				$searchtxt["sortbycol"] = $sortbycol;
			}
		} else {
			if (!empty($this->session->userdata['orders']['sdate']) && $this->session->userdata['orders']['sdate'] != "") {
				$sdate = $this->session->userdata['orders']['sdate'];
				$date = new DateTime($sdate);
				$searchtxt["sdate"] = $date->format('Y-m-d');
				$sdate = $this->session->userdata['orders']['sdate'];
			}
			if (!empty($this->session->userdata['orders']['edate']) && $this->session->userdata['orders']['edate'] != "") {
				$edate = $this->session->userdata['orders']['edate'];
				$date = new DateTime($edate);
				$searchtxt["edate"] = $date->format('Y-m-d');
				$edate = $this->session->userdata['orders']['edate'];
			}
			if (!empty($this->session->userdata['orders']['itemno'])) {
				$itemno = $this->session->userdata['orders']['itemno'];
				$searchtxt['itemno'] = $itemno;
			}
			if (!empty($this->session->userdata['orders']['parttype'])) {
				$parttype = $this->session->userdata['orders']['parttype'];
				$searchtxt['parttype'] = $parttype;
			}
			if (!empty($this->session->userdata['orders']['challanno'])) {
				$challanno = $this->session->userdata['orders']['challanno'];
				$searchtxt['challanno'] = $challanno;
			}
			if (!empty($this->session->userdata['orders']['customerid'])) {
				$customerid = $this->session->userdata['orders']['customerid'];
				$searchtxt['customerid'] = $customerid;
			}
			if (!empty($this->session->userdata['orders']['sortbycol'])) {
				$sortbycol = $this->session->userdata['orders']['sortbycol'];
				$searchtxt['sortbycol'] = $sortbycol;
			}
			if (!empty($this->session->userdata['orders']['sortby'])) {
				$sortby = $this->session->userdata['orders']['sortby'];
				$searchtxt['sortby'] = $sortby;
			}
		}

        // init params
		$params = array();
		$limit_per_page = 100000000;
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$total_records = $this->Queries->getOrderCount($searchtxt);
		$params['orderlist'] = $this->Queries->getOrder($searchtxt, $limit_per_page, $start_index);
		$params['page'] = $start_index;
		$session_data = array(
			'sortbycol' => $sortbycol,
			'sortby' => $sortby,
			'itemno' => $itemno,
			'parttype' => $parttype,
			'challanno' => $challanno,
			'customerid' => $customerid,
			'sdate' => $sdate,
			'edate' => $edate,
			'pageuri' => $start_index
		);
       // Add user data in session
		$this->session->set_userdata('orders', $session_data);
		if ($total_records > 0) {
			$config = PageConfig(base_url() . 'Order/index', $total_records, $limit_per_page, '3');
			$this->pagination->initialize($config);
			// build paging links
			$params["links"] = $this->pagination->create_links();
		}

		$query = "select id,company_name from " . TBL_CUSTOMER . " where isdelete=0 ";
		$params["customerlist"] = $this->Queries->get_tab_list($query, 'id', 'company_name');

		$query = "select id,item_no from " . TBL_ORDER . " where isdelete=0 group by item_no";
		$params["itemlist"] = $this->Queries->get_tab_list($query, 'item_no', 'item_no');

		$query = "select id,part_type from " . TBL_ORDER . " where isdelete=0 group by part_type";
		$params["parttypelist"] = $this->Queries->get_tab_list($query, 'part_type', 'part_type');

		$this->load->view('Order/index', $params);
	}

	public function add($id = 0)
	{
		$query = "select * from " . TBL_CUSTOMER . " where isdelete=0";
		$customerlist = $this->Queries->get_tab_list($query, 'id', 'company_name');
		$part_type = array('IR' => 'IR', 'OR' => 'OR','BUSH'=>'BUSH','SET'=>'SET');
		try {
			$order = "";
			if ($id != "" and $id != 0) {
				$query = "select * from " . TBL_ORDER . " where id=" . $id;
				$order = $this->Queries->getSingleRecord($query);
			}
			$data = array(
				'id' => $id, 
				'order' => $order, 
				'customerlist' => $customerlist,
				'part_type_list' => $part_type);
			$this->load->view('Order/add', $data);
		} catch (Exception $e) {
			echo $e;
		}
	}
	public function save()
	{

		$this->form_validation->set_rules('received_date', 'Received Date', 'required');
		$this->form_validation->set_rules('main_chalan_no', 'Main Challan No.', 'required');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$received_date = StringRepair($data['received_date']);
			$date = new DateTime($received_date);
			$received_date = $date->format('Y-m-d');
			$main_chalan_no = StringRepair($data['main_chalan_no']);
			$chalan_date = StringRepair($data['chalan_date']);
			$date = new DateTime($chalan_date);
			$chalan_date = $date->format('Y-m-d');
			$chalan_no = StringRepair($data['chalan_no']);
			$from_forgine_party = StringRepair($data['from_forgine_party']);
			$main_party = StringRepair($data['main_party']);
			$item_no = StringRepair($data['item_no']);
			$part_type = StringRepair($data['part_type']);
			$po_no = StringRepair($data['po_no']);
			$batch_qty = StringRepair($data['batch_qty']);
			$weight_piece = StringRepair($data['weight_piece']);
			$total_weight = StringRepair($data['total_weight']);
			$note = StringRepair($data['note']);
			$id = $this->input->post('id');
			$today = date('Y-m-d H:i:s');
			$orderdate = date('m-d');
			if ($id != 0 and $id != "") {

				$form_data = array(
					'received_date' => $received_date,
					'main_chalan_no' => $main_chalan_no,
					'chalan_date' => $chalan_date,
					'chalan_no' => $chalan_no,
					'from_forgine_party' => $from_forgine_party,
					'main_party' => $main_party,
					'item_no' => $item_no,
					'part_type' => $part_type,
					'po_no' => $po_no,
					'batch_qty' => $batch_qty,
					'weight_piece' => $weight_piece,
					'total_weight' => $total_weight,
					'updated_on' => $today,
					'note' => $note
				);
				if ($this->Queries->updateRecord(TBL_ORDER, $form_data, $id)) :

					$form_data = array(
					'orderid' => $id,
					'qty' => $batch_qty,
					'subid' => $id,
					'status' => 1
				);
				$this->Queries->updateSpecialRecord(TBL_STOCK, $form_data, 'subid', $id);

				$this->session->set_flashdata('success_msg', 'Order Updated Successfully');
				else :
					$this->session->set_flashdata('error_msg', 'Failed To Update Order');
				endif;
			} else {

				$query = "select orderid from " . TBL_ORDER . "  order by id desc limit 1";
				$billdata = $this->Queries->getSingleRecord($query);
				if ($orderdate == "04-01") {
					$billid = 1;
				} else if ($billdata != null) {
					$billrow = $billdata->orderid;
					$billid = $billrow + 1;
				} else {
					$billid = 1;
				}
				$billno = sprintf("%03d", $billid);
				$billno = "ORD-" . $billno;

				$form_data = array(
					'orderid' => $billid,
					'orderno' => $billno,
					'received_date' => $received_date,
					'main_chalan_no' => $main_chalan_no,
					'chalan_date' => $chalan_date,
					'chalan_no' => $chalan_no,
					'from_forgine_party' => $from_forgine_party,
					'main_party' => $main_party,
					'item_no' => $item_no,
					'part_type' => $part_type,
					'po_no' => $po_no,
					'batch_qty' => $batch_qty,
					'weight_piece' => $weight_piece,
					'total_weight' => $total_weight,
					'updated_on' => $today,
					'note' => $note
				);
				if ($this->Queries->addRecord(TBL_ORDER, $form_data)) :

					$insertid = $this->db->insert_id();
				$form_data = array(
					'orderid' => $insertid,
					'qty' => $batch_qty,
					'subid' => $insertid,
					'status' => 1
				);
				$this->Queries->addRecord(TBL_STOCK, $form_data);

				$this->session->set_flashdata('success_msg', 'Order Added Successfully');
				else :
					$this->session->set_flashdata('error_msg', 'Failed To Add Order');
				endif;
			}
		}
		$page = "";
		if ($this->session->userdata["order"]["pageuri"] > 0) {
			$page = $this->session->userdata["order"]["pageuri"];
		}
		return redirect('Order/index/' . $page);

	}
	public function delete($id)
	{
		$today = date('Y-m-d H:i:s');

		$query = "select * from " . TBL_PLATFORM_MATERIAL . " where isdelete=0 and  orderid=" . $id;
		$res = $this->Queries->getSingleRecord($query);
		if ($res != null) {
			$this->session->set_flashdata('error_msg', 'You Cannot Delete The Order is been Used in Process');
			return redirect('Order');
		}
		$form_data = array(
			'isdelete' => 1,
			'updated_on' => $today
		);
		if ($this->Queries->updateRecord(TBL_ORDER, $form_data, $id)) :
			$this->session->set_flashdata('success_msg', 'Order Deleted Successfully');
		else :
			$this->session->set_flashdata('error_msg', 'Failed To Delete Order');
		endif;

		return redirect('Order');
	}

	public function sendmsg($id)
	{
		$tabcustomer = TBL_CUSTOMER;
		$taborder = TBL_ORDER;

		$query = "select $taborder.chalan_no,$taborder.batch_qty,$tabcustomer.company_name,$tabcustomer.customer_mobile,$taborder.item_no,$taborder.part_type from " . TBL_ORDER . " LEFT JOIN $tabcustomer on $tabcustomer.id = $taborder.main_party where $taborder.id=" . $id;
		
		$order = $this->Queries->getSingleRecord($query);
		if ($order != null) {
			$mobile = $order->customer_mobile;
			$message = "Material Received,\n";
			// $message .= $query. " \n";
			$message .= "Item - " . $order->item_no . "-".$order->part_type ."\n";
			$message .= "Qty - " . $order->batch_qty . " Nos\n";
			$message .= "Challan No - " . $order->chalan_no . " \n";
			$message .= "Rec. From - " . $order->company_name . " \n";
			$message .= "Thank You - DPI";
			$this->load->view('Order/sendmsg', ['id' => $id, 'mobile' => $mobile, 'message' => $message, ]);
		} else {
			$this->session->set_flashdata('error_msg', 'No Record Found');
			return redirect('Order/');
		}
	}

	public function savemsg()
	{
		$this->form_validation->set_rules('mobileno', 'Dispatch Date', 'required');
		$this->form_validation->set_rules('message', 'Dispatch Date', 'required');
		$this->form_validation->set_rules('id', 'Order Id', 'required');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$id = StringRepair($data['id']);
			$mobileno = StringRepair($data['mobileno']);
			$msg = StringRepair($data['message']);
			$message = str_replace(" ", "+", $msg);
			$message = str_replace("\n", "%0A", $message);

			//$cgurl = 'http://mysms.smshisms.com/api/mt/SendSMS?user=unisex001&password=123456&senderid=DPIIND&channel=trans&DCS=0&flashsms=0&number=' . $mobileno . '&text=' . $message . '&route=8';

			$cgurl = 'http://login.smshisms.com/API/WebSMS/Http/v1.0a/index.php?username=dpiind001&password=123456&sender=DPIIND&to=' . $mobileno . '&message=' . $message . '&reqid=1&format={json|text}&route_id=7&sendondate=' . $sdate;

			$json = file_get_contents($cgurl);
			$obj = json_decode($json);
			$obj->ErrorCode;

			$form_data = array(
				'mobileno' => $mobileno,
				'message' => $msg,
				'disp_id' => $id
			);
			$this->Queries->addRecord(TBL_MESSAGEBOX, $form_data);
			$this->session->set_flashdata('error_msg', 'Message Sended Successfully');
			return redirect('Dispatch/');
		}
	}

	public function jobwork($id = 0)
	{
		try {
			$order = "";
			if ($id != "" and $id != 0) {
				$query = "select * from " . TBL_ORDER . " where id=" . $id;
				$order = $this->Queries->getSingleRecord($query);

				$query = "select * from " . TBL_DISPATCH . " where orderid=" . $id;
				$dispatchlist = $this->Queries->getRecord($query);

			}
			$this->load->view('Order/jobwork', ['id' => $id, 'order' => $order, 'dispatchlist' => $dispatchlist]);
		} catch (Exception $e) {
			echo $e;
		}
	}

	public function savejob()
	{

		$this->form_validation->set_rules('jobwork_date', 'Jobwork Date', 'required');
		$this->form_validation->set_rules('jobwork_chalan', 'Jobwork Challan No.', 'required');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$jobwork_date = StringRepair($data['jobwork_date']);
			$date = new DateTime($jobwork_date);
			$jobwork_date = $date->format('Y-m-d');
			$jobwork_chalan = StringRepair($data['jobwork_chalan']);
			$jobwork_qty = StringRepair($data['jobwork_qty']);
			$jobwork_amount = StringRepair($data['jobwork_amount']);

			$id = $this->input->post('id');
			$today = date('Y-m-d H:i:s');
			if ($id != 0 and $id != "") {

				$form_data = array(
					'status' => 1,
					'jobwork_date' => $jobwork_date,
					'jobwork_chalan' => $jobwork_chalan,
					'jobwork_qty' => $jobwork_qty,
					'jobwork_amount' => $jobwork_amount,
					'updated_on' => $today
				);
				if ($this->Queries->updateRecord(TBL_ORDER, $form_data, $id)) :
					$this->session->set_flashdata('success_msg', 'Jobwork Updated Successfully');
				else :
					$this->session->set_flashdata('error_msg', 'Failed To Update Jobwork');
				endif;
			}
		}
		return redirect('Order/index/');

	}

	function countDemo()
	{

		/*
		$query = "select id,batch_qty from " . TBL_ORDER . " where isdelete = 0";
		$result = $this->Queries->getRecord($query);
		foreach ($result as $post) {
			echo $post->id . "->" . $post->batch_qty . "<br>";
			$form_data = array(
				'orderid' => $post->id,
				'qty' => $post->batch_qty,
				'subid' => $post->id,
				'status' => 1
			);

			$this->Queries->addRecord(TBL_STOCK, $form_data);
		}
		 

		$query = "select id,qty,orderid from " . TBL_PLATFORM_MATERIAL . " where isdelete = 0";
		$result = $this->Queries->getRecord($query);
		foreach ($result as $post) {
			$form_data = array(
				'orderid' => $post->orderid,
				'qty' => $post->qty,
				'subid' => $post->id,
				'status' => 2
			);

			$this->Queries->addRecord(TBL_STOCK, $form_data);
		}
		 
		
		$query = "select id,qty,orderid from " . TBL_PLATFORM_MATERIAL . " where status=1 and  isdelete = 0";
		$result = $this->Queries->getRecord($query);
		foreach ($result as $post) {
			$form_data = array(
				'orderid' => $post->orderid,
				'qty' => $post->qty,
				'subid' => $post->id,
				'status' => 3
			);

			$this->Queries->addRecord(TBL_STOCK, $form_data);
		}
		 

		$query = "select id,batch_qty,orderid from " . TBL_DISPATCH . " where isdelete = 0";
		$result = $this->Queries->getRecord($query);
		foreach ($result as $post) {
			$form_data = array(
				'orderid' => $post->orderid,
				'qty' => $post->batch_qty,
				'subid' => $post->id,
				'status' => 4
			);

			$this->Queries->addRecord(TBL_STOCK, $form_data);
		}
		 */

	}
}
