<?php
$pageSave = "User/save";
$pageBack = "User";
$operation = "Add";
$val_user_fullname = "";
$val_user_email = "";
$val_user_mob = "";
$val_user_type = "";
$val_company_name = "";
$val_company_address = "";
$val_company_gstno = "";
$val_company_panno = "";
$val_activate = 1;
if ($id != "" and is_numeric($id)) {
    $operation = "Edit";
    $val_user_fullname = StringRepair3($user->user_fullname);
    $val_user_email = StringRepair3($user->user_email);
    $val_user_mob = StringRepair3($user->user_mob);
    $val_company_name = StringRepair3($user->company_name);
    $val_company_address = StringRepair3($user->company_address);
    $val_company_panno = StringRepair3($user->company_panno);
    $val_company_gstno = StringRepair3($user->company_gstno);
    $val_company_logo = StringRepair3($user->company_logo);
    $val_activate = $user->user_blocked;
}


$managePage = $operation . " User";
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
                    editbox('4', 'User FullName', 'user_fullname', 'Enter User Full Name', $val_user_fullname);
                    emailbox('4', 'User Email Id', 'user_email', 'Enter Email ID', $val_user_email, 'required');
                    passwordbox('4', 'User Password', 'user_password', 'Enter User Password', '');
                    editbox('4', 'Mobile No.', 'user_mob', 'Enter Mobile No.', $val_user_mob);
                    editbox('4', 'Company Name', 'company_name', 'Enter Company Name', $val_company_name);
                    editbox('4', 'Company Address', 'company_address', 'Enter Company Address', $val_company_address);
                    editbox('4', 'Company Panno', 'company_panno', 'Enter Company Panno', $val_company_panno);
                    editbox('4', 'Company Gstno', 'company_gstno', 'Enter Company GstNo', $val_company_gstno);
                    uploadbox('4', 'Upload Company Logo', 'filename', 'Upload Image');
                    checkbox($val_activate, 'Set Active', 'activate');
                    submitbutton($pageBack);
                    ?>
                    <div class="clearfix"></div>
                    <img src="<?= base_url($val_company_logo); ?>" alt="" style="width:25%;" />
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

        var user_fullname = $("#user_fullname").val();
        var user_email = $("#user_email").val();
        var user_mob = $("#user_mob").val();
        var company_name = $("#company_name").val();
        var company_address = $("#company_address").val();
        var company_panno = $("#company_panno").val();
        var company_gstno = $("#company_gstno").val();
        var user_pass = $("#user_password").val();

        if(user_fullname == ""){
            title = "User FullName";
            ttext = "Please Enter User FullName";
            document.frm1.user_fullname.focus();
        }else if(user_email == ""){
            title = "Email Id";
            ttext = "Please Enter User Email Address";
            document.frm1.user_email.focus();
        }<?php if ($operation == "Add") { ?>else if(user_pass == ""){
            title = "Password";
            ttext = "Please Enter User Password";
            document.frm1.user_password.focus();
        }<?php 
    } ?>else if(user_mob == ""){
            title = "Mobile No.";
            ttext = "Please Enter User Mobile No.";
            document.frm1.user_mob.focus();
        }else if(isNaN(user_mob)){
            title = "Mobile No.";
            ttext = "Please Enter Mobile No. Only Digits";
            document.frm1.user_mob.focus();
        }else if(user_mob.length != 10){
            title = "Mobile No.";
            ttext = "Please Enter Mobile No. 10 Digits Only";
            document.frm1.user_mob.focus();
        }else if(company_name == ""){
            title = "Company Name";
            ttext = "Please Enter Company Name";
            document.frm1.company_name.focus();
        }else if(company_address == ""){
            title = "Company Address";
            ttext = "Please Enter Company Address";
            document.frm1.company_address.focus();
        }else if(company_panno == ""){
            title = "Company Panno";
            ttext = "Please Enter Company Panno";
            document.frm1.company_panno.focus();
        }else if(company_gstno == ""){
            title = "Company Gstno";
            ttext = "Please Enter Company Gstno";
            document.frm1.company_gstno.focus();
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
