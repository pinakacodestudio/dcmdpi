<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function StringRepair($temptext)
{
    $temptext = trim($temptext);
    $temptext = str_replace("'", "&#39;", $temptext);
    $temptext = str_replace("\"", "&#34;", $temptext);
    return $temptext;
}
function StringRepair3($temptext)
{
    $temptext = trim($temptext);
    $temptext = str_replace("&#39;", "'", $temptext);
    $temptext = str_replace("&#34;", "\"", $temptext);
    return $temptext;
}
function PageConfig($baseurl, $total_records, $limit_per_page, $uriseg)
{
    $config = array();
    // get current page records
    $config['base_url'] = $baseurl;
    $config['total_rows'] = $total_records;
    $config['per_page'] = $limit_per_page;
    $config["uri_segment"] = $uriseg;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';

    $config['first_link'] = '« First';
    $config['first_tag_open'] = '<li class="prev page">';
    $config['first_tag_close'] = '</li>';

    $config['last_link'] = 'Last »';
    $config['last_tag_open'] = '<li class="next page">';
    $config['last_tag_close'] = '</li>';

    $config['next_link'] = 'Next';
    $config['next_tag_open'] = '<li class="next page">';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = 'Previous';
    $config['prev_tag_open'] = '<li class="prev page">';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="active"><a href="">';
    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li class="page">';
    $config['num_tag_close'] = '</li>';

    return $config;
}
function Actdeact($act)
{
    $btnval = "";
    if ($act == 1) :
        $btnval = '<button class="btn btn-primary pt5 pb5 mn" type="button">Activated</button>';
    else :
        $btnval = '<button class="btn btn-danger pt5 pb5 mn" type="button">Deactivated</button>';
    endif;

    return $btnval;
}
function alertbox()
{
    $CI = &get_instance();
    if ($msg = $CI->session->flashdata('error_msg')) :
        echo '  <div class="alert alert-danger dark alert-dismissable p5">' . $msg . '</div>';
    endif;
    if ($msg = $CI->session->flashdata('success_msg')) :
        echo '  <div class="alert alert-info dark alert-dismissable p5">' . $msg . '</div>';
    endif;
}
function manageheader($managePage, $addPage, $addButton)
{
    echo '<header id="topbar">
                <div class="topbar-left">
                    <ol class="breadcrumb">
                        <li class="crumb-trail">' . $managePage . '</li>
                    </ol>
                </div>';
    if ($addPage != "" && $addButton != "") {
        echo '<div class="topbar-right" >
        ' . anchor($addPage, '<span class="fa fa-plus pr5" ></span > ' . $addButton . '</a > ', ['class' => 'btn btn-primary btn-gradient btn-alt']) . '
        </div >';
    }
    echo '</header>';
}
function noRecord($addPage)
{
    echo '<div class="panel-body">
                            <p>No Record(s) added yet.</p>
                            <a href="' . $addPage . '" class="btn btn-primary float-left btn-gradient btn-alt" style="margin-left:15px;" > <i class="font-icon font-icon-plus"></i> Add Record</a>
                        </div>';

}
function labelbox($colname, $label, $value)
{
    echo '<div class="col-md-' . $colname . '">
              <fieldset class="form-group">
              <label class="form-label semibold">' . $label . '</label>
              <label class="form-control">' . $value . '</label>
              </fieldset>
            </div>';
}
function editbox($colname, $label, $fieldname, $placeholder, $value, $script = "")
{
    echo '<div class="col-md-' . $colname . '">
            <fieldset class="form-group">
                <label class="form-label semibold">' . $label . '</label>
                <input type="text" ' . $script . ' name="' . $fieldname . '" value="' . $value . '" id="' . $fieldname . '" placeholder ="' . $placeholder . '" class="form-control">
            </fieldset>
        </div>';
}
function textareabox($colname, $label, $fieldname, $placeholder, $value)
{
    echo '<div class="col-lg-' . $colname . '">
            <fieldset class="form-group">
                <label class="form-label semibold">' . $label . '</label>
                ' . form_textarea(['name' => $fieldname, 'id' => $fieldname, 'value' => $value, 'placeholder' => $placeholder, 'class' => 'form-control', 'style' => 'height:100px;']) . '
            </fieldset>
            </div>';
}
function emailbox($colname, $label, $fieldname, $placeholder, $value, $required)
{
    echo '<div class="col-md-' . $colname . '">
              <fieldset class="form-group">
              <label class="form-label semibold">' . $label . '</label>
              <input type="email" ' . $required . ' name="' . $fieldname . '" value="' . $value . '" id="' . $fieldname . '" placeholder ="' . $placeholder . '" class="form-control">
              </fieldset>
            </div>';
}
function passwordbox($colname, $label, $fieldname, $placeholder, $value)
{
    echo '<div class="col-md-' . $colname . '">
              <fieldset class="form-group">
              <label class="form-label semibold">' . $label . '</label>
              ' . form_password(['name' => $fieldname, 'value' => $value, 'id' => $fieldname, 'placeholder' => $placeholder, 'class' => 'form-control']) . '
              </fieldset>
            </div>';
}
function dropdownbox($colname, $label, $fieldname, $array, $value, $script = "")
{
    echo '<div class="col-md-' . $colname . '">
                        <fieldset class="form-group">
                            <label class="form-label semibold">' . $label . '</label>';
    $attributes = 'class="chosen-select" ' . $script . ' id="' . $fieldname . '"';
    echo form_dropdown($fieldname, $array, $value, $attributes);
    echo '</fieldset>
          </div>';
}
function datepicker($colname, $label, $fieldname, $placeholder, $value, $script = "")
{
    echo '<div class="col-md-' . $colname . '">
                            <fieldset class="form-group">
                                <label class="form-label">' . $label . '</label>
                                <div class="input-group date ">
                                    <input type="text" class="form-control datetimepicker" ' . $script . ' id="' . $fieldname . '" name="' . $fieldname . '" value="' . $value . '">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </fieldset>
                        </div>';
}
function checkbox($check, $label, $fieldname)
{
    $checked = "";
    if ($check == 1) {
        $checked = "checked";
    }

    echo '<div class="col-lg-12">
                <div class="checkbox-toggle">
                    <input id="check-toggle-2" value="0" name="' . $fieldname . '" id="' . $fieldname . '"  ' . $checked . ' type="checkbox">
                    <label for="check-toggle-2">' . $label . '</label>
                </div>
             </div>';

}
function uploadbox($colname, $label, $fieldname, $placeholder)
{
    echo '<div class="col-md-' . $colname . ' admin-form">
                        <div class="section" >
                            <label class="field prepend-icon append-button file" style="margin-top:22px;">
                                <span class="button btn-default">' . $label . '</span>
                                <input class="gui-file" name="' . $fieldname . '" id="' . $fieldname . '" onchange="document.getElementById(\'' . $fieldname . '_1\').value = this.value;" type="file">
                                <input class="gui-input" id="' . $fieldname . '_1" placeholder="' . $placeholder . '" type="text">
                                <label class="field-icon">
                                    <i class="fa fa-upload"></i>
                                </label>
                            </label>
                        </div>
                        </div>';
}
function submitbutton($pageBack)
{
    echo '<div class="clearfix"></div>
             <div class="col-lg-12">
               <div class="form-group" style="float:left;" >' .
        form_submit(['value' => 'Submit', 'class' => 'btn btn-primary btn-gradient btn-alt']) . '
    </div>
    
    <div class="form-group" style="float:left;">
        ' . anchor($pageBack, 'Cancel', ['class' => 'btn btn-danger btn-gradient btn-alt']) . '
    </div>
    </div>';
}

function customData($arraydata, $cid)
{

    foreach ($arraydata as $column => $value) {
        if ($cid == $column) {
            return $value;
        }
    }

}

function convertMoney($number)
{
    //A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands.
    $words = array(
        '0' => '', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five',
        '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine', '10' => 'ten',
        '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen', '14' => 'fouteen', '15' => 'fifteen',
        '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'fourty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninty'
    );
    
    //First find the length of the number
    $number_length = strlen($number);
    //Initialize an empty array
    $number_array = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
    $received_number_array = array();
    
    //Store all received numbers into an array
    for ($i = 0; $i < $number_length; $i++) {
        $received_number_array[$i] = substr($number, $i, 1);
    }
    //Populate the empty array with the numbers received - most critical operation
    for ($i = 9 - $number_length, $j = 0; $i < 9; $i++, $j++) {
        $number_array[$i] = $received_number_array[$j];
    }
    $number_to_words_string = "";
    //Finding out whether it is teen ? and then multiply by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
    for ($i = 0, $j = 1; $i < 9; $i++, $j++) {
        //"01,23,45,6,78"
        //"00,10,06,7,42"
        //"00,01,90,0,00"
        if ($i == 0 || $i == 2 || $i == 4 || $i == 7) {
            if ($number_array[$j] == 0 || $number_array[$i] == "1") {
                $number_array[$j] = intval($number_array[$i]) * 10 + $number_array[$j];
                $number_array[$i] = 0;
            }

        }
    }
    $value = "";
    for ($i = 0; $i < 9; $i++) {
        if ($i == 0 || $i == 2 || $i == 4 || $i == 7) {
            $value = $number_array[$i] * 10;
        } else {
            $value = $number_array[$i];
        }
        if ($value != 0) {
            $number_to_words_string .= $words["$value"] . " ";
        }
        if ($i == 1 && $value != 0) {
            $number_to_words_string .= "Crores ";
        }
        if ($i == 3 && $value != 0) {
            $number_to_words_string .= "Lakhs ";
        }
        if ($i == 5 && $value != 0) {
            $number_to_words_string .= "Thousand ";
        }
        if ($i == 6 && $value != 0) {
            $number_to_words_string .= "Hundred &amp; ";
        }
    }
    if ($number_length > 9) {
        $number_to_words_string = "Sorry This does not support more than 99 Crores";
    }
    return ucwords(strtolower($number_to_words_string) . " Only.");
}

?>