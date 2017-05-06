<?php	//echo "stu"; ?>
<script>
$('document').ready(function(){
	$('#form_add').hide();
$('#show_form_add').click(function(){
				$('#form_add').slideDown();
			});
			$('#btn_close').click(function(){
				$('#form_add').slideUp();
			});
			});
</script>
<?php 
	$con = Connection();
	$Std = "select * from tb_present, tb_student59 inner join Plate on tb_student59.student_id = Plate.SID inner join title on tb_student59.title_id = title.id ";
	$Qstd = mysqli_query($con,$Std);
	//echo $Std;
	
	$count = mysqli_num_rows($Qstd);
	
?>
<center>
<h2>สถิตินักเรียนมาโรงเรียน <span class="w3-badge w3-teal"> <?php echo $count; ?>  </span>  คน </h2>
<button id="show_form_add" class="w3-btn w3-light-green">เพิ่มข้อมูลลงทะเบียน</button>
<div id="form_add"><?php include('regis.php'); ?> </div></div>
<p>
<table class="w3-table-all w3-hoverable w3-bordered w3-centered" >
<thead>
  <tr >
   <th > <div align="center">ลำดับ</div></th>
    <th > <div align="center">รหัสนักเรียน</div></th>
	
      <th > <div align="center">ชื่อ-นามสกุล</div></th>
   

	<th > <div align="center">ระดับชั้น</div></th>
	<th > <div align="center">เบอร์โทรผู้ปกครอง</div></th>
	<th > <div align="center">สถานะส่ง SMS</div></th>
	    <th > <div align="center">เลขทะเบียน</div></th>
		<th > <div align="center">จังหวัด</div></th>
		 <th > <div align="center">รุ่นรถ</div></th>
		 
		 <th > <div align="center">เครื่องมือ</div></th>

  </tr>
  <?php
  
  while($rs = mysqli_fetch_array($Qstd)){
	$i++;    
	  
  ?>
  <tr>
  <td><?php echo $i; ?></td>
  <td><?php echo $rs['SID']; ?></td>
 
  <td class="w3-left"><?php echo $rs['title_name'].$rs['s_firstname']." ".$rs['s_lastname'];; ?></td>
  <td><?php echo "ม.".($rs['present']-$rs['year_in']+$rs['class'])."/".$rs['room']; ?></td>
  <td><?php echo $rs['guard_tel']; ?></td>
  <td><?php if($rs['sms']==1){ echo "ส่งSMS"; }   ?></td>
  <td><?php echo $rs['plate']; ?></td>
  <td><?php echo $rs['province']; ?></td>
  <td><?php echo $rs['Model']; ?></td>
  <td></td>
  </tr>
  <?php } ?>
  </table>