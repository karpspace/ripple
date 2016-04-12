<div class="row">
	<div class="small-3 small-centered text-center columns pages  ">
		<?php 

		$pages = ($companiesCount / 25);

		for ($i=1; $i <=$pages ; $i++) { 
			?>
			<a href = "#" data-page='<?php echo $i; ?>' class='pagesCompanies'><?php echo $i; ?></a>


			<?php
		}

		?>
	</div>
</div><br>
<div class="row">
	<div class="small-8 small-centered columns companies ">
		<table>
		  <thead>
		    <tr>
		      <th></th>
		      <th>Company's Name</th>
		      <th>Company's Ref</th>
		      <th width="150">Edit</th>
		      <th width="150">Delete</th>
		    </tr>
		    <tr>
		    	<th>Search</th>
		      <th><input type="text" name="companyName" id="companyName" class="searchCompany searchField"/></th>
		      <th><input type="text" name="ref" id="ref" class="searchCompany searchField"/></th>
		      <th></th>
		      <th></th>
		  </tr>
		  </thead>
		  <tbody>
		  
		  <?php foreach ($companies as $company):?>
		  	<tr>
		  	<td></td>
		      <td><?php echo $company->companyName; ?></td>
		      <td><?php echo $company->ref; ?></td>
		      <td><a href="editCompany/<?php echo $company->id; ?>"><i class="fa fa-pencil"></i></a></td>
		      <td><a href="removeCompany/<?php echo $company->id; ?>"<i class="fa fa-trash"></i></a></td>
		    </tr>
		        <?php endforeach;?>
		  </tbody>
		</table>
	</div>
</div>