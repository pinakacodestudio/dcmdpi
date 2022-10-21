<?php
$imageurl = "";
$username = "";
if (!empty($this->session->userdata['logged_in']['user_image'])) {
    $imageurl = $this->session->userdata['logged_in']['user_image'];
}
if (!empty($this->session->userdata['logged_in']['user_fullname'])) {
    $username = $this->session->userdata['logged_in']['user_fullname'];
}
?>
<!-- Start: Header -->
<header class="navbar navbar-fixed-top">
    <div class="navbar-branding">
        <a class="navbar-brand" href="<?= base_url() ?>Dashboard/">
            <img src="<?= base_url(); ?>assets/img/logomain.png" alt="" style=" width: 180px; padding-left: 5px; margin-top: 15px; height: auto;">
        </a>
        <span id="toggle_sidemenu_l" class="ad ad-lines"></span>
    </div>
    <ul class="nav navbar-nav navbar-left">
        <li class="hidden-xs">
            <a class="request-fullscreen toggle-active" href="#">
                <span class="ad ad-screen-full fs18"></span>
            </a>
        </li>
        <li  class="hidden-xs">
            <a href="<?= base_url('Dashboard'); ?>"><span>DCM PRECISION IND</span></a>
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
                <img src="<?= base_url() . $imageurl; ?>" alt="avatar" class="mw30 br64 mr15"> <?= $username; ?> <span class="caret caret-tp hidden-xs"></span>
            </a>
            <ul class="dropdown-menu list-group dropdown-persist w250" role="menu">
                <li class="list-group-item">
                    <a href="<?php echo base_url(); ?>Main/editprofile/" class="animated animated-short fadeInUp">
                        <span class="fa fa-user"></span> Profile
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="<?php echo base_url(); ?>Changepass" class="animated animated-short fadeInUp">
                        <span class="fa fa-gear"></span> Change Password
                    </a>
                </li>
                <li class="dropdown-footer">
                    <a href="<?php echo base_url(); ?>Logout" class="">
                        <span class="fa fa-power-off pr5"></span> Logout
                    </a>
                </li>
            </ul>
        </li>
    </ul>

</header>
<!-- End: Header -->        <!-- Start: Sidebar Left -->
<aside id="sidebar_left" class="nano nano-primary affix">

    <!-- Start: Sidebar Left Content -->
    <div class="sidebar-left-content nano-content">

        <!-- Start: Sidebar Left Menu -->
        <ul class="nav sidebar-menu">
            <li class="sidebar-label pt20">Menu</li>
            <li class="active">
                <a href="<?= base_url() ?>Dashboard/">
                    <span class="glyphicon glyphicon-home"></span>
                    <span class="sidebar-title">Dashboard</span>
                </a>
            </li>
          
            <li >
                <a href="<?= base_url() ?>Order/">
                    <span class="fa fa-circle-o"></span>
                    <span class="sidebar-title">Order Management</span>
                </a>
            </li>
           
            <li>
                <a href="<?= base_url() ?>Process/">
                    <span class="fa fa-cogs"></span>
                    <span class="sidebar-title">Process Management</span>
                </a>
            </li>
            <li >
                <a href="<?= base_url() ?>Dispatch/">
                    <span class="fa fa-truck"></span>
                    <span class="sidebar-title">Dispatch Management</span>
                </a>
            </li>
            <li >
                <a href="<?= base_url() ?>Jobwork/">
                    <span class="fa fa-briefcase"></span>
                    <span class="sidebar-title">Jobwork Management</span>
                </a>
            </li>
            <li >
                <a href="<?= base_url() ?>Invoice/">
                    <span class="fa fa-file"></span>
                    <span class="sidebar-title">Invoice Management</span>
                </a>
            </li>
            <li>
            <?php
            if (!empty($this->session->userdata['logged_in']['user_type'])) {
                $usertype = $this->session->userdata['logged_in']['user_type'];
            } else {
                $usertype = 0;
            }
            if ($usertype == 1) {
                ?>
            <li>
                <a class="accordion-toggle <?php if ($this->uri->segment(1) == "Customer" || $this->uri->segment(1) == "Platform" || $this->uri->segment(1) == "Furnace" || $this->uri->segment(1) == "Powerpanel" || $this->uri->segment(1) == "User") {
                                                echo 'menu-open';
                                            } ?>" href="#">
                    <span class="fa fa-briefcase"></span>
                    <span class="sidebar-title">Master</span>
                    <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                    <li <?php if ($this->uri->segment(1) == "Customer") {
                            echo 'class="active"';
                        } ?> >
                        <a href="<?= base_url(); ?>Customer">
                            <span class="fa fa-address-book"></span> Customer Master
                        </a>
                    </li>

                    <li <?php if ($this->uri->segment(1) == "Platform") {
                            echo 'class="active"';
                        } ?> >
                        <a href="<?= base_url(); ?>Platform">
                            <span class="fa fa-product-hunt"></span> Platform Master
                        </a>

                    </li>
                    <li <?php if ($this->uri->segment(1) == "Furnace") {
                            echo 'class="active"';
                        } ?> >
                        <a href="<?= base_url(); ?>Furnace">
                            <span class="fa fa-bell-o"></span> Furnace Master
                        </a>
                    </li>
                    <li <?php if ($this->uri->segment(1) == "Powerpanel") {
                            echo 'class="active"';
                        } ?> >
                        <a href="<?= base_url(); ?>Powerpanel">
                            <span class="fa fa-plug"></span> Power Panel Master
                        </a>
                    </li>
                    <li <?php if ($this->uri->segment(1) == "User") {
                            echo 'class="active"';
                        } ?> >
                        <a href="<?= base_url(); ?>User">
                            <span class="fa fa-user"></span> User Master
                        </a>
                    </li>
                    <li <?php if ($this->uri->segment(1) == "Vehicle") {
                            echo 'class="active"';
                        } ?> >
                        <a href="<?= base_url(); ?>Vehicle">
                            <span class="fa fa-truck"></span> Vehicle Master
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a class="accordion-toggle " href="#">
                    <span class="fa fa-bar-chart"></span>
                    <span class="sidebar-title">Reports</span>
                    <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                    <li>
                        <a href="<?= base_url(); ?>Reports/AnalingReport/">
                            <span class="fa fa-bar-chart"></span> Analing Report
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>Reports/InwardReport/">
                            <span class="fa fa-area-chart"></span> Inward Report
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>Reports/OutwardReport/">
                            <span class="fa fa-pie-chart"></span> Outward Report
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>Reports/MaterialReport/">
                            <span class="fa fa-pie-chart"></span> Material Report
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>Reports/ReadyStockReport/">
                            <span class="fa fa-pie-chart"></span> Ready Stock Report
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>Reports/CustomerReport/">
                            <span class="fa fa-user-circle"></span>Customer Report
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>Reports/SmsReport/">
                            <span class="fa fa-send"></span> Sms Report
                        </a>
                    </li>

                </ul>
            </li>
            <?php

        }
        ?>
        </ul>
        <!-- End: Sidebar Menu -->

    </div>
    <!-- End: Sidebar Left Content -->

</aside>
<!-- End: Sidebar Left -->
