<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/pepper-grinder/jquery-ui.css" />
    <style type="text/css">
    body {
        font-family:tahoma, "Microsoft Sans Serif", sans-serif, Verdana;
        font-size:12px;
    }
    #input_q{
            width:150px;   
    }
    /*   css ส่วนของรายการที่แสดง  */ 
    .ui-autocomplete {  
        padding-right: 5px;
        max-height:200px !important;
        overflow: auto !important;
    }  
    /*  css  ส่วนปุ่มคลิกเลือกแสดงรายการทั้งหมด*/ 
    .showAll_btn{  
        position: relative;
        top: -2px;    
        border:0px solid;  
        font-size: 10px;
        height: 23px;
        width: 25px;
    }  
    </style>    
</head>
<body>
 
 
 
 
 
<div style="margin:auto;width:80%;">
 
<br><br>
<form id="form001" name="form001" method="post" action="">
   <div>Tags: 
    <input name="input_q" id="input_q" size="50" />
    <button type="button" class="showAll_btn">V</button>
<!--    ส่วนสำหรับกำหนดค่า id ของรายการที่เลือก เพื่อไปใช้งาน-->
    <input name="h_input_q" type="hidden" id="h_input_q" value="" />
    </div>
</form>
 
<pre>
<?php
// ส่วนทดสอบแสดงค่า เมื่อกดปุ่มส่งข้อมูล 
if(count($_POST)>0){
    print_r($_POST);    
}
?>
</pre>
 
</div>
 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>    
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
 
<script type="text/javascript">
    $(function() {
         
        $( "#input_q" ).autocomplete({ // ใช้งาน autocomplete กับ input text id=tags
            minLength: 0, // กำหนดค่าสำหรับค้นหาอย่างน้อยเป็น 0 สำหรับใช้กับปุ่ใแสดงทั้งหมด
            source: "src_sid.php", // กำหนดให้ใช้ค่าจากการค้นหาในฐานข้อมูล
            open:function(){ // เมื่อมีการแสดงรายการ autocomplete
                var valInput=$(this).val(); // ดึงค่าจาก text box id=tags มาเก็บที่ตัวแปร
                if(valInput!=""){ // ถ้าไม่ใช่ค่าว่าง
                    $(".ui-menu-item a").each(function(){ // วนลูปเรียกดูค่าทั้งหมดใน รายการ autocomplete
                        var matcher = new RegExp("("+valInput+")", "ig" ); // ตรวจสอบค่าที่ตรงกันในแต่ละรายการ กับคำค้นหา
                        var s=$(this).text();
                        var newText=s.replace(matcher, "<b>$1</b>");    //      แทนค่าที่ตรงกันเป็นตัวหนา
                        $(this).html(newText); // แสดงรายการ autocomplete หลังจากปรับรูปแบบแล้ว
                    }); 
                }
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
 
         
    });
</script>
 
     
</body>
</html>