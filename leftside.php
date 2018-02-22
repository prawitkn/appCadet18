<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/<?php echo (empty($s_userPicture)? 'default-50x50.gif' : $s_userPicture) ?> " class="img-circle" alt="<?= $s_userFullname ?>">
        </div>
        <div class="pull-left info">
          <p><?= $s_userFullname ?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> 
	
      <ul class="sidebar-menu">
				
		<li class="header">รายงาน</li>
		<?php switch($s_userGroupCode){ case 'admin' : ?>			
			<li><a href="report_person.php"><i class="fa fa-bars"></i> <span> รายชื่อ นตท.18 </span></a></li>			
		<?php break; default : } ?>
		
 		
		<li class="header">Setting</li>	
		<li><a href="user_change_pw.php"><i class="fa fa-bars"></i> <span> Change Password </span></a></li>	    
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>