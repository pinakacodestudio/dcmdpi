<?php

class Powerpanel extends CI_Controller
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
        $limit_per_page = 10000000;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->Queries->getPowerpanelCount($searchtxt);
        $params['powerpanel'] = $this->Queries->getPowerpanel($searchtxt, $limit_per_page, $start_index);
        $params['page'] = $start_index;
        $session_data = array(
            'pageuri' => $start_index
        );
        // Add user data in session
        $this->session->set_userdata('powerpanel', $session_data);
        if ($total_records > 0) {
            // get current page records
            $config = PageConfig(base_url() . 'Powerpanel/index', $total_records, $limit_per_page, '3');
            $this->pagination->initialize($config);

            // build paging links
            $params["links"] = $this->pagination->create_links();
        }
        $this->load->view('Powerpanel/index', $params);
    }
    public function add($id = 0)
    {
        try {
            $powerpanel = "";
            if ($id != "" and $id != 0) {
                $query = "select * from " . TBL_POWERPANEL . " where  isdelete=0 and id=" . $id;
                $powerpanel = $this->Queries->getSingleRecord($query);
                if ($powerpanel == null) {
                    $this->session->set_flashdata('error_msg', 'No Record Found...');
                    return redirect('Powerpanel');
                }
            }
            $this->load->view('Powerpanel/add', ['id' => $id, 'powerpanel' => $powerpanel]);
        } catch (Exception $e) {
            echo $e;
        }
    }
    public function details($id)
    {
        $query = "select * from " . TBL_POWERPANEL . " where id=" . $id;
        $powerpanel = $this->Queries->getSingleRecord($query);
        $this->load->view('Powerpanel/details', ['powerpanel' => $powerpanel]);
    }

    public function save()
    {
        $this->form_validation->set_rules('panelid', 'Panel ID', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = StringRepair($data["id"]);
            $panelid = StringRepair($data['panelid']);
            $panel_description = StringRepair($data['panel_description']);
            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {
                $query = "select * from " . TBL_POWERPANEL . " where panelid='" . $panelid . "' and isdelete=0 and id!=" . $id;
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Powerpanel ID Already Exists...');
                    return redirect('Powerpanel/add/' . $id);
                }

                $form_data = array(
                    'panelid' => $panelid,
                    'panel_description' => $panel_description,
                    'updated_on' => $today
                );
                if ($this->Queries->updateRecord(TBL_POWERPANEL, $form_data, $id)) :
                    $this->session->set_flashdata('success_msg', 'Powerpanel Updated Successfully');
                else :
                    $this->session->set_flashdata('error_msg', 'Failed To Update Powerpanel');
                endif;
            } else {
                $query = "select * from " . TBL_POWERPANEL . " where panelid='" . $panelid . "' and isdelete=0";
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Powerpanel ID Already Exists...');
                    $this->session->set_flashdata($data);
                    return redirect('Powerpanel/add');
                }

                $form_data = array(
                    'panelid' => $panelid,
                    'panel_description' => $panel_description,
                    'updated_on' => $today
                );

                if ($this->Queries->addRecord(TBL_POWERPANEL, $form_data)) :
                    $this->session->set_flashdata('success_msg', 'Powerpanel Added Successfully');
                else :
                    $this->session->set_flashdata('error_msg', 'Failed To Add Powerpanel');
                endif;
            }
        }
        $page = "";
        if ($this->session->userdata["Powerpanel"]["pageuri"] > 0) {
            $page = $this->session->userdata["Powerpanel"]["pageuri"];
        }
        return redirect('Powerpanel/index/' . $page);
    }

    public function delete($id)
    {
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updated_on' => $today
        );
        if ($this->Queries->updateRecord(TBL_POWERPANEL, $form_data, $id)) :
            $this->session->set_flashdata('success_msg', 'Powerpanel Deleted Successfully');
        else :
            $this->session->set_flashdata('error_msg', 'Failed To Delete Powerpanel');
        endif;

        return redirect('Powerpanel');
    }
}
?>