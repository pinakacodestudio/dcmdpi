<?php

class Furnace extends CI_Controller
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
        //$platformid_name = "";
        /*$search =  $this->input->post();
        if(isset($search["clearall"])){
            $session_data = array(
                'tax_cat_name' => ''
            );
            // Add user data in session
            $this->session->set_userdata('taxmasters', $session_data);

        }if(isset($search["submit"])){
            if(!empty($search["taxmaster_name"])){
                $taxmaster_name = $search["taxmaster_name"];
                $searchtxt = "tax_cat_name LIKE '%".$taxmaster_name."%'";
            }
        }else {
            if(!empty($this->session->userdata['taxmasters']['taxmaster_name'])){
                $taxmaster_name = $this->session->userdata['taxmasters']['taxmaster_name'];
                $searchtxt = "tax_cat_name LIKE '%".$taxmaster_name."%'";
            }
        }*/


        // init params
        $params = array();
        $limit_per_page = 100000;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->Queries->getFurnaceCount($searchtxt);
        $params['furnace'] = $this->Queries->getFurnace($searchtxt, $limit_per_page, $start_index);
        $params['page'] = $start_index;
        $session_data = array(
            'pageuri' => $start_index
        );
        // Add user data in session
        $this->session->set_userdata('furnace', $session_data);
        if ($total_records > 0) {
            // get current page records
            $config = PageConfig(base_url() . 'Furnace/index', $total_records, $limit_per_page, '3');
            $this->pagination->initialize($config);

            // build paging links
            $params["links"] = $this->pagination->create_links();
        }
        $this->load->view('Furnace/index', $params);
    }
    public function add($id = 0)
    {
        try {
            $furnace = "";
            if ($id != "" and $id != 0) {
                $query = "select * from " . TBL_FURNACE . " where  isdelete=0 and id=" . $id;
                $furnace = $this->Queries->getSingleRecord($query);
                if ($furnace == null) {
                    $this->session->set_flashdata('error_msg', 'No Record Found...');
                    return redirect('Furnace');
                }
            }
            $this->load->view('Furnace/add', ['id' => $id, 'furnace' => $furnace]);
        } catch (Exception $e) {
            echo $e;
        }
    }
    public function details($id)
    {
        $query = "select * from " . TBL_FURNACE . " where id=" . $id;
        $furnace = $this->Queries->getSingleRecord($query);
        $this->load->view('Furnace/details', ['furnace' => $furnace]);
    }

    public function save()
    {
        $this->form_validation->set_rules('bellid', 'Bell ID', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = StringRepair($data["id"]);
            $bellid = StringRepair($data['bellid']);
            $bell_description = StringRepair($data['bell_description']);
            $bell_capacity = StringRepair($data['bell_capacity']);
            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {
                $query = "select * from " . TBL_FURNACE . " where bellid='" . $bellid . "' and isdelete=0 and id!=" . $id;
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Furnace Bell ID Already Exists...');
                    return redirect('Furnace/add/' . $id);
                }

                $form_data = array(
                    'bellid' => $bellid,
                    'bell_description' => $bell_description,
                    'bell_capacity' => $bell_capacity,
                    'updated_on' => $today
                );
                if ($this->Queries->updateRecord(TBL_FURNACE, $form_data, $id)) :
                    $this->session->set_flashdata('success_msg', 'Furnace Bell Updated Successfully');
                else :
                    $this->session->set_flashdata('error_msg', 'Failed To Update Furnace Bell');
                endif;
            } else {
                $query = "select * from " . TBL_FURNACE . " where bellid='" . $bellid . "' and isdelete=0";
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Furnace Bell ID Already Exists...');
                    $this->session->set_flashdata($data);
                    return redirect('Furnace/add');
                }

                $form_data = array(
                    'bellid' => $bellid,
                    'bell_description' => $bell_description,
                    'bell_capacity' => $bell_capacity,
                    'updated_on' => $today
                );

                if ($this->Queries->addRecord(TBL_FURNACE, $form_data)) :
                    $this->session->set_flashdata('success_msg', 'Furnace Bell Added Successfully');
                else :
                    $this->session->set_flashdata('error_msg', 'Failed To Add Furnace Bell');
                endif;
            }
        }
        $page = "";
        if ($this->session->userdata["furnace"]["pageuri"] > 0) {
            $page = $this->session->userdata["furnace"]["pageuri"];
        }
        return redirect('Furnace/index/' . $page);
    }

    public function delete($id)
    {

        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updated_on' => $today
        );
        if ($this->Queries->updateRecord(TBL_FURNACE, $form_data, $id)) :
            $this->session->set_flashdata('success_msg', 'Furnace Bell Deleted Successfully');
        else :
            $this->session->set_flashdata('error_msg', 'Failed To Delete Furnace Bell');
        endif;

        return redirect('Furnace');
    }
}
?>