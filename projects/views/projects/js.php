<script type="text/javascript">
	$(".connectedSortable").sortable({
      placeholder: "sort-highlight",
      connectWith: ".connectedSortable",
      handle: ".box-header, .nav-tabs",
      forcePlaceholderSize: true,
      zIndex: 999999
    });
    $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

    

    // Call bootstrap datepicker function
    $("#start_date, #deadline").bootstrapDP(options);

    $("#assignee").select2();
    

    $('.star').on('click', function () {
        $(this).toggleClass('star-checked');
      });

      $('.ckbox label').on('click', function () {
        $(this).parents('tr').toggleClass('selected');
      });

      $('.btn-filter').on('click', function () {
        var $target = $(this).data('target');
        if ($target != 'all') {
          $('.table tr').css('display', 'none');
          $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
        } else {
          $('.table tr').css('display', 'none').fadeIn('slow');
        }
      });


      function searchTable(){
	    /* Table search function */
	    const input = document.querySelector('#searchTable');
	    const filter = input.value.toUpperCase();	    
	    const table = document.querySelector('#projectsTable');
	    const tr = table.getElementsByTagName('tr');

	    for(let i = 0;i < tr.length; i++){

	      let td = tr[i].getElementsByTagName('td')[2];
	      
	      if (td) {
	        txtValue = td.textContent || td.innerText;
	        
	        if (txtValue.toUpperCase().indexOf(filter) > -1) {
	          tr[i].style.display = "";
	        } else {
	          tr[i].style.display = "none";
	        }
	      }
	    }
	  }

	  function deleteProject(){
	  	const selectedFields = document.getElementsByClassName('selected');
	  	// Check if there are selected rows
	  	if (selectedFields.length == 0) {
			Swal.fire({
				icon: 'error',
	            title: 'Oops...',
	  			text: 'No Project(s) checked, please select project(s) to delete!'
			}); 
		} else {
			Swal.fire({
			  title: 'Are you sure?',
			  text: "Do you want to delete selected project(s)?",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Yes, delete Project(s)!'
			}).then((result) => {
				if (result.value) {

					let idsToDelete = "";
			  		Object.keys(selectedFields).forEach(function(key){
			  			idsToDelete += `${selectedFields[key].id},`;	  			
			  		});

			  		$.ajax({
			  			type: "post",
			  			url: "projects/actions",
			  			data: {
			  				"deleteProjects" : "1",
			  				"ids" : idsToDelete
			  			},
			  			success: function(data){
			  				if (data == 'deleted') {
			  					Swal.fire(
							      'Deleted!',
							      'Your selected project(s) has been deleted.',
							      'success'
							    )
							    // Make selected rows disappear
							    Object.keys(selectedFields).forEach(function(key){
						  			selectedFields[key].style.display = 'none';			
						  		});
			  				}
			  			}
			  		});

				}
			});
		}			    
	 } 
</script>