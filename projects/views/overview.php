<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 

  if(isset($project)){
    // Get assignee name from badge
    $project[0]->ASSIGNEE_NAME = getAssigneeName($project[0]->ASSIGNEE);
    $project[0]->STATUS_LABEL = get_color_by_status($project[0]->STATUS); 
    $project[0]->PRIORITY_LABEL = get_color_by_priority($project[0]->PRIORITY);
    $project[0]->PROGRESSBAR_BG = progressBar($project[0]->PROGRESS);
    if(!empty($project[0]->DAYS_NEEDED)){
      $projected_days = date_difference($project[0]->START_DATE, $project[0]->DEADLINE);
      $days_needed_difference = $project[0]->DAYS_NEEDED - $projected_days['days'] ;
    }
    
  }
  
  $export_activities = json_encode($activities);

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

  .project-details {
    margin-left: 10px;
  }

  .scope {
    font-size: 18px;
  }

  #overviewTable {
    
  }

  .progress-bar {
    color: black;
  }

  .modal-close-btn {
    margin-bottom: 0 !important;
  }

</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <br>
<!-- Content Header (Page header) -->
  <!-- Main content -->
    <?php if(isset($_POST['status'])){ ?>
        <div class="container2">
          <div id="file_updated_box">
              <div class="alert <?php echo ($_POST['status']=="success") ? " alert-success " : " alert-danger "; ?> alert-dismissible file_updated">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="icon fa <?php echo ($_POST['status']=="success") ? " fa-check" : " fa-ban"; ?>"></i> <?php echo $_POST['msg']; ?></h4>
              </div>
          </div>
        </div>
     <?php } ?>
    <!-- /.content -->


<!-- Main content -->
  <section class="content">
    <div class="container2">
      <div class="panel panel-default">
        <div class="invoice">
          <!-- title row -->
            <div class="row">
              <div class="col-xs-12">
                <h2 class="page-header">
                  PROJECT DETAILS
                  <button type="button" class="btn3d btn btn-info btn-sm" data-toggle="modal" data-target="#updateProject"><span class="fa fa-edit"></span> Update</button>
                  
                  <button type="button" class="btn3d btn btn-info btn-sm" data-toggle="modal" data-target="#addNewActivity"><span class="fa fa-plus"></span> Activity</button>
                  <button type="button" class="btn3d btn btn-info btn-sm" onclick="closeProject('<?php echo $project[0]->PROJECT_ID; ?>');"><span class="fa fa-times" ></span> Close</button>

                  
                  <small class="pull-right"><?php echo convertDate($project[0]->CREATED_ON); ?></small>
                </h2>
              </div>
              <!-- /.col -->
            </div>
        <!-- info row -->
          <div class="row">
          
           
            <div class="col-md-12">
              
             
                <div class="box-header with-border">
                  <h3 class="box-title">Project Name: <strong><span class="project-details"><?php echo $project[0]->PROJECT_NAME; ?></span></strong></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <h4 >Status: <span class="project-details label <?php echo $project[0]->STATUS_LABEL; ?>"> <?php echo ucwords($project[0]->STATUS); ?></span></h4> 
                  
                  <hr>

                  <h4>Assigned To: <strong><span class="project-details"><?php echo  ucwords(strtolower($project[0]->ASSIGNEE_NAME->FIRST_NAME))." ". ucwords(strtolower($project[0]->ASSIGNEE_NAME->LAST_NAME))  ?></span></strong></h4>           

                  <hr>

                  <h4>Priority: <span class="project-details label <?php echo $project[0]->PRIORITY_LABEL->PRIORITY_LABEL; ?>"><?php echo $project[0]->PRIORITY.$project[0]->PRIORITY_LABEL->ARROW; ?></span></h4>         

                  <hr>              

                  <h4>Scope:</h4>

                  <p class="scope"><em><?php echo $project[0]->SCOPE; ?></em></p>
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
                           <table class="table table-bordered table-striped" id="overviewTable">
                            <thead> 
                                <tr class="table">
                                    <th scope="col">Today date</td>
                                    <th scope="col">Deadline</td>
                                    <th scope="col">Days left</td>
                                    <th scope="col">Days Needed</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo convertDate(date("Y/m/d")); ?></td>
                                    <td><?php echo convertDate($project[0]->DEADLINE); ?></td>
                                    <?php $date_diff = date_difference(date("Y/m/d"), $project[0]->DEADLINE); ?>

                                    <?php if($project['STATUS'] === 'Completed'): ?>
                                      <td><span class="label <?php echo $project['STATUS_LABEL']; ?>"> <?php echo $project->STATUS ?></span></td>
                                    <?php else: ?>
                                      <td><span class="<?php echo $date_diff['text-color']; ?>"><?php echo $date_diff['days'];   ?> day(s)</span></td>
                                    <?php endif; ?>
                                    <td>
                                      <?php if(!empty($project[0]->DAYS_NEEDED)): ?>
                                        <?php echo $project[0]->DAYS_NEEDED; ?> days <span class="badge badge-pill bg-green"><?php echo $days_needed_difference; ?>d</span>
                                      <?php endif; ?>
                                    </td>                                                                             
                                </tr>
                            </tbody>
                          </table>
                        </div>
                      </div> <!-- end row -->

                      <div class="row">
                          <div class="col-md-12">
                              <label>Completion Percentage :</label>
                              <div class="progress active">                              
                                  <div class="progress-bar <?php echo $project[0]->PROGRESSBAR_BG; ?>" role="progressbar" style="width: <?php echo $project[0]->PROGRESS; ?>%;" aria-valuenow="<?php echo $project[0]->PROGRESS; ?>" aria-valuemin="0" aria-valuemax="100" ><?php echo $project[0]->PROGRESS; ?>%</div>
                              </div>
                          </div>
                      </div>

                    </div>
                    <div class="tab-pane fade" id="tab2default">
                      <button type="button" class="btn3d btn btn-info btn-sm" onclick="deleteActivities();"><span class="fa fa-times"></span> Delete Selected</button>
                      <table class="table table-filter table-striped table-bordered table-hover" id="activitiesTable">
                          <thead>
                              <tr>
                                  <th scope="col" style="width: 32px;"></th>
                                  <th scope="col">#</th>
                                  <th scope="col">Name</th>
                                  <th scope="col">Details</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php if(count($activities) < 1) : ?> 
                              <tr>
                                <td>No Activities found</td>
                              </tr> 
                            <?php else: ?>
                              <?php $ctr = 1; ?>
                              <?php foreach($activities as $activity) : ?>
                                <tr id="<?php echo $activity->ACTIVITY_ID; ?>">
                                  <td>
                                    <div class="ckbox "  >
                                      <input type="checkbox" id="checkbox<?php echo $ctr; ?>">
                                      <label for="checkbox<?php echo $ctr; ?>"></label>
                                    </div>
                                  </td>
                                  <td scope="row">
                                    <strong><?php echo $ctr; ?></strong></td>
                                  <td>
                                    <?php echo $activity->NAME; ?>
                                  </td>
                                  <td>
                                    <?php echo substr($activity->DETAILS, 0, 50) . "..."; ?>
                                  </td>
                                  <td>
                                    <?php $color = getActivityStatusColor($activity->STATUS); ?>
                                    <span class="badge badge-pill <?php echo $color; ?>"><?php echo $activity->STATUS ?></span>
                                  </td>
                                  <td>
                                    <button class="btn btn-link btn-sm" data-activity-id="<?php echo $activity->ACTIVITY_ID; ?>" data-toggle="modal" data-target="#updateActivity" onclick="loadActivityInfo('<?php echo $activity->ACTIVITY_ID; ?>');">Update status</button>
                                  </td>          
                                </tr> 
                                <?php $ctr++; ?>                          
                              <?php endforeach; ?>
                            <?php endif; ?> 
                          </tbody>
                      </table>
                    </div>
                    <!-- <div class="tab-pane fade" id="tab3default">Default 3</div> -->
                  </div>
                </div>

              </div>
            </div>
          </div>




        </div>
      </div>
    </div>
  </section>

  <!-- Modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="updateProject">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h2 class="modal-title" id="myModalLabel">UPDATE PROJECT DETAILS</h2>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" action="<?php echo base_url(); ?>projects/actions" method="post" autocomplete="off">
            <div class="form-group">
              <div class="col-sm-12">
                <label class="col-sm-2">PROJECT NAME:</label>
                <div class="col-sm-10">           
     
                <input class="form-control" type="text" name="project_name" id="project_name" value="<?php echo $project[0]->PROJECT_NAME; ?>" required>
                <input type="hidden" name="project_id" id="project_id" value="<?php echo $project[0]->PROJECT_ID; ?>">


                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <label for="inputEmail3" class="col-sm-2">PROJECT ASSIGNEE:</label>
                <div class="col-sm-10">
                <select class="form-control select" type="text"  name="assignee" id="assignee" style="width: 100%;"  data-placeholder="SELECT TEAM MEMBER" required>
                  <option></option>
                  <?php foreach($assigneeList as $assignee) : ?>
                    <?php if($assignee['BADGE'] === $project[0]->ASSIGNEE) : ?>
                      <option value="<?php echo $assignee['BADGE']; ?>" selected><?php echo $assignee['FIRST_NAME']." ".$assignee['LAST_NAME']; ?></option>
                    <?php else : ?>
                      <option value="<?php echo $assignee['BADGE']; ?>"><?php echo $assignee['FIRST_NAME']." ".$assignee['LAST_NAME']; ?></option>
                    <?php endif; ?>           
                    
                  <?php endforeach; ?>
                </select>
                </div>
              </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2"> PROJECTED START DATE:</label>
              <div class="col-sm-10">
                <div class="input-group date">
                  <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right dp" id="start_date" name="start_date" type="text" required value="<?php echo $project[0]->START_DATE ?>">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2"> PROJECTED DEADLINE:</label>
              <div class="col-sm-10">
                <div class="input-group date">
                  <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right dp" id="deadline" name="deadline" type="text" required value="<?php echo $project[0]->DEADLINE; ?>">
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">PROGRESS (percentage):</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" min="0" max="100" step="1" name="progress" id="progress" value="<?php echo $project[0]->PROGRESS; ?>" onkeyup="checkIfNumeric('#progress')" required>
              </div>
            </div>
          </div> 

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">DAYS NEEDED:</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" min="0" max="100" step="1" name="days_needed" id="days_needed" value="<?php echo $project[0]->DAYS_NEEDED; ?>" onkeyup="checkIfNumeric('#days_needed')">
              </div>
            </div>
          </div> 
          

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">PROJECT SCOPE:</label>
              <div class="col-sm-10">
              <textarea required rows="3" cols="20" class="form-control" name="scope" id="scope" /><?php echo $project[0]->SCOPE; ?></textarea>    
              
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">STATUS:</label>
              <div class="col-sm-10">
                <select style="width: 100%;" class="form-control select" name="status" id="status" required>
                  <option></option>
                  <?php $statusArr = ['created', 'in progress', 'completed', 'closed', 'on hold']; ?>
                  <?php foreach($statusArr as $status) : ?>
                    <?php if($status === $project[0]->STATUS) : ?>
                      <option value="<?php echo $status; ?>" selected><?php echo ucwords($status); ?></option>
                    <?php else: ?>
                      <option value="<?php echo $status; ?>"><?php echo ucwords($status); ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div> 

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">PRIORITY:</label>
              <div class="col-sm-10">
                <select style="width: 100%;" class="form-control select" name="priority" id="priority" required>
                  <option></option>
                  <?php $priorityArr = ['low','medium','high']; ?>
                  <?php foreach($priorityArr as $priority) : ?>
                    <?php if($project[0]->PRIORITY === $priority) : ?>
                      <option value="<?php echo $priority ?>" selected><?php echo ucwords($priority); ?></option>
                    <?php else: ?>
                      <option value="<?php echo $priority ?>" ><?php echo ucwords($priority); ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>        

        </div>
        <div class="modal-footer">
          <button type="button" class="btn3d btn btn-default modal-close-btn" data-dismiss="modal">Close</button>
          <button type="submit" class="btn3d btn btn-info" name="updateProject">Update</button>
        </div>
       </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  <!-- Modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="addNewActivity">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h2 class="modal-title" id="addActivityModalLabel">Add New Activity</h2>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" action="<?php echo base_url(); ?>projects/actions" method="post" autocomplete="off">

            <div class="form-group">
              <div class="col-sm-12">
                <label class="col-sm-2">ACTIVITY NAME:</label>
                <div class="col-sm-10">
                  <input class="form-control" type="text" name="name" id="name" required>
                  <input type="hidden" name="project_id" value="<?php echo $project[0]->PROJECT_ID; ?>">
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-sm-12">
                <label class="col-sm-2">DETAILS:</label>
                <div class="col-sm-10">
                  <textarea required rows="3" cols="20" class="form-control" name="details" id="details" required/>
              
                  </textarea>
                </div>
              </div>
            </div> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn3d btn btn-default modal-close-btn" data-dismiss="modal">Close</button>
          <button type="submit" class="btn3d btn btn-info" name="addNewActivity">Add Activity</button>
        </div>
       </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  <!-- Modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="updateActivity">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h2 class="modal-title" id="addActivityModalLabel">Update Activity</h2>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" action="<?php echo base_url(); ?>projects/actions" method="post" autocomplete="off">

           <div class="box-body">
              <dl>
                <dt>Activity Name</dt>
                <dd id="updateActivityName"></dd>
                <dt>Details</dt>
                <dd id="updateActivityDetails"></dd>                            
              </dl>
            </div>
            <input type="hidden" name="activity_id" id="updateActivityID" readonly>
            <input type="hidden" name="project_id" value="<?php echo $project[0]->PROJECT_ID; ?>" readonly>
            <div class="form-group">
              <div class="col-sm-12">
                <label class="col-sm-2">STATUS:</label>
                <div class="col-sm-10">
                  <select style="width: 100%;" class="form-control select" name="status" id="updateActivityStatus" required>
                    <option></option>
                    <?php $statusArr = ['to do','work in progress','completed']; ?>
                    <?php foreach($statusArr as $status) : ?>
                      <option value="<?php echo $status ?>" ><?php echo ucwords($status); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>     
        </div>
        <div class="modal-footer">
          <button type="button" class="btn3d btn btn-default modal-close-btn" data-dismiss="modal">Close</button>
          <button type="submit" class="btn3d btn btn-info" name="updateActivity">Update</button>
        </div>
       </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

<!-- /.content -->
</div>
<!-- /.content-wrapper -->



<script>
  const activities = JSON.parse('<?php echo $export_activities ?>'); //Importing php array of objects to javascript
</script>