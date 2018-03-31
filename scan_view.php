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
					<h3>จปร.29 </h3>
					<h3>ทั้งหมด <?=$row['inviteTotal'];?> นาย</h3>
					<h3>ลงทะเบียน <?=$row['countTotal'];?> นาย</h3>
					<h3>คงเหลือ <?=$row['inviteTotal']-$row['countTotal'];?> นาย</h3>
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
					<h3>นนร.75 </h3>
					<h3>ทั้งหมด <?=$row['inviteTotal'];?> นาย</h3>
					<h3>ลงทะเบียน <?=$row['countTotal'];?> นาย</h3>
					<h3>คงเหลือ <?=$row['inviteTotal']-$row['countTotal'];?> นาย</h3>
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
					<h3>นนอ.25 </h3>
					<h3>ทั้งหมด <?=$row['inviteTotal'];?> นาย</h3>
					<h3>ลงทะเบียน <?=$row['countTotal'];?> นาย</h3>
					<h3>คงเหลือ <?=$row['inviteTotal']-$row['countTotal'];?> นาย</h3>
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
					<h3>นรต.34 </h3>
					<h3>ทั้งหมด <?=$row['inviteTotal'];?> นาย</h3>
					<h3>ลงทะเบียน <?=$row['countTotal'];?> นาย</h3>
					<h3>คงเหลือ <?=$row['inviteTotal']-$row['countTotal'];?> นาย</h3>
				</div>				
            </div>
            <!--/.row-->     

			<div class="row" style="text-align: center;"> 
				<div class="col-md-12">
					<h3>ยอดรวม</h3>
					<h3>ทั้งหมด <?=$sumInvite;?> นาย</h3>
					<h3>ลงทะเบียน <?=$sumCount;?> นาย</h3>
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
	setTimeout(function(){ location.reload(); }, 10000);
	$('#barcode').keyup(function(e){
		if(e.keyCode == 13)
		{	
			var params = {
				barcode: $('#barcode').val()
			}; //alert(params.barcode);
			/* Send the data using post and put the results in a div */
			$.post({
				url: 'scan_ajax.php',
				data: params,
				dataType: 'json'
			}).done(function (data) {					
				if (data.success){ 
					/*$.smkAlert({
						text: data.message,
						type: 'success',
						position:'top-center'
					});*/
					$itm=$.parseJSON(data.itm);
					$('#fullname').text($itm.fullname);
					$('#group').text($itm.groupName);
					$('#position').text($itm.position);
					$('#img').attr('src',$itm.photo);
					$('#barcode').select();
					//location.reload();
				} else {
					alert(data.message);
					$.smkAlert({
						text: data.message,
						type: 'danger'//,
					//                        position:'top-center'
					});
				}
			}).error(function (response) {
				alert(response.responseText);
			}); 
		}/* e.keycode=13 */	
	});
	
	
	
	/*$('#form1').on("submit", function(e) {
		if($('#newPassword').val() != $('#confirmPassword').val()){
			alert('New password not match confirm password');
			return false;
		}
		if ($('#form1').smkValidate()) {			
			$.ajax({
			url: '<?=$rootPage;?>_change_pw_ajax.php',
			type: 'POST',
			data: new FormData( this ),
			processData: false,
			contentType: false,
			dataType: 'json'
			}).done(function (data) { alert(data);
				if (data.success){  
					$.smkAlert({
						text: data.message,
						type: 'success',
						position:'top-center'
					});
					window.location.href = "logout.php";
				}else{
					$.smkAlert({
						text: data.message,
						type: 'danger',
						position:'top-center'
					});
				}
				alert('Success');
				window.location.href = "<?=$rootPage;?>.php";
			}).error(function (response) {
				alert(response.responseText);
			});  
			//.ajax		
			e.preventDefault();
		}   
		//end if 
		e.preventDefault();
	});
	//form.submit*/
});
//doc ready
</script>





</body>
</html>
