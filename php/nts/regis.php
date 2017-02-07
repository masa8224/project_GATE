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
			$('#btn_add').click(function(){
				//alert("666");
				 $.post("regis2.php",
				{	
					strMode : 'add',
					sid: $('#input_q').val(),
					plate: $('#plate').val(),
					province: $('#province').val(),
					brand: $('#brand').val(),
					model: $('#model').val(),
					color: $('#color').val(),
					sms:$('#sms').val(),
					tel:$('#tel').val()
					
				},
				function(data, status){
				//alert("Data: " + data + "\nStatus: " + status);
				$('#status_add').html(data);
				});
				
			});
			$('#btn_save_edit').click(function(){
				//alert("666");
				 $.post("regis2.php",
				{	
					strMode : 'edit',
					sid: $('#input_q').val(),
					plate: $('#plate').val(),
					province: $('#province').val(),
					brand: $('#brand').val(),
					model: $('#model').val(),
					color: $('#color').val(),
					sms:$('#sms').val(),
					tel:$('#tel').val()
					
				},
				function(data, status){
				//alert("Data: " + data + "\nStatus: " + status);
				$('#status_add').html(data);
				});
				
			});
			
			
		});
         
    });
</script>
<div style="margin:auto;width:80%;">
 



	
<div class="w3-container w3-card-4 w3-light-grey w3-text-indigo w3-margin">
<h2 class="w3-center">ลงทะเบียนนักเรียน</h2>
 <div id="status_add"></div>
<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
    <div class="w3-rest">
      <input name="input_q" id="input_q" class="w3-input w3-border" placeholder="พิมพ์ชื่อนักเรียนเพื่อค้นหา"/>  
	   
	    <input name="h_input_q" type="hidden" id="h_input_q" value="" class="w3-input w3-border"/>  
    </div>
</div>

<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-credit-card"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border" id="plate" type="text" placeholder="ป้ายทะเบียนรถ">
    </div>
</div>

<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-globe"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border" id="province" type="text" placeholder="จังหวัด">
    </div>
</div>

<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-cc"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border" id="brand" type="text" placeholder="ยี้ห้อรถ">
    </div>
</div>

<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-motorcycle"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border" id="model" type="text" placeholder="รุ่น">
    </div>
</div>
<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-podcast"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border" id="color" type="text" placeholder="สี">
    </div>
</div>
<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-phone"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border" id="tel" type="text" placeholder="เบอร์โทรศัพท์ผู้ปกครอง">
    </div>
</div>
<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge "></i></div>
    <div class="w3-rest">
      <input id="sms" class="w3-check " type="checkbox">
<label class="w3-validate ">ส่ง  SMS ถึงผู้ปกครอง</label>
    </div>
</div>

<p class="w3-center">
<button id="btn_add" class="w3-btn w3-section w3-teal w3-ripple"> ลงทะเบียนนักเรียน </button>
<button id="btn_save_edit" class="w3-btn w3-section w3-orange w3-ripple"> บันทึกการแก้ไข </button>
<button id="btn_close" class="w3-btn w3-section w3-red w3-ripple"> ปิด </button>
</p>
</div>
	<?php } ?>