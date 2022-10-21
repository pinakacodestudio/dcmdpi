<?php
class Queries extends CI_Model
{

    /********************************************************** User Login Section **********************************************/
    // Read data using username and password
    public function login($data)
    {

        $condition = "user_email =" . "'" . $data['username'] . "' AND " . "user_password =" . "'" . $data['password'] . "'";
        $this->db->select('*');
        $this->db->from(TBL_USERINFO);
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    // Read data from database to show data in admin page
    public function read_user_information($username)
    {

        $condition = "user_email =" . "'" . $username . "'";
        $this->db->select('*');
        $this->db->from(TBL_USERINFO);
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    /********************************************************** General Query Section **********************************************/


    // Record Counting For Table
    public function record_count($tablename)
    {
        return $this->db->count_all($tablename);
    }

    // Get List of Records
    public function getRecord($query)
    {
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    // Get Single Record Master table List
    public function getSingleRecord($query)
    {
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    // Add Record To Table
    public function addRecord($tablename, $data)
    {
        return $this->db->insert($tablename, $data);
    }

    // Update Record To Table
    public function updateRecord($tablename, $data, $id)
    {
        return $this->db->where('id', $id)
            ->update($tablename, $data);
    }

    // Update Record To Table
    public function updateSpecialRecord($tablename, $data, $column, $id)
    {
        return $this->db->where($column, $id)->update($tablename, $data);
    }
    

    // Get Dropdown List from Table
    public function get_tab_list($query, $id, $colname)
    {
        $query = $this->db->query($query);
        $result = $query->result();
        $cat_id = array('');
        $cat_name = array('- Select -');
        for ($i = 0; $i < count($result); $i++) {
            array_push($cat_id, $result[$i]->$id);
            array_push($cat_name, $result[$i]->$colname);
        }
        return array_combine($cat_id, $cat_name);
    }

      // Get Dropdown List from Table
    public function get_tab_list_two($query, $id, $colname, $colname2)
    {
        $query = $this->db->query($query);
        $result = $query->result();
        $cat_id = array('');
        $cat_name = array('- Select -');
        for ($i = 0; $i < count($result); $i++) {
            array_push($cat_id, $result[$i]->$id);
            array_push($cat_name, $result[$i]->$colname . " - " . $result[$i]->$colname2);
        }
        return array_combine($cat_id, $cat_name);
    }



    /********************************************************** User Management Section **********************************************/

    public function getUserCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_USERINFO);
        if (!empty($likeCriteria['user_fullname'])) {
            $this->db->WHERE("user_fullname LIKE '%" . $likeCriteria['user_fullname'] . "%'");
        }
        if (!empty($likeCriteria['user_email'])) {
            $this->db->WHERE("user_email LIKE '%" . $likeCriteria['user_email'] . "%'");
        }
        if (!empty($likeCriteria['user_mob'])) {
            $this->db->WHERE("user_mob LIKE '%" . $likeCriteria['user_mob'] . "%'");
        }
        $this->db->where('isdelete', 0);
        $query = $this->db->get();
        return count($query->result());
    }

    function getUser($likeCriteria = '', $page, $segment)
    {
        $this->db->select('t1.id,t1.user_fullname,t1.user_blocked,t1.user_email,t1.user_mob');
        $this->db->from(TBL_USERINFO . ' as t1');
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria['user_fullname'])) {
            $this->db->WHERE("t1.user_fullname LIKE '%" . $likeCriteria['user_fullname'] . "%'");
        }
        if (!empty($likeCriteria['user_email'])) {
            $this->db->WHERE("t1.user_email LIKE '%" . $likeCriteria['user_email'] . "%'");
        }
        if (!empty($likeCriteria['user_mob'])) {
            $this->db->WHERE("t1.user_mob LIKE '%" . $likeCriteria['user_mob'] . "%'");
        }
        $this->db->limit($page, $segment);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    /********************************************************** Platform Section **********************************************/

    public function getPlatformCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_PLATFORM);
        $this->db->where('isdelete', 0);
        $query = $this->db->get();
        return count($query->result());
    }

    function getPlatform($likeCriteria = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from(TBL_PLATFORM);
        $this->db->where('isdelete', 0);
        $this->db->limit($page, $segment);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    /************************************Furnace Section *********************************/

    public function getFurnaceCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_FURNACE);
        $this->db->where('isdelete', 0);
        $query = $this->db->get();
        return count($query->result());
    }

    function getFurnace($likeCriteria = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from(TBL_FURNACE . ' as t1');
        $this->db->where('isdelete', 0);
        $this->db->limit($page, $segment);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    /************************************Furnace Section *********************************/

    public function getPowerpanelCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_POWERPANEL);
        $this->db->where('isdelete', 0);
        $query = $this->db->get();
        return count($query->result());
    }

    function getPowerpanel($likeCriteria = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from(TBL_POWERPANEL . ' as t1');
        $this->db->where('isdelete', 0);
        $this->db->limit($page, $segment);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }


    /********************************************************** Customer Management Section **********************************************/

    public function getCustomerCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_CUSTOMER);
        $this->db->where('isdelete', 0);
        $query = $this->db->get();
        return count($query->result());
    }

    function getCustomer($likeCriteria = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from(TBL_CUSTOMER);
        $this->db->where('isdelete', 0);
        $this->db->limit($page, $segment);
        $this->db->order_by("company_name", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    /********************************************************** Vehicle Management Section **********************************************/

    public function getVehicleCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_VEHICLE);
        $this->db->where('isdelete', 0);
        $query = $this->db->get();
        return count($query->result());
    }

    function getVehicle($likeCriteria = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from(TBL_VEHICLE);
        $this->db->where('isdelete', 0);
        $this->db->limit($page, $segment);
        $this->db->order_by("driver_name", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    /********************************************************** Order Management Section **********************************************/

    public function getOrderCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_ORDER . " as t1");
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("t2.id = '" . $likeCriteria["customerid"] . "' or t3.id = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("t1.item_no = '" . $likeCriteria["itemno"] . "'");
        }
        if (!empty($likeCriteria["parttype"])) {
            $this->db->where("t1.part_type = '" . $likeCriteria["parttype"] . "'");
        }
        if (!empty($likeCriteria["challanno"])) {
            $this->db->where("t1.chalan_no LIKE '%" . $likeCriteria['challanno'] . "%'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("date(t1.received_date) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("date(t1.received_date) <= '" . $likeCriteria["edate"] . "'");
        }
        $this->db->join(TBL_CUSTOMER . ' as t2', 't2.id = t1.from_forgine_party', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t3', 't3.id = t1.main_party', 'LEFT');

        $query = $this->db->get();
        return count($query->result());
    }

    function getOrder($likeCriteria = '', $page, $segment)
    {
        $this->db->select('t1.id,t1.orderno,t1.received_date,t1.total_weight,t1.chalan_no,t1.batch_qty,t1.item_no,t1.part_type,t2.company_name as from_forgine_party,t3.company_name as main_party, coalesce((select sum(qty) from ' . TBL_STOCK . ' where orderid=t1.id and status = 4),0) as qty_dispatch');
        $this->db->from(TBL_ORDER . ' as t1');
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("t2.id = '" . $likeCriteria["customerid"] . "' or t3.id = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("t1.item_no = '" . $likeCriteria["itemno"] . "'");
        }
        if (!empty($likeCriteria["parttype"])) {
            $this->db->where("t1.part_type = '" . $likeCriteria["parttype"] . "'");
        }
        if (!empty($likeCriteria["challanno"])) {
            $this->db->where("t1.chalan_no LIKE '%" . $likeCriteria['challanno'] . "%'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("date(t1.received_date) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("date(t1.received_date) <= '" . $likeCriteria["edate"] . "'");
        }
        $this->db->join(TBL_CUSTOMER . ' as t2', 't1.from_forgine_party= t2.id', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t3', 't1.main_party= t3.id', 'LEFT');
        $this->db->limit($page, $segment);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    /********************************************************** Invoice Management Section **********************************************/

    public function getInvoiceCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_INVOICE . " as t1");
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("t2.id = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("t1.item_no = '" . $likeCriteria["itemno"] . "'");
        }
        if (!empty($likeCriteria["parttype"])) {
            $this->db->where("t1.part_type = '" . $likeCriteria["parttype"] . "'");
        }
        if (!empty($likeCriteria["challanno"])) {
            $this->db->where("t1.chalan_no LIKE '%" . $likeCriteria['challanno'] . "%'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("date(t1.received_date) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("date(t1.received_date) <= '" . $likeCriteria["edate"] . "'");
        }
        $this->db->join(TBL_CUSTOMER . ' as t2', 't2.id = t1.customerid', 'LEFT');

        $query = $this->db->get();
        return count($query->result());
    }

    function getInvoice($likeCriteria = '', $page, $segment)
    {
        $this->db->select('t1.id,t1.invoice_date,t1.cash_debit,t1.total_qty,t1.invoice_no,t1.total_weight,t1.total_amount,t1.grand_amount,t2.company_name');
        $this->db->from(TBL_INVOICE . ' as t1');
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("t2.id = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("t1.item_no = '" . $likeCriteria["itemno"] . "'");
        }
        if (!empty($likeCriteria["parttype"])) {
            $this->db->where("t1.part_type = '" . $likeCriteria["parttype"] . "'");
        }
        if (!empty($likeCriteria["challanno"])) {
            $this->db->where("t1.chalan_no LIKE '%" . $likeCriteria['challanno'] . "%'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("date(t1.received_date) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("date(t1.received_date) <= '" . $likeCriteria["edate"] . "'");
        }
        $this->db->join(TBL_CUSTOMER . ' as t2', 't1.customerid= t2.id', 'LEFT');
        $this->db->limit($page, $segment);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    /********************************************************** Dispatch Management Section **********************************************/

    public function getDispatchCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_DISPATCH);
        $this->db->where('isdelete', 0);
        $query = $this->db->get();
        return count($query->result());
    }

    function getDispatch($likeCriteria = '', $page, $segment)
    {
        $this->db->select('t1.id,t1.orderid,t3.orderno,t1.dispatch_date,t1.chalan_no,t2.company_name as dispatch_party,t4.company_name as main_party,t1.batch_qty,t3.item_no,t3.part_type,t1.total_weight');
        $this->db->from(TBL_DISPATCH . ' as t1');
        $this->db->where('t1.isdelete', 0);
        $this->db->join(TBL_CUSTOMER . ' as t2', 't1.dispatch_party= t2.id', 'LEFT');
        $this->db->join(TBL_ORDER . ' as t3', 't1.orderid= t3.id', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t4', 't3.main_party= t4.id', 'LEFT');
        $this->db->limit($page, $segment);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    /********************************************************** Process Management Section **********************************************/

    public function getProcessCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_PROCESS);
        $this->db->where('isdelete', 0);
        $query = $this->db->get();
        return count($query->result());
    }

    function getProcess($likeCriteria = '', $page, $segment)
    {
        $this->db->select('t1.id,t2.platformid,t3.bellid,t4.panelid,t1.status,t1.platform_capacity,t1.start_preparing,t1.end_removing,t1.remaining_capacity');
        $this->db->from(TBL_PROCESS . ' as t1');
        $this->db->where('t1.isdelete', 0);
        $this->db->join(TBL_PLATFORM . ' as t2', 't1.platformid= t2.id', 'LEFT');
        $this->db->join(TBL_FURNACE . ' as t3', 't1.furnaceid= t3.id', 'LEFT');
        $this->db->join(TBL_POWERPANEL . ' as t4', 't1.panelid= t4.id', 'LEFT');
        $this->db->limit($page, $segment);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    /********************************************************** Jobwork Management Section **********************************************/

    public function getJobworkCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_ORDER . " as t1");
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("t2.id = '" . $likeCriteria["customerid"] . "' or t3.id = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("t1.item_no = '" . $likeCriteria["itemno"] . "'");
        }
        if (!empty($likeCriteria["parttype"])) {
            $this->db->where("t1.part_type = '" . $likeCriteria["parttype"] . "'");
        }
        if (!empty($likeCriteria["challanno"])) {
            $this->db->where("t1.chalan_no LIKE '%" . $likeCriteria['challanno'] . "%'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("date(t1.received_date) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("date(t1.received_date) <= '" . $likeCriteria["edate"] . "'");
        }
        $this->db->join(TBL_CUSTOMER . ' as t2', 't2.id = t1.from_forgine_party', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t3', 't3.id = t1.main_party', 'LEFT');

        $query = $this->db->get();
        return count($query->result());
    }

    function getJobwork($likeCriteria = '', $page, $segment)
    {
        $this->db->select('t1.id,t1.orderno,t1.status,t1.weight_piece,t1.received_date,t1.total_weight,t1.chalan_no,t1.batch_qty,t1.item_no,t1.part_type,t2.company_name as from_forgine_party,t3.company_name as main_party, coalesce((select sum(qty) from ' . TBL_STOCK . ' where orderid=t1.id and status = 4),0) as qty_dispatch');
        $this->db->from(TBL_ORDER . ' as t1');
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where("t2.id = '" . $likeCriteria["customerid"] . "' or t3.id = '" . $likeCriteria["customerid"] . "'");
        }
        if (!empty($likeCriteria["itemno"])) {
            $this->db->where("t1.item_no = '" . $likeCriteria["itemno"] . "'");
        }
        if (!empty($likeCriteria["parttype"])) {
            $this->db->where("t1.part_type = '" . $likeCriteria["parttype"] . "'");
        }
        if (!empty($likeCriteria["challanno"])) {
            $this->db->where("t1.chalan_no LIKE '%" . $likeCriteria['challanno'] . "%'");
        }
        if (!empty($likeCriteria["sdate"])) {
            $this->db->where("date(t1.received_date) >= '" . $likeCriteria["sdate"] . "'");
        }
        if (!empty($likeCriteria["edate"])) {
            $this->db->where("date(t1.received_date) <= '" . $likeCriteria["edate"] . "'");
        }
        $this->db->join(TBL_CUSTOMER . ' as t2', 't1.from_forgine_party= t2.id', 'LEFT');
        $this->db->join(TBL_CUSTOMER . ' as t3', 't1.main_party= t3.id', 'LEFT');
        $this->db->limit($page, $segment);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

}
?>
