<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller
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
        $sdate = "";
        $edate = "";
        $itemno = "";
        $parttype = "";
        $challanno = "";
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
                'challanno' => '',
                'customerid' => '',
                'sdate' => '',
                'edate' => ''
            );
            // Add user data in session
            $this->session->set_userdata('orders', $session_data);
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
            if (!empty($search["challanno"])) {
                $challanno = $search["challanno"];
                $searchtxt["challanno"] = $challanno;
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
            if (!empty($this->session->userdata['orders']['sdate']) && $this->session->userdata['orders']['sdate'] != "") {
                $sdate = $this->session->userdata['orders']['sdate'];
                $date = new DateTime($sdate);
                $searchtxt["sdate"] = $date->format('Y-m-d');
                $sdate = $this->session->userdata['orders']['sdate'];
            }
            if (!empty($this->session->userdata['orders']['edate']) && $this->session->userdata['orders']['edate'] != "") {
                $edate = $this->session->userdata['orders']['edate'];
                $date = new DateTime($edate);
                $searchtxt["edate"] = $date->format('Y-m-d');
                $edate = $this->session->userdata['orders']['edate'];
            }
            if (!empty($this->session->userdata['orders']['itemno'])) {
                $itemno = $this->session->userdata['orders']['itemno'];
                $searchtxt['itemno'] = $itemno;
            }
            if (!empty($this->session->userdata['orders']['parttype'])) {
                $parttype = $this->session->userdata['orders']['parttype'];
                $searchtxt['parttype'] = $parttype;
            }
            if (!empty($this->session->userdata['orders']['challanno'])) {
                $challanno = $this->session->userdata['orders']['challanno'];
                $searchtxt['challanno'] = $challanno;
            }
            if (!empty($this->session->userdata['orders']['customerid'])) {
                $customerid = $this->session->userdata['orders']['customerid'];
                $searchtxt['customerid'] = $customerid;
            }
            if (!empty($this->session->userdata['orders']['sortbycol'])) {
                $sortbycol = $this->session->userdata['orders']['sortbycol'];
                $searchtxt['sortbycol'] = $sortbycol;
            }
            if (!empty($this->session->userdata['orders']['sortby'])) {
                $sortby = $this->session->userdata['orders']['sortby'];
                $searchtxt['sortby'] = $sortby;
            }
        }

        // init params
        $params = array();
        $limit_per_page = 100000000;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->Queries->getInvoiceCount($searchtxt);
        $params['invoicelist'] = $this->Queries->getInvoice($searchtxt, $limit_per_page, $start_index);
        $params['page'] = $start_index;
        $session_data = array(
            'sortbycol' => $sortbycol,
            'sortby' => $sortby,
            'itemno' => $itemno,
            'parttype' => $parttype,
            'challanno' => $challanno,
            'customerid' => $customerid,
            'sdate' => $sdate,
            'edate' => $edate,
            'pageuri' => $start_index
        );
       // Add user data in session
        $this->session->set_userdata('invoice', $session_data);
        if ($total_records > 0) {
            $config = PageConfig(base_url() . 'Invoice/index', $total_records, $limit_per_page, '3');
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

        $this->load->view('Invoice/index', $params);
    }

    public function add($id = 0)
    {
        $query = "select * from " . TBL_CUSTOMER . " where isdelete=0";
        $customerlist = $this->Queries->get_tab_list($query, 'id', 'company_name');
        try {
            $invoice = "";
            if ($id != "" and $id != 0) {
                $query = "select * from " . TBL_INVOICE . " where id=" . $id;
                $invoice = $this->Queries->getSingleRecord($query);

                $query = "select t1.id,t1.jobwork_chalan,t1.jobwork_date,t1.jobwork_qty,t1.jobwork_amount,t1.item_no,t1.part_type,t2.contract_rate,t2.company_name,t1.weight_piece from " . TBL_ORDER . " as t1 left join " . TBL_CUSTOMER . " as t2 on t2.id = t1.main_party where t1.billstatus = 1 and t1.invoiceid=" . $id;
                $orderlist = $this->Queries->getRecord($query);
            }
            $this->load->view('Invoice/add', ['id' => $id, 'invoice' => $invoice, 'customerlist' => $customerlist, 'orderlist' => $orderlist]);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function addsub($id = 0, $subid = 0)
    {

        try {
            $invoice = "";
            if ($id != "" and $id != 0) {
                $query = "select t1.id,t1.jobwork_chalan,t1.jobwork_date,t1.jobwork_qty,t1.jobwork_amount,t1.item_no,t1.part_type,t2.contract_rate,t2.company_name,t1.weight_piece from " . TBL_ORDER . " as t1 left join " . TBL_CUSTOMER . " as t2 on t2.id = t1.main_party where t1.main_party=" . $id . " and status = 1 and ( (billstatus = 0) or ( billstatus = 1 and invoiceid = " . $subid . "))  ";
                $orderlist = $this->Queries->getRecord($query);
            }
            $this->load->view('Invoice/addsub', ['id' => $id, 'orderlist' => $orderlist]);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function save()
    {
        $this->form_validation->set_rules('customerid', 'Customer', 'required');
        $this->form_validation->set_rules('invoice_no', 'Invoice No.', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $invoice_date = StringRepair($data['invoice_date']);
            $date = new DateTime($invoice_date);
            $invoice_date = $date->format('Y-m-d');
            $customerid = StringRepair($data['customerid']);
            $invoice_no = StringRepair($data['invoice_no']);
            $cash_debit = StringRepair($data['cash_debit']);
            $tax_invoice = StringRepair($data['tax_invoice']);
            $supply_of = StringRepair($data['supply_of']);
            $dispatch_through = StringRepair($data['dispatch_through']);
            $destination = StringRepair($data['destination']);
            $case_bag = StringRepair($data['case_bag']);
            $sgst = StringRepair($data['sgst']);
            $sgst_value = StringRepair($data['sgst_value']);
            $cgst = StringRepair($data['cgst']);
            $cgst_value = StringRepair($data['cgst_value']);
            $igst = StringRepair($data['igst']);
            $igst_value = StringRepair($data['igst_value']);
            $total_qty = StringRepair($data['totalqty']);
            $total_amount = StringRepair($data['totalamount']);
            $total_weight = StringRepair($data['totalweight']);
            $grand_amount = StringRepair($data['grandamount']);

            $count = StringRepair($data['count']);

            $orgcopy = $this->input->post('original_copy');
            $original_copy = 0;
            if ($orgcopy != "") {
                $original_copy = 1;
            }
            $dupcopy = $this->input->post('duplicate_copy');
            $duplicate_copy = 0;
            if ($dupcopy != "") {
                $duplicate_copy = 1;
            }
            $extcopy = $this->input->post('extra_copy');
            $extra_copy = 0;
            if ($extcopy != "") {
                $extra_copy = 1;
            }

            $id = $this->input->post('id');
            $today = date('Y-m-d H:i:s');
            $orderdate = date('m-d');
            if ($id != 0 and $id != "") {

                $form_data = array(
                    'userid' => $this->session->userdata['logged_in']['userid'],
                    'customerid' => $customerid,
                    'invoice_date' => $invoice_date,
                    'invoice_no' => $invoice_no,
                    'cash_debit' => $cash_debit,
                    'tax_invoice' => $tax_invoice,
                    'supply_of' => $supply_of,
                    'dispatch_through' => $dispatch_through,
                    'destination' => $destination,
                    'case_bag' => $case_bag,
                    'sgst' => $sgst,
                    'sgst_value' => $sgst_value,
                    'cgst' => $cgst,
                    'cgst_value' => $cgst_value,
                    'igst' => $igst,
                    'igst_value' => $igst_value,
                    'total_qty' => $total_qty,
                    'total_weight' => $total_weight,
                    'total_amount' => $total_amount,
                    'grand_amount' => $grand_amount,
                    'original_copy' => $original_copy,
                    'duplicate_copy' => $duplicate_copy,
                    'extra_copy' => $extra_copy,
                    'updated_on' => $today
                );
                if ($this->Queries->updateRecord(TBL_INVOICE, $form_data, $id)) :
                    $this->session->set_flashdata('success_msg', 'Invoice Updated Successfully');
                else :
                    $this->session->set_flashdata('error_msg', 'Failed To Update Invoice');
                endif;
            } else {

                $form_data = array(
                    'userid' => $this->session->userdata['logged_in']['userid'],
                    'customerid' => $customerid,
                    'invoice_date' => $invoice_date,
                    'invoice_no' => $invoice_no,
                    'cash_debit' => $cash_debit,
                    'tax_invoice' => $tax_invoice,
                    'supply_of' => $supply_of,
                    'dispatch_through' => $dispatch_through,
                    'destination' => $destination,
                    'case_bag' => $case_bag,
                    'sgst' => $sgst,
                    'sgst_value' => $sgst_value,
                    'cgst' => $cgst,
                    'cgst_value' => $cgst_value,
                    'igst' => $igst,
                    'igst_value' => $igst_value,
                    'total_qty' => $total_qty,
                    'total_weight' => $total_weight,
                    'total_amount' => $total_amount,
                    'grand_amount' => $grand_amount,
                    'original_copy' => $original_copy,
                    'duplicate_copy' => $duplicate_copy,
                    'extra_copy' => $extra_copy,
                    'updated_on' => $today
                );
                if ($this->Queries->addRecord(TBL_INVOICE, $form_data)) :
                    $id = $this->db->insert_id();
                $this->session->set_flashdata('success_msg', 'Invoice Added Successfully');
                else :
                    $this->session->set_flashdata('error_msg', 'Failed To Add Invoice');
                endif;
            }

            if ($count != 0 || $count != "") {

                $form_data = array(
                    'billstatus' => 0,
                    'invoiceid' => 0
                );

                $warray = array('invoiceid' => $id);
                $this->db->where($warray)->update(TBL_ORDER, $form_data);

                $i = 1;
                while ($i <= $count) {
                    $orderid = StringRepair($data['ord_' . $i]);
                    if ($orderid != "" || $orderid != 0) {
                        $form_data = array(
                            'billstatus' => 1,
                            'invoiceid' => $id
                        );
                        $this->Queries->updateRecord(TBL_ORDER, $form_data, $orderid);
                    }
                    $i++;
                }
            }

        }
        return redirect('Invoice/index/');

    }
    public function delete($id)
    {
        $today = date('Y-m-d H:i:s');

        $form_data = array(
            'isdelete' => 1,
            'updated_on' => $today
        );
        if ($this->Queries->updateRecord(TBL_INVOICE, $form_data, $id)) :
            $form_data = array(
            'billstatus' => 0,
            'invoiceid' => 0
        );

        $warray = array('invoiceid' => $id);
        $this->db->where($warray)->update(TBL_ORDER, $form_data);
        $this->session->set_flashdata('success_msg', 'Invoice Deleted Successfully');
        else :
            $this->session->set_flashdata('error_msg', 'Failed To Delete Invoice');
        endif;

        return redirect('Order');
    }


    public function print($id)
    {

        try {
            $invoice = "";
            if ($id != "" and $id != 0) {
                $query = "select * from " . TBL_INVOICE . " where id=" . $id;
                $invoice = $this->Queries->getSingleRecord($query);
                $query = "select * from " . TBL_USERINFO . " where id=" . $invoice->userid;
                $userinfo = $this->Queries->getSingleRecord($query);
                $query = "select * from " . TBL_CUSTOMER . " where id=" . $invoice->customerid;
                $customer = $this->Queries->getSingleRecord($query);

                $query = "select t1.id,t1.jobwork_chalan,t1.jobwork_date,t1.jobwork_qty,t1.jobwork_amount,t1.item_no,t1.part_type,t2.contract_rate,t2.company_name,t1.weight_piece from " . TBL_ORDER . " as t1 left join " . TBL_CUSTOMER . " as t2 on t2.id = t1.main_party where t1.billstatus = 1 and t1.invoiceid=" . $id;
                $orderlist = $this->Queries->getRecord($query);
            }
            $this->load->view('Invoice/invoice', ['id' => $id, 'invoice' => $invoice, 'userinfo' => $userinfo, 'customer' => $customer, 'orderlist' => $orderlist]);
        } catch (Exception $e) {
            echo $e;
        }
    }

}
