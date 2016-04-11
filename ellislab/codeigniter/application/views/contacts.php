		<div class="row">
	<div class="small-10 text-center small-centered columns pages  ">
		<?php 

		$pages = ($contactsCount / 25);

		for ($i=1; $i <=$pages ; $i++) { 
			?>
			<a href = "#" data-page='<?php echo $i; ?>' class='pagesContacts'><?php echo $i; ?></a>


			<?php
		}

		?>
	</div>
	</div>
<div class="row searchBar ">
	<div class="small-12 small-centered columns">
		<table>
		  <thead>
		  
		  </thead>	  
		</table>
	</div>
</div>
</div>
<div class="row contacts">
	<div class="small-12 small-centered columns">
		<table>
		  <thead>
		    <tr>
		      <th>Title</th>
		      <th>Name</th>
		      <th>Surname</th>
		      <th>Email</th>
		      <th>Phone</th>
		      <th>Mobile</th>
		      <th>Company</th>
		      <th>Position</th>
		      <th>Archive</th>
		      <th>Edit</th>
		      <th>Delete</th>
		    </tr>
		    	    <tr>
		      <td>Search</td>
		      <td><input type="text" name="name" id="name" class="searchContact searchField"/></td>
		      <td><input type="text" name="surname" id="surname" class="searchContact searchField"/></td>
		      <td><input type="text" name="email" id="email" class="searchContact searchField"/></td>
		      <td><input type="text" name="phone" id="phone" class="searchContact searchField"/></td>
		      <td><input type="text" name="mobile" id="mobile" class="searchContact searchField"/></td>
		      <td><input type="text" name="companName" id="companyName" class="searchContact searchField"/></td>
		      <td><input type="text" name="position" id="position" class="searchContact searchField"/></td>
		      <td></td>
		      <td></td>
		      <td></td>
		    </tr>
		  </thead>
		  <tbody>
	
		  <?php foreach ($contacts as $contact):?>
		  	<tr>
		      <td><?php echo $contact->title; ?></td>
		      <td><?php echo $contact->name; ?></td>
		      <td><?php echo $contact->surname; ?></td>
		      <td><?php echo $contact->email; ?></td>
		      <td><?php echo $contact->phone; ?></td>
		      <td><?php echo $contact->mobile; ?></td>
		      <td><?php echo $contact->companyName; ?></td>
		      <td><?php echo $contact->position; ?></td>
		      <td><a href="archiveContact/<?php echo $contact->id; ?>"><i class="fa fa-file-archive-o"></i></a></td>
		      <td><a href="editContact/<?php echo $contact->id; ?>"><i class="fa fa-pencil"></i></a></td>
		      <td><a href="removeContact/<?php echo $contact->id; ?>"<i class="fa fa-trash"></i></a></td>
		    </tr>
		        <?php endforeach;?>
		  </tbody>
		</table>
	</div>
</div>