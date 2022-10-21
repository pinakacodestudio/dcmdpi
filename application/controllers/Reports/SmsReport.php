<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SmsReport extends CI_Controller
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
        $mobileno = "";
        $search = $this->input->post();
        if (isset($search["clearall"])) {
            $session_data = array(
                'mobileno' => '',
                'sdate' => '',
                'edate' => ''
            );
			// Add user data in session
            $this->session->set_userdata('smsreport', $session_data);
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
            if (!empty($search["mobileno"])) {
                $mobileno = $search["mobileno"];
                $searchtxt["mobileno"] = $mobileno;
            }
        } else {
            if (!empty($this->session->userdata['smsreport']['sdate']) && $this->session->userdata['smsreport']['sdate'] != "") {
                $sdate = $this->session->userdata['smsreport']['sdate'];
                $date = new DateTime($sdate);
                $searchtxt["sdate"] = $date->format('Y-m-d');
                $sdate = $this->session->userdata['smsreport']['sdate'];
            }
            if (!empty($this->session->userdata['smsreport']['edate']) && $this->session->userdata['smsreport']['edate'] != "") {
                $edate = $this->session->userdata['smsreport']['edate'];
                $date = new DateTime($edate);
                $searchtxt["edate"] = $date->format('Y-m-d');
                $edate = $this->session->userdata['smsreport']['edate'];
            }
            if (!empty($this->session->userdata['smsreport']['mobileno'])) {
                $mobileno = $this->session->userdata['smsreport']['mobileno'];
                $searchtxt['mobileno'] = $mobileno;
            }
        }

		// init params
        $params = array();
        $limit_per_page = 1000000000;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $total_records = $this->QueriesReport->getSmsReportCount($searchtxt);
        $params['smsreport'] = $this->QueriesReport->getSmsReport($searchtxt, $limit_per_page, $start_index);
        $params['page'] = $start_index;

        $session_data = array(
            'mobileno' => $mobileno,
            'sdate' => $sdate,
            'edate' => $edate,
            'pageuri' => $start_index
        );
		// Add user data in session
        $this->session->set_userdata('smsreport', $session_data);
        if ($total_records > 0) {
			// get current page records
            $config = PageConfig(base_url() . 'Reports/SmsReport/index', $total_records, $limit_per_page, '4');
            $this->pagination->initialize($config);
			// build paging links
            $params["links"] = $this->pagination->create_links();
        }

        $this->load->view('Reports/SmsReport/index', $params);
    }

}
