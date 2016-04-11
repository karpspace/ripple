<?php echo form_open('updateCompany/'.$company->id); ?>
<div class="row company window">
	<div class="small-6 columns">
	<h4>Company Details</h4>
		<label>Name
			<input type="text" name="companyName" placeholder="" value="<?php echo $company->companyName ?>">
		</label>
		<label>Ref
			<input type="text" name="ref" placeholder="" value="<?php echo $company->ref ?>">
		</label>
		<label>Nature of Business
			<textarea name="natureOfBusiness" rows="5"  ><?php echo $company->natureOfBusiness ?></textarea>
		</label>
	</div>

	<div class="small-3 columns">
			<h4>Key Contact</h4>
						<label>Change
				<select name="keyContactId">
			 		<?php foreach ($companyContacts as $contact):?>
						<option <?php if($company->keyContactEmail == $contact->email){ echo "selected='selected'"; }  ?> value="<?php echo $contact->id?>"><?php echo $contact->title." ".$contact->name." ".$contact->surname; ?></option>
					<?php endforeach;?>
				</select>
			</label>
			<p>Name: <?php echo "$company->keyContactTitle $company->keyContactName $company->keyContactSurname"; ?></h2><br/>
			Phone: <?php echo $company->keyContactPhone; ?><br>
			Mobile: <?php echo $company->keyContactMobile; ?><br>
			Email: <?php echo $company->keyContactEmail; ?><br>
			Position: <?php echo $company->keyContactPosition; ?><br>
			Based in building : <input name="keyContactInBuilding" type="checkbox" 
			<?php if( $company->keyContactInBuilding=="on"){ echo " checked"; } ?>

			></p><br/>

			</div>
	<div class="small-3 columns">
		<h4>Emergency Contact</h4>
<label>Change
				<select name="emergencyContactId">
			 		<?php foreach ($companyContacts as $contact):?>
						<option <?php if($company->emergencyContactEmail ==$contact->email){ echo "selected='selected'"; }  ?>  value="<?php echo $contact->id?>"><?php echo $contact->title." ".$contact->name." ".$contact->surname; ?></option>
					<?php endforeach;?>
				</select>
</label>
			<p>Name: <?php echo "$company->emergencyContactTitle $company->emergencyContactName $company->emergencyContactSurname"; ?></h2><br/>
			Phone: <?php echo $company->emergencyContactPhone; ?><br>
			Mobile: <?php echo $company->emergencyContactMobile; ?><br>
			Email: <?php echo $company->emergencyContactEmail; ?><br>
			Position: <?php echo $company->emergencyContactPosition; ?><br>

			</p><br/>
			
		</p>
	</div>
		<div class="small-1 small-offset-11 columns">
		<input type="submit" class="success button" value="Save">
	</div>
</div>

<!--

<?php var_dump($companyContacts); ?>
<?php var_dump($company); ?>
-->