<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<?php	include 'head.php'; ?>    

<div class="wrapper">
  <!-- Main Header -->
  <?php include 'header.php'; 	include 'inc_helper.php';  
  $rootPage="scan_list";
  ?>  
  
  <!-- Left side column. contains the logo and sidebar -->
   <?php include 'leftside.php'; ?>
   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><i class="glyphicon glyphicon-user"></i>
		นตท.18
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=$rootPage;?>.php"><i class="glyphicon glyphicon-list"></i>รายชื่อ นตท.18</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <!-- Your Page Content Here -->
    <div class="box box-primary">
        <div class="box-header with-border">
		<label class="box-title">รายชื่อ นตท.18</label>
			<!--<a href="<?=$rootPage;?>_add.php" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add Shipping Marks</a>-->
		
        <div class="box-tools pull-right">
          <!-- Buttons, labels, and many other things can be placed here! -->
          <!-- Here is a label for example -->
          <?php
				$search_word="";
				$queryString="id=";
				if(isset($_GET['groupCode'])){
					$queryString.="&groupCode=".$_GET['groupCode'];
				}
				if(isset($_GET['search_word'])){
					$queryString.="&search_word=".$_GET['search_word'];
				}
				
                $sql = "SELECT a.id 
				FROM cadet18_person a
				WHERE 1 ";
				if(isset($_GET['groupCode']) AND $_GET['groupCode']<>""){
					$sql.="and a.groupCode = :groupCode ";
				}
				if(isset($_GET['search_word']) and isset($_GET['search_word'])){
					$sql.="and (a.id = :search_word OR a.fullname like :search_word2) ";
				}
				$stmt = $pdo->prepare($sql);
				if(isset($_GET['groupCode']) AND $_GET['groupCode']<>""){
					$stmt->bindParam(':groupCode', $_GET['groupCode']);
				}
				if(isset($_GET['search_word']) and isset($_GET['search_word'])){
					$search_word='%'.$_GET['search_word'].'%';
					$stmt->bindParam(':search_word', $search_word);
					$stmt->bindParam(':search_word2', $search_word);
				}
				$stmt->execute();				
				$countTotal=$stmt->rowCount();
				
				$rows=100;
				$page=0;
				if( !empty($_GET["page"]) and isset($_GET["page"]) ) $page=$_GET["page"];
				if($page<=0) $page=1;
				$total_data=$countTotal;
				$total_page=ceil($total_data/$rows);
				if($page>=$total_page) $page=$total_page;
				$start=($page-1)*$rows;
				if($start<0) $start=0;
          ?>
          <span class="label label-primary">ทั้งหมด <?php echo $countTotal; ?> รายการ</span>
        </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
			<div class="row">
			<div class="col-md-6">					
                    <form id="form1" action="<?=$rootPage;?>.php" method="get" class="form" novalidate>
						<!--<div class="form-group">
                            <label for="search_word">Shipping marks search key word.</label>
							<div class="input-group">
								<input id="search_word" type="text" class="form-control" name="search_word" data-smk-msg="Require userFullname."required>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-search"></span>
								</span>
							</div>
                        </div>-->
						<div class="form-group">
                            <label for="search_word">กลุ่ม</label>
							<div class="input-group">
								<select id="groupCode" name="groupCode" class="form-control"  >
									<option value=""> -- Select -- </option>
									<?php
									$sql = "SELECT `id`, `code`, `name`, `statusCode`  FROM `cadet18_person_group` WHERE statusCode='A' ";							
									$stmt = $pdo->prepare($sql);		
									$stmt->execute();
									$selected="";
									while($row = $stmt->fetch()){
										$selected=(isset($_GET['groupCode'])?($_GET['groupCode']==$row['id']?' selected ':''):'');
										echo '<option value="'.$row['code'].'" 
											'.$selected.' 
											 >'.$row['id'].' : '.$row['name'].'</option>';
									}
									?>
								</select>
							</div>
                        </div>
						<div class="form-group">
                            <label for="orderBy">เรียงโดย</label>
							<div class="input-group">
								<select id="orderBy" name="orderBy" class="form-control"  >									
									
									<option value="1" <?php echo (isset($_GET['orderBy'])?($_GET['orderBy']==1?' selected ':''):''); ?> >order No.</option>
									<option value="2" <?php echo (isset($_GET['orderBy'])?($_GET['orderBy']==2?' selected ':''):''); ?> >group : a->z</option>
									<option value="3" <?php echo (isset($_GET['orderBy'])?($_GET['orderBy']==3?' selected ':''):''); ?> >a->z</option>
									<option value="4" <?php echo (isset($_GET['orderBy'])?($_GET['orderBy']==4?' selected ':''):''); ?> >id/importing data</option>
								</select>
							</div>
                        </div>
						<input type="submit" class="btn btn-default" value="ค้นหา">
                    </form>
                </div>    
			</div>
           <?php
                $sql = "SELECT `id`, `orderNo`, `title`, `name`, `surname`, `fullname`, `photo`, `nickname`, `position`
				, `groupCode`, `groupName`, `group2code`, `group2Name`
				, `isInvite`, `isCount`, `statusCode`				
				, IF(left(name,1) IN ('เ','แ','ไ','ใ','โ'),right(name,CHAR_LENGTH(name)-1),name) as nameForOrder 
				FROM cadet18_person a
				WHERE 1 ";
				if(isset($_GET['groupCode']) AND $_GET['groupCode']<>""){
					$sql.="and a.groupCode = :groupCode ";
				}
				if(isset($_GET['search_word']) and isset($_GET['search_word'])){
					$sql.="and (a.id = :search_word OR a.fullname like :search_word2) ";
				}
				if(isset($_GET['orderBy'])){
					switch($_GET['orderBy']){
						case 1 : 
							$sql .="ORDER BY CAST(a.groupCode AS UNSIGNED), CAST(a.group2Code AS DECIMAL(10,2)), orderNo "; 
							break;
						case 2 : 
							$sql .="ORDER BY CAST(a.groupCode AS UNSIGNED), CAST(a.group2Code AS DECIMAL(10,2)), nameForOrder "; 
							break;
						case 3 : 
							$sql .="ORDER BY CAST(a.groupCode AS UNSIGNED), nameForOrder "; 
							break;
						default : 
							$sql .="ORDER BY CAST(a.groupCode AS UNSIGNED), CAST(a.group2Code AS DECIMAL(10,2)), a.id "; 		
					}
				}				
				
				$stmt = $pdo->prepare($sql);
				if(isset($_GET['groupCode']) AND $_GET['groupCode']<>""){
					$stmt->bindParam(':groupCode', $_GET['groupCode']);
				}
				if(isset($_GET['search_word']) and isset($_GET['search_word'])){
					$search_word='%'.$_GET['search_word'].'%';
					$stmt->bindParam(':search_word', $search_word);
					$stmt->bindParam(':search_word2', $search_word);
				}
				
				$stmt->execute();				
           ?>             
            <table class="table table-striped">
                <tr>
                    <th>ลำดับ</th>
					<th>ประเภท</th>	
					<th>ยศ ชื่อ นามสกุล</th>
					<th>การตอบรับ</th>
					<th>มาร่วมงาน</th>
                </tr>
                <?php $c_row=($start+1); while ($row = $stmt->fetch()) { 
					$img = '../images/shippingMarks/'.(empty($row['filePath'])? 'default.jpg' : $row['filePath']);
				?>
                <tr>
                    <td>
                         <?= $c_row; ?>
                    </td>					
					<!--<td>
                         <img class="img-circle" src="<?=$img;?>" alt="Image" width="50" />
                    </td>-->
					<td>
                         <?= $row['groupName']; ?>
                    </td>	
					<td>
                         <?= $row['fullname']; ?>
                    </td>	
					<td>
                         <?php if($row['isInvite']==0){ ?>
							 <a class="btn btn-default" name="btn_row_isInvite" data-statusCode="1" data-id="<?= $row['id']; ?>" >ไม่ตอบรับ</a>
						 <?php }else{ ?>
							 <a class="btn btn-primary" name="btn_row_isInvite" data-statusCode="0" data-id="<?= $row['id']; ?>" >ตอบรับ</a>
						 <?php } ?>
                    </td>
					<td>
                         <?php if($row['isCount']==0){ ?>
							 <a class="btn btn-default" name="btn_row_isCount" data-statusCode="1" data-id="<?= $row['id']; ?>" >ยังไม่มา</a>
						 <?php }else{ ?>
							 <a class="btn btn-success" name="btn_row_isCount" data-statusCode="0" data-id="<?= $row['id']; ?>" >มาแล้ว</a>
						 <?php } ?>
                    </td>	
                    </td>
                </tr>
                <?php $c_row +=1; } ?>
            </table>
			
			<nav>
			<ul class="pagination">
				<li <?php if($page==1) echo 'class="disabled"'; ?> >
					<a href="<?=$rootPage;?>.php?<?=$queryString;?>&=page=<?= $page-1; ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
				</li>
				<?php for($i=1; $i<=$total_page;$i++){ ?>
				<li <?php if($page==$i) echo 'class="active"'; ?> >
					<a href="<?=$rootPage;?>.php?<?=$queryString;?>&page=<?= $i?>" > <?= $i;?></a>			
				</li>
				<?php } ?>
				<li <?php if($page==$total_page) echo 'class="disabled"'; ?> >
					<a href="<?=$rootPage;?>.php?<?=$queryString;?>&page=<?=$page+1?>" aria-labels="Next"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
			</nav>
			
			
			<div class="box-footer">
				<div class="col-md-12">					  
					  <a href="<?=$rootPage;?>_xls.php?<?=$queryString;?>" class="btn btn-default  pull-right"  style="margin-right: 5px;"><i class="glyphicon glyphicon-xls"></i> รายงานข้อมูล (.xlsx)</a>
				</div>
			  </div><!-- box-footer -->
			
			
        </div><!-- /.box-body -->
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

<!-- jQuery 2.2.3 -->
<!--Deprecation Notice: The jqXHR.success(), jqXHR.error(), and jqXHR.complete() callbacks are removed as of jQuery 3.0. 
    You can use jqXHR.done(), jqXHR.fail(), and jqXHR.always() instead.-->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- smoke validate -->
<script src="bootstrap/js/smoke.min.js"></script>
<!-- Add Spinner feature -->
<script src="bootstrap/js/spin.min.js"></script>


<script> 		
$(document).ready(function() {    
			//.ajaxStart inside $(document).ready to start and stop spiner.  
			$( document ).ajaxStart(function() {
				$("#spin").show();
			}).ajaxStop(function() {
				$("#spin").hide();
			});
			//.ajaxStart inside $(document).ready END
			
            $("#title").focus();
            var spinner = new Spinner().spin();
            $("#spin").append(spinner.el);
            $("#spin").hide();
			 
	
	$('a[name=btn_row_isInvite]').click(function(){
		var params = {
			id: $(this).attr('data-id'),
			statusCode: $(this).attr('data-statusCode')
		};
		$.smkConfirm({text:'Are you sure ?',accept:'Yes', cancel:'Cancel'}, function (e){if(e){
			$.post({
				url: '<?=$rootPage;?>_set_invite_ajax.php',
				data: params,
				dataType: 'json'
			}).done(function (data) {					
				if (data.success){ 
					$.smkAlert({
						text: data.message,
						type: 'success',
						position:'top-center'
					});
					location.reload();
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
		}});
		e.preventDefault();
	});
	//end remove
	
	$('a[name=btn_row_isCount]').click(function(){
		var params = {
			id: $(this).attr('data-id'),
			statusCode: $(this).attr('data-statusCode')
		};
		$.smkConfirm({text:'Are you sure ?',accept:'Yes', cancel:'Cancel'}, function (e){if(e){
			$.post({
				url: '<?=$rootPage;?>_set_count_ajax.php',
				data: params,
				dataType: 'json'
			}).done(function (data) {					
				if (data.success){ 
					$.smkAlert({
						text: data.message,
						type: 'success',
						position:'top-center'
					});
					location.reload();
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
		}});
		e.preventDefault();
	});
	//end isCount
	
});
</script>

</body>
</html>
