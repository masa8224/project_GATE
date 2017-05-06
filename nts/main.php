 <div class="w3-container w3-section">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-third">
        <h5>กราฟแสดงสถิติ</h5>
		<?php include('chart.php'); ?>
        
      </div>
      <div class="w3-twothird">
        <h5>ข้อมูลการเข้า-ออกล่าสุด 10 อันดับ</h5>
        <table class="w3-table w3-striped w3-white">
		
		  <?php 
				$con=Connection();
				$Qlog ="SELECT *, RFID.datetime as datetime FROM tb_present, RFID inner join tb_student59 on RFID.UID = tb_student59.uid inner join Plate on tb_student59.student_id = Plate.sid inner join title on tb_student59.title_id = title.id order by RFID.datetime desc limit 11";
				$log = mysqli_query($con,$Qlog);	
				//echo $Qlog;
				while($rs = mysqli_fetch_assoc($log)){

		  ?>
		  <tr>
            <td>
			<?php  if($rs['status']=='1'){ ?>
			<i class="fa fa-user w3-teal w3-padding-tiny"></i> 
			<?php } ?>
			<?php  if($rs['status']=='2'){ ?>
			<i class="fa fa-user w3-red w3-padding-tiny"></i> 
			<?php } ?>
			
			</td>
			 <td><?php echo datetimethaifull($rs['datetime']); ?></td>
            <td><?php echo $rs['title_name'].$rs['s_firstname']." ".$rs['s_lastname']; ?></td>
			<td><?php echo "ม.".($rs['present']-$rs['year_in']+$rs['class'])."/".$rs['room']; ?></td>
            <td><?php echo $rs['plate']; ?></td>
          </tr>
				<?php } ?>
         
        </table>
      </div>
    </div>
  </div>
  <hr>