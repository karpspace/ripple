<div class="row">
	<div class="small-2 small-centered text-center columns">
		<a href="addUser"><button class="success button">Add User</button></a>
	</div>
</div>
<div class="row contacts">
	<div class="small-7 small-centered columns">
		<table>
		  <thead>
		    <tr>
		      <th>Name</th>
		      <th>Surname</th>
		      <th>Email</th>
		      <th>Active</th>
		      <th>Edit</th>
		      <th>Delete</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php foreach ($users as $user):?>
		  	<tr>

		      <td><?php echo $user->name; ?></td>
		      <td><?php echo $user->surname; ?></td>
		      <td><?php echo $user->email; ?></td>
		      <td>




		      <?php if($user->active==1){ ?>
		      
		      <a href="deactivateUser/<?php echo $user->id; ?>"><i class="fa fa-ban"></i></a>
		      <?php }else{ ?>
							<a href="activateUser/<?php echo $user->id; ?>"><i class="fa fa-check-circle"></i></a>
		      <?php }?>



		      </td>
		      <td>


		      <a href="editUser/<?php echo $user->id; ?>"><i class="fa fa-pencil"></i></a>







		      </td>
		      <td><a href="removeUser/<?php echo $user->id; ?>"<i class="fa fa-trash"></i></a></td>
		    </tr>
		        <?php endforeach;?>
		  </tbody>
		</table>
	</div>
</div>