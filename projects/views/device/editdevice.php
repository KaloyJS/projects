<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">

<h1>
Pallet Management
<small>Control panel</small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Pallet Management</li>
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
					
					   <?php  echo  $this->session->flashdata('error'); 
					   $detail = $details[0];
					   $frntimg =	explode('BRS',$detail['FRONT_IMAGE_FULL_PATH']);
						$backimg =	explode('BRS',$detail['BACK_IMAGE_FULL_PATH']);
					   ?>
					   <form id="addprojectform" action="<?php echo base_url();?>brs/updatedetails/<?=$detail['BRS_ID']?>" method="post" class="form-horizontal" enctype="multipart/form-data">
					
						<div class="col-md-12">
							<div  class="form-group">
									<label for="username">Serial Number</label>
									<input type="text" value="<?=$detail['SERIALNUMBER']?>" class="form-control" name="sn" required  id="sn"/>
							</div>
							<div  class="form-group">
									<label for="username">Model</label>
									
									<select required class="form-control select2" id="model" name="model"  data-placeholder="Select.." required >
									<option value=''>--</option>
									<option value='HH 2000' <?php if($detail['DEVICE_MODEL'] =='HH 2000'){echo "selected"; } ?>>HH 2000</option>
									<option value='HH 3000' <?php if($detail['DEVICE_MODEL'] =='HH 3000'){echo "selected"; } ?>>HH 3000</option>
									</select>
							</div>
							<div  class="form-group">
									<label for="username">Store Code</label>
									<input type="text" class="form-control" name="str_code" required value="<?=$detail['STORECODE']?>" id="str_code"/>
							</div>
							<div  class="form-group">
									<label for="username">Inbound Waybill </label>
									<input type="text" class="form-control" name="waybill" required value="<?=$detail['INBOUND_WAYBILL']?>" id="waybill"/>
							</div>
							<div  class="form-group">
									<label for="username">Cosmetic Grading</label>
									<select required class="form-control select2" id="cgrade" name="cgrade"  data-placeholder="Select.." required >
									<option value=''>--</option>
									<option value='A' <?php if($detail['COSMETIC_GRADE'] =='A'){echo "selected"; } ?>>A</option>
									<option value='B' <?php if($detail['COSMETIC_GRADE'] =='B'){echo "selected"; } ?>>B</option>
									<option value='C'<?php if($detail['COSMETIC_GRADE'] =='C'){echo "selected"; } ?> >C</option>
									<option value='D'<?php if($detail['COSMETIC_GRADE'] =='D'){echo "selected"; } ?> >D</option>
									</select>
							</div>
							<div  class="form-group">
									<label for="username">Description </label>
									<textarea name="description" required id="description" rows="3" class="form-control"><?=$detail['DESCRIPTION']?></textarea>
									
							</div>
							<div  class="form-group">
									<label for="username">Attach Device Front Image (jpg)</label>
									<input id="inputimg1" type="file" onchange="showimg1(this);"  accept=".jpg,.JPG,.png,.PNG,.jpeg,.JPEG" class="form-control" name="frontimage" size="50" />
									
							</div>
							
							<div  class="form-group">
									<label for="username">Attach Device Back Image (jpg)</label>
									<input id="inputimg2" type="file" onchange="showimg2(this);"  accept=".jpg,.JPG,.png,.PNG,.jpeg,.JPEG" class="form-control" name="backimage" size="50" />
									
							</div>
							<div  class="form-group">
								<label for="username">View Current Images</label><br/>
							<?php echo "<a onclick=\"viewpic('".$frntimg[1]."','".$backimg[1]."')\" ><img src='".base_url()."/assets/backend/AdminLTE/dist/img/view.png' class='' name=''  height='30px' width='30px' title='Show File'/ ></a>";
									?>
									
								</div>
							
							<div  class="form-group">
							<div class="col-md-6">
							<input type="submit" class="btn btn-primary"  name="adddetails" value="Update">
							
							</div>
							</div>
						
						</div>
					</form>
					<!-- Modal -->
<div id="showpic" class="modal fade" role="dialog">
  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Device Images</h4>
					  </div>
					  <div id="modalbody"class="modal-body">

					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
					</div>

				  </div>
				</div>
					
				
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

function viewpic(path1,path2){
	// $( "#showfile" ).dialog( "open" );	
	$('#showpic').modal('show');
// $('#myModal').modal('hide');
	$("#modalbody").html("<img src='<?=base_url();?>uploads/BRS/"+path1+"' width='100%'   style='border: none;'/ ><br/><br/><img src='<?=base_url();?>uploads/BRS/"+path2+"' width='100%'   style='border: none;'/ >");
	
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