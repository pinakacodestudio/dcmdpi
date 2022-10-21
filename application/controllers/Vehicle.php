<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vehicle extends CI_Controller
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

		// init params
        $params = array();
        $limit_per_page = 1000000;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->Queries->getVehicleCount($searchtxt);
        $params['vehicle'] = $this->Queries->getVehicle($searchtxt, $limit_per_page, $start_index);
        $params['page'] = $start_index;
        $session_data = array(
            'pageuri' => $start_index
        );
		// Add user data in session
        $this->session->set_userdata('vehicle', $session_data);
        if ($total_records > 0) {
            $config = PageConfig(base_url() . 'Vehicle/index', $total_records, $limit_per_page, '3');
            $this->pagination->initialize($config);
			// build paging links
            $params["links"] = $this->pagination->create_links();
        }

        $this->load->view('Vehicle/index', $params);
    }

    public function add($id = 0)
    {
        try {
            $vehicle = "";
            if ($id != "" and $id != 0) {
                $query = "select * from " . TBL_VEHICLE . " where id=" . $id;
                $vehicle = $this->Queries->getSingleRecord($query);
            }
            $this->load->view('Vehicle/add', ['id' => $id, 'vehicle' => $vehicle]);
        } catch (Exception $e) {
            echo $e;
        }
    }
    public function save()
    {

        $this->form_validation->set_rules('driver_name', 'Driver Name', 'required');
        $this->form_validation->set_rules('vehicle_no', 'Vehicle No.', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $driver_name = StringRepair($data['driver_name']);
            $vehicle_type = StringRepair($data['vehicle_type']);
            $vehicle_no = StringRepair($data['vehicle_no']);
            $id = $this->input->post('id');
            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {

                $form_data = array(
                    'driver_name' => $driver_name,
                    'vehicle_type' => $vehicle_type,
                    'vehicle_no' => $vehicle_no,
                    'updated_on' => $today
                );
                if ($this->Queries->updateRecord(TBL_VEHICLE, $form_data, $id)) :
                    $this->session->set_flashdata('success_msg', 'Vehicle Updated Successfully');
                else :
                    $this->session->set_flashdata('error_msg', 'Failed To Update Vehicle');
                endif;
            } else {

                $form_data = array(
                    'driver_name' => $driver_name,
                    'vehicle_type' => $vehicle_type,
                    'vehicle_no' => $vehicle_no,
                    'updated_on' => $today
                );
                if ($this->Queries->addRecord(TBL_VEHICLE, $form_data)) :
                    $this->session->set_flashdata('success_msg', 'Vehicle Added Successfully');
                else :
                    $this->session->set_flashdata('error_msg', 'Failed To Add Vehicle');
                endif;
            }

        }
        $page = "";
        if ($this->session->userdata["vehicle"]["pageuri"] > 0) {
            $page = $this->session->userdata["vehicle"]["pageuri"];
        }
        return redirect('Vehicle/index/' . $page);

    }
    public function delete($id)
    {
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updated_on' => $today
        );
        if ($this->Queries->updateRecord(TBL_VEHICLE, $form_data, $id)) :
            $this->session->set_flashdata('success_msg', 'Vehicle Deleted Successfully');
        else :
            $this->session->set_flashdata('error_msg', 'Failed To Delete Vehicle');
        endif;

        return redirect('Vehicle');
    }
}
