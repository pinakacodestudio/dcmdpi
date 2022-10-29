<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Process extends CI_Controller
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
		$limit_per_page = 1000000000;
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$total_records = $this->Queries->getProcessCount($searchtxt);
		$params['processlist'] = $this->Queries->getProcess($searchtxt, $limit_per_page, $start_index);
		$params['page'] = $start_index;
		$session_data = array(
			'pageuri' => $start_index
		);
		// Add user data in session
		$this->session->set_userdata('process', $session_data);
		if ($total_records > 0) {
			$config = PageConfig(base_url() . 'Process/index', $total_records, $limit_per_page, '3');
			$this->pagination->initialize($config);
			// build paging links
			$params["links"] = $this->pagination->create_links();
		}

		$this->load->view('Process/index', $params);
	}

	public function add($id = 0, $cid = 0)
	{
		try {
			$panellist = array();
			$platformlist = array();
			$furnacelist = array();

			$query = "select * from " . TBL_PLATFORM . " where isdelete=0 and status = 0";
			$res = $this->Queries->getRecord($query);
			foreach ($res as $post) {
				if ($post->status == 0) {
					$platformlist[$post->id] = $post->platformid;
				}
				if ($post->status == 1) {

					$qry = "select end_removing from " . TBL_PROCESS . " where id=" . $post->processid . " order by id limit 1";
					$rs = $this->Queries->getSingleRecord($qry);
					if ($rs != null) {
						$cdate = date('Y-m-d H:i:s');
						$sdate = new DateTimeImmutable($rs->end_removing);
						$sdate = $sdate->format('Y-m-d H:i:s');
						
						$cdate = new DateTime($cdate);
						$sdate = new DateTime($sdate);
						$diff = date_diff($cdate, $sdate);
						if ($diff->invert == 1) {
							$platformlist[$post->id] = $post->platformid;
						}
					}
				}
			}

			$query = "select * from " . TBL_FURNACE . " where isdelete=0 and status = 0";
			$res = $this->Queries->getRecord($query);
			foreach ($res as $post) {
				if ($post->status == 0) {
					$furnacelist[$post->id] = $post->bellid;
				}
				if ($post->status == 1) {

					$qry = "select dettach_furnace from " . TBL_PROCESS . " where id=" . $post->processid . " order by id limit 1";
					$rs = $this->Queries->getSingleRecord($qry);
					if ($rs != null) {
						$cdate = date('Y-m-d H:i:s');
						$sdate = date_create($rs->dettach_furnace);
						$sdate = date_format($sdate, 'Y-m-d H:i:s');
						$cdate = new DateTime($cdate);
						$sdate = new DateTime($sdate);
						$diff = date_diff($cdate, $sdate);
						if ($diff->invert == 1) {
							$furnacelist[$post->id] = $post->bellid;
						}
					}
				}
			}

			$query = "select * from " . TBL_POWERPANEL . " where isdelete=0";
			$res = $this->Queries->getRecord($query);
			foreach ($res as $post) {
				if ($post->status == 0) {
					$panellist[$post->id] = $post->panelid;
				}
				if ($post->status == 1) {

					$qry = "select dettach_panel from " . TBL_PROCESS . " where id=" . $post->processid . " order by id limit 1";
					$rs = $this->Queries->getSingleRecord($qry);
					if ($rs != null) {
						$cdate = date('Y-m-d H:i:s');
						$sdate = new DateTimeImmutable(str_replace('/', '-', $rs->dettach_panel));
						$sdate = $sdate->format('Y-m-d H:i:s');
						$cdate = new DateTime($cdate);
						$sdate = new DateTime($sdate);
						$diff = date_diff($cdate, $sdate);
						if ($diff->invert == 1) {
							$panellist[$post->id] = $post->panelid;
						}
					}
				}
			}
			$capacity = 0;
			if ($cid != 0 and $cid != "") {
				$query = "select * from " . TBL_PLATFORM . " where isdelete=0 and id=" . $cid;
				$res = $this->Queries->getSingleRecord($query);
				if ($res != null) {
					$capacity = $res->platform_capacity;
				}
			}
			$process = array();
			if ($id != "" and $id != 0) {
				$query = "select * from " . TBL_PROCESS . " where id=" . $id;
				$process = $this->Queries->getSingleRecord($query);
				if ($process == null) {
					$this->session->set_flashdata('error_msg', 'No Record Found...');
					return redirect('Process');
				}
				$platformid = $process->platformid;
				$furnaceid = $process->furnaceid;
				$panelid = $process->panelid;
				$tbl_order = TBL_ORDER;
				$tbl_customer = TBL_CUSTOMER;
				$tbl_material = TBL_PLATFORM_MATERIAL;


				if ($platformid != 0) {
					$platformlist = array();
					$query = "select * from " . TBL_PLATFORM . " where isdelete=0 and id=$platformid";
					$rs = $this->Queries->getSingleRecord($query);
					if ($rs != null) {
						$platformlist[$rs->id] = $rs->platformid;
					}
				}
				if ($furnaceid != 0) {
					$furnacelist = array();
					$query = "select * from " . TBL_FURNACE . " where isdelete=0 and id=$furnaceid";
					$rs = $this->Queries->getSingleRecord($query);
					if ($rs != null) {
						$furnacelist[$rs->id] = $rs->bellid;
					}
				}
				if ($panelid != 0) {
					$panellist = array();
					$query = "select * from " . TBL_POWERPANEL . " where isdelete=0 and id=$panelid";
					$rs = $this->Queries->getSingleRecord($query);
					if ($rs != null) {
						$panellist[$rs->id] = $rs->panelid;
					}
				}


				$query = "select $tbl_material.id,$tbl_material.orderid,$tbl_customer.company_name,$tbl_order.item_no,$tbl_order.part_type,$tbl_material.qty,$tbl_material.weight_piece,$tbl_material.total_weight from $tbl_material LEFT JOIN $tbl_order on $tbl_order.id = $tbl_material.orderid LEFT JOIN $tbl_customer ON $tbl_customer.id = $tbl_order.main_party where $tbl_material.isdelete=0 and $tbl_material.pid=" . $id;
				$materialslist = $this->Queries->getRecord($query);
			} else {
				if ($cid == 0 and $cid == "") {
					$query = "select * from " . TBL_PLATFORM . " where isdelete=0 and status=0 order by id limit 1";
					$res = $this->Queries->getSingleRecord($query);
					if ($res != null) {
						$capacity = $res->platform_capacity;
					}
				}
			}
			$this->load->view('Process/add', ['id' => $id, 'cid' => $cid, 'capacity' => $capacity, 'process' => $process, 'materialslist' => $materialslist, 'platformlist' => $platformlist, 'furnacelist' => $furnacelist, 'panellist' => $panellist]);
		} catch (Exception $e) {
			echo $e;
		}
	}

	public function additem($id)
	{
		$to = TBL_ORDER;
		$tc = TBL_CUSTOMER;

		$query = "select $to.id,$to.item_no,$to.part_type,$to.batch_qty,$to.qty_used,$tc.company_name from $to LEFT  JOIN $tc ON $tc.id = $to.main_party where $to.isdelete=0 ";
		$result = $this->Queries->getRecord($query);
		$cat_id = array('');
		$cat_name = array('- Select -');
		for ($i = 0; $i < count($result); $i++) {

			$remaining_weight = $result[$i]->batch_qty - $result[$i]->qty_used;

			if ($remaining_weight != 0) {
				array_push($cat_id, $result[$i]->id);
				array_push($cat_name, $result[$i]->company_name . " - " . $result[$i]->item_no . " - " . $result[$i]->part_type . " - " . $remaining_weight);
			}
		}
		$data = array_combine($cat_id, $cat_name);
		$this->load->view('Process/additem', ['id' => $id, 'orderlist' => $data,]);
	}
	public function details($id)
	{
		$protab = TBL_PROCESS;
		$furtab = TBL_FURNACE;
		$pantab = TBL_POWERPANEL;
		$plattab = TBL_PLATFORM;
		$custtab = TBL_CUSTOMER;
		$query = "select $protab.status,$plattab.platformid,$furtab.bellid,$pantab.panelid,$protab.attach_panel,$protab.dettach_panel from $protab LEFT JOIN $plattab ON $plattab.id=$protab.platformid LEFT JOIN $furtab ON $furtab.id= $protab.furnaceid LEFT JOIN $pantab ON $pantab.id = $protab.panelid where $protab.id=" . $id;
		$process = $this->Queries->getSingleRecord($query);
		if ($process != null) {
			$tbl_order = TBL_ORDER;
			$tbl_material = TBL_PLATFORM_MATERIAL;
			$query = "select $custtab.company_name,$tbl_material.id,$tbl_order.orderno,$tbl_material.qty,$tbl_material.total_weight,$tbl_order.item_no, $tbl_order.part_type from $tbl_material LEFT JOIN $tbl_order on $tbl_order.id = $tbl_material.orderid LEFT JOIN $custtab ON $custtab.id = $tbl_order.main_party where $tbl_material.isdelete=0 and $tbl_material.pid=" . $id;
			$materialslist = $this->Queries->getRecord($query);
			$this->load->view('Process/details', ['id' => '1', 'process' => $process, 'materialslist' => $materialslist]);
		} else {
			$this->load->view('Process/details', ['id' => '0']);
		}
	}
	public function getpcap($id = 0)
	{
		$capacity = 0;
		$query = "select * from " . TBL_PLATFORM . " where isdelete=0 and id=" . $id;
		$res = $this->Queries->getSingleRecord($query);
		if ($res != null) {
			$capacity = $res->platform_capacity;
		}
		$cap = array("capacity" => $capacity);
		echo json_encode($cap);
	}
	public function getOrderDetail($id = 0)
	{


		$query = "select * from " . TBL_ORDER . " where isdelete=0 and id=" . $id;
		$res = $this->Queries->getSingleRecord($query);
		if ($res != null) {
			$qty = 0;
			$qr = "select sum(qty) as qty from " . TBL_STOCK . " where orderid=" . $id . " and status=2";
			$rs = $this->Queries->getSingleRecord($qr);
			if ($rs != null) {
				$qty = $res->batch_qty - $rs->qty;
			}
			$weight = $res->weight_piece;
		}
		$cap = array("qty" => $qty, "weight" => $weight);
		echo json_encode($cap);
	}
	public function save()
	{

		$this->form_validation->set_rules('platformid', 'Platform Id', 'required');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$platformid = StringRepair($data['platformid']);
			$start_preparing = StringRepair($data['start_preparing']);
			$end_removing = StringRepair($data['end_removing']);
			$furnaceid = StringRepair($data['furnaceid']);
			$attach_furnace = StringRepair($data['attach_furnace']);
			$dettach_furnace = StringRepair($data['dettach_furnace']);
			$panelid = StringRepair($data['panelid']);
			$attach_panel = StringRepair($data['attach_panel']);
			$dettach_panel = StringRepair($data['dettach_panel']);
			$platform_capacity = StringRepair($data['platform_capacity']);
			$remaining_capacity = StringRepair($data['remaining_capacity']);
			$status = StringRepair($data['status']);
			$id = $this->input->post('id');
			$today = date('Y-m-d H:i:s');

			if ($id != 0 and $id != "") {

				$form_data = array(
					'platformid' => $platformid,
					'start_preparing' => $start_preparing,
					'end_removing' => $end_removing,
					'furnaceid' => $furnaceid,
					'attach_furnace' => $attach_furnace,
					'dettach_furnace' => $dettach_furnace,
					'panelid' => $panelid,
					'attach_panel' => $attach_panel,
					'dettach_panel' => $dettach_panel,
					'platform_capacity' => $platform_capacity,
					'remaining_capacity' => $remaining_capacity,
					'status' => $status,
					'updated_on' => $today
				);
				$this->Queries->updateRecord(TBL_PROCESS, $form_data, $id);
				$this->session->set_flashdata('success_msg', 'Process Updated Successfully');
				$orid = $id;
				$cloop = $data["cloop"];
				$i = 1;
				while ($i <= $cloop) {
					$tid = "";
					$subid = "";
					if (!empty($data["subid_" . $i])) {
						$subid = $data["subid_" . $i];
					}

					if (!empty($data["orderid_" . $i])) {
						$tid = $data["orderid_" . $i];
					}

					if ($subid != "" && $tid == "") {
						$qty = 0;
						$query = "select qty,orderid from " . TBL_PLATFORM_MATERIAL . " where id=" . $data["subid_" . $i];
						$res = $this->Queries->getSingleRecord($query);
						if ($res != null) {
							$qty = $res->qty;
							$orderid = $res->orderid;
						}

						$form_data = array(
							'isdelete' => 1,
							'updated_on' => $today
						);
						$this->Queries->updateRecord(TBL_PLATFORM_MATERIAL, $form_data, $data["subid_" . $i]);
					} elseif ($subid != "" && $tid != "") {


						$form_data = array(
							'qty' => $data["qty_" . $i]
						);
						$this->Queries->updateRecord(TBL_PLATFORM_MATERIAL, $form_data, $subid);

						$form_data = array(
							'qty' => $data["qty_" . $i]
						);

						$warray = array('orderid' => $tid, 'subid' => $subid, 'status' => 2);
						$this->db->where($warray)->update(TBL_STOCK, $form_data);

						if ($status == 5) {
							$query = "select qty,orderid,status from " . TBL_PLATFORM_MATERIAL . " where id=" . $data["subid_" . $i];
							$res = $this->Queries->getSingleRecord($query);
							if ($res != null) {
								$qty = $res->qty;
								$orderid = $res->orderid;
								$material_status = $res->status;
								$form_data = array(
									'status' => 1
								);
								$this->Queries->updateRecord(TBL_PLATFORM_MATERIAL, $form_data, $data["subid_" . $i]);

								$qry = "select id from " . TBL_STOCK . " where orderid=" . $res->orderid . " and subid=" . $subid . " and status=3";
								$rs = $this->Queries->getSingleRecord($qry);
								if ($rs != null) {
									$form_data = array(
										'qty' => $res->qty
									);
									$this->Queries->updateRecord(TBL_STOCK, $form_data, $rs->id);

									$qry = "select id from " . TBL_STOCK . " where orderid=" . $res->orderid . " and subid=" . $subid . " and status=2";
									$rs = $this->Queries->getSingleRecord($qry);
									if ($rs != null) {
										$form_data = array(
											'qty' => $res->qty
										);
										$this->Queries->updateRecord(TBL_STOCK, $form_data, $rs->id);
									}
								} else {
									$form_data = array(
										'orderid' => $res->orderid,
										'qty' => $res->qty,
										'subid' => $data["subid_" . $i],
										'status' => 3
									);
									$this->Queries->addRecord(TBL_STOCK, $form_data);
								}
							}
						}
					} else {
						if (!empty($data["orderid_" . $i])) {
							$form_data = array(
								'pid' => StringRepair($data["id"]),
								'orderid' => StringRepair($data["orderid_" . $i]),
								'qty' => StringRepair($data["qty_" . $i]),
								'weight_piece' => StringRepair($data["weight_" . $i]),
								'total_weight' => StringRepair($data["total_" . $i]),
								'updated_on' => $today
							);
							$this->Queries->addRecord(TBL_PLATFORM_MATERIAL, $form_data);
						}
					}
					$i++;
				}

				if ($status == 2) {
					$form_data = array(
						'processid' => $orid,
						'status' => 1
					);
					$this->Queries->updateRecord(TBL_FURNACE, $form_data, $furnaceid);
				}
				if ($status == 3) {
					$form_data = array(
						'processid' => $orid,
						'status' => 1
					);
					$this->Queries->updateRecord(TBL_POWERPANEL, $form_data, $panelid);
				}
				if ($status == 4) {
					$form_data = array(
						'processid' => 0,
						'status' => 0
					);
					$this->Queries->updateRecord(TBL_POWERPANEL, $form_data, $panelid);
				}
				if ($status == 5) {
					$form_data = array(
						'processid' => 0,
						'status' => 0
					);
					$this->Queries->updateRecord(TBL_FURNACE, $form_data, $furnaceid);
					$this->Queries->updateRecord(TBL_PLATFORM, $form_data, $platformid);
				}
			} else {
				$form_data = array(
					'platformid' => $platformid,
					'start_preparing' => $start_preparing,
					'end_removing' => $end_removing,
					'furnaceid' => $furnaceid,
					'attach_furnace' => $attach_furnace,
					'dettach_furnace' => $dettach_furnace,
					'panelid' => $panelid,
					'attach_panel' => $attach_panel,
					'dettach_panel' => $dettach_panel,
					'platform_capacity' => $platform_capacity,
					'remaining_capacity' => $remaining_capacity,
					'status' => $status,
					'updated_on' => $today,
					'created_on' => $today
				);
				$this->Queries->addRecord(TBL_PROCESS, $form_data);
				$orid = $this->db->insert_id();
				$this->session->set_flashdata('success_msg', 'Process Added Successfully');
				$cloop = $data["cloop"];
				$i = 1;

				while ($i <= $cloop) {
					if (!empty($data["orderid_" . $i])) {
						$form_data = array(
							'pid' => $orid,
							'orderid' => StringRepair($data["orderid_" . $i]),
							'qty' => StringRepair($data["qty_" . $i]),
							'weight_piece' => StringRepair($data["weight_" . $i]),
							'total_weight' => StringRepair($data["total_" . $i]),
							'updated_on' => $today
						);
						$this->Queries->addRecord(TBL_PLATFORM_MATERIAL, $form_data);

						$insertid = $this->db->insert_id();
						$form_data = array(
							'orderid' => $data["orderid_" . $i],
							'qty' => StringRepair($data["qty_" . $i]),
							'subid' => $insertid,
							'status' => 2
						);
						$this->Queries->addRecord(TBL_STOCK, $form_data);
					}
					$i++;
				}
				if ($status == 1) {
					$form_data = array(
						'processid' => $orid,
						'status' => 1
					);
					$this->Queries->updateRecord(TBL_PLATFORM, $form_data, $platformid);
				}
			}
		}

		$page = "";
		if ($this->session->userdata["process"]["pageuri"] > 0) {
			$page = $this->session->userdata["process"]["pageuri"];
		}
		return redirect('Process/index/' . $page);
	}
	public function delete($id)
	{
		$today = date('Y-m-d H:i:s');
		$query = "select * from " . TBL_PROCESS . " where id=" . $id;
		$res = $this->Queries->getSingleRecord($query);
		if ($res != null) {
			if ($res->status == 5) {
				$this->session->set_flashdata('error_msg', 'The Process is Closed you cannot Delete this Process');
				return redirect('Process/index/');
			} else {
				$form_data = array(
					'processid' => 0,
					'status' => 0
				);
				$this->Queries->updateRecord(TBL_PLATFORM, $form_data, $res->platformid);
				$this->Queries->updateRecord(TBL_FURNACE, $form_data, $res->furnaceid);
				$this->Queries->updateRecord(TBL_POWERPANEL, $form_data, $res->panelid);

				$query = "select * from " . TBL_PLATFORM_MATERIAL . " where pid=" . $id;
				$res = $this->Queries->getRecord($query);
				if (count($res)) {
					foreach ($res as $post) {

						$query1 = "select * from " . TBL_ORDER . " where id=" . $post->orderid;
						$res1 = $this->Queries->getSingleRecord($query1);
						$form_data = array(
							'qty_used' => $res1->qty_used - $post->qty
						);
						$this->Queries->updateRecord(TBL_ORDER, $form_data, $post->orderid);
						$form_data = array(
							'isdelete' => 1,
							'updated_on' => $today
						);
						$this->Queries->updateRecord(TBL_PLATFORM_MATERIAL, $form_data, $post->id);

						$this->db->where('subid', $post->id);
						$this->db->where('status', "2");
						$this->db->delete(TBL_STOCK);
						$this->db->where('subid', $post->id);
						$this->db->where('status', "3");
						$this->db->delete(TBL_STOCK);
					}
				}
			}
		}
		$form_data = array(
			'isdelete' => 1,
			'updated_on' => $today
		);
		if ($this->Queries->updateRecord(TBL_PROCESS, $form_data, $id)) :
			$this->session->set_flashdata('success_msg', 'Process Deleted Successfully');
		else :
			$this->session->set_flashdata('error_msg', 'Failed To Delete Process');
		endif;

		return redirect('Process');
	}
}
