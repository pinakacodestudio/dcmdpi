<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dispatch extends CI_Controller
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

		// init params
		$params = array();
		$limit_per_page = 100000000;
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$total_records = $this->Queries->getDispatchCount($searchtxt);
		$params['dispatchlist'] = $this->Queries->getDispatch($searchtxt, $limit_per_page, $start_index);
		$params['page'] = $start_index;
		$session_data = array(
			'pageuri' => $start_index
		);
		// Add user data in session
		$this->session->set_userdata('dispatch', $session_data);
		if ($total_records > 0) {
			$config = PageConfig(base_url() . 'Dispatch/index', $total_records, $limit_per_page, '3');
			$this->pagination->initialize($config);
			// build paging links
			$params["links"] = $this->pagination->create_links();
		}

		$this->load->view('Dispatch/index', $params);
	}

	public function add($id = 0)
	{
		$query = "select * from " . TBL_CUSTOMER . " where isdelete=0";
		$customerlist = $this->Queries->get_tab_list($query, 'id', 'company_name');
		$to = TBL_ORDER;
		$tc = TBL_CUSTOMER;

		$query = "select * from " . TBL_VEHICLE . " where isdelete=0 order by id";
		$result = $this->Queries->getRecord($query);
		$vehid = array('');
		$vehicle = array('- Select -');
		for ($i = 0; $i < count($result); $i++) {
			array_push($vehid, $result[$i]->id);
			array_push($vehicle, $result[$i]->driver_name . " - " . $result[$i]->vehicle_type . " - " . $result[$i]->vehicle_no);
		}
		$vehiclelist = array_combine($vehid, $vehicle);

		$query = "select $to.id,$to.item_no,$to.part_type,$to.qty_dispatch,$to.qty_ready,$tc.company_name from $to LEFT  JOIN $tc ON $tc.id = $to.main_party where $to.isdelete=0 order by $to.id desc";
		$result = $this->Queries->getRecord($query);
		$cat_id = array('');
		$cat_name = array('- Select -');
		for ($i = 0; $i < count($result); $i++) {

			$qty_ready = $result[$i]->qty_ready;
			$qty_dispatch = $result[$i]->qty_dispatch;

			if ($qty_ready > $qty_dispatch) {

				$qty_ready = $qty_ready - $qty_dispatch;

				array_push($cat_id, $result[$i]->id);
				array_push($cat_name, $result[$i]->company_name . " - " . $result[$i]->item_no . " - " . $result[$i]->part_type . " - " . $qty_ready);
			}
		}
		$orderlist = array_combine($cat_id, $cat_name);
		try {
			$dispatch = "";
			if ($id != "" and $id != 0) {
				$query = "select * from " . TBL_DISPATCH . " where id=" . $id;
				$dispatch = $this->Queries->getSingleRecord($query);
				$query = "select $tc.company_name,$to.item_no,$to.part_type from " . TBL_ORDER . " LEFT JOIN $tc ON $tc.id = $to.main_party where $to.id=" . $dispatch->orderid;
				$result = $this->Queries->getRecord($query);
				$cat_id = array('');
				$cat_name = array('- Select -');
				for ($i = 0; $i < count($result); $i++) {
					array_push($cat_id, $result[$i]->id);
					array_push($cat_name, $result[$i]->company_name . " - " . $result[$i]->item_no . " - " . $result[$i]->part_type);
				}
				$orderlist = array_combine($cat_id, $cat_name);

				$qty_ready = 0;
				$qty_dispatch = 0;
				$qr = "select qty_ready,qty_dispatch from " . TBL_ORDER . " where id=" . $dispatch->orderid . " ";
				$res = $this->Queries->getSingleRecord($qr);
				if ($res != null) {
					$qty_ready = $res->qty_ready;
					$qty_dispatch = $res->qty_dispatch;
				}


				$pending_qty = $qty_ready - $qty_dispatch;
			}
			$this->load->view('Dispatch/add', ['id' => $id, 'dispatch' => $dispatch, 'orderlist' => $orderlist, 'pendingqty' => $pending_qty, 'customerlist' => $customerlist, 'vehiclelist' => $vehiclelist]);
		} catch (Exception $e) {
			echo $e;
		}
	}
	public function getOrderDetail($id = 0)
	{
		$customerid = 0;
		$query = "select * from " . TBL_ORDER . " where isdelete=0  and id=" . $id;
		$res = $this->Queries->getSingleRecord($query);
		if ($res != null) {
			$weight = $res->weight_piece;
			$customerid = $res->from_forgine_party;
			$qty_ready = $res->qty_ready;
			$qty_dispatch = $res->qty_dispatch;
		}

		$query = "select * from " . TBL_CUSTOMER . " where isdelete=0 and id=" . $customerid;
		$res = $this->Queries->getSingleRecord($query);
		if ($res != null) {
			$rate = $res->contract_rate;
		}

		$qty = $qty_ready - $qty_dispatch;

		$cap = array("qty" => $qty, "rate" => $rate, "weight" => $weight);
		echo json_encode($cap);
	}

	public function save()
	{

		$this->form_validation->set_rules('dispatch_date', 'Dispatch Date', 'required');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$orderid = StringRepair($data['orderid']);
			$dispatch_date = StringRepair($data['dispatch_date']);
			$date = new DateTime($dispatch_date);
			$dispatch_date = $date->format('Y-m-d');
			$dispatch_party = StringRepair($data['dispatch_party']);
			$rate_qty = StringRepair($data['rate_qty']);
			$total_amount = StringRepair($data['total_amount']);
			$batch_qty = StringRepair($data['batch_qty']);
			$weight_piece = StringRepair($data['weight_piece']);
			$total_weight = StringRepair($data['total_weight']);
			$vehicleid = StringRepair($data['vehicleid']);
			$id = $this->input->post('id');
			$today = date('Y-m-d H:i:s');
			$orderdate = date('m-d');
			if ($id != 0 and $id != "") {

				$prev_qty = 0;
				$query = "select batch_qty from " . TBL_DISPATCH . " where id=" . $id;
				$res = $this->Queries->getSingleRecord($query);
				if ($res != null) {
					$prev_qty = $res->batch_qty;
				}


				$form_data = array(
					'dispatch_party' => $dispatch_party,
					'dispatch_date' => $dispatch_date,
					'rate_qty' => $rate_qty,
					'total_amount' => $total_amount,
					'batch_qty' => $batch_qty,
					'weight_piece' => $weight_piece,
					'total_weight' => $total_weight,
					'vehicleid' => $vehicleid,
					'updated_on' => $today
				);
				if ($this->Queries->updateRecord(TBL_DISPATCH, $form_data, $id)) :
					$form_data = array(
						'qty' => $batch_qty
					);

					$warray = array('orderid' => $orderid, 'subid' => $id, 'status' => 4);
					$this->db->where($warray)->update(TBL_STOCK, $form_data);


					$this->session->set_flashdata('success_msg', 'Dispatch Order Updated Successfully');
				else :
					$this->session->set_flashdata('error_msg', 'Failed To Update Dispatch Order');
				endif;
			} else {

				$query = "select chalan_no from " . TBL_DISPATCH . " where isdelete=0  order by id desc limit 1";
				$billdata = $this->Queries->getSingleRecord($query);
				if ($orderdate == "04-01") {
					$billid = 1;
				} else if ($billdata != null) {
					$billrow = $billdata->chalan_no;
					$billid = $billrow + 1;
				} else {
					$billid = 1;
				}

				$form_data = array(
					'chalan_no' => $billid,
					'orderid' => $orderid,
					'dispatch_party' => $dispatch_party,
					'dispatch_date' => $dispatch_date,
					'rate_qty' => $rate_qty,
					'total_amount' => $total_amount,
					'batch_qty' => $batch_qty,
					'weight_piece' => $weight_piece,
					'total_weight' => $total_weight,
					'vehicleid' => $vehicleid,
					'updated_on' => $today
				);

				if ($this->Queries->addRecord(TBL_DISPATCH, $form_data)) :

					$insertid = $this->db->insert_id();
					$form_data = array(
						'orderid' => $orderid,
						'qty' => $batch_qty,
						'subid' => $insertid,
						'status' => 4
					);
					$this->Queries->addRecord(TBL_STOCK, $form_data);
					$this->session->set_flashdata('success_msg', 'Dispatch Order Added Successfully');
				else :
					$this->session->set_flashdata('error_msg', 'Failed To Add Dispatch Order ');
				endif;
			}
		}
		$page = "";
		if ($this->session->userdata["dispatch"]["pageuri"] > 0) {
			$page = $this->session->userdata["dispatch"]["pageuri"];
		}
		return redirect('Dispatch/index/' . $page);
	}
	public function delete($id)
	{
		$today = date('Y-m-d H:i:s');

		$query = "select * from " . TBL_DISPATCH . " where id=" . $id;
		$res = $this->Queries->getSingleRecord($query);
		if ($res != null) {
			$query1 = "select * from " . TBL_ORDER . " where id=" . $res->orderid;
			$res1 = $this->Queries->getSingleRecord($query1);

			$qry = "select id from " . TBL_STOCK . " where subid=" . $res->id . " and status=4";
			$rs = $this->Queries->getSingleRecord($qry);
			if ($rs != null) {
				$this->db->where('id', $rs->id);
				$this->db->delete(TBL_STOCK);
			}
		}
		$form_data = array(
			'isdelete' => 1,
			'updated_on' => $today
		);
		if ($this->Queries->updateRecord(TBL_DISPATCH, $form_data, $id)) :
			$this->session->set_flashdata('success_msg', 'Dispatch Order Deleted Successfully');
		else :
			$this->session->set_flashdata('error_msg', 'Failed To Delete Dispatch Order');
		endif;

		return redirect('Dispatch');
	}

	public function invoice($id)
	{
		$tabdispatch = TBL_DISPATCH;
		$tabcustomer = TBL_CUSTOMER;
		$taborder = TBL_ORDER;

		$query = "select t2.company_name as dispatch_party, $tabdispatch.id,$tabdispatch.vehicleid,$tabdispatch.orderid,$taborder.batch_qty as totalqty,$tabdispatch.chalan_no,$tabdispatch.dispatch_date,$tabdispatch.batch_qty,$tabdispatch.total_weight,t1.company_name,t1.customer_address,t1.gstno,$taborder.item_no,$taborder.part_type from " . TBL_DISPATCH . "  LEFT JOIN $taborder ON $taborder.id = $tabdispatch.orderid LEFT JOIN $tabcustomer as t1 on t1.id = $taborder.main_party LEFT JOIN $tabcustomer as t2 on t2.id = $tabdispatch.dispatch_party where $tabdispatch.id=" . $id;
		$dispatch = $this->Queries->getSingleRecord($query);
		if ($dispatch != null) {
			$res = $this->Queries->getSingleRecord("select sum(batch_qty) as tot_dispatch from " . TBL_DISPATCH . " where orderid=" . $dispatch->orderid . " and id<" . $dispatch->id);
			if ($res != null) {
				$tot_dispatch = $res->tot_dispatch;
			} else {
				$tot_dispatch = 0;
			}
			$res = $this->Queries->getSingleRecord("select vehicle_no from " . TBL_VEHICLE . " where id=" . $dispatch->vehicleid);
			if ($res != null) {
				$vehicle = $res->vehicle_no;
			}
			$opening = $dispatch->totalqty - $tot_dispatch;
			$used_material = $dispatch->batch_qty;
			$closing_balance = $opening - $used_material;

			$this->load->view('Dispatch/invoice', ['dispatch' => $dispatch, 'vehicle' => $vehicle, 'opening' => $opening, 'used_material' => $used_material, 'closing' => $closing_balance]);
		} else {
			$this->session->set_flashdata('error_msg', 'No Record Found');
			return redirect('Dispatch/');
		}
	}

	public function sendmsg($id)
	{
		$tabdispatch = TBL_DISPATCH;
		$tabcustomer = TBL_CUSTOMER;
		$tabcustomerdispatch = TBL_CUSTOMER;
		$taborder = TBL_ORDER;

		$query = "select d1.chalan_no,d1.batch_qty,t3.company_name,t2.customer_mobile,t1.item_no,t1.part_type from " . TBL_DISPATCH . " as d1 LEFT JOIN $taborder as t1 ON t1.id = d1.orderid LEFT JOIN $tabcustomer as t2 on t2.id = t1.main_party LEFT JOIN $tabcustomer as t3 on t3.id = d1.dispatch_party  where d1.id=" . $id;
		$dispatch = $this->Queries->getSingleRecord($query);
		if ($dispatch != null) {
			$mobile = $dispatch->customer_mobile;
			$message = "Material Dispatched \n";
			$message .= "Item - " . $dispatch->item_no . " " . $dispatch->part_type . " \n";
			$message .= "Qty - " . $dispatch->batch_qty . " Nos\n";
			$message .= "Del. At - " . $dispatch->company_name . " \n";
			$message .= "Thank You - DPI";
			$this->load->view('Dispatch/sendmsg', ['id' => $id, 'mobile' => $mobile, 'message' => $message,]);
		} else {
			$this->session->set_flashdata('error_msg', 'No Record Found');
			return redirect('Dispatch/');
		}
	}

	public function savemsg()
	{
		$this->form_validation->set_rules('mobileno', 'Dispatch Date', 'required');
		$this->form_validation->set_rules('message', 'Dispatch Date', 'required');
		$this->form_validation->set_rules('id', 'Dispatch Id', 'required');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$sdate = date("d-m-YTh:i:s");
			$id = StringRepair($data['id']);
			$mobileno = StringRepair($data['mobileno']);
			$msg = StringRepair($data['message']);
			$message = str_replace(" ", "+", $msg);
			$message = str_replace("\n", "%0a", $message);

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
}
