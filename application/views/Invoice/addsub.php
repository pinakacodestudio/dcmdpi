<?php

$i = 0;
foreach ($orderlist as $post) {

    $i++;
    $totweight = $post->jobwork_qty * $post->weight_piece;
    $totamount = $totweight * $post->contract_rate;
    $date = new DateTime($post->jobwork_date);
    $jobwork_date = $date->format('d-m-Y');
    ?>

<tr id="box_<?= $i; ?>">
    <td style="text-align: center; "><?= $post->jobwork_chalan; ?></td>
    <td style="text-align: center; "><?= $jobwork_date; ?></td>
    <td style="text-align: center; "><?= $post->item_no; ?></td>
    <td style="text-align: center; "><?= $post->part_type; ?></td>
    <td style="text-align: center; "><?= $post->jobwork_qty; ?></td>
    <td style="text-align: center; "><?= $post->weight_piece; ?></td>
    <td style="text-align: right; "><?= $totweight; ?></td>
    <td style="text-align: center; ">Rs. <?= $post->contract_rate; ?></td>
    <td style="text-align: right; ">Rs. <?= $totamount; ?></td>
    <td  style="text-align: center; vertical-align: middle; ">
        <button type="button" class="btn btn-danger btn-gradient btn-alt pt5 pb5 mn" onclick="javascript:RemoveData(<?= $i; ?>)" title="Delete Record"><i class="fa fa-close"></i></button>
    </td>
    <input type="hidden" name="ord_<?= $i; ?>" id="ord_<?= $i; ?>" value="<?= $post->id; ?>">
    <input type="hidden" name="qty_<?= $i; ?>" id="qty_<?= $i; ?>" value="<?= $post->jobwork_qty; ?>">
    <input type="hidden" name="weight_<?= $i; ?>" id="weight_<?= $i; ?>" value="<?= $totweight; ?>">
    <input type="hidden" name="total_<?= $i; ?>" id="total_<?= $i; ?>" value="<?= $totamount; ?>">
</tr>

<?php 
} ?>
<input type="hidden" name="count" id="count" value="<?= $i; ?>" />