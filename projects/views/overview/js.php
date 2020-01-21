<script type="text/javascript">
	console.log(activities);

	$('.ckbox label').on('click', function () {
	    $(this).parents('tr').toggleClass('selected');
	  });

	/*instantiate select2*/
	const selectElements = document.getElementsByClassName('select');	
	Object.keys(selectElements).forEach(function(i, element){		
		$(document.getElementById(selectElements[i].id)).select2();		
	});

	/*instantiate datepicker*/
	const dateElements = document.getElementsByClassName('dp');
	console.log(dateElements);	
	Object.keys(dateElements).forEach(function(i, element){		
		$(document.getElementById(dateElements[i].id)).bootstrapDP(options);		
	});
	



	// Checks in update project if entered progress is numeric
	function checkIfNumeric(elementId) {
		const input = document.querySelector(elementId);
		const data = input.value;
		if(!isNumber(data)){
			Swal.fire({
				icon: 'error',
	            title: 'Oops...',
	  			text: 'Numeric values only!'
			});      
           
            input.value = "";
		}
	}

	function loadActivityInfo(id){
		// filter through activities array to return one with passed id
		const obj = activities.find(o => o.ACTIVITY_ID == id);
		const activityID = document.querySelector('#updateActivityID');
		activityID.value = id;
		const activityName = document.querySelector('#updateActivityName');
		activityName.innerHTML = obj.NAME;
		const activityDetails = document.querySelector('#updateActivityDetails');

		// Splitting DETAILS with '.' and then showing each line with <li>
		const detailsArr = obj.DETAILS.split('.');
		let html = `<ul>`;

		for (let i = 0;i < detailsArr.length; i++) {
			if (detailsArr[i] != "") {
				// let newDetails = detailsArr[i].trim();
				html += `<li>${detailsArr[i].trim()}</li>`;
			}
		}
		html += `</ul>`;		
		activityDetails.innerHTML = html;

		$("#updateActivityStatus").val(obj.STATUS).trigger('change');
	}

	function closeProject(project_id){
		Swal.fire({
			title: 'Are you sure?',
			text: 'Do you really want to close this project?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, close project'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: "post",
					url: "../projects/actions",
					data:{
						"closeProject":"1",
						"id": project_id
					},
					success:function(data){
						if (data == 'closed') {
							Swal.fire(
						      'Closed!',
						      'Project Successfully closed',
						      'success'
						    )
							window.location.href = "../projects";

						}
					}
				});
			}
		});


		
	}


	function deleteActivities(){
		const selectedFields = document.getElementsByClassName('selected');
		// Check if there are selected rows
		  	if (selectedFields.length == 0) {
  				Swal.fire({
					icon: 'error',
		            title: 'Oops...',
		  			text: 'Please select activity/activities to delete'
				}); 
  			} else {
				Swal.fire({
				  title: 'Are you sure?',
				  text: "Do you want to delete selected Activity?",
				  icon: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Yes, delete selected!'
				}).then((result) => {
				  if (result.value) {
				  	let idsToDelete = "";
			  		Object.keys(selectedFields).forEach(function(key){
			  			idsToDelete += `${selectedFields[key].id},`;	  			
			  		});

			  		console.log(idsToDelete);

			  		$.ajax({
			  			type: "post",
			  			url: "../projects/actions",
			  			data: {
			  				"deleteActivities" : "1",
			  				"ids" : idsToDelete
			  			},
			  			success: function(data){
			  				
			  				if (data == 'deleted') {
			  					Swal.fire(
							      'Deleted!',
							      'Selected activity/activities has been deleted.',
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
				})
			 
			}
		  		
		  		
  	}	

	  	

</script>

				