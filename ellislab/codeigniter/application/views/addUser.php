<?php echo form_open('addUserExecute'); ?>
<div class="row company window">
	<div class="small-6 columns">
		<h4>User Details</h4>
		<div class="row">


		<div class="small-1 columns">Name </div> <div class="small-11 columns"><input type='text' name='name' class="editField"/></div>

		<div class="small-1 columns">Surname</div> <div class="small-11  columns"> <input type='text' name='surname' class="editField"/></div>

		<div class="small-1 columns">Email</div> <div class="small-11  columns"><input type='text' name='email'  class="editField"/></div>

		<div class="small-1 columns"> Password </div> <div class="small-11  columns"><input type='text' name='password' class="editField" /></div>

		</div>
	</div>
	<div class="small-1 small-offset-11 columns">
		<input type="submit" class="success button" value="Save">
	</div>
</div>
<?php echo form_close(); ?>
