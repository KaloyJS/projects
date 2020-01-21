<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="addNewProjectModal"  role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><strong>+ADD NEW PROJECT</strong></h4>
      </div>
      <div class="modal-body">
       <form class="form-horizontal" action="actions.php" method="post" autocomplete="off">
         <div class="form-group">
          <div class="col-sm-12">
            <label class="col-sm-2">PROJECT NUMBER:</label>
            <div class="col-sm-10">

            <!-- <?php $new_id = projectNumber(); ?> -->
 
            <input class="form-control" type="text" name="project_id" id="project_id"  readonly>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-12">
            <label class="col-sm-2">PROJECT NAME:</label>
            <div class="col-sm-10">
            <input class="form-control" type="text" name="project_name" id="project_name">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-12">
            <label for="inputEmail3" class="col-sm-2">ASSIGNEE:</label>
            <div class="col-sm-10">
            <select class="form-control select2" type="text"  name="assignee" id="assignee" style="width: 100%;" data-placeholder="SELECT TEAM MEMBER" required>
              <option></option>
              <?php $query="SELECT distinct badge, first_name, last_name FROM dir_indir
                where badge is not null ORDER BY first_name"; ?>
              <?php foreach($conn->query($query) as $row): ?>
                <option value="<?php echo $row["BADGE"]; ?>"> <?php echo $row["FIRST_NAME"] . " " . $row["LAST_NAME"]; ?></option>
              <?php endforeach; ?>  
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
                <input class="form-control pull-right" id="startDate" name="start_date" type="text"   required>
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
          <button type="submit" class="btn btn-primary" name="add_project_modal">Save Project</button>
        </div>
       </form>      
    </div>
  </div>
</div>