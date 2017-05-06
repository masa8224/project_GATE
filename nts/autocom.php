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
    /*   css ��ǹ�ͧ��¡�÷���ʴ�  */ 
    .ui-autocomplete {  
        padding-right: 5px;
        max-height:200px !important;
        overflow: auto !important;
    }  
    /*  css  ��ǹ������ԡ���͡�ʴ���¡�÷�����*/ 
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
<!--    ��ǹ����Ѻ��˹���� id �ͧ��¡�÷�����͡ �������ҹ-->
    <input name="h_input_q" type="hidden" id="h_input_q" value="" />
    </div>
</form>
 
<pre>
<?php
// ��ǹ���ͺ�ʴ���� ����͡������觢����� 
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
         
        $( "#input_q" ).autocomplete({ // ��ҹ autocomplete �Ѻ input text id=tags
            minLength: 0, // ��˹��������Ѻ�������ҧ������ 0 ����Ѻ��Ѻ�����ʴ�������
            source: "src_sid.php", // ��˹�������Ҩҡ��ä���㹰ҹ������
            open:function(){ // ������ա���ʴ���¡�� autocomplete
                var valInput=$(this).val(); // �֧��Ҩҡ text box id=tags ���纷������
                if(valInput!=""){ // ������������ҧ
                    $(".ui-menu-item a").each(function(){ // ǹ�ٻ���¡�٤�ҷ������ ��¡�� autocomplete
                        var matcher = new RegExp("("+valInput+")", "ig" ); // ��Ǩ�ͺ��ҷ��ç�ѹ�������¡�� �Ѻ�Ӥ���
                        var s=$(this).text();
                        var newText=s.replace(matcher, "<b>$1</b>");    //      ᷹��ҷ��ç�ѹ�繵��˹�
                        $(this).html(newText); // �ʴ���¡�� autocomplete ��ѧ�ҡ��Ѻ�ٻẺ����
                    }); 
                }
            },
            select: function( event, ui ) {
                // ����Ѻ���ͺ�ʴ���� ��������͡��¡��
//              console.log( ui.item ?
//                  "Selected: " + ui.item.label :
//                  "Nothing selected, input was " + this.value);
                $("#h_input_q").val(ui.item.id); // �� id ���� hiden element ���Ӥ�����ҹ
//                setTimeout(function(){
//                  $("#h_input_q").parents("form").submit(); // ��������͡��¡����������觤�ҿ���� �ѹ��
//                },500);
            }
        });
 
        $(".showAll_btn").click(function(){
            // ��Ǩ�ͺ����ա���ʴ���¡�÷�������������  
            if ($( "#input_q" ).autocomplete( "widget" ).is( ":visible" ) ) {  
                $( "#input_q" ).autocomplete( "close" ); // �Դ����ʴ���¡�÷�����  
                return;  
            }  
            // �觤����ҧ�����价ӡ�ä��� ������Ѿ������¡�÷�����  
            $( "#input_q" ).autocomplete( "search", "" );  
 
            $( "#input_q" ).focus(); //��� cursor ������� input text id=tags              
        });
 
         
    });
</script>
 
     
</body>
</html>