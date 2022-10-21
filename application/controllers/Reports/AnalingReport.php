<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AnalingReport extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$searchtxt = array();
		$sdate = "";
		$edate = "";
		$itemno = "";
		$parttype = "";
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
				'customerid' => '',
				'sdate' => '',
				'edate' => ''
			);
			// Add user data in session
			$this->session->set_userdata('analingreport', $session_data);
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
			if (!empty($search["sortby"])) {
				$sortby = $search["sortby"];
				$searchtxt["sortby"] = $sortby;
			}
			if (!empty($search["sortbycol"])) {
				$sortbycol = $search["sortbycol"];
				$searchtxt["sortbycol"] = $sortbycol;
			}
		} else {
			if (!empty($this->session->userdata['analingreport']['sdate']) && $this->session->userdata['analingreport']['sdate'] != "") {
				$sdate = $this->session->userdata['analingreport']['sdate'];
				$date = new DateTime($sdate);
				$searchtxt["sdate"] = $date->format('Y-m-d');
				$sdate = $this->session->userdata['analingreport']['sdate'];
			}
			if (!empty($this->session->userdata['analingreport']['edate']) && $this->session->userdata['analingreport']['edate'] != "") {
				$edate = $this->session->userdata['analingreport']['edate'];
				$date = new DateTime($edate);
				$searchtxt["edate"] = $date->format('Y-m-d');
				$edate = $this->session->userdata['analingreport']['edate'];
			}
			if (!empty($this->session->userdata['analingreport']['itemno'])) {
				$itemno = $this->session->userdata['analingreport']['itemno'];
				$searchtxt['itemno'] = $itemno;
			}
			if (!empty($this->session->userdata['analingreport']['parttype'])) {
				$parttype = $this->session->userdata['analingreport']['parttype'];
				$searchtxt['parttype'] = $parttype;
			}
			if (!empty($this->session->userdata['analingreport']['customerid'])) {
				$customerid = $this->session->userdata['analingreport']['customerid'];
				$searchtxt['customerid'] = $customerid;
			}
			if (!empty($this->session->userdata['analingreport']['sortbycol'])) {
				$sortbycol = $this->session->userdata['analingreport']['sortbycol'];
				$searchtxt['sortbycol'] = $sortbycol;
			}
			if (!empty($this->session->userdata['analingreport']['sortby'])) {
				$sortby = $this->session->userdata['analingreport']['sortby'];
				$searchtxt['sortby'] = $sortby;
			}
		}

		// init params
		$params = array();
		$limit_per_page = 1000000;
		$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$total_records = $this->QueriesReport->getAnalingReportCount($searchtxt);
		$params['analingreport'] = $this->QueriesReport->getAnalingReport($searchtxt, $limit_per_page, $start_index);
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
		$this->session->set_userdata('analingreport', $session_data);
		if ($total_records > 0) {
			// get current page records
			$config = PageConfig(base_url() . 'Reports/AnalingReport/index', $total_records, $limit_per_page, '4');
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

		$this->load->view('Reports/AnalingReport/index', $params);
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
		$filename = "AnalingReport" . $today . ".xlsx";

		if (!empty($this->session->userdata['analingreport']['sdate']) && $this->session->userdata['analingreport']['sdate'] != "") {
			$sdate = $this->session->userdata['analingreport']['sdate'];
			$date = new DateTime($sdate);
			$searchtxt["sdate"] = $date->format('Y-m-d 00:00:00');
			$sdate = $this->session->userdata['analingreport']['sdate'];
		}
		if (!empty($this->session->userdata['analingreport']['edate']) && $this->session->userdata['analingreport']['edate'] != "") {
			$edate = $this->session->userdata['analingreport']['edate'];
			$date = new DateTime($edate);
			$searchtxt["edate"] = $date->format('Y-m-d 23:59:59');
			$edate = $this->session->userdata['analingreport']['edate'];
		}
		if (!empty($this->session->userdata['analingreport']['itemno'])) {
			$itemno = $this->session->userdata['analingreport']['itemno'];
			$searchtxt['itemno'] = $itemno;
		}
		if (!empty($this->session->userdata['analingreport']['parttype'])) {
			$parttype = $this->session->userdata['analingreport']['parttype'];
			$searchtxt['parttype'] = $parttype;
		}
		if (!empty($this->session->userdata['analingreport']['customerid'])) {
			$customerid = $this->session->userdata['analingreport']['customerid'];
			$searchtxt['customerid'] = $customerid;
		}
		if (!empty($this->session->userdata['analingreport']['sortbycol'])) {
			$sortbycol = $this->session->userdata['analingreport']['sortbycol'];
			$searchtxt['sortbycol'] = $sortbycol;
		}
		if (!empty($this->session->userdata['analingreport']['sortby'])) {
			$sortby = $this->session->userdata['analingreport']['sortby'];
			$searchtxt['sortby'] = $sortby;
		}
		require_once APPPATH . 'third_party/Phpspreadsheet/vendor/autoload.php';

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$spreadsheet->getProperties()->setCreator('awesomeinfosys.com')
			->setLastModifiedBy('DPI Analing')
			->setTitle('DPI Reports')
			->setSubject('For the purpose of DPI Reports');



		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('sample/analing.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$spreadsheet->setActiveSheetIndex(0);

		$analingreport = $this->QueriesReport->getAnalingReport($searchtxt, '', '');

		$x = 3;
		foreach ($analingreport as $row) {
			$sdate = $row->start_preparing;
			$edate = $row->end_removing;
			$fdate = $row->attach_furnace;

			$spreadsheet->setActiveSheetIndex(0)->setCellValue("A$x", $row->platformid);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("B$x", $row->bellid);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("C$x", $row->panelid);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("D$x", $sdate);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("E$x", $edate);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("F$x", $fdate);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("G$x", $row->forging_name);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("H$x", $row->main_party);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("I$x", $row->item_no);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("J$x", $row->part_type);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("K$x", $row->qty);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("L$x", $row->weight_piece);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("M$x", $row->total_weight);

			$x++;
		}

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

		$spreadsheet->getActiveSheet()->getStyle("A1:M" . $x)->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A1:M' . $x)->getAlignment()->setWrapText(true);
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
