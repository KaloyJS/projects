<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
  
 ?>


 <style type="text/css">
  #searchTable {
    /*background: url('<?php echo base_url(); ?>assets/frontend/projects/img/searchicon.png') !important;*/
    background: url('<?php echo base_url(); ?>assets/frontend/projects/img/searchicon.png');
    background-size: 21px 21px;
    background-position: 5px 5px;
    background-repeat: no-repeat;
    width: 200px;
    margin-bottom: 10px;
    font-size: 16px;
    padding: 12px 20px 12px 40px;
    border: 1px solid #ddd;
  }

  .select2 {
    width: 100%;
  }

  .datepicker {
    z-index:1151 !important;
  }

  .modal-close-btn {
    margin-bottom: 0 !important;
  }
 </style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<br>
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
    <?php if(isset($_SESSION['error'])) : ?>
      <div id="file_updated_box">
            <div class="alert alert-warning alert-dismissible file_updated">
              <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
              <h4><i class="icon fa fa-ban"></i> <?php  echo  $this->session->flashdata('error');?></h4>
            </div>
        </div>
    <?php endif; ?>        

<div class="container2">
  <section class="content-header"> 
    <br>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sbe Projects</li>
      </ol>
  </section>
</div>
<!-- Main content -->
  <section class="content">
    
    <div class="row">

        <div class="col-md-12 connectedSortable">
          <div class="col-md-12 container2">
            <div class="panel panel-default">
              <div class="panel-body">
                 <h3>Project List</h3>
                 <input class="form-control input-sm datepicker" type="text" id="searchTable" onkeyup="searchTable()" placeholder="Search projects.." title="Type in a name">
                 <a class="btn3d btn icon-btn btn-info" href="#" data-toggle="modal" data-target="#addNewProject"><span class="glyphicon glyphicon-plus"></span>Add Project</a>
                 <button class="btn3d btn icon-btn btn-info" onclick="deleteProject();"><i class="glyphicon btn-glyphicon glyphicon-erase"></i> Delete Selected</button>
                 
                 <div class="pull-right">
                  <div class="btn-group">
                      <button type="button" class="btn btn-default btn-filter" data-target="all">All Projects</button>
                    <button type="button" class="btn btn-success btn-filter" data-target="current">On Going Projects</button>
                    <button type="button" class="btn btn-warning btn-filter" data-target="completed">Completed Projects</button>
                    <button type="button" class="btn btn-danger btn-filter" data-target="closed">Closed Projects</button>
                    
                  </div>
                </div>

                <div class="table-container">
                  <table class="table table-filter " id="projectsTable">
                    <tbody>
                      <?php if(count($projects) < 1): ?>
                        <tr>
                          <td>No Projects found</td>
                        </tr>
                      <?php else: ?> 
                        <?php $ctr = "1"; ?>                      
                        <?php foreach($projects as $project): ?>

                          <?php if(strtolower($project['STATUS']) === 'created' || strtolower($project['STATUS']) === 'in progress' || strtolower($project['STATUS']) === 'on hold' ): ?>
                              <?php $category = 'current'; ?>
                          <?php elseif(strtolower($project['STATUS']) === 'completed'): ?>
                              <?php $category = 'completed'; ?>
                          <?php elseif(strtolower($project['STATUS']) === 'closed'): ?>
                              <?php $category = 'closed'; ?>
                          <?php endif; ?> 

                          <?php if($project['PRIORITY'] == 'high') : ?> 
                            <?php $priorityLabel = "text-red"; ?>
                            <?php $priorityArrow = "<i class='fa fa-fw fa-long-arrow-up'></i>"; ?> 
                          <?php elseif($project['PRIORITY'] == 'medium') : ?>
                            <?php $priorityLabel = "text-yellow"; ?>
                            <?php $priorityArrow = "<i class='fa fa-fw fa-long-arrow-down'></i>"; ?> 
                          <?php else : ?>
                            <?php $priorityLabel = "text-aqua"; ?>
                            <?php $priorityArrow = "<i class='fa fa-fw fa-long-arrow-down'></i>"; ?>
                          <?php endif; ?>

                          <tr data-status="<?php echo $category; ?>" id="<?php echo $project['PROJECT_ID']; ?>"  data-toggle='tooltip' title = "test" data-original-title = "test2" data-project-id = "<?php echo $project['PROJECT_ID']; ?>">
                            <td>
                              <div class="ckbox "  >
                                <input type="checkbox" id="checkbox<?php echo $ctr; ?>">
                                <label for="checkbox<?php echo $ctr; ?>"></label>
                              </div>
                            </td>
                            <!-- <td>
                              <a href="javascript:;" class="star">
                                <i class="glyphicon glyphicon-star"></i>
                              </a>
                            </td> -->
                            <td style="width: 80px;">
                              <span  class="label <?php echo $priorityLabel; ?>"><?php echo $project['PRIORITY']." ".$priorityArrow; ?></span>
                            </td>
                            <td>
                              <div class="media">
                                
                                <div class="media-body">
                                  <?php $new_date = convertDate($project['CREATED_ON']); ?>
                                  <span class="media-meta pull-right"><?php echo $new_date; ?></span>
                                  <h4 class="title project-title">
                                   <a href="<?php echo base_url(); ?>projects/overview/<?php echo $project['PROJECT_ID']; ?>"><?php echo $project['PROJECT_NAME'] ?></a> 
                                    <span class="pull-right <?php echo $category; ?>"><?php echo ucwords($project['STATUS']); ?></span>
                                  </h4>
                                  <p class="summary"><?php echo substr($project['SCOPE'], 0, 50); ?>...</p>
                                </div>
                              </div>
                            </td>
                          </tr>
                          </a>  
                          <?php $ctr++; ?>
                        <?php endforeach; ?>          
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

    </div>  <!-- row --> 



  </section>
  <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addNewProject">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><strong>+ ADD NEW PROJECT</strong></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="<?php echo base_url(); ?>projects/actions" method="post" autocomplete="off">
          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">PROJECT NAME:</label>
              <div class="col-sm-10">           
   
              <input class="form-control" type="text" name="project_name" id="project_name" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <label for="inputEmail3" class="col-sm-2">PROJECT ASSIGNEE:</label>
              <div class="col-sm-10">
              <select class="form-control select2" type="text"  name="assignee" id="assignee" style="width: 100%;"  data-placeholder="SELECT TEAM MEMBER" required>
                <option></option>
                <?php foreach($assigneeList as $assignee) : ?>              
                  <option value="<?php echo $assignee['BADGE']; ?>"><?php echo $assignee['FIRST_NAME']." ".$assignee['LAST_NAME']; ?></option>
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
                <input class="form-control pull-right datepicker" id="start_date" name="start_date" type="text" required>
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
                <input class="form-control pull-right datepicker" id="deadline" name="deadline" type="text" required>
              </div>
            </div>
          </div>
        </div>
        

        <div class="form-group">
          <div class="col-sm-12">
            <label class="col-sm-2">PROJECT SCOPE:</label>
            <div class="col-sm-10">
            <textarea required rows="3" cols="20" class="form-control" name="scope" id="scope" required/>
              
            </textarea>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-12">
            <label class="col-sm-2">PRIORITY:</label>
            <div class="col-sm-10">
              <select class="form-control" name="priority" id="priority" required>
                <option></option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
            </div>
          </div>
        </div>        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn3d btn btn-default modal-close-btn" data-dismiss="modal">Close</button>
        <button type="submit" class="btn3d btn btn-info" name="addNewProject">Add New Project</button>
      </div>
     </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->







<!-- /.content -->
</div>
<!-- /.content-wrapper -->



