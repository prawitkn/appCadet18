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
      <h1><i class="glyphicon glyphicon-barcode"></i>
       Check in
        <small>Check in management</small>
      </h1>
	  <ol class="breadcrumb">
        <li><a href="<?=$rootPage;?>.php"><i class="glyphicon glyphicon-list"></i>Check in List</a></li>
		<li><a href="#"><i class="glyphicon glyphicon-edit"></i>Check in</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->
	<div class="box box-primary">
        <div class="box-header with-border">
        <h3 class="box-title">Check in</h3>
        <div class="box-tools pull-right">
          <!-- Buttons, labels, and many other things can be placed here! -->
          <!-- Here is a label for example -->
         
        </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">            
            <div class="row">                
					<div class="col-md-6">	
						<input id="userId" type="hidden" name="userId" value="<?=$s_userId;?>" />
                        <div class="form-group">
                            <label for="barcode">Barcode</label>
                            <input id="barcode" type="text" class="form-control" name="barcode" >							
                        </div>
						<div class="form-group">
                            <label for="fullname">ยศ ชื่อ นามสกุล</label>
							<h3 id="fullname"></h3>
                        </div>
						<div class="form-group">
                            <label for="group">กลุ่ม</label>
							<h3 id="group"></h3>
                        </div>
						<div class="form-group">
                            <label for="position">ตำแหน่ง</label>
							<h3 id="position"></h3>
                        </div>						
                        <button id="btn_submit" type="submit" class="btn btn-primary">Submit</button>
					</div>
					<div class="col-md-6">	
						<div class="form-group">                            
							<img id="img" src="" width="250px;" />
                        </div>
					</div>
					<!--/.col-md-->
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
					$('#img').prop('src','images/person/'+$itm.photo);
					//$('#barcode').select();
					$('#btn_submit').focus();
					//location.reload();
				} else {
					alert(data.message);
					$.smkAlert({
						text: data.message,
						type: 'danger'//,
					//                        position:'top-center'
					});
					$('#barcode').select();
				}
			}).error(function (response) {
				alert(response.responseText);
			}); 
		}/* e.keycode=13 */	
	});
	
	$('#btn_submit').on("click", function(e) {
		var params = {
			barcode: $('#barcode').val()
		}; //alert(params.barcode);
		$.post({
			url: 'scan_save_ajax.php',
			data: params,
			dataType: 'json'
		}).done(function (data) {					
			if (data.success){ 
				//alert(data.message);
				/*$.smkAlert({
					text: data.message,
					type: 'success'//,
				//                        position:'top-center'
				});*/
				$('#barcode').select();
				//$('#btn_submit').focus();
				//location.reload();
			} else {
				alert(data.message);
				$.smkAlert({
					text: data.message,
					type: 'danger'//,
				//                        position:'top-center'
				});
				$('#barcode').select();
			}
		}).error(function (response) {
			alert(response.responseText);
		}); 
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
