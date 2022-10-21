<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class InwardReport extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$searchtxt = array();
		$itemno = "";
		$parttype = "";
		$customerid = "";
		$sdate = "";
		$edate = "";
		$sortbycol = "";
		$sortby = "";
		$search = $this->input->post();
		if (isset($search["clearall"])) {
			$session_data = array(
				'sortbycol' => '',
				'sortby' => '',
				'itemno' => '',
				'parttype' => '',
				'customerid' => '',
				'sdate' => '',
				'edate' => ''
			);
			// Add user data in session
			$this->session->set_userdata('inwardreport', $session_data);
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
			if (!empty($search["customerid"])) {
				$customerid = $search["customerid"];
				$searchtxt["customerid"] = $customerid;
			}
		} else {
			if (!empty($this->session->userdata['inwardreport']['sdate']) && $this->session->userdata['inwardreport']['sdate'] != "") {
				$sdate = $this->session->userdata['inwardreport']['sdate'];
				$date = new DateTime($sdate);
				$searchtxt["sdate"] = $date->format('Y-m-d');
				$sdate = $this->session->userdata['inwardreport']['sdate'];
			}
			if (!empty($this->session->userdata['inwardreport']['edate']) && $this->session->userdata['inwardreport']['edate'] != "") {
				$edate = $this->session->userdata['inwardreport']['edate'];
				$date = new DateTime($edate);
				$searchtxt["edate"] = $date->format('Y-m-d');
				$edate = $this->session->userdata['inwardreport']['edate'];
			}
			if (!empty($this->session->userdata['inwardreport']['itemno'])) {
				$itemno = $this->session->userdata['inwardreport']['itemno'];
				$searchtxt['itemno'] = $itemno;
			}
			if (!empty($this->session->userdata['inwardreport']['parttype'])) {
				$parttype = $this->session->userdata['inwardreport']['parttype'];
				$searchtxt['parttype'] = $parttype;
			}
			if (!empty($this->session->userdata['inwardreport']['customerid'])) {
				$customerid = $this->session->userdata['inwardreport']['customerid'];
				$searchtxt['customerid'] = $customerid;
			}
			if (!empty($this->session->userdata['inwardreport']['sortbycol'])) {
				$sortbycol = $this->session->userdata['inwardreport']['sortbycol'];
				$searchtxt['sortbycol'] = $sortbycol;
			}
			if (!empty($this->session->userdata['inwardreport']['sortby'])) {
				$sortby = $this->session->userdata['inwardreport']['sortby'];
				$searchtxt['sortby'] = $sortby;
			}
		}

		if ($this->uri->segment(5) != "") {
			$sortbycol = $this->uri->segment(5);
			$searchtxt["sortbycol"] = $sortbycol;
			// Add user data in session
		}
		if ($this->uri->segment(6) != "") {
			$sortby = $this->uri->segment(6);
			$searchtxt["sortby"] = $sortby;
		}

		// init params
		$params = array();
		$limit_per_page = 1000000000;
		$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$total_records = $this->QueriesReport->getInwardReportCount($searchtxt);
		$params['inwardreport'] = $this->QueriesReport->getInwardReport($searchtxt, $limit_per_page, $start_index);
		$params['page'] = $start_index;
		$session_data = array(
			'sortbycol' => $sortbycol,
			'sortby' => $sortby,
			'itemno' => $itemno,
			'parttype' => $parttype,
			'customerid' => $customerid,
			'sdate' => $sdate,
			'edate' => $edate,
			'pageuri' => $start_index
		);
		// Add user data in session
		$this->session->set_userdata('inwardreport', $session_data);
		if ($total_records > 0) {
			// get current page records
			$config = PageConfig(base_url() . 'Reports/InwardReport/index', $total_records, $limit_per_page, '4');
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

		$this->load->view('Reports/InwardReport/index', $params);
	}

	public function action()
	{
		date_default_timezone_set('Asia/Kolkata');
		$today = date("d_m_Y_g_i_A");
		$searchtxt = array();
		$itemno = "";
		$parttype = "";
		$customerid = "";
		$sdate = "";
		$edate = "";
		$sortbycol = "";
		$sortby = "";
		$filename = "InwardReport" . $today . ".xlsx";

		if (!empty($this->session->userdata['inwardreport']['sdate']) && $this->session->userdata['inwardreport']['sdate'] != "") {
			$sdate = $this->session->userdata['inwardreport']['sdate'];
			$date = new DateTime($sdate);
			$searchtxt["sdate"] = $date->format('Y-m-d');
			$sdate = $this->session->userdata['inwardreport']['sdate'];
		}
		if (!empty($this->session->userdata['inwardreport']['edate']) && $this->session->userdata['inwardreport']['edate'] != "") {
			$edate = $this->session->userdata['inwardreport']['edate'];
			$date = new DateTime($edate);
			$searchtxt["edate"] = $date->format('Y-m-d');
			$edate = $this->session->userdata['inwardreport']['edate'];
		}
		if (!empty($this->session->userdata['inwardreport']['itemno'])) {
			$itemno = $this->session->userdata['inwardreport']['itemno'];
			$searchtxt['itemno'] = $itemno;
		}
		if (!empty($this->session->userdata['inwardreport']['parttype'])) {
			$parttype = $this->session->userdata['inwardreport']['parttype'];
			$searchtxt['parttype'] = $parttype;
		}
		if (!empty($this->session->userdata['inwardreport']['customerid'])) {
			$customerid = $this->session->userdata['inwardreport']['customerid'];
			$searchtxt['customerid'] = $customerid;
		}
		if (!empty($this->session->userdata['inwardreport']['sortbycol'])) {
			$sortbycol = $this->session->userdata['inwardreport']['sortbycol'];
			$searchtxt['sortbycol'] = $sortbycol;
		}
		if (!empty($this->session->userdata['inwardreport']['sortby'])) {
			$sortby = $this->session->userdata['inwardreport']['sortby'];
			$searchtxt['sortby'] = $sortby;
		}
		require_once APPPATH . 'third_party/Phpspreadsheet/vendor/autoload.php';

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$spreadsheet->getProperties()->setCreator('awesomeinfosys.com')
			->setLastModifiedBy('HighLevel')
			->setTitle('Highlevel Reports')
			->setSubject('For the purpose of HighLevel Reportss');



		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('sample/inward.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$spreadsheet->setActiveSheetIndex(0);

		$analingreport = $this->QueriesReport->getInwardReport($searchtxt, '', '');

		$x = 3;
		$qty = 0;
		$totalweight = 0;
		foreach ($analingreport as $row) {
			$date = new DateTime($row->received_date);
			$rdate = $date->format('d-m-Y');
			$date = new DateTime($row->chalan_date);
			$cdate = $date->format('d-m-Y');
			$qty = $qty + $row->batch_qty;
			$totalweight = $totalweight + $row->total_weight;
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("A$x", $rdate);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("B$x", $row->chalan_no);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("C$x", $row->main_chalan_no);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("D$x", $cdate);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("E$x", $row->forging_name);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("F$x", $row->main_party);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("G$x", $row->item_no);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("H$x", $row->part_type);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("I$x", $row->batch_qty);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("J$x", $row->weight_piece);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("K$x", $row->total_weight);
			$x++;
		}
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("H$x", "Total");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("I$x", $qty);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("K$x", $totalweight);
		$x--;

		$styleArray = array(
			'font' => array(
				'name' => "Tahoma",
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				),
			),

		);

		$spreadsheet->getActiveSheet()->getStyle("A1:K" . $x)->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A1:K' . $x)->getAlignment()->setWrapText(true);
		// Set page orientation and size
		$spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
		$spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$spreadsheet->setActiveSheetIndex(0);
		$object_writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
		$object_writer->save("reportdata/" . $filename);
		$dir = base_url() . "reportdata/";
		header("Location: " . $dir . $filename . "");

	}

}
