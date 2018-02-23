<?php
  //  include '../db/database.php';
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<?php include 'head.php'; 
//Check user roll.
switch($s_userGroupCode){
	case 'it' : case 'admin' :
		break;
	default : 
		header('Location: access_denied.php');
		exit();
}
?>

<div class="wrapper">

  <!-- Main Header -->
<?php 

include 'header.php'; 
include 'leftside.php';

$rootPage = 'user';

$id=$_GET['id'];

$sql = "SELECT hdr.`userId` as id, hdr.`userName`, hdr.`userPassword`, hdr.`userFullname`, hdr.`userGroupCode`
, hdr.`smId`, hdr.`userEmail`, hdr.`userTel`, hdr.`userPicture`, hdr.`statusCode` 
, ug.`name` as userGroupName 
FROM `cadet18_user` hdr 
LEFT JOIN cadet18_user_group ug on ug.code=hdr.userGroupCode  
WHERE 1=1
AND hdr.userId=:id 
";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$row = $stmt->fetch();

$userGroupCode=$row['userGroupCode'];
$smId=$row['smId'];
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="glyphicon glyphicon-user"></i>
       Users
        <small>User management</small>
      </h1>
	  <ol class="breadcrumb">
        <li><a href="<?=$rootPage;?>.php"><i class="glyphicon glyphicon-list"></i>User List</a></li>
		<li><a href="#"><i class="glyphicon glyphicon-edit"></i>User</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->
    <div class="box box-primary">
        <div class="box-header with-border">
        <h3 class="box-title">Edit User</h3>
        <div class="box-tools pull-right">
          <!-- Buttons, labels, and many other things can be placed here! -->
          <!-- Here is a label for example -->
         
        </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">            
            <div class="row">                
                    <form id="form1" method="post" class="form" enctype="multipart/form-data" validate>
					<div class="col-md-6">	
						<input id="userId" type="hidden" name="userId" value="<?=$row['id'];?>" />				
						<div class="form-group">
                            <label for="userName" style="color: blue;">Username</label><?=$row['userName'];?>
                            <input id="userName" type="text" class="form-control" name="userName" value="<?=$row['userName'];?>" data-smk-msg="Require userName" required>
                        </div>
                        <div class="form-group">
                            <label for="userPassword" style="color: blue;">User Password<small style="color: red;"> *** Leave blank for not change user password.</small></label>
                            <input id="userPassword" type="text" class="form-control" name="userPassword" >							
                        </div>
						
                        <div class="form-group">
                            <label for="userFullname">User Fullname</label>
                            <input id="userFullname" type="text" class="form-control" name="userFullname" value="<?=$row['userFullname'];?>" data-smk-msg="Require userFullname."required>
                        </div>
					</div>
					<!--/.col-md-->
					<div class="col-md-6">
						<div class="form-group">
							<label for="userGroupCode">User Group</label>
							<select id="userGroupCode" name="userGroupCode" class="form-control"  data-smk-msg="Require User Group" required>
								<option value=""> -- Select -- </option>
								<?php
								$sql = "SELECT `id`, `code`, `name`, `statusCode`  FROM `cadet18_user_group` WHERE statusCode='A' ";							
								$stmt = $pdo->prepare($sql);		
								$stmt->execute();
								while($rOption = $stmt->fetch()){
									$selected = ($rOption['code']==$userGroupCode?' selected ':'');									
									echo '<option value="'.$rOption['code'].'" '
										.$selected
										 .'>'.$rOption['code'].' : ['.$rOption['name'].']</option>';
								}
								?>
							</select>
						</div>		
						<div class="form-group">
                            <label for="statusCode">Status</label>
							<input type="radio" name="statusCode" value="A" <?php echo ($row['statusCode']=='A'?' checked ':'');?> >Active
							<input type="radio" name="statusCode" value="X" <?php echo ($row['statusCode']=='X'?' checked ':'');?> >Non-Active
						</div>
						<div class="form-group">
							<input type="hidden" name="curPhoto" id="curPhoto" value="<?=$row['userPicture'];?>" />
							<input type="file" name="inputFile" accept="image/*" multiple  onchange="showMyImage(this)" /> <br/>
							<img id="thumbnil" style="width:50%; margin-top:10px;"  src="dist/img/<?php echo (empty($row['userPicture'])? 'default.jpg' : $row['userPicture']); ?>" alt="image"/>
						</div>
                        <button id="btn1" type="submit" class="btn btn-default">Submit</button>
					</div>
					<!--/.col-md-->
                    </form>
                </div>
                <!--/.row-->       
            </div>
			<!--.body-->    
    </div>
	<!-- /.box box-primary -->
  

<div id="spin"></div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php include'footer.php'; ?>
  
  
</div>
<!-- ./wrapper -->

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
  // to start and stop spiner.  
$( document ).ajaxStart(function() {
	$("#spin").show();
}).ajaxStop(function() {
	$("#spin").hide();
});
//   

$(document).ready(function() {
	$("#userFullname").focus();

	var spinner = new Spinner().spin();
	$("#spin").append(spinner.el);
	$("#spin").hide();
//           
	$('#form1').on("submit", function(e) {
		if ($('#form1').smkValidate()) {			
			$.ajax({
			url: '<?=$rootPage;?>_edit_ajax.php',
			type: 'POST',
			data: new FormData( this ),
			processData: false,
			contentType: false,
			dataType: 'json'
			}).done(function (data) {
				if (data.success){  
					$.smkAlert({
						text: data.message,
						type: 'success',
						position:'top-center'
					});
					//window.location.href = "user_add.php";
				}else{
					$.smkAlert({
						text: data.message,
						type: 'danger',
						position:'top-center'
					});
				}
				alert('Success');
				window.location.href = "<?=$rootPage;?>.php";
			});  
			//.ajax		
			e.preventDefault();
		}   
		//end if 
		e.preventDefault();
	});
	//form.submit
});
//doc ready
</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
	 
<script>
function showMyImage(fileInput) {
        var files = fileInput.files;
        for (var i = 0; i < files.length; i++) {           
            var file = files[i];
            var imageType = /image.*/;     
            if (!file.type.match(imageType)) {
                continue;
            }           
            var img=document.getElementById("thumbnil");            
            img.file = file;    
            var reader = new FileReader();
            reader.onload = (function(aImg) { 
                return function(e) { 
                    aImg.src = e.target.result; 
                }; 
            })(img);
            reader.readAsDataURL(file);
        }    
    }
</script>
	 
</body>
</html>
