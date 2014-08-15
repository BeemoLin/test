<?php
/*
20121109 修改日曆元件的顯示
*/
?>

<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);
$logoutAction = 'logout.php';



define("Gym","1000");
define("PartyRoom","1003");
define("HearCenter","1002");
define("Barbecue","1001");
function GetUnit($equid){
  switch($equid){
  
    case Barbecue:
      $unit="使用爐數";
      break;
    case Gym:  
    case PartyRoom:
    case HearCenter:
    default:              
      $unit="使用人數";
      break;
  }

  return $unit;

}


if (isset($_GET['equipment_id'])) {
  $equipment_id = $_GET['equipment_id'];
}
else{
	header('Location: reservation.php');
	exit();
}

$query_Recordset1 = "
SELECT *
FROM `equipment_reservation`
WHERE `equipment_id` = '".$equipment_id."'
	AND `equipment_disable` = '0' 
	AND `equipment_stop` = '0' 
	AND `equipment_hidden` = '0'
";
$Recordset = mysql_query($query_Recordset1, $connSQL) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);

$processTime= split(":", $row_Recordset['advance_end']);
$end_hour=$processTime[0];
$endTime=$processTime[0]-1;
$strendTime=($endTime<10)?"0".(string)$endTime.":00:00":(string)$endTime.":00:00";

$unitTitle=GetUnit($equipment_id);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>公設預約</title>
<script language="javascript" type="text/javascript" src="includes/My97DatePicker/01_WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="includes/reservation.js"></script>
<script type="text/javascript">
<!--
var advance_start = '<?php echo $row_Recordset['advance_start'];?>';
var advance_end = '<?php echo $strendTime;?>';
var equipment_max_people = '<?php echo $row_Recordset['equipment_max_people'];?>';
var end_hour='<?php echo $end_hour;?>';


const PartyRoom="1003";
const Gym="1000";
const HearCenter="1002";
const Barbecue="1001";

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
function mark(){
 /*
        var equipmentid= document.getElementById("equipment_id").value;
         
        var listtime= document.getElementById("set_list_time").value;
        
        var timeformat= listtime.split(":");
        var hour=timeformat[0];
        var min=timeformat[1];
        var sec="00";
        if(equipmentid=="10")
        {
            hour=parseInt(hour,10)+3;
        }
        else
        {
            hour=parseInt(hour,10)+2;
        }
        
        hour=(hour>=parseInt(end_hour,10))?parseInt(end_hour,10):hour;//>=最大時間,則就是最大時間
        min=(hour>=parseInt(end_hour,10))?"00":min;//最大時間,分為00
        
        hour=(hour>9)?String(hour):"0"+String(hour);
        document.getElementById("list_endtime").value=hour+":"+min+":"+sec;//20121117
        
        
        document.getElementById("list_time_format").value=listtime+"~"+hour+":"+min+":"+sec;
    
        //alert(document.getElementById("list_time_format").value);
    */
}
function check(){
		var v1 = document.getElementById("set_list_date").value;
		var v2 = document.getElementById("set_list_time").value;
		var v3 = document.getElementById("max_people_hidden").value;
    //var v4 = document.getElementById("equipment_exclusive").value;
    var v5 = document.getElementById("equipment_max_people").value;
    
		if(v1 == ""){
      alert('請選擇日期');
    }
    else if(v2 == ""){
      alert('請選擇時間');
    }
    /*else if(v4 == "0" && v3 == ""){
      alert('請選擇人數');
    }*/
    else{
    
        document.getElementById("equipment_exclusive").value=(parseInt(v5)>0)?0:1;//201407 by akai for equipment_reservation_check.php新增用
        //mark();
        listtime=document.getElementById("show_check_reservation2").innerHTML;
      
        var timeblock= listtime.split(" ");
        var timeList=timeblock[0].split("~");
        //alert(timeList[0]);//開始時間
        //alert(timeList[1]);//結束時間
        //return;
        document.getElementById("set_list_time").value=timeList[0];
        document.getElementById("list_endtime").value= timeList[1];
        document.getElementById("list_time_format").value=timeblock[0];
        document.form1.submit();
    }
    return false;
  }
	

	function edate_yes(){
	    //--------FOR CC80每個公設都有各自的準則------------	
	  var equid=document.getElementById("equipment_id").value;
    switch(equid){
	   case Gym:
        var list_date = document.getElementById("list_date").value; 
        var today = new Date();
        var today_year = today.getFullYear(); //西元年份
        var today_month = today.getMonth()+1; //一年中的第幾月
        var today_date = today.getDate(); //一月份中的第幾天
        //var today_hours = today.getHours(); //一天中的小時數
        //var today_minutes = today.getMinutes(); //一天中的分鐘
        //var today_seconds = today.getSeconds(); //一天中的秒數
        
        var CurrentDate = today_year+"/"+today_month+"/"+today_date;//+"  "+today_hours+":"+today_minutes+":"+today_seconds;
         
        if((Date.parse(list_date.replace(/-/g, "/"))).valueOf() < (Date.parse(CurrentDate)).valueOf() || (Date.parse(list_date.replace(/-/g, "/"))).valueOf() >(Date.parse(CurrentDate)).valueOf()){
            alert("限當天登記");
            document.getElementById("list_date").value="";
            return;
        }/*else{alert("預約日期在指定區間內");}*/
        break;
      case PartyRoom:
      case Barbecue:
      
        break;
      case HearCenter:
        var list_date = document.getElementById("list_date").value; 
        
        var datelist = list_date.split("-");   
        var newdt = new Date(Number(datelist[0]),Number(datelist[1])-1,Number(datelist[2])+1);   
        repnewdt = newdt.getFullYear() + "-" + (newdt.getMonth()+1) + "-" + newdt.getDate();   
        
        document.getElementById("list_date").value =repnewdt;
        
        break;
   } 
   //--------FOR CC80每個公設都有各自的準則------------
		if(document.getElementById("list_date").value != ""){
			checkReservation1();
		}
	}	
	function edate_no(){
		document.getElementById("list_date_yes").disabled=false;
		document.getElementById("set_list_date").value = "";
		document.getElementById("set_list_time").value = "";
		document.getElementById("list_date").disabled=false;
		document.getElementById("list_time").disabled=true;
		//document.getElementById("equipment_max_people").disabled=true;
		document.getElementById("show_check_reservation1").innerHTML = "";
		document.getElementById("show_check_reservation1").value = "";
		document.getElementById("show_check_reservation2").innerHTML = "";
		document.getElementById("show_check_reservation2").value = "";
		document.getElementById("show_check_reservation3").innerHTML = "";

		
		document.getElementById("list_date_hidden").style.display="";
		document.getElementById("list_time_hidden").style.display="none";
		document.getElementById("max_people_hidden").style.display="none";
	}
	
	
	//cc80 :有1小時 2小時 4小時
	
	function etime_yes(){
	
	  //20121109增加判斷;否則會錯誤   重要!!!!
	  if(document.getElementById("list_time").value == "")
	  {
	     alert('請選擇時間');
	     return;
	  }
	  //-----------------
	  //20121109增加判斷 可以註解IF
		checkReservation2();
		if(document.getElementById("list_time").value != "")
    {
      if(document.getElementById("equipment_exclusive").value == "1" | document.getElementById("equipment_exclusive").value == "0")
      {
        
        document.getElementById("list_time_yes").disabled=true;
        document.getElementById("list_date").disabled=true;
        document.getElementById("set_list_time").value = document.getElementById("list_time").value;
        document.getElementById("list_time").disabled=true;
        //20121109不顯示用戶人數
        //先remark
        //2014/07 By akai for 跑步機人數統計 放到reservation.js
        /*if(document.getElementById("equipment_id").value=="1"){
          //alert('11');
          document.getElementById("max_people_hidden").style.display="";
          document.getElementById("equipment_max_people").style.display="";
          document.getElementById("equipment_max_people").disabled=false;
          document.getElementById("equipment_max_people").value="1";
        }*/
        
        document.getElementById("list_date_hidden").style.display="";
        document.getElementById("list_time_hidden").style.display="";
       // document.getElementById("submit01").style.display=""; 放到reservation.js
        document.getElementById("equipment_exclusive").value="1";//20121110  0 或1都設成1 動javascript不動php怕影響其他的程式
        //alert('TEST');
      }
      /*
      else if(document.getElementById("equipment_exclusive").value == "0")
      {
        //alert('22');
        document.getElementById("list_time_yes").disabled=true;
        document.getElementById("list_date").disabled=true;
        document.getElementById("set_list_time").value = document.getElementById("list_time").value;
        document.getElementById("list_time").disabled=true;
        //20121109不顯示用戶人數
        //document.getElementById("equipment_max_people").disabled=false;
        //document.getElementById("equipment_max_people").value="1";
        
        document.getElementById("list_date_hidden").style.display="";
        document.getElementById("list_time_hidden").style.display="";
        //document.getElementById("max_people_hidden").style.display="none";
        document.getElementById("submit01").style.display="";
      }
      */
      //document.getElementById("max_people_hidden").style.display="none"; //""代表SHOW
		}
	}	
	function etime_no(){
		document.getElementById("list_time_yes").disabled=false;
		document.getElementById("list_date").disabled=true;
		document.getElementById("set_list_time").value = "";
		document.getElementById("list_time").disabled=false;
		//document.getElementById("equipment_max_people").disabled=true;
		document.getElementById("show_check_reservation2").innerHTML = "";
		document.getElementById("show_check_reservation2").value = "";
		document.getElementById("show_check_reservation3").innerHTML = "";
		
		document.getElementById("list_date_hidden").style.display="";
		document.getElementById("list_time_hidden").style.display="";
		document.getElementById("max_people_hidden").style.display="none";
    document.getElementById("submit01").style.display="none";
	}
	
  
	function enumber_cheng(){
    var r2_number = document.getElementById("reservation2_number").value;
    
    //cc80要計算價錢
    var equid = document.getElementById("equipment_id").value;
    //alert(equid);
    switch(equid){
      case Gym:  //艾美健身房
         var price= parseInt(document.getElementById("equipment_max_people").value,10)*20;
         document.getElementById("show_price").innerHTML="付費:"+price;
         break;
      case PartyRoom:  
      case HearCenter:
         var price= parseInt(document.getElementById("equipment_max_people").value,10)*100;
         document.getElementById("show_price").innerHTML="付費:"+price;
         break;
         
      case Barbecue:
         var price= parseInt(document.getElementById("equipment_max_people").value,10)*300;
         document.getElementById("show_price").innerHTML="付費:"+price;
         break;
      
      default:
           document.getElementById("show_price").innerHTML="";
    
    
    }
    //var emax_people = document.getElementById("equipment_max_people").value;
    //if((equipment_max_people - r2_number - emax_people) > 0){
      //目前
    //}
		

	}	
	function show_time(){
	//當日期點完的時候;會跑來這裡執行

    var equid=document.getElementById("equipment_id").value;
    
    var list_date_value = document.getElementById('list_date').value;
		
    var list_time = document.getElementById('list_time'); //取時間元件的ID
		//list_time.setAttribute("style","visibility: visible");
    //list_time.style.visbility

    now = new Date();
		year = now.getUTCFullYear();
		
		if((now.getMonth()+1)<10){
			month = now.getMonth()+1;
			month = '0'+month;
		}
		else{
			month = now.getMonth()+1;
		}
		
		if(now.getDate()<10){
			date = now.getDate();
			date = '0'+date;
		}
		else{
			date = now.getDate();
		}
		//時間元件設定屬性
    //list_time.setAttribute("onClick","WdatePicker({minDate:'{%H}:30:00',maxDate:'" + advance_end + "',dateFmt:'HH:mm:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..']})");
	
		if(list_date_value==year+"-"+month+"-"+date)
    {
    <?php
      /*今天日期
      alert("1");
      alert(list_date_value);
      alert(year+"-"+month+"-"+date);
			list_time.setAttribute("onClick","WdatePicker({minDate:'{%H+3}:00:00',maxDate:'" + advance_end + "',dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..']})");
      */
    ?>
      nowhour=now.getHours();
		  nowhour=nowhour+1;
		 // alert(nowhour);
		//alert(nowhour);
		//alert(advance_start_hour);
		//22 21;
		//預約要在前一個小時 如8點則要再7點多預約
		  advance_start_hour= advance_start.split(":")[0];
		  //alert(advance_start_hour);
		  
		  advance_end_hour= advance_end.split(":")[0];
		  //alert(advance_end_hour);
		  
		 // alert(advance_start_hour);
		 // alert(advance_end_hour);
		  nowhour=(nowhour>advance_end_hour|nowhour<advance_start_hour)?24:nowhour;
		  nowhour =(nowhour<10)?'0'+nowhour+':00:00':nowhour+':00:00';
		   
      //list_time.onclick= function() { WdatePicker({qsEnabled:false,minDate:'{%H+3}:00:00',maxDate:advance_end,dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..'],qsEnabled:false}); };
		  //20121109
    
     switch(equid){
      case Gym:
      case PartyRoom:
      case Barbecue:
          list_time.onclick= function() { WdatePicker({minDate:nowhour,maxDate:advance_end,dateFmt:'HH:mm:00',disabledDates:['\:05\:','\:10\:','\:15\:','\:20\:','\:25\:','\:30\:','\:35\:','\:40\:','\:45\:','\:50\:','\:55\:']}); };
   
        break;
      case HearCenter:
          list_time.onclick= function() { WdatePicker({minDate:advance_start,maxDate:advance_end,dateFmt:'HH:00:00',disabledDates:['\:05\:','\:10\:','\:15\:','\:20\:','\:25\:','\:30\:','\:35\:','\:40\:','\:45\:','\:50\:','\:55\:']}); };
  	     break;
      default:
          list_time.onclick= function() { WdatePicker({minDate:nowhour,maxDate:advance_end,dateFmt:'HH:mm:00',disabledDates:['\:05\:','\:10\:','\:15\:','\:20\:','\:25\:','\:35\:','\:40\:','\:45\:','\:50\:','\:55\:']}); };
     }
    
      
    }else{
    <?php
      /*其他日期
      alert("2");
      alert(list_date_value);
      alert(year+"-"+month+"-"+date);
			list_time.setAttribute("onClick","WdatePicker({minDate:'" + advance_start + "',maxDate:'" + advance_end + "',dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..']})");
      list_time.onclick="WdatePicker({minDate:'" + advance_start + "',maxDate:'" + advance_end + "',dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..']})";
      */
    ?>
      //list_time.onclick= function() { WdatePicker({qsEnabled:false,minDate:advance_start,maxDate:advance_end,dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..']}); };
		   //20121109
  		  switch(equid){
          case Gym:
          case PartyRoom:
          case HearCenter:
          case Barbecue:
            list_time.onclick= function() { WdatePicker({minDate:advance_start,maxDate:advance_end,dateFmt:'HH:mm:00',disabledDates:['\:05\:','\:10\:','\:15\:','\:20\:','\:25\:','\:30\:','\:35\:','\:40\:','\:45\:','\:50\:','\:55\:']}); };
  	
        
            break;
        
          default:
        
            list_time.onclick= function() { WdatePicker({minDate:advance_start,maxDate:advance_end,dateFmt:'HH:mm:00',disabledDates:['\:05\:','\:10\:','\:15\:','\:20\:','\:25\:','\:35\:','\:40\:','\:45\:','\:50\:','\:55\:']}); };
     
        
        }
       
      }
	}
function seeklistmenu() 
{
//20121119

  var listdate=document.getElementById("list_date").value;
  var seek_startdate;
  var seek_enddate;
  //alert(document.getElementById("set_list_date").value);
 if(listdate=="")
 {  
  //抓取當月的全部區段
 	  now = new Date();
		
		//年
    year = now.getUTCFullYear();
    year1=year;
			
		//月
		month=now.getMonth()+1;//從0到11
		
    month1=month+2;//11+2=13 12+2=14
    if(month1>12)
    {
      month1=month1-12;
      year1=year1+1;
    }
    month=(month<10)?'0'+month:month;
    
    month1=(month1<10)?'0'+month1:month1;
      
		 list_startdate=year+"-"+month+"-"+now.getDate();
	   list_enddate=year1+"-"+month1+"-"+"31";
	 
 }
 else
 {
 
      list_startdate=listdate;
      
      var timeformat= list_startdate.split("-");
      
      year=parseInt(timeformat[0],10);
      month=parseInt(timeformat[1],10)+2;
      //timeformat[1]=timeformat[1]+2;
      if(month>12)
      {
        month=month-12;
        year=year+1;
      }
      month=(month<10)?'0'+month:month;
      list_enddate=year+"-"+month+"-"+"31";//扣兩個字元
  // alert(list_enddate);
 
 }


  //window.showModalDialog('list_reservation_menu.php?equipment_id='+ document.getElementById("equipment_id").value+'&list_startdate='+list_startdate+'&list_enddate='+list_enddate,,"Dialog Box Arguments # 2","dialogHeight: 250px; dialogWidth: 250px; dialogTop: 250px; dialogLeft: 250px; edge: Raised; center: Yes; help: No; resizable: No; status: No;");



  window.name = 'rootWindow';
  //條件維設備的ID與查詢的日期今天到月底(都到31,因為資料庫搜尋無就無,不用在考慮28 或 30日的問題)
  //使用Javascript將網址編碼，請愛用 encodeURIComponent()。因為 encodeURIComponent 才可對 "＆" 進行編碼，使得傳遞參數成為可能。
  //編碼後，PHP 用 urldecode() 即可輕鬆解碼，取得正確的參數值～
  window.remoteWindow = window.open('list_reservation_menu.php?equipment_id='+ document.getElementById("equipment_id").value+'&list_startdate='+list_startdate+'&list_enddate='+list_enddate,'','height=300,width=530,fullscreen=no,top=210,left=100,scrollbars=yes,toolbar=no,menubar=no,resizable=no,location=no,status=no');
  //height=530,width=780,
  
  //'fullscreen=yes,Status=yes,scrollbars=yes,resizable=no ')       
        //window.remoteWindow.moveTo(0,0);
        //window.remoteWindow.resizeTo(screen.availWidth,screen.availHeight);
        //window.remoteWindow.resizeTo(screen.availWidth,screen.availHeight);       
        //window.remoteWindow.outerWidth=screen.availWidth;
        //window.remoteWindow.outerHeight=screen.availHeight;
  
  window.remoteWindow.window.focus();
  
//window.open("http://把你想要彈出的﹝網頁；網站；圖片；文件；各類型檔案﹞的網址寫在這裡","show","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,fullscreen=no,height=300,width=350,top=100,left=20");
}
  

//-->
</script>





<link href="CSS/link.css" rel="stylesheet" type="text/css" />
<link href="CSS/define.css" rel="stylesheet" type="text/css" />
</head>

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif','img/BTN/already_dn.png')">
  <?php include('layout/template.html'); ?>
</body>
</html>
