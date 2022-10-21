<?php
$pageSave = "Powerpanel/save";
$pageBack = "Powerpanel";
$operation = "Add";
$val_panelid = "";
$val_panel_description = "";
if($id!="" and is_numeric($id)) {
    $operation = "Edit";
    $val_panelid = StringRepair3($powerpanel->panelid);
    $val_panel_description = StringRepair3($powerpanel->panel_description);
}
if ($panelid =  $this->session->flashdata('panelid')):
    $val_panelid = StringRepair3($panelid);
endif;
if ($panel_description =  $this->session->flashdata('panel_description')):
    $val_panel_description = StringRepair3($panel_description);
endif;

$managePage = $operation." Powerpanel";
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
                        editbox('4','PowerPanel ID','panelid','Enter PowerPanel ID',$val_panelid);
                        textareabox('12','PowerPanel Description','panel_description','Enter PowerPanel Description',$val_panel_description);
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

        var panelid = $("#panelid").val();

        if(panelid == ""){
            title = "Panel ID";
            ttext = "Please Enter Panel ID";
            document.frm1.panelid.focus();
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
