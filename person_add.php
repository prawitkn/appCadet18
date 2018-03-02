<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<?php include 'head.php'; ?>

<div class="wrapper">

  <!-- Main Header -->
<?php include 'header.php'; 
$rootPage = 'person';

//Check user roll.
switch($s_userGroupCode){
	case 'admin' :
		break;
	default : 
		header('Location: access_denied.php');
		exit();
}
?>
  
  <!-- Left side column. contains the logo and sidebar -->
   <?php include 'leftside.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="glyphicon glyphicon-user"></i>
       Person
        <small>Person management</small>
      </h1>
	  <ol class="breadcrumb">
        <li><a href="<?=$rootPage;?>.php"><i class="glyphicon glyphicon-list"></i>Person List</a></li>
		<li><a href="#"><i class="glyphicon glyphicon-edit"></i>Person</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->
    <div class="box box-primary">
        <div class="box-header with-border">
        <h3 class="box-title">Add Person</h3>
        <div class="box-tools pull-right">
          <!-- Buttons, labels, and many other things can be placed here! -->
          <!-- Here is a label for example -->
         
        </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">            
            <div class="row">                
                    <form id="form1" method="post" class="form" enctype="multipart/form-data" validate>
					<input type="hidden" name="action" value="add" />
					<!--`title`, `name`, `surname`, `fullname`, `photo`, `nickname`, `origin`, `genNo`, `subService`
					, `randCode`, `position`, `workPlace`, `dateOfBirth`, `mobileNo`, `tel`, `email`
					, `address`, `person_type`, `groupCode`, `group2code`, `group2Name`, `status`, `retireYear`-->					
					<div class="col-md-6">	
						<div class="form-group">
                            <label for="title" style="color: blue;">title</label>
                            <input type="text" id="title" name="title" class="form-control" data-smk-msg="Require title" required>
                        </div>
						<div class="form-group">
                            <label for="name" style="color: blue;">name</label>
                            <input type="text" id="name" name="name" class="form-control" data-smk-msg="Require name" required>
                        </div>
						<div class="form-group">
                            <label for="surname" style="color: blue;">surname</label>
                            <input type="text" id="surname" name="surname" class="form-control" data-smk-msg="Require surname" required>
                        </div>
						<div class="form-group">
                            <label for="nickname" style="color: blue;">nickname</label>
                            <input type="text" id="nickname" name="nickname" class="form-control" />
                        </div>
						<div class="form-group">
                            <label for="origin" style="color: blue;">origin</label>
                            <input type="text" id="origin" name="origin" class="form-control" />
                        </div>
						<div class="form-group">
                            <label for="genNo" style="color: blue;">genNo</label>
                            <input type="text" id="genNo" name="genNo" class="form-control" />
                        </div>
						<div class="form-group">
                            <label for="subService" style="color: blue;">subService</label>
                            <input type="text" id="subService" name="subService" class="form-control" />
                        </div>
						<!--, `randCode`, `position`, `workPlace`, `dateOfBirth`, `mobileNo`, `tel`, `email`-->
						<div class="form-group">
                            <label for="position" style="color: blue;">position</label>
                            <input type="text" id="position" name="position" class="form-control" />
                        </div>
						<div class="form-group">
                            <label for="workPlace" style="color: blue;">workPlace</label>
                            <input type="text" id="workPlace" name="workPlace" class="form-control" />
							<input type="text" id="workPlace2" name="workPlace2" class="form-control" />
                        </div>
						<div class="form-group">
                            <label for="dateOfBirth" style="color: blue;">dateOfBirth</label>
                            <input type="text" id="dateOfBirth" name="dateOfBirth" class="form-control datepicker" />
                        </div>
						<div class="form-group">
                            <label for="mobileNo" style="color: blue;">mobileNo</label>
                            <input type="text" id="mobileNo" name="mobileNo" class="form-control" />
                        </div>
						<div class="form-group">
                            <label for="tel" style="color: blue;">tel</label>
                            <input type="text" id="tel" name="tel" class="form-control" />
                        </div><div class="form-group">
                            <label for="email" style="color: blue;">email</label>
                            <input type="text" id="email" name="email" class="form-control" />
                        </div>
						<!--, `address`, `person_type`, `groupCode`, `group2code`, `group2Name`, `status`, `retireYear`-->
						<div class="form-group">
                            <label for="address" style="color: blue;">address</label>
                            <input type="text" id="address" name="address" class="form-control" />
							<input type="text" id="address2" name="address2" class="form-control" />
                        </div>
						<div class="form-group">
                            <label for="groupCode" style="color: blue;">groupCode</label>
                            <input type="text" id="groupCode" name="groupCode" class="form-control" />
                        </div>
						<div class="form-group">
                            <label for="group2code" style="color: blue;">group2code</label>
                            <input type="text" id="group2code" name="group2code" class="form-control" />
                        </div>
						<div class="form-group">
                            <label for="group2Name" style="color: blue;">group2Name</label>
                            <input type="text" id="group2Name" name="group2Name" class="form-control" />
                        </div>
						<div class="form-group">
                            <label for="retireYear" style="color: blue;">retireYear</label>
                            <input type="text" id="retireYear" name="retireYear" class="form-control" />
                        </div>
					</div>
					<!--/.col-md-->
					<div class="col-md-6">
						<!--<div class="form-group">
							<label for="userGroupCode">User Group</label>
							<select id="userGroupCode" name="userGroupCode" class="form-control"  data-smk-msg="Require User Group" required>
								<option value=""> -- Select -- </option>
								<?php
								$sql = "SELECT `id`, `code`, `name`, `statusCode`  FROM `cadet18_user_group` WHERE statusCode='A' ";							
								$stmt = $pdo->prepare($sql);		
								$stmt->execute();
								while($row = $stmt->fetch()){
									echo '<option value="'.$row['code'].'" 
										 >'.$row['code'].' : ['.$row['name'].']</option>';
								}
								?>
							</select>
						</div>	-->
						<div class="form-group">
							<input type="hidden" name="curPhoto" id="curPhoto" value="<?=$row['photo'];?>" />
							<input type="file" name="inputFile" accept="image/*" multiple  onchange="showMyImage(this)" /> <br/>
							<img id="thumbnil" style="width:50%; margin-top:10px;"  src="dist/img/person/<?php echo (empty($row['photo'])? 'default.jpg' : $row['photo']); ?>" alt="image"/>
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
  <div class="box-footer">
      
      
    <!--The footer of the box -->
  </div><!-- box-footer -->
</div><!-- /.box -->

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
	$("#title").focus();

	var spinner = new Spinner().spin();
	$("#spin").append(spinner.el);
	$("#spin").hide();
//           
	$('#form1').on("submit", function(e) {
		if ($('#form1').smkValidate()) {
			$.ajax({
			url: '<?=$rootPage;?>_ajax.php',
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
				}else{
					$.smkAlert({
						text: data.message,
						type: 'danger',
						position:'top-center'
					});
				}
				$('#form1')[0].reset();
				$("#title").focus(); 
			})
			.error(function (response) {
				  alert(response.responseText);
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


<link href="bootstrap-datepicker-custom-thai/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
<script src="bootstrap-datepicker-custom-thai/dist/js/bootstrap-datepicker-custom.js"></script>
<script src="bootstrap-datepicker-custom-thai/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
  
<script>
	$(document).ready(function () {
		$('.datepicker').datepicker({
			todayHighlight: true,
			daysOfWeekHighlighted: "0,6",
			autoclose: true,
			format: 'dd/mm/yyyy',
			todayBtn: true,
			language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
			thaiyear: true              //Set เป็นปี พ.ศ.
		});  //กำหนดเป็นวันปัจุบัน
		
		//กำหนดเป็น วันที่จากฐานข้อมูล		
		$('#dateOfBirth').datepicker('setDate', '0');
		//จบ กำหนดเป็น วันที่จากฐานข้อมูล
		
	});
</script>

	 
	 
</body>
</html>
