
<?php echo form_open("authenticate")?>
	<div class="row">
			<div class="small-3 small-centered columns">
				<div class="window">
				<h2>Company Directory</h2>
					<label>email
						<input type="text" name="email" placeholder="">
					</label>
					<label>password
						<input type="text" name="password" placeholder="">
				</label>
				<input type="submit" class="success button" value="Login"/>
				<?php if(isset($error)){ ?>
					<p><?php echo $error; ?></p>
				<?php } ?>
			</div>
		</div>
	</div>
</form>
