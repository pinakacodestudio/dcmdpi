<?php
$pageSave = "Main/saveprofile";
$pageBack = "Dashboard";
$managePage = "Edit Profile";

?>
<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('Includes/head'); ?>
</head>

<body class="dashboard-page sb-l-o sb-r-c">
<!-- Start: Main -->
<div id="main">
    <?php $this->load->view('Includes/header'); ?>
    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

        <!-- Start: Topbar -->
        <header id="topbar">
            <div class="topbar-left">
                <ol class="breadcrumb">
                    <li class="crumb-icon">
                        <a href="<?= base_url("Dashboard"); ?>">
                            <span class="glyphicon glyphicon-home"></span>
                        </a>
                    </li>
                    <li class="crumb-trail">Edit Profile</li>
                </ol>
            </div>
        </header>
        <!-- End: Topbar -->
        <!-- Begin: Content -->
        <section id="content" class="animated fadeIn">

            <?php alertbox(); ?>

            <div class="panel panel-default panel-border top">
                <?php echo form_open($pageSave, ['name' => 'frm1', 'onsubmit' => 'return onSubmitBox()', 'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>
                <div class="panel-heading">
                    <span class="panel-title"> <?= $managePage; ?></span>
                </div>
                <div class="panel-body">
                    <?php
                    editbox('4', 'User Fullname', 'user_fullname', 'Enter User Fullname', $user->user_fullname);
                    editbox('4', 'Mobile No.', 'user_mobile', 'Enter User Mobile', $user->user_mob);
                    uploadbox('4', 'Upload Profile Image', 'filename', 'Upload Image');
                    editbox('4', 'Company Name', 'company_name', 'Enter Company Name', $user->company_name);
                    editbox('4', 'Company Address', 'company_address', 'Enter Company Address', $user->company_address);
                    editbox('4', 'Company Panno', 'company_panno', 'Enter Company Panno', $user->company_panno);
                    editbox('4', 'Company Gstno', 'company_gstno', 'Enter Company GstNo', $user->company_gstno);
                    uploadbox('4', 'Upload Company Logo', 'filename2', 'Upload Image');
                    submitbutton($pageBack);
                    ?>
                      <div class="clearfix"></div>
                    <img src="<?= base_url($user->company_logo); ?>" alt="" style="width:25%;" />
                </div>
                <?php form_close(); ?>
              
            </div>

            <div class="clearfix"></div>
        </section>
        <!-- End: Content -->

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

        var fullname = $("#user_fullname").val();
        var mobile = $("#user_mobile").val();

        if(fullname == ""){
            title = "User Fullname";
            ttext = "Please Enter User Fullname";
            document.frm1.user_fullname.focus();
        }else if(mobile == ""){
            title = "User Mobile";
            ttext = "Please Enter Mobile No.";
            document.frm1.newpass.focus();
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
