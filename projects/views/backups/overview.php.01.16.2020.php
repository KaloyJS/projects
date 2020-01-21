<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 

  if(isset($project)){
    $project['ASSIGNEE_NAME'] = getAssigneeName($project['ASSIGNEE']);
    $project['STATUS_LABEL'] = get_color_by_status($project['STATUS']); 
    $project['PRIORITY_LABEL'] = get_color_by_priority($project['PRIORITY']);
    $project['PROGRESSBAR_BG'] = progressBar($project['PROGRESS']);
  }

  
  prints($project);
  
 ?>

<style type="text/css">
 .container2 {
    width: 98%;
    padding-right: 15px;
    padding-left: 15px;
    /*margin-right: auto;
    margin-left: auto;*/
  }

  .border {
    border: 1px solid #f4f4f4;
  }

  hr {
    border: 0;
    height: 1px;
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0.10), rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.10));
  }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <!-- Main content -->
    <?php if(isset($_POST['status'])){ ?>
        <div id="file_updated_box">
            <div class="alert <?php echo ($_POST['status']=="success") ? " alert-success " : " alert-danger "; ?> alert-dismissible file_updated">
              <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
              <h4><i class="icon fa <?php echo ($_POST['status']=="success") ? " fa-check" : " fa-ban"; ?>"></i> <?php echo $_POST['msg']; ?></h4>
            </div>
        </div>
     <?php } ?>
    <!-- /.content -->


<!-- Main content -->
  <section class="content">
    <div class="container2">
      <div class="invoice">
        <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                PROJECT DETAILS <button type="button" class="btn btn-box-tool edit-modal-btn"   data-id="<?php echo $project['ID']; ?>" id="<?php echo $project['ID']; ?>" data-toggle="tooltip" title="edit/update project"><i class="fa fa-edit"></i></button>
                <a href="actions.php?deleteProject=<?php echo $project['ID']; ?>" data-toggle="tooltip" title="delete project"><i class="fa fa-eraser"></i></a>
                <small class="pull-right"><?php echo convertDate($project['CREATED_ON']); ?></small>
              </h2>
            </div>
            <!-- /.col -->
          </div>
      <!-- info row -->
        <div class="row">
        
         
          <div class="col-md-12">
            
           
              <div class="box-header with-border">
                <h3 class="box-title">Project Name: <strong><?php echo $project['PROJECTNAME']; ?></strong></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <h4 >Status: <span class="label <?php echo $project['STATUS_LABEL']; ?>"> <?php echo $project['STATUS'] ?></span></h4> 
                
                <hr>

                <h4>Assigned To: <strong><?php echo  ucwords(strtolower($project['ASSIGNEE_NAME'][0]['PRENOM']))." ". ucwords(strtolower($project['ASSIGNEE_NAME'][0]['NOM']))  ?></strong></h4>           

                <hr>

                <h4>Priority: <span class="label <?php echo $project['PRIORITY_LABEL']['priority_label']; ?>"><?php echo $project['PRIORITY']." ".$project['PRIORITY_LABEL']['arrow']; ?></span></h4>         

                <hr>              

                <h4>Scope:</h4>

                <p><em><?php echo $project['SCOPE']; ?></em></p>
              </div>
              <!-- /.box-body -->
          </div>
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-md-12">
            <div class="panel with-nav-tabs panel-default">
              <div class="panel-heading">
                  <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab1default" data-toggle="tab">Overview</a></li>
                      <li><a href="#tab2default" data-toggle="tab">Activities</a></li>
                     <!--  <li><a href="#tab3default" data-toggle="tab">Work packages</a></li> -->                     
                  </ul>
              </div>
              <div class="panel-body">
                <div class="tab-content">
                  <div class="tab-pane fade in active" id="tab1default">
                    <div class="row">
                      <div class="col-md-12">
                         <table class="table table-bordered table-striped">
                          <thead> 
                              <tr class="table">
                                  <th scope="col">Today date</td>
                                  <th scope="col">Deadline</td>
                                  <th scope="col">Time left</td>
                                  
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <td><?php echo convertDate(date("Y/m/d")); ?></td>
                                  <td><?php echo convertDate($project['END_DATE']); ?></td>
                                  <?php $date_diff = date_difference($date_today, $project['END_DATE']); ?>

                                  <?php if($project['STATUS'] === 'Completed'): ?>
                                    <td><span class="label <?php echo $project['STATUS_LABEL']; ?>"> <?php echo $project['STATUS'] ?></span></td>
                                  <?php else: ?>
                                    <td><span class="<?php echo $date_diff['text-color']; ?>"><?php echo $date_diff['days'];   ?> days</span></td>
                                  <?php endif; ?>

                                                                               
                              </tr>
                          </tbody>
                        </table>
                      </div>
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-md-12">
                            <label>Completion Percentage :</label>
                            <div class="progress">
                                <div class="progress-bar <?php echo $project['PROGRESSBAR_BG']; ?>" role="progressbar" style="width: <?php echo $project['PROGRESS']; ?>%;" aria-valuenow="<?php echo $project['PROGRESS']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $project['PROGRESS']; ?>%</div>
                            </div>
                        </div>
                    </div>

                  </div>
                  <div class="tab-pane fade" id="tab2default">Default 2</div>
                  <!-- <div class="tab-pane fade" id="tab3default">Default 3</div> -->
                </div>
              </div>

            </div>
          </div>
        </div>




      </div>
    </div>
  </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->



<script>

</script>