<?php
$pageredirect = base_url() . "Process/add/";
$detailPage = base_url() . "Process/details/";
?>
<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('Includes/head'); ?>
    <style>
        .blink_me {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        a {
            text-decoration: none !important;
        }

        .panel-tile .panel-body {
            height: 90px;
            vertical-align: middle;
        }

        .panel-tile .panel-body h1 {
            vertical-align: middle;
        }

        .dataTables_length {
            display: none;
        }

        .reportbutton a {
            width: 31%;
        }
    </style>
</head>

<body class="dashboard-page sb-l-m sb-r-c">
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
                            <a href="home.php">
                                <span class="glyphicon glyphicon-home"></span>
                            </a>
                        </li>
                        <li class="crumb-trail">Dashboard</li>
                    </ol>
                </div>
            </header>
            <!-- End: Topbar -->
            <!-- Begin: Content -->
            <section id="content" class="animated fadeIn">

                <?php alertbox(); ?>
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <?php
                    $i = 0;
                    if (count($platform)) {
                        foreach ($platform as $post) :
                            $i++;
                            $status = $post->status;
                            $statno = $post->status;
                            if ($status != "") {
                                $seldata = array('1' => 'Waiting For Furnace', '2' => 'Waiting For PowerPanel', '3' => 'Processing', '4' => 'Cooling', '5' => 'Closed');
                                $status = customData($seldata, $post->status);
                                $seldata = array('1' => 'warning', '2' => 'danger', '3' => 'danger  blink_me', '4' => 'primary', '5' => 'success');
                                $bgcolor = customData($seldata, $post->status);
                            } else {
                                $status = "Available";
                                $bgcolor = "success";
                            }
                            ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="panel panel-tile text-center br-a br-light">
                                    <a href="javascript:void(0);" data-id="<?= $post->processid; ?>" class="anchorDetail">
                                        <div class="panel-body bg-<?= $bgcolor; ?>">
                                            <h1 class="fs35 mbn mtn"><?= $post->platform_capacity - $post->remaining_capacity; ?></h1>
                                            <?php
                                            if ($statno == 4) {
                                                $date = DateTime::createFromFormat("d/m/Y h:i A", $post->dettach_panel);
                                                $edate = $date->format('Y-m-d H:i:s');
                                                ?>
                                                <div data-countdown="<?= $edate; ?>"></div>
                                            <?php
                                        } ?>
                                        </div>
                                    </a>
                                    <a href="<?= $pageredirect . $post->processid . '/' . $post->id; ?>" target="_blank">
                                        <div class="panel-footer bg-white br-t br-light p12">
                                            <span class="fs11">
                                                <i class="fa fa-th pr5 text-system"></i>
                                                <b><?= $post->platformid . " ( " . $status . " )"; ?> </b>

                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php
                            if ($i % 3 == 0) {
                                echo '<div class="clearfix"></div>';
                            }
                        endforeach;
                    }
                    ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="panel bg-danger light of-h mb10">
                        <div class="pn pl20 p5">
                            <div class="icon-bg">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <h2 class="mt15 lh15">
                                <b><?= intval($totalweight) . " Tons"; ?></b>
                            </h2>
                            <h5 class="text-muted">Dispatch</h5>
                        </div>
                    </div>

                    <div class="reportbutton">

                        <?php echo anchor(base_url() . 'Reports/MaterialReport/', '<span class="fa fa-bar-chart pr5"></span>Material Report</a>', ['class' => 'btn btn-success btn-gradient btn-alt']); ?>
                        <?php echo anchor(base_url() . 'Reports/InwardReport/', '<span class="fa fa-area-chart pr5"></span>Inward Report</a>', ['class' => 'btn btn-success btn-gradient btn-alt']); ?>
                        <?php echo anchor(base_url() . 'Reports/OutwardReport/', '<span class="fa fa-pie-chart pr5"></span>Outward Report</a>', ['class' => 'btn btn-success btn-gradient btn-alt']); ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="panel panel-visible" id="spy2">
                        <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Current Order Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($orderlist)) {
                                    foreach ($orderlist as $post) {

                                        if ($post->batch_qty > $post->qty_dispatch) {

                                            echo "<tr><td><a href='" . base_url() . "Order/add/" . $post->id . "'>";
                                            echo "<b class='text-muted'>" . $post->orderno . "</b>";
                                            echo " |<b> Forgine: </b>" . $post->from_forgine_party . "";
                                            echo " | <b>  Main: </b>" . $post->main_party . "";
                                            echo "<br>";
                                            echo "<span class='text-primary-light'><b> Item : </b>" . $post->item_no . " - " . $post->part_type . "</span>";
                                            echo "<br>";
                                            echo "<span class='text-warning'><b> Qty: </b>" . $post->batch_qty . "</span>";
                                            echo " | <span class='text-danger'><b> Used: </b>" . ($post->qty_used - $post->qty_ready) . "</span>";
                                            echo " | <span class='text-danger-darker'><b> Ready: </b>" . ($post->qty_ready - $post->qty_dispatch) . "</span>";
                                            echo " | <span class='text-success'><b> Dispatch: </b>" . $post->qty_dispatch . "</span>";
                                            echo "</a></td></tr>";
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>

                </div>
                <div class="clearfix"></div>
            </section>
            <!-- End: Content -->

            <?php $this->load->view('Includes/footer'); ?>
        </section>
        <!-- End: Content-Wrapper -->
    </div>
    <!-- End: Main -->
    <!-- End: Content -->
    <div id='myModal' class='modal'>
        <div class="modal-dialog panel  panel-default panel-border top">
            <div class="modal-content">
                <div id='myModalContent'></div>
            </div>
        </div>

    </div>

    <?php $this->load->view('Includes/footerscript'); ?>
    <script type="application/javascript" src="<?= base_url(); ?>assets/js/jquery.countdown.min.js"></script>

    <script>
        var TeamDetailPostBackURL = '<?= $detailPage; ?>';
        $(function() {
            $(".anchorDetail").click(function() {
                debugger;
                var $buttonClicked = $(this);
                var id = $buttonClicked.attr('data-id');
                var options = {
                    "backdrop": "static",
                    keyboard: true
                };
                $.ajax({
                    type: "GET",
                    url: TeamDetailPostBackURL + '/' + id,
                    contentType: "application/json; charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $('#myModalContent').html(data);
                        $('#myModal').modal(options);
                        $('#myModal').modal('show');

                    },
                    error: function() {
                        alert("Dynamic content load failed.");
                    }
                });
            });

            $("#closbtn").click(function() {
                $('#myModal').modal('hide');
            });
        });

        $(function() {
            $('[data-countdown]').each(function() {
                var $this = $(this),
                    finalDate = $(this).data('countdown');
                $this.countdown(finalDate, function(event) {
                    $this.html(event.strftime('%D days %H:%M:%S'));
                });
            });
        });
    </script>
</body>

</html>
<?php

$endtime = microtime(true); // Bottom of page
printf("Page loaded in %f seconds", $endtime - $starttime);
?>