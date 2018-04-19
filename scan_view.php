<?php
	include 'inc_helper.php'; 
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<?php 	
	//$year = date('Y');
	//$month = "0";//date('m');
	//if(isset($_GET['year'])) $year = $_GET['year'];
	//if(isset($_GET['month'])) $month = $_GET['month'];
?>
<?php 
	include 'head.php'; 
?>

<div class="wrapper">

  <!-- Main Header -->
  <?php include 'header.php'; ?>
  
  <!-- Left side column. contains the logo and sidebar -->
   <?php include 'leftside.php'; ?>
   <?php
	$rootPage = 'scan';
	$tb="cadet18_person";
   ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="glyphicon glyphicon-search"></i>
       View
        <small>View management</small>
      </h1>
	  <ol class="breadcrumb">
        <li><a href="<?=$rootPage;?>.php"><i class="glyphicon glyphicon-list"></i>View List</a></li>
		<li><a href="#"><i class="glyphicon glyphicon-edit"></i>View</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->
	<div class="box box-primary">
        <div class="box-header with-border">
        <h3 class="box-title">View</h3>
        <div class="box-tools pull-right">
          <!-- Buttons, labels, and many other things can be placed here! -->
          <!-- Here is a label for example -->
         
        </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">            
            <div class="row" style="text-align: center;"> 
				<div class="col-md-3">
					<img src="dist/img/typeLogo/1.jpg" height="200px;" />
					<?php
					$sumInvite=0;
					$sumCount=0;
					$sql = "SELECT SUM(isInvite) as inviteTotal, SUM(isCount) as countTotal 
					FROM `".$tb."` WHERE groupCode=1 ";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();	
					$row=$stmt->fetch();
					$sumInvite+=$row['inviteTotal'];
					$sumCount+=$row['countTotal'];
					?>
					<h1>จปร.29 </h1>
					<h3 style="color: blue;">ทั้งหมด <span id="lblInvite1"><?=$row['inviteTotal'];?></span> นาย</h3>
					<h3 style="color: #009933;">ลงทะเบียน <span id="lblCheckedIn1"><?=$row['countTotal'];?></span> นาย</h3>
					<h3 style="color: #ff6666;">คงเหลือ <span id="lblPending1"><?=$row['inviteTotal']-$row['countTotal'];?></span> นาย</h3>
				</div>
				<div class="col-md-3">
					<img src="dist/img/typeLogo/2.jpg" height="200px;" />
					<?php
					$sql = "SELECT SUM(isInvite) as inviteTotal, SUM(isCount) as countTotal 
					FROM `".$tb."` WHERE groupCode=2 ";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();	
					$row=$stmt->fetch();
					$sumInvite+=$row['inviteTotal'];
					$sumCount+=$row['countTotal'];
					?>
					<h1>นนร.75 </h1>
					<h3 style="color: blue;">ทั้งหมด <span id="lblInvite2"><?=$row['inviteTotal'];?></span> นาย</h3>
					<h3 style="color: #009933;">ลงทะเบียน <span id="lblCheckedIn2"><?=$row['countTotal'];?></span> นาย</h3>
					<h3 style="color: #ff6666;">คงเหลือ <span id="lblPending2"><?=$row['inviteTotal']-$row['countTotal'];?></span> นาย</h3>
				</div>
				<div class="col-md-3">
					<img src="dist/img/typeLogo/3.jpg" height="200px;" />
					<?php
					$sql = "SELECT SUM(isInvite) as inviteTotal, SUM(isCount) as countTotal 
					FROM `".$tb."` WHERE groupCode=3 ";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();	
					$row=$stmt->fetch();
					$sumInvite+=$row['inviteTotal'];
					$sumCount+=$row['countTotal'];
					?>
					<h1>นนอ.25 </h1>
					<h3 style="color: blue;">ทั้งหมด <span id="lblInvite3"><?=$row['inviteTotal'];?></span> นาย</h3>
					<h3 style="color: #009933;">ลงทะเบียน <span id="lblCheckedIn3"><?=$row['countTotal'];?></span> นาย</h3>
					<h3 style="color: #ff6666;">คงเหลือ <span id="lblPending3"><?=$row['inviteTotal']-$row['countTotal'];?></span> นาย</h3>
				</div>
				<div class="col-md-3">
					<img src="dist/img/typeLogo/4.jpg" height="200px;" />
					<?php
					$sql = "SELECT SUM(isInvite) as inviteTotal, SUM(isCount) as countTotal 
					FROM `".$tb."` WHERE groupCode=4 ";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();	
					$row=$stmt->fetch();
					$sumInvite+=$row['inviteTotal'];
					$sumCount+=$row['countTotal'];
					?>
					<h1>นรต.34 </h1>
					<h3 style="color: blue;">ทั้งหมด <span id="lblInvite4"><?=$row['inviteTotal'];?></span> นาย</h3>
					<h3 style="color: #009933;">ลงทะเบียน <span id="lblCheckedIn4"><?=$row['countTotal'];?></span> นาย</h3>
					<h3 style="color: #ff6666;">คงเหลือ <span id="lblPending4"><?=$row['inviteTotal']-$row['countTotal'];?></span> นาย</h3>
				</div>				
            </div>
            <!--/.row-->     

			<div class="row" style="text-align: center;"> 
				<div class="col-md-12">
					<h1>ยอดรวม</h1>
					<h3 style="color: blue;">ทั้งหมด <span id="lblInvite5"><?=$sumInvite;?> </span>นาย</h3>
					<h3 style="color: #009933;">ลงทะเบียน <span id="lblCheckedIn5"><?=$sumCount;?> </span>นาย</h3>
					<h3 style="color: #ff6666;">คงเหลือ <span id="lblPending5"><?=$sumInvite-$sumCount;?></span> นาย</h3>
				</div>		
            </div>
            <!--/.row-->       
        </div>
		<!--.body-->    
    </div>
	<!-- /.box box-primary -->
	

	</section>
	<!--sec.content-->
	
	</div>
	<!--content-wrapper-->

</div>
<!--warpper-->

<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>

<script src="bootstrap/js/smoke.min.js"></script>

<!-- Add Spinner feature -->
<script src="bootstrap/js/spin.min.js"></script>



<script> 
$(document).ready(function() {
	$('#barcode').select();
	
	setTimeout(function(){ getList(); }, 5000);
	
	function getList(){		
		var params = {
			action: 'getList'
		}; //alert(params.sendDate);
		/* Send the data using post and put the results in a div */
		  $.ajax({
			  url: "scan_view_ajax.php",
			  type: "post",
			  data: params,
			datatype: 'json',
			  success: function(data){	//alert(data);
					//data=$.parseJSON(data);
					var sumInviteTotal=0;
					var sumCountTotal=0;
					var sumPendingTotal=0;
					
					switch(data.rowCount){
						case 0 : alert('Data not found.');
							//$('#tbl_items tbody').empty();
							return false; break;
						default : 							
							//$('#tbl_items tbody').empty();
							$.each($.parseJSON(data.data), function(key,value){
								if(value.groupCode==1){
									$('#lblInvite1').fadeOut('slow').text(value.inviteTotal).fadeIn('slow');
									$('#lblCheckedIn1').fadeOut('slow').text(value.countTotal).fadeIn('slow');
									$('#lblPending1').fadeOut('slow').text(value.inviteTotal-value.countTotal).fadeIn('slow');
								}
								if(value.groupCode==2){
									$('#lblInvite2').fadeOut('slow').text(value.inviteTotal).fadeIn('slow');
									$('#lblCheckedIn2').fadeOut('slow').text(value.countTotal).fadeIn('slow');
									$('#lblPending2').fadeOut('slow').text(value.inviteTotal-value.countTotal).fadeIn('slow');
								}
								if(value.groupCode==3){
									$('#lblInvite3').fadeOut('slow').text(value.inviteTotal).fadeIn('slow');
									$('#lblCheckedIn3').fadeOut('slow').text(value.countTotal).fadeIn('slow');
									$('#lblPending3').fadeOut('slow').text(value.inviteTotal-value.countTotal).fadeIn('slow');
								}
								if(value.groupCode==4){
									$('#lblInvite4').fadeOut('slow').text(value.inviteTotal).fadeIn('slow');
									$('#lblCheckedIn4').fadeOut('slow').text(value.countTotal).fadeIn('slow');
									$('#lblPending4').fadeOut('slow').text(value.inviteTotal-value.countTotal).fadeIn('slow');
								}
								sumInviteTotal=(int)sumInviteTotal+(int)value.inviteTotal;
								sumCountTotal=(int)sumCountTotal+(int)value.countTotal;
								sumPendingTotal=(int)sumPendingTotal+((int)value.inviteTotal-(int)value.countTotal); 	
							});
							$('#lblInvite5').fadeOut('slow').text(sumInviteTotal).fadeIn('slow');
							$('#lblCheckedIn5').fadeOut('slow').text(sumCountTotal).fadeIn('slow');
							$('#lblPending5').fadeOut('slow').text(sumPendingTotal).fadeIn('slow');
						//('#modal_search_person').modal('show');	
					}	
			  }   
			}).error(function (response) {
				alert(response.responseText);
			}); 
	}
	
});
//doc ready
</script>





</body>
</html>
