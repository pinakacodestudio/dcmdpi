<?php
class dashboard extends CI_Controller
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

        $params["starttime"] = microtime(true); // Top of page
        $platform = TBL_PLATFORM;
        $process = TBL_PROCESS;
        $query = "select $platform.id,$platform.platformid,$process.dettach_panel,$platform.processid,$process.platform_capacity , $process.remaining_capacity,$process.status  from $platform LEFT JOIN $process ON $process.id = $platform.processid where $platform.isdelete=0 order by $platform.id";
        $params["platform"] = $this->Queries->getRecord($query);

        $order = TBL_ORDER;
        $stock = TBL_STOCK;
        $customer = TBL_CUSTOMER;

        $query = "select $order.id,$order.orderno,$order.main_chalan_no,t1.company_name as from_forgine_party,t2.company_name as main_party,$order.item_no,$order.part_type,$order.batch_qty,$order.qty_used,$order.qty_ready, $order.qty_dispatch from $order LEFT JOIN $customer as t1 on $order.from_forgine_party = t1.id LEFT JOIN $customer as t2 on $order.main_party = t2.id where $order.isdelete=0 order by $order.id desc";
        $params["orderlist"] = $this->Queries->getRecord($query);

        $tot = 0;
        $start_date = date('Y-m-01');

        $query = "select sum(total_weight)/1000 as totalweight from " . TBL_DISPATCH . " where isdelete=0 and date(dispatch_date)>= '" . $start_date . "'";
        $res = $this->Queries->getSingleRecord($query);
        if ($res != null) {
            $tot = $res->totalweight;
        }
        $params["totalweight"] = $tot;

        $this->load->view('dashboard', $params);
    }
}
