function searchComapanies(companyName,ref,page,target){
	$.post( "/searchCompaniesAjax", { companyName: companyName, ref: ref, page:page })
  .done(function( dataEncoded ) {
  	$(target).empty();
 		data = $.parseJSON( dataEncoded );

  	$.each(data,function(index, value){
  		$(target).append("<tr><td></td><td>"+value['companyName']+"</td><td>"+value['ref']+"</td><td><a href='editCompany/"+value['id']+"'><i class='fa fa-pencil'></i></a></td><td><a href='removeCompany/"+value['id']+"'><i class='fa fa-trash'></i></a></td></tr>");
 	})
    
  });

}

function searchContacts(name,surname,email,phone,mobile,companyName,position,page,target){
	$.post( "/searchContactsAjax", { name:name,surname:surname,email:email,phone:phone,mobile:mobile,companyName:companyName,position:position,page:page })
  .done(function( dataEncoded ) {
  	$(target).empty();
 		data = $.parseJSON( dataEncoded );

  	$.each(data,function(index, value){
  		$(target).append("<tr><td>"+value['title']+"</td><td>"+value['name']+"</td><td>"+value['surname']+"</td><td>"+value['email']+"</td><td>"+value['phone']+"</td><td>"+value['mobile']+"</td><td>"+value['companyName']+"</td><td>"+value['position']+"</td><td><a href='archiveContact/"+value['id']+"'><i class='fa fa-file-archive-o'></i></a></td><td><a href='editContact/"+value['id']+"'><i class='fa fa-pencil'></i></a></td><td><a href='removeContact/"+value['id']+"'><i class='fa fa-trash'></i></a></td></tr>");
 	})
    
  });

}



$(document).ready(function(){

// Ajax Requests
	$(".searchCompany").keyup(function(){
		searchComapanies(
		 $("#companyName").val(),
		 $("#ref").val(),
		 1,
		 ".companies table tbody"
		 );
	});

	$(".pagesCompanies").click(function(){
		console.log($(this).attr("data-page"));
		searchComapanies(
		 $("#companyName").val(),
		 $("#ref").val(),
		 $(this).attr("data-page"),
		 ".companies table tbody"
		 );
	});
	

	$(".searchContact").keyup(function(){
		searchContacts(
			$("#name").val(),
			$("#surname").val(),
			$("#email").val(),
			$("#phone").val(),
			$("#mobile").val(),
			$("#companyName").val(),
			$("#position").val(),
			1,
			 ".contacts div table tbody"
		 );
	});

		$(".pagesContacts").click(function(){
		console.log($(this).attr("data-page"));
		searchContacts(
			$("#name").val(),
			$("#surname").val(),
			$("#email").val(),
			$("#phone").val(),
			$("#mobile").val(),
			$("#companyName").val(),
			$("#position").val(),
		 	$(this).attr("data-page"),
		 ".contacts div table tbody"
		 );
	});

	//Companies requests



});
