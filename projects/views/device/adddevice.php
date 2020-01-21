<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">

<h1>
BRS Management
<small>Control panel</small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">BRS Management</li>
</ol>
</section>
<!-- Main content -->
<section class="content">
	
		<div class="row">
			<div class="col-md-12 col-lg-12">
		  <?php if(isset($_POST['status'])){ ?>
					<div id="file_updated_box">
							<div class="alert <?php echo ($_POST['status']=="success") ? " alert-success " : " alert-danger "; ?> alert-dismissible file_updated">
								<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								<h4><i class="icon fa <?php echo ($_POST['status']=="success") ? " fa-check" : " fa-ban"; ?>"></i> <?php echo $_POST['msg']; ?></h4>
							</div>
					</div>
					
					<?php
					
			}

?>
			</div>
	
		</div>
		<div class="row">

			<section class="col-lg-6 col-md-6">
				<div class="box box-info">
				
					<div class="box-body">
					
				   <?php  echo  $this->session->flashdata('error'); ?>
					<form id="addprojectform" action="<?php echo base_url();?>brs/savedetails" method="post" class="form-horizontal" enctype="multipart/form-data">
					
						<div class="col-md-12">
							<div  class="form-group">
									<label for="username">Serial Number</label>
									<input type="text" class="form-control" name="sn" required value="" id="sn"/>
							</div>
							<div  class="form-group">
									<label for="username">Model</label>
									
									<select required class="form-control select2" id="model" name="model"  data-placeholder="Select.." required >
									<option value=''>--</option>
									<option value='HH 2000'>HH 2000</option>
									<option value='HH 3000'>HH 3000</option>
									</select>
							</div>
							<div  class="form-group">
									<label for="username">Store Code</label>
									<input type="text" class="form-control" name="str_code" required value="" id="str_code"/>
							</div>
							<div  class="form-group">
									<label for="username">Inbound Waybill </label>
									<input type="text" class="form-control" name="waybill" required value="" id="waybill"/>
							</div>
							<div  class="form-group">
									<label for="username">Cosmetic Grading</label>
									<select required class="form-control select2" id="cgrade" name="cgrade"  data-placeholder="Select.." required >
									<option value=''>--</option>
									<option value='A'>A</option>
									<option value='B'>B</option>
									<option value='C'>C</option>
									<option value='D'>D</option>
									</select>
							</div>
							<div  class="form-group">
									<label for="username">Description </label>
									<textarea name="description" required id="description" rows="3" class="form-control"></textarea>
									
							</div>
							<div  class="form-group">
									<label for="username">Attach Device Front Image (jpg)</label>
									<input id="inputimg1" type="file" onchange="showimg1(this);" required accept=".jpg,.JPG,.png,.PNG,.jpeg,.JPEG" class="form-control" name="frontimage" size="50" />
									
							</div>
							
							<div  class="form-group">
									<label for="username">Attach Device Back Image (jpg)</label>
									<input id="inputimg2" type="file" onchange="showimg2(this);" required accept=".jpg,.JPG,.png,.PNG,.jpeg,.JPEG" class="form-control" name="backimage" size="50" />
									
							</div>
							
							
							<div  class="form-group">
							<div class="col-md-6">
							<input type="submit" class="btn btn-primary"  name="adddetails" value="Submit">
							
							</div>
							</div>
						
						</div>
					</form>
					
					
		
					
					
					
				
					</div>
				</div>
			</section>
			<section class="col-lg-6">
				<div style="min-height:80vh;"class="box box-info">
				
					<div class="box-body">
					
					<div id="img1">
					</div>
					<br/>
					<br/>
					<div id="img2">
					</div>
					
					
					</div>
				</div>
			</section>
		</div>
		<div id="showfile" title="">

		</div>
    </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
function showimg1(input){
	 if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
						$("#img1").html("<img style='width:200px;' src='"+e.target.result+"' alt='your image' />");
                  
                };

                reader.readAsDataURL(input.files[0]);
            }

	
}
   
function showimg2(input){
	if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#img2").html("<img style='width:200px;' src='"+e.target.result+"' alt='your image' />");
                };

                reader.readAsDataURL(input.files[0]);
            }
	
	
}
$(document).ready(function() {
    $('#datatable_report').DataTable( {
        "order": [[ 3, "desc" ]]
    } );
} );

function viewdoc(path){
	$( "#showfile" ).dialog( "open" );	
	$("#showfile").html("<iframe src='<?=base_url();?>assets/viewerjs/ViewerJS/#<?=base_url();?>"+path+"' width='100%' height='100%'  style='border: none;' allowfullscreen ></iframe>");
	
}
$(function() {
  $('input[name="startdate"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
	"minDate": "2019/01/01",
	locale: {
            format: 'YYYY/MM/DD'
        }
  });
    $('input[name="enddate"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
	"minDate": "2019/01/01",
	locale: {
		  format: 'YYYY/MM/DD'
        }
  });

});
</script>