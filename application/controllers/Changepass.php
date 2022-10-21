<?php
class Changepass extends CI_Controller
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
        $this->load->view('changepass');
    }

    public function savepass()
    {


        $this->form_validation->set_rules('oldpass', 'Old Password', 'required');
        $this->form_validation->set_rules('newpass', 'New Password', 'required');
        if ($this->form_validation->run()) {
            $oldpass = StringRepair($this->input->post('oldpass'));
            $newpass = StringRepair($this->input->post('newpass'));
            $userid = $this->session->userdata['logged_in']['userid'];
            $query = "select * from " . TBL_USERINFO . " where user_password='" . $oldpass . "' and id=" . $userid;
            $res = $this->Queries->getSingleRecord($query);
            $oldp = $res->user_password;
            if ($oldp != "") {
                //Do nothing
            } else {
                $this->session->set_flashdata('error_msg', 'Old Password Does Not Match...');
                return redirect('Changepass');
            }
            $today = date('Y-m-d H:i:s');
            $form_data = array(
                'user_password' => $newpass,
                'updated_by' => $this->session->userdata['logged_in']['userid'],
                'updated_on' => $today
            );

            if ($this->Queries->updateRecord(TBL_USERINFO, $form_data, $userid)) :
                $this->session->set_flashdata('success_msg', 'Password Changed Successfully');
            else :
                $this->session->set_flashdata('error_msg', 'Failed To Update Password');
            endif;
        }
        $this->load->view('changepass');
    }
}