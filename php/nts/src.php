<?php	//echo "regis"; 
	session_start();
	if($_SESSION['Auser']==""){
		echo "กรุณาล็อกอิน";
	}else{
	?>
	 
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>    
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/pepper-grinder/jquery-ui.css">
 
<script type="text/javascript">
    $(function() {
         
        $( "#input_q" ).autocomplete({ // ใช้งาน autocomplete กับ input text id=tags
            minLength: 0, // กำหนดค่าสำหรับค้นหาอย่างน้อยเป็น 0 สำหรับใช้กับปุ่ใแสดงทั้งหมด
            source: "src_sid.php", // กำหนดให้ใช้ค่าจากการค้นหาในฐานข้อมูล
            open:function(){ // เมื่อมีการแสดงรายการ autocomplete
                var valInput=$(this).val(); // ดึงค่าจาก text box id=tags มาเก็บที่ตัวแปร
              /*  if(valInput!=""){ // ถ้าไม่ใช่ค่าว่าง
                    $(".ui-menu-item a").each(function(){ // วนลูปเรียกดูค่าทั้งหมดใน รายการ autocomplete
                        var matcher = new RegExp("("+valInput+")", "ig" ); // ตรวจสอบค่าที่ตรงกันในแต่ละรายการ กับคำค้นหา
                        var s=$(this).text();
                        var newText=s.replace(matcher, "<b>$1</b>");    //      แทนค่าที่ตรงกันเป็นตัวหนา
                        $(this).html(newText); // แสดงรายการ autocomplete หลังจากปรับรูปแบบแล้ว
                    }); 
                }*/
            },
            select: function( event, ui ) {
                // สำหรับทดสอบแสดงค่า เมื่อเลือกรายการ
//              console.log( ui.item ?
//                  "Selected: " + ui.item.label :
//                  "Nothing selected, input was " + this.value);
                $("#h_input_q").val(ui.item.id); // เก็บ id ไว้ใน hiden element ไว้นำค่าไปใช้งาน
//                setTimeout(function(){
//                  $("#h_input_q").parents("form").submit(); // เมื่อเลือกรายการแล้วให้ส่งค่าฟอร์ม ทันที
//                },500);
            }
        });
 
        $(".showAll_btn").click(function(){
            // ตรวจสอบถ้ามีการแสดงรายการทั้งหมดอยู่แล้ว  
            if ($( "#input_q" ).autocomplete( "widget" ).is( ":visible" ) ) {  
                $( "#input_q" ).autocomplete( "close" ); // ปิดการแสดงรายการทั้งหมด  
                return;  
            }  
            // ส่งค่าว่างปล่าวไปทำการค้นหา จะได้ผลลัพธ์เป็นรายการทั้งหมด  
            $( "#input_q" ).autocomplete( "search", "" );  
 
            $( "#input_q" ).focus(); //ให้ cursor ไปอยู่ที่ input text id=tags              
        });
		$('document').ready(function(){
			$('#input_q').change(function(){
				 $.post("src2.php",
				{	
					strMode : 'src',
					sid: $('#input_q').val()
					
					
				},
				function(data, status){
				//alert("Data: " + data + "\nStatus: " + status);
				$('#show_src').html(data);
				});
								
			});
			
			
		});
         
    });
</script>
<div style="margin:auto;width:80%;">
 



	
<div class="w3-container w3-card-4 w3-light-grey w3-text-indigo w3-margin">
<h2 class="w3-center">สืบค้นนักเรียนรายคน</h2>
<p>** ขั้นตอนการค้นหาข้อมูลนักเรียน ให้พิมพ์ชื่อนักเรียนที่ต้องการค้นหา เมื่อปรากฏชื่อให้คลิกเลือกชื่อที่ต้องการจากนั้น กด enter 1 ครั้งเพื่อยืนยัน</p>
<p>**หากต้องการค้นหาใหม่ให้ลบข้อมูลเดิมแล้วพิมพ์ข้อมูลใหม่ได้</p>
 <div id="status_add"></div>
<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
    <div class="w3-rest">
      <input name="input_q" id="input_q" class="w3-input w3-border" placeholder="พิมพ์ชื่อนักเรียนเพื่อค้นหา"/>  
	   
	    <input name="h_input_q" type="hidden" id="h_input_q" value="" class="w3-input w3-border"/>  
    </div>
</div>
</p><div id="show_src"></div>
</div>
	<?php } ?>