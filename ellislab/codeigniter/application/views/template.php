
<?php $this->load->view('header'); ?>
<div class="row main">
	<div class="small-12 columns">
		<?php if($data['view'] != "login"){ $this->load->view("menu"); } ?>
		<?php $this->load->view($data['view'],$data); ?>
	</div>
</div>

<?php $this->load->view('footer'); ?>

