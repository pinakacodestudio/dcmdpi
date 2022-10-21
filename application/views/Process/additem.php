<tr id="box_<?= $id; ?>">
    <td style="text-align: center; vertical-align: middle; width: 350px;">
        <?php $attributes = 'class="chosen-select" onchange="javascript:getOrderDetail(this.value,'.$id.')"  id="orderid_'.$id.'"';
        echo form_dropdown('orderid_'.$id, $orderlist, $orderid, $attributes); ?>
    </td>
    <td style="text-align: center; vertical-align: middle; ">
        <input type="number" class="form-control" id="qty_<?= $id; ?>" name="qty_<?= $id; ?>" value="0" required onblur="getAmount(<?= $id; ?>)">
    </td>
    <td style="text-align: center; vertical-align: middle; ">
        <input type="number" step="any" class="form-control" id="weight2_<?= $id; ?>" disabled name="weight2_<?= $id; ?>" value="0" >
    </td>
    <td style="text-align: center; vertical-align: middle; ">
        <input type="number" step="any" class="form-control" disabled id="total2_<?= $id; ?>" name="total2_<?= $id; ?>" value="0" required>
    </td>
    <td  style="text-align: center; vertical-align: middle; ">
        <button type="button" class="btn btn-danger btn-gradient btn-alt pt5 pb5 mn" onclick="javascript:RemoveData(<?= $id; ?>)" title="Print Record"><i class="fa fa-cross"></i>X Delete</button>
    </td>
    <input type="hidden" name="weight_<?= $id; ?>" id="weight_<?= $id; ?>" value="0">
    <input type="hidden" name="total_<?= $id; ?>" id="total_<?= $id; ?>" value="0">
    <input type="hidden" name="remqty_<?= $id; ?>" id="remqty_<?= $id; ?>" value="0">
</tr>

