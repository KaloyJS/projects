<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
  // echo "<pre>";
  // print_r($projects);
  // echo "</pre>";

 ?>
 <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/sbe_projects-style.css"> 

 <style type="text/css">

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

<section class="content-header">
 
  <br>

  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Sbe Projects</li>
  </ol>
</section>
<!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="container2">
        <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua" >

                <div class="inner" id="add_new_project_trigger">
                  <a href="javascript:void(0)" style="color: #fff;">
                    <h3 data-toggle="modal" data-target="#myModal" style="cursor: pointer;"><i class="fa fa-plus-square" ></i>ADD</h3>

                    <p>New Project</p>
                  </a>
                </div>
                <div class="icon add_new_project_trigger">
                  <i class="fa fa-rocket" ></i>
                 
                </div>
                <a href="projects.php" class="small-box-footer">PROJECTS <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3 data-toggle="modal" data-target="#myModal2" style="cursor: pointer;"><i class="fa fa-plus-square" ></i>ADD</h3>

                  <p>New Activity</p>
                </div>
                <div class="icon">
                  <i class="fa fa-adn"></i>
                </div>
                <a href="#" class="small-box-footer">ACTIVITIES <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3 data-toggle="modal" data-target="#myModal3" style="cursor: pointer;"><i class="fa fa-plus-square" ></i>ADD</h3>

                  <p>New Workpackage</p>
                </div>
                <div class="icon">
                  <i class="fa fa-wordpress"></i>
                </div>
                <a href="#" class="small-box-footer">WORKPACKAGES <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
      </div>                         
    </div>  <!-- row -->  
    <div class="row">
      <div class="col-md-4 connectedSortable">
        <div class="box box-primary ">
            <div class="box-header with-border">           
              <h3>Activities <small>today</small></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="javascript:void(0)" class="uppercase">View All Activities</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
          
        </div>


        <div class="col-md-8 connectedSortable">
          <div class="col-md-12 container2">
            <div class="panel panel-default">
              <div class="panel-body">
                 <div class="pull-right">
                  <div class="btn-group">
                      <button type="button" class="btn btn-default btn-filter" data-target="all">All Projects</button>
                    <button type="button" class="btn btn-success btn-filter" data-target="current">On Going Projects</button>
                    <button type="button" class="btn btn-warning btn-filter" data-target="completed">Completed Projects</button>
                    <button type="button" class="btn btn-danger btn-filter" data-target="closed">Closed Projects</button>
                    
                  </div>
                </div>

                <div class="table-container">
                  <table class="table table-filter">
                    <tbody>
                      <?php foreach($projects as $project): ?>
                        <?php if($project['STATUS'] === 'Created' || $project['STATUS'] === 'In Progress' || $project['STATUS'] === 'On hold' ): ?>
                            <?php $category = 'current'; ?>
                        <?php elseif($project['STATUS'] === 'Completed'): ?>
                            <?php $category = 'completed'; ?>
                        <?php elseif($project['STATUS'] === 'Closed'): ?>
                            <?php $category = 'closed'; ?>
                        <?php endif; ?>   
                        <tr data-status="<?php echo $category; ?>" id="<?php echo $project['ID']; ?>">
                          <td>
                            <a href="javascript:;" class="star">
                              <i class="glyphicon glyphicon-star"></i>
                            </a>
                          </td>
                          <td>
                            <div class="media">
                              
                              <div class="media-body">
                                <?php $new_date = convertDate($project['DATE_INS']); ?>
                                <span class="media-meta pull-right"><?php echo $new_date; ?></span>
                                <h4 class="title project-title">
                                 <a href="<?php echo base_url(); ?>projects/overview/<?php echo $project['ID']; ?>"><?php echo $project['PROJECTNAME'] ?></a> 
                                  <span class="pull-right <?php echo $category; ?>"><?php echo $project['STATUS']; ?></span>
                                </h4>
                                <p class="summary"><?php echo substr($project['SCOPE'], 0, 50); ?>...</p>
                              </div>
                            </div>
                          </td>
                        </tr>
                        </a>  

                      <?php endforeach; ?>                   
                      
                     
                      
                     
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
<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><strong>+ADD NEW PROJECT</strong></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="" method="post" autocomplete="off">
          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">PROJECT NUMBER:</label>
              <div class="col-sm-10">           
   
              <input class="form-control" type="text" name="id" id="project_id"  readonly>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <label for="inputEmail3" class="col-sm-2">ASSIGNEE:</label>
              <div class="col-sm-10">
              <select class="form-control select2" type="text"  name="assignee" id="assignee" style="width: 100%;" data-placeholder="SELECT TEAM MEMBER" required>
                <option></option>              
              </select>
              </div>
            </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <label class="col-sm-2">START DATE:</label>
            <div class="col-sm-10">
              <div class="input-group date">
                <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" id="start_date" name="start_date" type="text"   required>
              </div>
            </div>
          </div>
        </div>
          <div class="form-group">
          <div class="col-sm-12">
            <label class="col-sm-2">END DATE:</label>
            <div class="col-sm-10">
              <div class="input-group date">
                <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" id="endDate" name="end_date" type="text"  required>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-12">
            <label class="col-sm-2">SCOPE:</label>
            <div class="col-sm-10">
            <textarea rows="3" cols="20" class="form-control" name="scope" id="scope"/></textarea>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-12">
            <label class="col-sm-2">PRIORITY:</label>
            <div class="col-sm-10">
              <select class="form-control" name="priority" id="priority">
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
     </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" tabindex="-1" role="dialog" id="myModal2">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><strong>+ADD NEW ACTIVITY</strong></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="" method="post" autocomplete="off">

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">PROJECT ID:</label>
              <div class="col-sm-10">           
   
                <select class="form-control" name="project_id" id="act_project_id">
                  <option></option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">ACTIVITY NAME:</label>
              <div class="col-sm-10">
              <input class="form-control" type="text" name="activity_name" id="activity_name">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">DESCRIPTION:</label>
              <div class="col-sm-10">
              <textarea rows="3" cols="20" class="form-control" name="description" id="description"/></textarea>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">START DATE:</label>
              <div class="col-sm-10">
                <div class="input-group date">
                  <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right" id="act_start_date" name="start_date" type="text"   required>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">END DATE:</label>
              <div class="col-sm-10">
                <div class="input-group date">
                  <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right" id="act_end_date" name="end_date" type="text"  required>
                </div>
              </div>
            </div>
          </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="myModal3">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-plus"></i><strong>ADD NEW WORKPACKAGE</strong></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="actions.php" method="post" autocomplete="off">

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">ACTIVITY ID:</label>
              <div class="col-sm-10">           
   
              <input class="form-control" type="text" name="activity_id" id="workpackage_aid"  readonly>
              <input type="text" name="project_id" id="project_id" >
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">WORKPACKAGE NAME:</label>
              <div class="col-sm-10">
              <input class="form-control" type="text" name="name" id="workpackage_name">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">DESCRIPTION:</label>
              <div class="col-sm-10">
              <textarea rows="3" cols="20" class="form-control" name="description" id="description"/></textarea>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">START DATE:</label>
              <div class="col-sm-10">
                <div class="input-group date">
                  <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right" id="workpackage_start_date" name="start_date" type="text"   required>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <label class="col-sm-2">END DATE:</label>
              <div class="col-sm-10">
                <div class="input-group date">
                  <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right" id="workpackage_end_date" name="end_date" type="text"  required>
                </div>
              </div>
            </div>
          </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /.content -->
</div>
<!-- /.content-wrapper -->



<script>
  $(document).ready(function () {

    $(".connectedSortable").sortable({
      placeholder: "sort-highlight",
      connectWith: ".connectedSortable",
      handle: ".box-header, .nav-tabs",
      forcePlaceholderSize: true,
      zIndex: 999999
    });
    $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

    // $('.table-filter tr').on('click', function(){
    //   console.log("clicked");
    //   window.location.href = "projects.php";
    // });
   

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

   });
</script>