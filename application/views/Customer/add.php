<?php
$pageSave = "Customer/save";
$pageBack = "Customer";
$operation = "Add";
$val_customer_name = "";
$val_customer_email = "";
$val_customer_mobile = "";
$val_customer_address = "";
$val_company_name = "";
$val_contract_rate = "";
$val_gstno = "";
if($id!="" and is_numeric($id)) {
    $operation = "Edit";
    $val_customer_name = StringRepair3($customer->customer_name);
    $val_customer_email = StringRepair3($customer->customer_email);
    $val_customer_mobile = StringRepair3($customer->customer_mobile);
    $val_customer_address = StringRepair3($customer->customer_address);
    $val_company_name = StringRepair3($customer->company_name);
    $val_contract_rate = StringRepair3($customer->contract_rate);
    $val_gstno = StringRepair3($customer->gstno);
}
if ($customer_name =  $this->session->flashdata('customer_name')):
    $val_customer_name = StringRepair3($customer_name);
endif;
if ($customer_mobile =  $this->session->flashdata('customer_mobile')):
    $val_customer_mobile = StringRepair3($customer_mobile);
endif;
if ($customer_address =  $this->session->flashdata('customer_address')):
    $val_customer_address = StringRepair3($customer_address);
endif;
if ($company_name =  $this->session->flashdata('company_name')):
    $val_company_name = StringRepair3($company_name);
endif;
if ($customer_email =  $this->session->flashdata('customer_email')):
    $val_customer_email = StringRepair3($customer_email);
endif;
if ($contract_rate =  $this->session->flashdata('contract_rate')):
    $val_contract_rate = StringRepair3($contract_rate);
endif;
if ($gstno =  $this->session->flashdata('gstno')):
    $val_gstno = StringRepair3($gstno);
endif;

$managePage = $operation." Customer";
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
                        editbox('4','Contact person','customer_name','Enter Customer Name',$val_customer_name);
                        editbox('4','Company Name','company_name','Enter Company Name',$val_company_name);
                        emailbox('4','Email Id','customer_email','Enter Email ID',$val_customer_email,'required');
                        editbox('4','Mobile No.','customer_mobile','Enter Mobile No.',$val_customer_mobile);
                        editbox('4','Company Address','customer_address','Enter Customer Address',$val_customer_address);
                        editbox('4','Contract Rate','contract_rate','Enter Contract Rate',$val_contract_rate);
                        editbox('4','GST No.','gstno','Enter GST No.',$val_gstno);
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

        var customer_name = $("#customer_name").val();
        var customer_email = $("#customer_email").val();
        var customer_mobile = $("#customer_mobile").val();
        var customer_address = $("#customer_address").val();
        var company_name = $("#company_name").val();
        var contract_rate = $("#contract_rate").val();
        var gstno = $("#gstno").val();

        var reggst = /^([0-9]{2}[a-zA-Z]{4}([a-zA-Z]{1}|[0-9]{1})[0-9]{4}[a-zA-Z]{1}([a-zA-Z]|[0-9]){3}){0,15}$/;
       
        if(customer_name == ""){
            title = "Contact Person";
            ttext = "Please Enter Contact Person";
            document.frm1.customer_name.focus();
        }else if(company_name == ""){
            title = "Company Name";
            ttext = "Please Enter Company Name";
            document.frm1.company_name.focus();
        }else if(customer_email == ""){
            title = "Email Id";
            ttext = "Please Enter Email Address";
            document.frm1.customer_email.focus();
        }else if(customer_mobile == ""){
            title = "Mobile No.";
            ttext = "Please Enter Mobile No.";
            document.frm1.customer_mobile.focus();
        }else if(isNaN(customer_mobile)){
            title = "Mobile No.";
            ttext = "Please Enter Mobile No. Only Digits";
            document.frm1.customer_mobile.focus();
        }else if(customer_mobile.length != 10){
            title = "Mobile No.";
            ttext = "Please Enter Mobile No. 10 Digits Only";
            document.frm1.customer_mobile.focus();
        }else if(customer_address == ""){
            title = "Address";
            ttext = "Please Enter Address";
            document.frm1.customer_address.focus();
        }else if(contract_rate == ""){
            title = "Contract Rate";
            ttext = "Please Enter Contract Rate";
            document.frm1.contract_rate.focus();
        }else if(isNaN(contract_rate)){
            title = "Contract Rate";
            ttext = "Please Enter Contract Rate Only Digits";
            document.frm1.contract_rate.focus();
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
