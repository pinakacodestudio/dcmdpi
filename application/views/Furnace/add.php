<?php
$pageSave = "Furnace/save";
$pageBack = "Furnace";
$operation = "Add";
$val_bellid = "";
$val_bell_description = "";
$val_bell_capacity = "";
if($id!="" and is_numeric($id)) {
    $operation = "Edit";
    $val_bellid = StringRepair3($furnace->bellid);
    $val_bell_description = StringRepair3($furnace->bell_description);
    $val_bell_capacity = StringRepair3($furnace->bell_capacity);
}
if ($bellid =  $this->session->flashdata('bellid')):
    $val_bellid = StringRepair3($bellid);
endif;
if ($bell_description =  $this->session->flashdata('bell_description')):
    $val_bell_description = StringRepair3($bell_description);
endif;
if ($bell_capacity =  $this->session->flashdata('bell_capacity')):
    $val_bell_capacity = StringRepair3($bell_capacity);
endif;

$managePage = $operation." Furnace Bell";
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
                <?php echo form_open($pageSave,['name'=>'frm1','onsubmit'=>'return onSubmitBox()','enctype'=>'multipart/form-data','class'=>'stdform']); ?>
                <input type="hidden" name="id" value="<?= $id; ?>">
                <div class="panel-heading">
                    <span class="panel-title"> <?= $managePage; ?></span>
                </div>
                <div class="panel-body">
                    <?php
                        editbox('4','Furnace Bell ID','bellid','Enter Furnace Bell ID',$val_bellid);
                        editbox('4','Furnace Bell Capacity','bell_capacity','Enter Bell Capacity',$val_bell_capacity);
                        textareabox('12','Furnace Bell Description','bell_description','Enter Bell Description',$val_bell_description);
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

        var bellid = $("#bellid").val();
        var bell_capacity = $("#bell_capacity").val();

        if(bellid == ""){
            title = "Bell ID";
            ttext = "Please Enter Bell ID";
            document.frm1.bellid.focus();
        }else if(bell_capacity == ""){
            title = "Bell Capacity";
            ttext = "Please Enter Bell Capacity";
            document.frm1.bell_capacity.focus();
        }else if(isNaN(bell_capacity)){
            title = "Bell Capacity";
            ttext = "Please Enter Only Digits";
            document.frm1.bell_capacity.focus();
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
