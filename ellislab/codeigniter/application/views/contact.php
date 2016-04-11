<?php echo form_open('updateContact/'.$contact->id); ?>
<div class="row company window">
	<div class="small-6  columns">
		<h4>Contact Details</h4>
		<div class="row">
		<div class="small-1 columns">Company</div>
		<div class="small-11 columns"><select name="companyId" class="editField">
				<?php foreach ($companies as $company):?>
				<option <?php if($company->companyName == $contact->companyName){ echo "selected='selected'"; }  ?>  value="<?php echo $company->id?>"><?php echo $company->companyName ?></option>
				<?php endforeach;?>
			</select>
		</div>

		<div class="small-1 columns">Title</div> <div class="small-11  columns"><input type='text' name='title' value='<?php echo $contact->title ?>' class="editField"/></div>

		<div class="small-1 columns">Name </div> <div class="small-11 columns"><input type='text' name='name' value='<?php echo $contact->name ?>' class="editField"/></div>

		<div class="small-1 columns"> Surname</div> <div class="small-11  columns"> <input type='text' name='surname' value='<?php echo $contact->surname ?>' class="editField"/></div>

		<div class="small-1 columns">Email</div> <div class="small-11  columns"><input type='text' name='email' value='<?php echo $contact->email ?>' class="editField"/></div>

		<div class="small-1 columns"> Phone </div> <div class="small-11  columns"><input type='text' name='phone' value='<?php echo $contact->phone ?>' class="editField"/></div>

		<div class="small-1 columns"> Mobile</div> <div class="small-11 columns"> <input type='text' name='mobile' value='<?php echo $contact->mobile ?>' class="editField"/></div>

		<div class="small-1 columns">Position</div> <div class="small-11	 columns"> <input type='text' name='position' value='<?php echo $contact->position ?>' class="editField"/></div>

		<div class="small-1 columns"> Notes</div> <div class="small-11	 columns">  <textarea type='text' name='notes' class="editField"/><?php echo $contact->notes ?></textarea>

	</div>
	</div></div>

	<div class="small-6 columns">
		<h4>Supervisor Details</h4>
		<label>Change
				<select name="supervisorId">
			 		<?php foreach ($companyContacts as $companyContact):?>
						<option <?php if($companyContact->email == $supervisor->email){ echo "selected='selected'"; }  ?>  value="<?php echo $companyContact->id ?>"><?php echo $companyContact->title." ".$companyContact->name." ".$companyContact->surname; ?></option>
					<?php endforeach;?>
				</select>
</label>
			<p>Name: <?php echo "$supervisor->title $supervisor->name $supervisor->surname"; ?></h2><br/>
			Phone: <?php echo $supervisor->phone; ?><br>
			Mobile: <?php echo $supervisor->mobile; ?><br>
			Email: <?php echo $supervisor->email; ?><br>
			Position: <?php echo $supervisor->position; ?><br>

			</p><br/>
	</div>
		<div class="small-1 small-offset-11 columns">
		<input type="submit" class="success button" value="Save">
	</div>
</div>
<?php echo form_close(); ?>
