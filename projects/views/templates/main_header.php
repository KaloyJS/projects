<?php
if($this->session->has_userdata(PORTAL_NAME.'portal')){
$sbegn_u_name = $this->session->userdata(PORTAL_NAME.'uname');
		$sbegn_role = $this->session->userdata(PORTAL_NAME.'role');
		$sbegn_account = $this->session->userdata(PORTAL_NAME.'account');
		$sbegn_badge = $this->session->userdata(PORTAL_NAME.'badge');
		$sbegn_fname = $this->session->userdata(PORTAL_NAME.'fname');
		$sbegn_lname = $this->session->userdata(PORTAL_NAME.'lname');
		$sbegn_access = $this->session->userdata(PORTAL_NAME.'access');
}
		?>
<body class="hold-transition skin-black sidebar-mini sidebar-collapse">
<div class="wrapper">
 
   <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url(); ?>home" class="logo nobg">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>BE</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo base_url(); ?>assets/backend/AdminLTE/dist/img/sbe_logo.png" height="45px"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top nobg">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Tasks: style can be found in dropdown.less -->
           <li>
              <a href="<?php echo base_url(); ?>projects"><i class="fa fa-home"></i> Home</a>
          </li>
		 
		  <li class="user">
            <a href="#">
              <i class="fa fa-user"></i>
              <span><?php if(isset($sbegn_u_name)){echo $sbegn_u_name;}?></span>
            </a>
          </li>
          <li>
              <a href="<?php echo base_url(); ?>logout">Logout</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
