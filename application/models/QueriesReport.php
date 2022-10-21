<?php
class QueriesReport extends CI_Model
{
    /************************************Analing Reports Section **************************************/

    public function getAnalingReportCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_PROCESS . " as t1");
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("t4.id = '" . $likeCriteria["customerid"] . "' or t5.id = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("t3.item_no = '" . $likeCriteria["itemno"] . "'");
        }
        if (!empty($likeCriteria["parttype"])) {
            $this->db->where("t3.part_type = '" . $likeCriteria["parttype"] . "'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("date(t1.start_preparing) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("date(t1.end_removing) <= '" . $likeCriteria["edate"] . "'");
        }
        $this->db->join(TBL_PLATFORM_MATERIAL . ' as t2', 't2.pid = t1.id', 'LEFT');
        $this->db->join(TBL_ORDER . ' as t3', 't3.id = t2.orderid', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t4', 't4.id = t3.from_forgine_party', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t5', 't5.id = t3.main_party', 'LEFT');
        $query = $this->db->get();
        return count($query->result());
    }

    function getAnalingReport($likeCriteria = '', $page, $segment)
    {
        $this->db->select('t4.platformid,t5.bellid,t6.panelid,t2.start_preparing,t2.end_removing,t2.attach_furnace,t1.qty,t1.weight_piece,t1.total_weight,t3.item_no,t3.part_type,(select company_name from ' . TBL_CUSTOMER . ' where id=t3.from_forgine_party order by id limit 1) as forging_name,(select company_name from ' . TBL_CUSTOMER . ' where id=t3.main_party order by id limit 1) main_party');
        $this->db->from(TBL_PLATFORM_MATERIAL . " as t1");
        $this->db->join(TBL_PROCESS . ' as t2', 't1.pid = t2.id', 'LEFT');
        $this->db->join(TBL_ORDER . ' as t3', 't1.orderid = t3.id', 'LEFT');
        $this->db->join(TBL_PLATFORM . ' as t4', 't2.platformid = t4.id', 'LEFT');
        $this->db->join(TBL_FURNACE . ' as t5', 't2.furnaceid = t5.id', 'LEFT');
        $this->db->join(TBL_POWERPANEL . ' as t6', 't2.panelid = t6.id', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("t3.main_party = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("t3.item_no = '" . $likeCriteria["itemno"] . "'");
        }
        if (!empty($likeCriteria["parttype"])) {
            $this->db->where("t3.part_type = '" . $likeCriteria["parttype"] . "'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("date(t2.start_preparing) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("date(t2.end_removing) <= '" . $likeCriteria["edate"] . "'");
        }
        $this->db->order_by("t1.id", "desc");
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }

    /************************************Inward Reports Section **************************************/

    public function getInwardReportCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_ORDER);
        $this->db->where('isdelete', 0);
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("item_no = '" . $likeCriteria["itemno"] . "'");
        }
        if (!empty($likeCriteria["parttype"])) {
            $this->db->where("part_type = '" . $likeCriteria["parttype"] . "'");
        }
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("main_party = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("date(received_date) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("date(received_date) <= '" . $likeCriteria["edate"] . "'");
        }
        $query = $this->db->get();
        return count($query->result());
    }

    function getInwardReport($likeCriteria = '', $page, $segment)
    {
        $this->db->select('t1.id,t1.received_date,t1.id,chalan_no,t1.main_chalan_no,t1.chalan_date,t1.item_no,t1.part_type,t1.batch_qty,t1.weight_piece,t1.total_weight,t2.company_name as forging_name,t3.company_name as main_party');
        $this->db->from(TBL_ORDER . " as t1");
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("t1.item_no = '" . $likeCriteria["itemno"] . "'");
        }
        if (!empty($likeCriteria["parttype"])) {
            $this->db->where("t1.part_type = '" . $likeCriteria["parttype"] . "'");
        }
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("t1.main_party = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("DATE(t1.received_date) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("DATE(t1.received_date) <= '" . $likeCriteria["edate"] . "'");
        }
        $this->db->join(TBL_CUSTOMER . ' as t2', 't1.from_forgine_party= t2.id', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t3', 't1.main_party = t3.id', 'LEFT');
        if ($page != "" && $segment != "") {
            $this->db->limit($page, $segment);
        }
        if (!empty($likeCriteria["sortbycol"]) && !empty($likeCriteria["sortby"])) {
            if ($likeCriteria["sortbycol"] == "received_from") {
                $this->db->order_by("t2.company_name", $likeCriteria["sortby"]);
            } elseif ($likeCriteria["sortbycol"] == "main_party") {
                $this->db->order_by("t3.company_name", $likeCriteria["sortby"]);
            } else {
                $this->db->order_by("t1." . $likeCriteria["sortbycol"], $likeCriteria["sortby"]);
            }
        } else {
            $this->db->order_by("t1.id", "asc");
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }

    /************************************Outward Reports Section **************************************/

    public function getOutwardReportCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_DISPATCH . " as t1");
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["dispatch_party"])) {
            $this->db->where("t1.dispatch_party = '" . $likeCriteria["dispatch_party"] . "'");
        }
        if (!empty($likeCriteria["main_party"])) {
            $this->db->where("t2.main_party = '" . $likeCriteria["dispatch_party"] . "'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("date(t1.dispatch_date) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("date(t1.dispatch_date) <= '" . $likeCriteria["edate"] . "'");
        }
        $this->db->join(TBL_ORDER . ' as t2', 't2.id= t1.orderid', 'LEFT');
        $query = $this->db->get();
        return count($query->result());
    }

    function getOutwardReport($likeCriteria = '', $page, $segment)
    {
        $this->db->select('t1.id,t1.dispatch_date,t1.chalan_no,t2.po_no,t2.item_no,t2.part_type,t1.batch_qty,t1.weight_piece,t1.total_weight,t1.rate_qty,t1.total_amount,t3.company_name as dispatch_party,t4.company_name as main_party');
        $this->db->from(TBL_DISPATCH . " as t1");
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["dispatch_party"])) {
            $this->db->where("t1.dispatch_party = '" . $likeCriteria["dispatch_party"] . "'");
        }
        if (!empty($likeCriteria["main_party"])) {
            $this->db->where("t2.main_party = '" . $likeCriteria["main_party"] . "'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("DATE(t1.dispatch_date) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("DATE(t1.dispatch_date) <= '" . $likeCriteria["edate"] . "'");
        }
        $this->db->join(TBL_ORDER . ' as t2', 't1.orderid= t2.id', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t3', 't1.dispatch_party= t3.id', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t4', 't2.main_party = t4.id', 'LEFT');
        if ($page != "" && $segment != "") {
            $this->db->limit($page, $segment);
        }
        if (!empty($likeCriteria["sortbycol"]) && !empty($likeCriteria["sortby"])) {
            $this->db->order_by("t1." . $likeCriteria["sortbycol"], $likeCriteria["sortby"]);
        } else {
            $this->db->order_by("t1.id", "asc");
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }

    /************************************Material Reports Section **************************************/

    public function getMaterialReportCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_ORDER . " as t1");
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("t1.from_forgine_party = '" . $likeCriteria["customerid"] . "' or t1.main_party = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("t1.item_no = '" . $likeCriteria["itemno"] . "'");
        }
        $this->db->join(TBL_CUSTOMER . ' as t2', 't2.id = t1.from_forgine_party', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t3', 't3.id = t1.main_party', 'LEFT');
        $query = $this->db->get();
        return count($query->result());
    }

    function getMaterialReport($likeCriteria = '', $page, $segment)
    {
        $this->db->select('t1.orderno,t1.item_no,t1.part_type,t1.batch_qty,t2.company_name as forging_name,t3.company_name as main_party,  COALESCE((select sum(qty) from '.TBL_STOCK.' where orderid=t1.id and status=2 ),0) as qty_used,  COALESCE((select sum(qty) from '.TBL_STOCK.' where orderid=t1.id and status=3 ),0) as qty_ready,  COALESCE((select sum(qty) from '.TBL_STOCK.' where orderid=t1.id and status=4 ),0) as qty_dispatch');
        $this->db->from(TBL_ORDER . " as t1");
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("t1.from_forgine_party = '" . $likeCriteria["customerid"] . "' or t1.main_party = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("t1.item_no = '" . $likeCriteria["itemno"] . "'");
        }
        $this->db->join(TBL_CUSTOMER . ' as t2', 't2.id = t1.from_forgine_party', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t3', 't3.id = t1.main_party', 'LEFT');
        if ($page != "" && $segment != "") {
            $this->db->limit($page, $segment);
        }
        if (!empty($likeCriteria["sortbycol"]) && !empty($likeCriteria["sortby"])) {
            $this->db->order_by("t1." . $likeCriteria["sortbycol"], $likeCriteria["sortby"]);
        } else {
            $this->db->order_by("t1.id", "desc");
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }

    /************************************Ready Reports Section **************************************/

    public function getDispatchReportCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_ORDER . " as t1");
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("t1.from_forgine_party = '" . $likeCriteria["customerid"] . "' or t1.main_party = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("t1.item_no = '" . $likeCriteria["itemno"] . "'");
        }
        $this->db->join(TBL_CUSTOMER . ' as t2', 't2.id = t1.from_forgine_party', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t3', 't3.id = t1.main_party', 'LEFT');
        $this->db->where("(t1.qty_ready - t1.qty_dispatch) > 0 ");
        $query = $this->db->get();
        return count($query->result());
    }

    function getDispatchReport($likeCriteria = '', $page, $segment)
    {
        $this->db->select('t1.orderno,t1.po_no,t1.item_no,t1.part_type,t1.weight_piece,t1.qty_used,t1.qty_ready, t1.qty_dispatch,t2.company_name as forging_name,t3.company_name as main_party');
        $this->db->from(TBL_ORDER . " as t1");
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("t1.from_forgine_party = '" . $likeCriteria["customerid"] . "' or t1.main_party = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("t1.item_no = '" . $likeCriteria["itemno"] . "'");
        }
        $this->db->join(TBL_CUSTOMER . ' as t2', 't2.id = t1.from_forgine_party', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t3', 't3.id = t1.main_party', 'LEFT');
        if ($page != "" && $segment != "") {
            $this->db->limit($page, $segment);
        }
        if (!empty($likeCriteria["sortbycol"]) && !empty($likeCriteria["sortby"])) {
            $this->db->order_by("t1." . $likeCriteria["sortbycol"], $likeCriteria["sortby"]);
        } else {
            $this->db->order_by("t1.id", "desc");
        }
        $this->db->where("( coalesce((select sum(qty) from " . TBL_STOCK . " where orderid=t1.id and status = 3),0) -  coalesce((select sum(qty) from " . TBL_STOCK . " where orderid=t1.id and status = 4),0)) > 0 ");
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }

    /********************************************************** Sms Report Section **********************************************/

    public function getSmsReportCount($likeCriteria = '')
    {
        $this->db->from(TBL_MESSAGEBOX);
        $query = $this->db->get();
        return count($query->result());
    }

    function getSmsReport($likeCriteria = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from(TBL_MESSAGEBOX);
        if (!empty($likeCriteria["mobileno"])) {
            $this->db->where("mobileno LIKE '%" . $likeCriteria['mobileno'] . "%'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("date(created_on) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("date(created_on) <= '" . $likeCriteria["edate"] . "'");
        }
        $this->db->limit($page, $segment);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    /********************************************************** Customer Report Section **********************************************/

    public function getCustomerReportCount($likeCriteria = '')
    {
        $this->db->from(TBL_CUSTOMER);
        $query = $this->db->get();
        return count($query->result());
    }

    function getCustomerReport($likeCriteria = '', $page, $segment)
    {
        $cyear = date("Y");
        $cdate = $cyear . "-04-01";
        $pyear = $cyear - 1;
        $lsdate = $pyear . "-04-01";
        $ledate = $cyear . "-03-31";
        $tabstock = TBL_STOCK;
        $taborder = TBL_ORDER;
        $tabdispatch = TBL_DISPATCH;


        $this->db->select("t1.id,t1.customer_name,t1.company_name,t1.customer_mobile,t1.customer_address,coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join " . $taborder . " as t3 on t3.id=t2.orderid where t3.main_party = t1.id),0) as totqty,coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join " . $taborder . " as t3 on t3.id=t2.orderid where t3.main_party = t1.id and date(t2.dispatch_date) >='" . $cdate . "'),0) as cqty,coalesce((select sum(t2.total_weight) from " . $tabdispatch . " as t2 left join " . $taborder . " as t3 on t3.id=t2.orderid where t3.main_party = t1.id and date(t2.dispatch_date) >='" . $lsdate . "' and date(t2.dispatch_date) <='" . $ledate . "'),0) as lastqty");
        $this->db->from(TBL_CUSTOMER . " as t1");

        if (!empty($likeCriteria["mobileno"])) {
            $this->db->where("mobileno LIKE '%" . $likeCriteria['mobileno'] . "%'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("date(created_on) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("date(created_on) <= '" . $likeCriteria["edate"] . "'");
        }
        $this->db->limit($page, $segment);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
}
