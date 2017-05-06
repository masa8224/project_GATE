<?php
header("Content-type:application/json; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);       
// ส่วนของการเชิ่อมต่อกับฐานข้อมูล  
mysql_connect("localhost","root","00125410") or die("Cannot connect the Server");  
mysql_select_db("arduino") or die("Cannot select database");  
mysql_query("set character set utf8");  
?>
 
<?php
$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db="tb_student59"; // ตารางที่ต้องการค้นหา
$find_field="s_firstname"; // ฟิลที่ต้องการค้นหา
if($_GET['term']!=""){
    $q = $_GET["term"];
    $sql = "select * from $table_db 
    where  locate('$q', $find_field) > 0 
    order by locate('$q', $find_field), $find_field limit $pagesize";
}else{
    $sql = "select * from $table_db  where 1 limit $pagesize";      
}
$qr=mysql_query($sql);
$total=mysql_num_rows($qr);
while($rs=mysql_fetch_array($qr)) {
    $json_data[]=array(  
        "id"=>$rs['student_id'],  
        "label"=>$rs['student_id']." ชื่อ ".$rs['s_firstname']."  ".$rs['s_lastname'],  
        "value"=>$rs['student_id'],  
    );    
}  
$json= json_encode($json_data);  
echo $json;  
mysql_close();  
exit;
?>