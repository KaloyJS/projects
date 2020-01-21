<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<?php
// prints($details);
?>
<h1>
BRS
<small>Control panel</small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">BRS</li>
</ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Small boxes (Stat box) -->

<!-- /.row -->
<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-12 col-md-12 connectedSortable">
   
 
    <!-- TO DO List -->
    <div class="box box-primary">
      <div class="box-header">
        <i class="ion ion-clipboard"></i>
        <h3 class="box-title">BRS</h3>
        <div class="box-tools pull-right">
          <ul class="pagination pagination-sm inline">
         
          </ul>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
     
					
					<table id="datatable_report" class='table table-striped table-bordered '>
						<thead>
							<tr>
								<th>SERIALNUMBER</th>
								<th>MODEL</th>
								<th>DESCRIPTION</th>
								<th>STORECODE</th>
								<th>INBOUND_WAYBILL</th>
								<th>CREATED_ON</th>
								<th>CREATED_BY</th>
								<th>Actions</th>
								
								
							  
							</tr>
						</thead>
						<tbody>
						<?php      
						if(isset($details) && count($details) > 0){ 
							foreach($details as $device){
							
						$frntimg =	explode('BRS',$device['FRONT_IMAGE_FULL_PATH']);
						$backimg =	explode('BRS',$device['BACK_IMAGE_FULL_PATH']);
							echo"<tr><td>".$device['SERIALNUMBER']."</td>";
							echo"<td>".$device['DEVICE_MODEL']."</td>";
							echo"<td>".$device['DESCRIPTION']."</td>";
							echo"<td>".$device['STORECODE']."</td>";
							echo"<td>".$device['INBOUND_WAYBILL']."</td>";
							echo"<td>".$device['COSMETIC_GRADE']."</td>";
							echo"<td>".$device['CREATED_ON']."</td>";
							echo"<td>".$device['CREATED_BY']."</td>";
						
							
							echo"<td><span class='pull-left' style='margin:17px;'><a href='".base_url()."brs/editdetails/".$device['BRS_ID']."' class='btn btn-primary'>Edit</a>    <a onclick=\"viewpic('".$frntimg[1]."','".$backimg[1]."')\" ><img src='".base_url()."/assets/backend/AdminLTE/dist/img/view.png' class='' name=''  height='30px' width='30px' title='Show File'/ ></a></span> </td></tr>";
							
							}
						}
						 ?>
						</tbody>

					</table>
			
      </div>

      <!-- /.box-body -->
      <div class="box-footer clearfix no-border">
	

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
    <!-- /.box -->
  
  </section>
  <!-- /.Left col -->
  <!-- right col (We are only adding the ID to make the widgets sortable)-->
  
  <!-- right col -->
</div>
<!-- /.row (main row) -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<style>
.switchbtn {
  display: block;
  opacity: 0;
}
.switchbtn ~ label {
  width: 60px;
  height: 30px;
  cursor: pointer;
  display: inline-block;
  position: relative;
  background: rgb(189, 189, 189);
  border-radius: 30px;
  
  transition: background-color 0.4s;
  -moz-transition: background-color 0.4s;
  -webkit-transition: background-color 0.4s;
}
.switchbtn ~ label:after {
  left: 0;
  width: 20px;
  height: 20px;
  margin: 5px;
  content: '';
  position: absolute;
  background: #FFF;
  border-radius: 10px;
}
.switchbtn:checked + label {
  background: rgb(39, 173, 95);
}
.switchbtn:checked + label:after {
  left: auto;
  right: 0;
}

.switchbtn ~ p {
  font: normal 8px/40px Arial;
  color: rgb(189, 189, 189);
  display: none;
  text-transform: uppercase;
  letter-spacing: 1px;
}
.switchbtn:checked ~ p:nth-of-type(1) {
  color: rgb(39, 173, 95);
  display: block;
}
.switchbtn:not(:checked) ~ p:nth-of-type(2) {
  display: block;
}
</style>

<script>
$(document).ready(function() {
    $('#datatable_report').DataTable( {
        "order": [[ 3, "desc" ]]
    } );
} );

function viewpic(path1,path2){
	// $( "#showfile" ).dialog( "open" );	
	$('#showpic').modal('show');
// $('#myModal').modal('hide');
	$("#modalbody").html("<img src='<?=base_url();?>uploads/BRS/"+path1+"' width='100%'   style='border: none;'/ ><br/><br/><img src='<?=base_url();?>uploads/BRS/"+path2+"' width='100%'   style='border: none;'/ >");
	
}

function check(id){
	// alert(id);
	var idval = $('#checkbox'+id).prop('checked');
	var approved = '';
	// alert(idval);
				if(idval == true){
					approved ='YES';
				}else{
					approved = 'NO';
					
				}
			

				$.ajax({
				type:"post",
				url:"<?php echo base_url();?>setapproved",
				data:'projectapproved='+approved+'&boxid='+id,
				dataType:"json",
				success:function(data)
				{		
				// console.log(data);
				// alert(data);
					window.location.reload();
				
		
				}
					
					
				
				});	
}
</script>