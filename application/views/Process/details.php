<?php
$seldata = array('1'=>'Waiting For Material','2'=>'Waiting For Furnace','3'=>'Waiting For PowerPanel','4'=>'Processing','5'=>'Cooling','6'=>'Unloading','7'=>'Closed');
$status = customData($seldata,$process->status);

$date = new DateTime( $post->dispatch_date);
$panel_attach = $date->format('d-m-Y H:i:s');
$date = new DateTime( $post->dispatch_date);
$panel_dettach = $date->format('d-m-Y H:i:s');

?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="clearfix"></div>
        <div class="col-md-6"><h4 class="modal-title">Furnace Material Details</h4></div>
        <div class="clearfix"></div>

    </div>
    <div class="modal-body" style="min-height: 100px;">
        <div class="col-md-12">
            <?php
            if($id == 1){
            $j = 0;
            $j++;
            ?>
            <table class="table table-bordered mbn">
                <thead>
                <tr><th colspan="4" style="padding: 5px">Platform ID :  <?= $process->platformid; ?></th></tr>
                <tr><th colspan="4">Furnace ID :  <?= $process->bellid; ?></th></tr>
                <tr><th colspan="4">Panel ID :  <?= $process->panelid; ?></th></tr>
                <tr>
                    <th style="width: 35%; padding: 5px;">Customer Name</th>
                    <th style="width: 40%; padding: 5px;">Part No. &amp; Type</th>
                    <th style="width: 10%; padding: 5px;">Qty</th>
                    <th style="width: 15%; padding: 5px;">Weight</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                if(count($materialslist)):
                foreach ($materialslist as $post):
                $i++;
                ?>
                <tr>
                    <td style="padding: 5px"><?= $post->company_name; ?></td>
                    <td style="padding: 5px"><?= $post->item_no." - ".$post->part_type; ?></td>
                    <td style="padding: 5px"><?= $post->qty; ?></td>
                    <td style="padding: 5px"><?= $post->total_weight; ?></td>
                </tr>
                <?php
                endforeach;
                endif;
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4" style="text-align: center; padding:0px;  vertical-align: top; border: 1px solid #e5e5e5">
                        <h5 style="text-align: left; color: #2e313d; padding: 5px;"> Process Start Date : <?= $panel_attach; ?></h5>
                        <h5 style="text-align: left; color: #2e313d; padding: 5px;"> Process End Date : <?= $panel_dettach; ?></h5>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <?php }else{?>
            <h5 style="margin-bottom: 50px;"><b>No Process Started</b></h5>
            <div class="clearfix"></div>
            <?php } ?>
        <div class="clearfix"></div>
    </div>
</div>
