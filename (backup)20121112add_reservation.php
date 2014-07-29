<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);

$logoutAction = 'logout.php';

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
var advance_end = '<?php echo $row_Recordset['advance_end'];?>';
var equipment_max_people = '<?php echo $row_Recordset['equipment_max_people'];?>';

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

  function check(){
		var v1 = document.getElementById("set_list_date").value;
		var v2 = document.getElementById("set_list_time").value;
		var v3 = document.getElementById("max_people_hidden").value;
    var v4 = document.getElementById("equipment_exclusive").value;
    
		if(v1 == ""){
      alert('請選擇日期');
    }
    else if(v2 == ""){
      alert('請選擇時間');
    }
    else if(v4 == "0" && v3 == ""){
      alert('請選擇人數');
    }
    else{
      document.form1.submit();
    }
    return false;
  }
	
	function edate_yes(){
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
		document.getElementById("equipment_max_people").disabled=true;
		document.getElementById("show_check_reservation1").innerHTML = "";
		document.getElementById("show_check_reservation1").value = "";
		document.getElementById("show_check_reservation2").innerHTML = "";
		document.getElementById("show_check_reservation2").value = "";
		document.getElementById("show_check_reservation3").innerHTML = "";

		
		document.getElementById("list_date_hidden").style.display="";
		document.getElementById("list_time_hidden").style.display="none";
		document.getElementById("max_people_hidden").style.display="none";
	}
	
	function etime_yes(){
		checkReservation2();
		if(document.getElementById("list_time").value != ""){
      if(document.getElementById("equipment_exclusive").value == "1"){
        document.getElementById("list_time_yes").disabled=true;
        document.getElementById("list_date").disabled=true;
        document.getElementById("set_list_time").value = document.getElementById("list_time").value;
        document.getElementById("list_time").disabled=true;
        document.getElementById("equipment_max_people").disabled=false;
        
        document.getElementById("list_date_hidden").style.display="";
        document.getElementById("list_time_hidden").style.display="";
        document.getElementById("submit01").style.display="";
      }
      else if(document.getElementById("equipment_exclusive").value == "0"){
        document.getElementById("list_time_yes").disabled=true;
        document.getElementById("list_date").disabled=true;
        document.getElementById("set_list_time").value = document.getElementById("list_time").value;
        document.getElementById("list_time").disabled=true;
        document.getElementById("equipment_max_people").disabled=false;
        
        document.getElementById("list_date_hidden").style.display="";
        document.getElementById("list_time_hidden").style.display="";
        document.getElementById("max_people_hidden").style.display="";
        document.getElementById("submit01").style.display="";
      }
		}
	}	
	function etime_no(){
		document.getElementById("list_time_yes").disabled=false;
		document.getElementById("list_date").disabled=true;
		document.getElementById("set_list_time").value = "";
		document.getElementById("list_time").disabled=false;
		document.getElementById("equipment_max_people").disabled=true;
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
    var emax_people = document.getElementById("equipment_max_people").value;
    //if((equipment_max_people - r2_number - emax_people) > 0){
      //目前
    //}
		

	}	

	
	
	function show_time(){
		var list_time = document.getElementById('list_time'); 
		//list_time.setAttribute("style","visibility: visible");
    //list_time.style.visbility
		var list_date_value = document.getElementById('list_date').value;
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
		
		if(list_date_value==year+"-"+month+"-"+date){
    <?php
      /*
      alert("1");
      alert(list_date_value);
      alert(year+"-"+month+"-"+date);
			list_time.setAttribute("onClick","WdatePicker({minDate:'{%H+3}:00:00',maxDate:'" + advance_end + "',dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..']})");
      */
    ?>
      list_time.onclick= function() { WdatePicker({qsEnabled:false,minDate:'{%H+3}:00:00',maxDate:advance_end,dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..'],qsEnabled:false}); };
		}
		else{
    <?php
      /*
      alert("2");
      alert(list_date_value);
      alert(year+"-"+month+"-"+date);
			list_time.setAttribute("onClick","WdatePicker({minDate:'" + advance_start + "',maxDate:'" + advance_end + "',dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..']})");
      list_time.onclick="WdatePicker({minDate:'" + advance_start + "',maxDate:'" + advance_end + "',dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..']})";
      */
    ?>
      list_time.onclick= function() { WdatePicker({qsEnabled:false,minDate:advance_start,maxDate:advance_end,dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..']}); };
		}
		
	}

//-->
</script>
<link href="CSS/link.css" rel="stylesheet" type="text/css" />
<link href="CSS/define.css" rel="stylesheet" type="text/css" />
</head>

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif','img/BTN/already_dn.png')">
  <table border="0" align="center" cellpadding="0" cellspacing="0" id="allpic">
    <?php include('pic1_template.php'); ?>
    <?php include('pic2_template.php'); ?>
    <tr>
      <td height="420">
				<div id="pic3">
					<div id="pic3_left"></div>
					<div id="pic3_right" style="height:420px;width:750px;border:0px;padding:0px;border-spacing:0px">
<?php /*********************************************************************************************************/ ?>
			<form action="equipment_reservation_check.php" method="get" name="form1">
        <input type="hidden" name="equipment_id" id="equipment_id" value="<?php echo $equipment_id;?>">
        <input type="hidden" name="equipment_exclusive" id="equipment_exclusive" value="<?php echo $row_Recordset['equipment_exclusive'];?>">
        <input type="hidden" name="m_id" id="m_id" value="<?php echo $_SESSION['MM_UserID'];?>">
        <div style="width:100%;height:60px;text-align: center;font-size: 24px;" >
          <div style="padding-top:20px">
            <?php
              echo $row_Recordset['equipment_name'];
            ?>
          </div>
        </div>
        <table border="0" cellpadding="8" cellspacing="1" style="width: 100%;">
          <tbody>
            <tr>
              <th scope="row" style="text-align: left;"> 預約日期：</th>
              <td>
                <div id="list_date_hidden">
                  <input type="hidden" name="set_list_date" id="set_list_date" value="">
                  <input name="list_date" id="list_date" type="text" class="Wdate"
                  onClick="var list_time=$dp.$('list_time');WdatePicker({onpicked:function(){show_time();  },minDate:'%y-%M-%d',dateFmt:'yyyy-MM-dd'})">
                  <input id="list_date_yes" type="button" onclick="edate_yes();" value="確定">
                  <input id="list_date_no" type="button"  onclick="edate_no();"  value="取消">
                </div>
              </td>
              <td></td>
            </tr>
            <tr  id="list_time_hidden" style="display:none;">
              <th scope="row" style="text-align: left;"> 預約時間：</th>
              <td>
                <div>
                  <input type="hidden" name="set_list_time" id="set_list_time" value="">
                  <input name="list_time" id="list_time" type="text" class="Wdate" >
                  <input id="list_time_yes" type="button" onclick="etime_yes();" value="確定">
                  <input id="list_time_no" type="button"  onclick="etime_no();"  value="取消">
                </div>
              </td>
              <td>
                <input type="hidden" name="reservation2_number" id="reservation2_number" value="" />
                <div id="show_check_reservation2" ></div>
              </td>
            </tr>
            <tr id="max_people_hidden" style="display:none;">
              <th scope="row" style="width: 140px; text-align: left;">使用人數</th>
              <td>
                <div>
                  <select name="equipment_max_people" id="equipment_max_people" onChange="enumber_cheng()">
                  <?php
                    $equipment_max_people = $row_Recordset['equipment_max_people'];
                    for($i=1;$i<=$equipment_max_people;$i++){
                      echo '<option value="'.$i.'">'.$i.'人</option>'."\n";
                    }
                  ?>
                  </select>
                </div>
              </td>
              <td>
                <div id="show_check_reservation3" ></div>
              </td>
            </tr>

            <tr>
              <th align="right" colspan="3" scope="row">
                <input id="submit01" style="display:none;" type="button" value="確定" onclick="check()" />
                <input type="button" value="回預約列表" onclick="location.href='reservation.php'" />
              </th>
            </tr>
          </tbody>
        </table>
			</form>
<?php /*********************************************************************************************************/ ?>
					</div>
					<div id="show_sql" ></div>
				</div>
      </td>
    </tr>
  </table>
</body>
</html>
