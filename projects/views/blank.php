<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


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

  </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->



<script>

</script>