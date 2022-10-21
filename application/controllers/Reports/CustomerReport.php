<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CustomerReport extends CI_Controller
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
            $this->session->set_userdata('customerreport', $session_data);
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
            if (!empty($this->session->userdata['customerreport']['sdate']) && $this->session->userdata['customerreport']['sdate'] != "") {
                $sdate = $this->session->userdata['customerreport']['sdate'];
                $date = new DateTime($sdate);
                $searchtxt["sdate"] = $date->format('Y-m-d');
                $sdate = $this->session->userdata['customerreport']['sdate'];
            }
            if (!empty($this->session->userdata['customerreport']['edate']) && $this->session->userdata['customerreport']['edate'] != "") {
                $edate = $this->session->userdata['customerreport']['edate'];
                $date = new DateTime($edate);
                $searchtxt["edate"] = $date->format('Y-m-d');
                $edate = $this->session->userdata['customerreport']['edate'];
            }
            if (!empty($this->session->userdata['customerreport']['mobileno'])) {
                $mobileno = $this->session->userdata['customerreport']['mobileno'];
                $searchtxt['mobileno'] = $mobileno;
            }
        }

        
		// init params
        $params = array();
        $limit_per_page = 100000000;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $total_records = $this->QueriesReport->getCustomerReportCount($searchtxt);
        $params['customerreport'] = $this->QueriesReport->getCustomerReport($searchtxt, $limit_per_page, $start_index);
        $params['page'] = $start_index;

        $session_data = array(
            'mobileno' => $mobileno,
            'sdate' => $sdate,
            'edate' => $edate,
            'pageuri' => $start_index
        );
		// Add user data in session
        $this->session->set_userdata('customerreport', $session_data);
        if ($total_records > 0) {
			// get current page records
            $config = PageConfig(base_url() . 'Reports/CustomerReport/index', $total_records, $limit_per_page, '4');
            $this->pagination->initialize($config);
			// build paging links
            $params["links"] = $this->pagination->create_links();
        }

        $this->load->view('Reports/CustomerReport/index', $params);
    }

    public function details($id)
    {
        $cyear = date("Y");
        $cdate = $cyear . "-04-01";
        $pyear = $cyear - 1;
        $c1year = $cyear + 1;
        $lsdate = $pyear . "-04-01";
        $ledate = $cyear . "-03-31";
        $tabstock = TBL_STOCK;
        $taborder = TBL_ORDER;
        $tabdispatch = TBL_DISPATCH;


        $query = "select t1.company_name,
        
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id),0) as totqty,

        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and date(t2.dispatch_date) >='".$cdate."'),0) as cqty,
        
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and date(t2.dispatch_date) >='".$lsdate."' and date(t2.dispatch_date) <='".$ledate."'),0) as lastqty,

        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$cyear."' and MONTH(t2.dispatch_date) = '4'),0) as c_apr_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$cyear."' and MONTH(t2.dispatch_date) = '5'),0) as c_may_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$cyear."' and MONTH(t2.dispatch_date) = '6'),0) as c_jun_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$cyear."' and MONTH(t2.dispatch_date) = '7'),0) as c_jul_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$cyear."' and MONTH(t2.dispatch_date) = '8'),0) as c_aug_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$cyear."' and MONTH(t2.dispatch_date) = '9'),0) as c_sep_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$cyear."' and MONTH(t2.dispatch_date) = '10'),0) as c_oct_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$cyear."' and MONTH(t2.dispatch_date) = '11'),0) as c_nov_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$cyear."' and MONTH(t2.dispatch_date) = '12'),0) as c_dec_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$c1year."' and MONTH(t2.dispatch_date) = '1'),0) as c_jan_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$c1year."' and MONTH(t2.dispatch_date) = '2'),0) as c_feb_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$c1year."' and MONTH(t2.dispatch_date) = '3'),0) as c_mar_qty,
       

        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$pyear."' and MONTH(t2.dispatch_date) = '4'),0) as l_apr_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$pyear."' and MONTH(t2.dispatch_date) = '5'),0) as l_may_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$pyear."' and MONTH(t2.dispatch_date) = '6'),0) as l_jun_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$pyear."' and MONTH(t2.dispatch_date) = '7'),0) as l_jul_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$pyear."' and MONTH(t2.dispatch_date) = '8'),0) as l_aug_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$pyear."' and MONTH(t2.dispatch_date) = '9'),0) as l_sep_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$pyear."' and MONTH(t2.dispatch_date) = '10'),0) as l_oct_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$pyear."' and MONTH(t2.dispatch_date) = '11'),0) as l_nov_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$pyear."' and MONTH(t2.dispatch_date) = '12'),0) as l_dec_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$cyear."' and MONTH(t2.dispatch_date) = '1'),0) as l_jan_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$cyear."' and MONTH(t2.dispatch_date) = '2'),0) as l_feb_qty,
       
        coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id and YEAR(t2.dispatch_date)='".$cyear."' and MONTH(t2.dispatch_date) = '3'),0) as l_mar_qty
       
        
        from " . TBL_CUSTOMER . " as t1 where t1.id=" . $id;
        $params = $this->Queries->getSingleRecord($query);

        $query = "select ,coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join ".$taborder." as t3 on t3.id=t2.orderid where t3.main_party = t1.id),0) as totqty ";

        $this->load->view('Reports/CustomerReport/view', $params);
    }

}
