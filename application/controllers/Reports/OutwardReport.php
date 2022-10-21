<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class OutwardReport extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$searchtxt = array();
		$dispatch_party = "";
		$main_party = "";
		$sdate = "";
		$edate = "";
		$sortbycol = "";
		$sortby = "";
		$search = $this->input->post();
		if (isset($search["clearall"])) {
			$session_data = array(
				'sortbycol' => '',
				'sortby' => '',
				'dispatch_party' => '',
				'main_party' => '',
				'sdate' => '',
				'edate' => ''
			);
			// Add user data in session
			$this->session->set_userdata('outwardreport', $session_data);
		} else if (isset($search["submit"])) {
			if (!empty($search["sdate"])) {
				$sdate = $search["sdate"];
				$date = new DateTime($sdate);
				$searchtxt["sdate"] = $date->format('Y-m-d 00:00:00');
			}

			if (!empty($search["edate"])) {
				$edate = $search["edate"];
				$date = new DateTime($edate);
				$searchtxt["edate"] = $date->format('Y-m-d 23:59:59');
			}
			if (!empty($search["dispatch_party"])) {
				$dispatch_party = $search["dispatch_party"];
				$searchtxt["dispatch_party"] = $dispatch_party;
			}
			if (!empty($search["main_party"])) {
				$main_party = $search["main_party"];
				$searchtxt["main_party"] = $main_party;
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
			if (!empty($this->session->userdata['outwardreport']['sdate']) && $this->session->userdata['outwardreport']['sdate'] != "") {
				$sdate = $this->session->userdata['outwardreport']['sdate'];
				$date = new DateTime($sdate);
				$searchtxt["sdate"] = $date->format('Y-m-d 00:00:00');
				$sdate = $this->session->userdata['outwardreport']['sdate'];
			}
			if (!empty($this->session->userdata['outwardreport']['edate']) && $this->session->userdata['outwardreport']['edate'] != "") {
				$edate = $this->session->userdata['outwardreport']['edate'];
				$date = new DateTime($edate);
				$searchtxt["edate"] = $date->format('Y-m-d 23:59:59');
				$edate = $this->session->userdata['outwardreport']['edate'];
			}
			if (!empty($this->session->userdata['outwardreport']['dispatch_party'])) {
				$dispatch_party = $this->session->userdata['outwardreport']['dispatch_party'];
				$searchtxt['dispatch_party'] = $dispatch_party;
			}
			if (!empty($this->session->userdata['outwardreport']['main_party'])) {
				$main_party = $this->session->userdata['outwardreport']['main_party'];
				$searchtxt['main_party'] = $main_party;
			}
			if (!empty($this->session->userdata['outwardreport']['sortbycol'])) {
				$sortbycol = $this->session->userdata['outwardreport']['sortbycol'];
				$searchtxt['sortbycol'] = $sortbycol;
			}
			if (!empty($this->session->userdata['outwardreport']['sortby'])) {
				$sortby = $this->session->userdata['outwardreport']['sortby'];
				$searchtxt['sortby'] = $sortby;
			}
		}
		// init params
		$params = array();
		$limit_per_page = 10000000;
		$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$total_records = $this->QueriesReport->getOutwardReportCount($searchtxt);
		$params['outwardreport'] = $this->QueriesReport->getOutwardReport($searchtxt, $limit_per_page, $start_index);
		$params['page'] = $start_index;
               // $params['outwardtotal'] = $this->QueriesReport->getOutwardReportTotal($searchtxt);
		$session_data = array(
			'sortbycol' => $sortbycol,
			'sortby' => $sortby,
			'dispatch_party' => $dispatch_party,
			'main_party' => $main_party,
			'sdate' => $sdate,
			'edate' => $edate,
			'pageuri' => $start_index
		);
		// Add user data in session
		$this->session->set_userdata('outwardreport', $session_data);
		if ($total_records > 0) {
			// get current page records
			$config = PageConfig(base_url() . 'Reports/OutwardReport/index', $total_records, $limit_per_page, '4');
			$this->pagination->initialize($config);
			// build paging links
			$params["links"] = $this->pagination->create_links();
		}

		$query = "select id,company_name from " . TBL_CUSTOMER . " where isdelete=0 ";
		$params["customerlist"] = $this->Queries->get_tab_list($query, 'id', 'company_name');

		$this->load->view('Reports/OutwardReport/index', $params);
	}

	public function action()
	{
		date_default_timezone_set('Asia/Kolkata');
		$today = date("d_m_Y_g_i_A");
		$searchtxt = array();
		$sdate = "";
		$edate = "";
		$sortbycol = "";
		$sortby = "";
		$filename = "OutwardReport" . $today . ".xlsx";

		if (!empty($this->session->userdata['outwardreport']['sdate']) && $this->session->userdata['outwardreport']['sdate'] != "") {
			$sdate = $this->session->userdata['outwardreport']['sdate'];
			$date = new DateTime($sdate);
			$searchtxt["sdate"] = $date->format('Y-m-d 00:00:00');
			$sdate = $this->session->userdata['outwardreport']['sdate'];
		}
		if (!empty($this->session->userdata['outwardreport']['edate']) && $this->session->userdata['outwardreport']['edate'] != "") {
			$edate = $this->session->userdata['outwardreport']['edate'];
			$date = new DateTime($edate);
			$searchtxt["edate"] = $date->format('Y-m-d 23:59:59');
			$edate = $this->session->userdata['outwardreport']['edate'];
		}
		if (!empty($this->session->userdata['outwardreport']['sortbycol'])) {
			$sortbycol = $this->session->userdata['outwardreport']['sortbycol'];
			$searchtxt['sortbycol'] = $sortbycol;
		}
		if (!empty($this->session->userdata['outwardreport']['sortby'])) {
			$sortby = $this->session->userdata['outwardreport']['sortby'];
			$searchtxt['sortby'] = $sortby;
		}
		require_once APPPATH . 'third_party/Phpspreadsheet/vendor/autoload.php';

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$spreadsheet->getProperties()->setCreator('awesomeinfosys.com')
			->setLastModifiedBy('HighLevel')
			->setTitle('Highlevel Reports')
			->setSubject('For the purpose of HighLevel Reportss');



		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('sample/outward.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$spreadsheet->setActiveSheetIndex(0);

		$analingreport = $this->QueriesReport->getOutwardReport($searchtxt, '', '');

		$x = 3;
		$qty = 0;
		$totalweight = 0;
		$totalamount = 0;
		foreach ($analingreport as $row) {
			$date = new DateTime($row->dispatch_date);
			$disdate = $date->format('d-m-Y');

			$qty = $qty + $row->batch_qty;
			$totalweight = $totalweight + $row->total_weight;
			$totalamount = $totalamount + $row->total_amount;
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("A$x", $disdate);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("B$x", $row->chalan_no);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("C$x", $row->po_no);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("D$x", $row->item_no);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("E$x", $row->part_type);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("F$x", $row->batch_qty);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("G$x", $row->weight_piece);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("H$x", $row->total_weight);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("I$x", $row->dispatch_party);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("J$x", $row->main_party);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("K$x", $row->rate_qty);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue("L$x", $row->total_amount);
			$x++;
		}
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("A$x", "Total");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("F$x", $qty);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("H$x", $totalweight);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue("L$x", $totalamount);
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

		$spreadsheet->getActiveSheet()->getStyle("A1:L" . $x)->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A1:L' . $x)->getAlignment()->setWrapText(true);
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
