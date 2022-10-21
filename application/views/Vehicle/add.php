<?php
$pageSave = "Vehicle/save";
$pageBack = "Vehicle";
$operation = "Add";
$val_driver_name = "";
$val_vehicle_type = "";
$val_vehicle_no = "";
if ($id != "" and is_numeric($id)) {
    $operation = "Edit";
    $val_driver_name = StringRepair3($vehicle->driver_name);
    $val_vehicle_type = StringRepair3($vehicle->vehicle_type);
    $val_vehicle_no = StringRepair3($vehicle->vehicle_no);
}

$managePage = $operation . " Vehicle";
?>
<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('Includes/head'); ?>
</head>

<body class="dashboard-page sb-l-m sb-r-c">
<!-- Start: Main -->
<div id="main">
    <?php $this->load->view('Includes/header'); ?>
    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

        <!-- Begin: Content -->
        <section id="content" class="animated fadeIn">
            <?php alertbox(); ?>
            <div class="panel panel-default panel-border top">
                <?php echo form_open($pageSave, ['name' => 'frm1', 'onsubmit' => 'return onSubmitBox()', 'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>
                <input type="hidden" name="id" value="<?= $id; ?>">
                <div class="panel-heading">
                    <span class="panel-title"> <?= $managePage; ?></span>
                </div>
                <div class="panel-body">
                    <?php
                    editbox('4', 'Driver Name', 'driver_name', 'Enter Driver Name', $val_driver_name);
                    editbox('4', 'Vehicle Type', 'vehicle_type', 'Enter Vehicle Type', $val_vehicle_type);
                    editbox('4', 'Vehicle No.', 'vehicle_no', 'Enter Vehicle No.', $val_vehicle_no);
                    submitbutton($pageBack);
                    ?>
                </div>
                <?php form_close(); ?>
            </div>

        </section>
        <?php $this->load->view('Includes/footer'); ?>
    </section>
    <!-- End: Content-Wrapper -->
</div>
<!-- End: Main -->
<?php $this->load->view('Includes/footerscript'); ?>
<script>
    function onSubmitBox(){

        var title="";
        var ttext="";

        var driver_name = $("#driver_name").val();
        var vehicle_no = $("#vehicle_no").val();
        var vehicle_type = $("#vehicle_type").val();
    
        if(driver_name == ""){
            title = "Driver Name";
            ttext = "Please Enter Driver Name";
            document.frm1.driver_name.focus();
        }else if(vehicle_type == ""){
            title = "Vehicle Type";
            ttext = "Please Enter Vehicle Type";
            document.frm1.vehicle_type.focus();
        }else if(vehicle_no == ""){
            title = "Vehicle No.";
            ttext = "Please Enter Vehicle No.";
            document.frm1.vehicle_no.focus();
        }

        if(title != "" && ttext != "") {
            swal({
                title: title,
                text: ttext,
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Ok"
            });
            return false;
        }else{
            return true;
        }
    }
</script>
</body>
</html>
