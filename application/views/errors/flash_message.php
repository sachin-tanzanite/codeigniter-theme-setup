<?php
	if($this->session->flashdata('success_msg')) {
?>
		<div class="row" id="success_flash_msg" style="color:green;">
			<div class="col-sm-12">
				<h4 class="text-center text-success"><?php echo $this->session->flashdata('success_msg');?></h4>
				
             </div>
        </div>
		
<?php } else if($this->session->flashdata('error_msg')) {
?>
		<div class="row" id="error_flash_msg"  style="color:red;">
			<div class="col-sm-12 error_msg">
				<h4 class="text-center text-danger"><?php echo $this->session->flashdata('error_msg');?></h4>
             </div>
        </div>
		
<?php }  ?>

						
