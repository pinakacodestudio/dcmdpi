<?php
    if($orderinvoice->paymod == 1){
        $paytype = "By Cash";
    }else if($orderinvoice->paymod == 2){
        $paytype = "Online";
    }else{
        $paytype = "Unpaid";
    }
    if($tokenno != null){
        $token = $tokenno->token;
    }else{
        $token = 0;
    }
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="clearfix"></div>
        <div class="col-md-6"><h4 class="modal-title"><?= $orderinvoice->billno; ?></h4></div>
        <div class="col-md-6"><h5 class="text-right"><?= $orderinvoice->created_on; ?></h5></div>
        <div class="clearfix"></div>

    </div>
    <div class="modal-body">
        <div class="col-md-6">
            <h5><b>Customer Name : </b> <?= $orderinvoice->cust_name; ?></h5>
            <h5><b>Customer Mobile : </b> <?= $orderinvoice->cust_mob; ?></h5>
            <h5><b>Token No. : </b> <?= $token; ?></h5>
            <h5><b>Payment Type : </b> <?= $paytype; ?></h5>
            <h5><b>Created By : </b> <?= $cuser->user_fullname; ?></h5>
            <h5><b>Created On : </b> <?= $orderinvoice->created_on; ?></h5>
        </div>
        <div class="col-md-6">
            <h5><b>Customer Email: </b> <?= $orderinvoice->cust_email; ?></h5>
            <h5><b>Customer Address : </b> <?= $orderinvoice->cust_address; ?></h5>
            <?php
            if($orderinvoice->disamt > 0 ){
            ?>
            <h5><b>Promo Code : </b> <?= $offshow->offer_code; ?></h5>
            <?php } ?>
            <h5><b>Updated By : </b> <?= $uuser->user_fullname; ?></h5>
            <h5><b>Updated On : </b> <?= $orderinvoice->updated_on; ?></h5>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <?php
            $j = 0;
            if(count($ordersub)):
            $j++;
            ?>
            <table class="table table-bordered mbn">
                <thead>
                <tr>
                    <th style="width: 10%">#</th>
                    <th style="width: 45%">Description</th>
                    <th style="width: 25%">Quantity</th>
                    <th style="width: 20%">Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                if(count($ordersub)):
                foreach ($ordersub as $post):
                $i++;
                ?>
                <tr>
                    <td><b><?= $i; ?></b></td>
                    <td><?= $post->item_name; ?></td>
                    <td><?= $post->item_qty; ?></td>
                    <td><?= PAYTYPE; ?> <?= number_format($post->item_price,2); ?></td>
                </tr>
                <?php
                endforeach;
                endif;
                ?>
                </tbody>
                <tfoot>
                <?php
                if($orderinvoice->disamt > 0){
                    $rowspan = 5;
                }else{
                    $rowspan = 3;
                }
                ?>
                <tr>
                    <td rowspan="<?= $rowspan; ?>" colspan="2" style="text-align: center; padding:0px;  vertical-align: top; border: 1px solid #e5e5e5">
                        <h5 style="background: #e5e5e5; color: #2e313d; margin: 0px; padding: 5px;"> OTHER COMMENTS </h5>
                        <p style="padding: 10px; text-align: left;"><?= $orderinvoice->description; ?></p>
                    </td>
                    <td style="width: 12%;">
                        Sub Total:
                    </td>
                    <td style="width: 15%"><?= PAYTYPE; ?> <?= number_format($orderinvoice->totamt,2); ?></td>
                </tr>
                <tr>
                    <td>
                        Tax
                    </td>
                    <td><?= PAYTYPE; ?> <?= number_format($orderinvoice->taxamt,2); ?></td>
                </tr>
                <?php
                if($orderinvoice->disamt > 0 ){
                    ?>
                    <tr>
                        <td>
                            Amount
                        </td>
                        <td><?= PAYTYPE; ?> <?= number_format($orderinvoice->taxamt+$orderinvoice->totamt,2); ?></td>
                    </tr>
                    <tr>
                        <td>
                            Discount
                        </td>
                        <td><?= PAYTYPE; ?> <?= number_format($orderinvoice->disamt,2); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>
                        <b>Final Total </b>
                    </th>
                        <th><?= PAYTYPE; ?> <?= number_format(($orderinvoice->taxamt+$orderinvoice->totamt)- $orderinvoice->disamt,2); ?></th>
                </tr>

                </tfoot>
            </table>

            <?php endif; ?>
        </div>

        <div class="clearfix"></div>
    </div>
</div>
