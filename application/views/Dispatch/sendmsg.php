<?php
	$pageSave = base_url()."Dispatch/savemsg/"
?>
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="clearfix"></div>
		<div class="col-md-6"><h4 class="modal-title">Send Msg</h4></div>
		<div class="clearfix"></div>
	</div>
	<div class="modal-body">
		<div class="row">
			<?php
				echo form_open($pageSave,['name'=>'frm1','enctype'=>'multipart/form-data','class'=>'stdform']);
				echo '<input type="hidden" name="id" value="'.$id.'" />';
				editbox(12,"Mobile No.","mobileno","Enter Mobile No.",$mobile);
				textareabox(12,"Message","message","Enter Message.",$message);
			?>
		</div>
		<!-- <button type="submit" class="btn btn-alt btn-primary " >Send Msg</button> -->
		<a 
			href="https://wa.me/+91<?=$mobile?>?text=<?=urlencode($message)?>" 
			id="send_whatsapa" class="btn btn-sm btn-primary toggle" target="_blank">Send Whatsapp Message</a>
		<div class="clearfix"></div>
		<div class="clearfix"></div>
		<?php form_close(); ?>
	</div>
</div>
