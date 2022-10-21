<?php
$managePage = '<span class="fa fa-user-circle mr10"></span> Customer Reports';
$addButton = "Export Customer Report";
$searchTitle = "Search Customer Report";

$ses_mobileno = $this->session->userdata['customerreport']['mobileno'];
$ses_sdate = $this->session->userdata['customerreport']['sdate'];
$ses_edate = $this->session->userdata['customerreport']['edate'];
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
        <?php manageheader($managePage, $addPage, $addButton); ?>
        <section id="content" class="animated fadeIn">
            <?php alertbox(); ?>
            <div class="panel" id="p7">
                                <div class="panel-heading">
                                    <span class="panel-title">Customer Name : <?= $company_name; ?></span>
                                </div>
                                <div class="panel-body pn">
                                    <div class="br-b admin-form">
                                        <table class="table mbn br-t">
                                            <tbody>
                                                <tr>
                                                    <td class="va-m fw600 text-muted p5">
                                                        <span class="fa fa-calendar text-primary fs14 ml5 mr10"></span>Total Order</td>
                                                    <td class="fs14 fw600 text-right"><?= sprintf("%0.2f",$totqty); ?> KG</td>
                                                </tr>
                                                <tr>
                                                    <td class="va-m fw600 text-muted p5">
                                                        <span class="fa fa-hourglass-end text-info fs14 ml5 mr10"></span>Last Year</td>
                                                    <td class="fs14 fw600 text-right"><?= sprintf("%0.2f",$lastqty); ?> KG</td>
                                                </tr>
                                                <tr>
                                                    <td class="va-m fw600 text-muted p5">
                                                        <span class="fa fa-bell text-warning fs15 ml5 mr10"></span>Current Year</td>
                                                    <td class="fs14 fw600 text-right"><?= sprintf("%0.2f",$cqty); ?> KG</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="high-line3" class="highchart-wrapper" style="width: 100%; height: 350px; margin: 0 auto"></div>
                                </div>
                            </div>
                            </section>
        <?php $this->load->view('Includes/footer'); ?>
    </section>
    <!-- End: Content-Wrapper -->
</div>
<!-- End: Main -->
<?php $this->load->view('Includes/footerscript'); ?>
<!-- HighCharts Plugin -->
<script src="<?= base_url(); ?>assets/vendor/plugins/highcharts/highcharts.js"></script>
<script src="<?= base_url(); ?>assets/js/demo/widgets.js"></script>
<script>
 'use strict'; 
/*! main.js - v0.1.1
* http://admindesigns.com/
* Copyright (c) 2015 Admin Designs;*/


/* Demo theme functions. Required for
 * Settings Pane and misc functions */
function demoHighCharts() {

        // Define chart color patterns
        var highColors = [bgWarning, bgPrimary, bgInfo, bgAlert,
            bgDanger, bgSuccess, bgSystem, bgDark
        ];


                var line3 = $('#high-line3');
                 
                if (line3.length) {

                    // High Line 3
                    $('#high-line3').highcharts({
                        credits: false,
                        colors: highColors,
                        chart: {
                            backgroundColor: '#f9f9f9',
                            className: 'br-r',
                            type: 'line',
                            zoomType: 'x',
                            panning: true,
                            panKey: 'shift',
                            marginTop: 25,
                            marginRight: 1,
                        },
                        title: {
                            text: null
                        },
                        xAxis: {
                            gridLineColor: '#EEE',
                            lineColor: '#EEE',
                            tickColor: '#EEE',
                            categories: ['Apr','May', 'Jun', 'Jul', 'Aug','Sep', 'Oct', 'Nov', 'Dec','Jan', 'Feb', 'Mar'
                            ]
                        },
                        yAxis: {
                            min: 0,
                            tickInterval: 100,
                            gridLineColor: '#EEE',
                            title: {
                                text: null,
                            }
                        },
                        plotOptions: {
                            spline: {
                                lineWidth: 3,
                            },
                            area: {
                                fillOpacity: 0.2
                            }
                        },
                        legend: {
                            enabled: false,
                        },
                        series: [{
                            name: 'Current Year',
                            data: [<?php echo sprintf("%0.2f",$c_apr_qty).",".sprintf("%0.2f",$c_may_qty).",".sprintf("%0.2f",$c_jun_qty).",".sprintf("%0.2f",$c_jul_qty).",".sprintf("%0.2f",$c_aug_qty).",".sprintf("%0.2f",$c_sep_qty).",".sprintf("%0.2f",$c_oct_qty).",".sprintf("%0.2f",$c_nov_qty).",".sprintf("%0.2f",$c_dec_qty).",".sprintf("%0.2f",$c_jan_qty).",".sprintf("%0.2f",$c_feb_qty).",".sprintf("%0.2f",$c_mar_qty); ?>]
                        }, {
                            name: 'Last Year',
                            data: [<?php echo sprintf("%0.2f",$l_apr_qty).",".sprintf("%0.2f",$l_may_qty).",".sprintf("%0.2f",$l_jun_qty).",".sprintf("%0.2f",$l_jul_qty).",".sprintf("%0.2f",$l_aug_qty).",".sprintf("%0.2f",$l_sep_qty).",".sprintf("%0.2f",$l_oct_qty).",".sprintf("%0.2f",$l_nov_qty).",".sprintf("%0.2f",$l_dec_qty).",".sprintf("%0.2f",$l_jan_qty).",".sprintf("%0.2f",$l_feb_qty).",".sprintf("%0.2f",$l_mar_qty); ?>]
                        }]
                    });

                }

};

 demoHighCharts();
           
</script>
</body>
</html>

