<?php
$pageSave = "Platform/save";
$pageBack = "Platform";
$operation = "Add";
$val_platformid = "";
$val_platform_description = "";
$val_platform_capacity = "";
if($id!="" and is_numeric($id)) {
    $operation = "Edit";
    $val_platformid = StringRepair3($platform->platformid);
    $val_platform_description = StringRepair3($platform->platform_description);
    $val_platform_capacity = StringRepair3($platform->platform_capacity);
}
if ($platformid =  $this->session->flashdata('platformid')):
    $val_platformid = StringRepair3($platformid);
endif;
if ($platform_description =  $this->session->flashdata('platform_description')):
    $val_platform_description = StringRepair3($platform_description);
endif;
if ($platform_capacity =  $this->session->flashdata('platform_capacity')):
    $val_platform_capacity = StringRepair3($platform_capacity);
endif;

$managePage = $operation." Platform";
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
                        editbox('4','Platform ID','platformid','Enter Platform ID',$val_platformid);
                        editbox('4','Platform Capacity','platform_capacity','Enter Platform Capacity',$val_platform_capacity);
                        textareabox('12','Platform Description','platform_description','Enter Platform Description',$val_platform_description);
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

        var platformid = $("#platformid").val();
        var platform_capacity = $("#platform_capacity").val();

        if(platformid == ""){
            title = "Platform ID";
            ttext = "Please Enter Platform ID";
            document.frm1.platformid.focus();
        }else if(platform_capacity == ""){
            title = "Platform Capacity";
            ttext = "Please Enter Platform Capacity";
            document.frm1.platform_capacity.focus();
        }else if(isNaN(platform_capacity)){
            title = "Platform Capacity";
            ttext = "Please Enter Only Digits";
            document.frm1.platform_capacity.focus();
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
