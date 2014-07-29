<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>公設預約</title>
<script type="text/javascript">
<!--
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
function mark(face,field_color,text_color){
if (document.documentElement){//if browser is IE5+ or NS6+
face.style.backgroundColor=field_color;
face.style.color=text_color;
}
}

function tfm_confirmLink(message, path, params, method) 
{ //v1.0
  //alert(message);
  // alert(path);
   // alert(params);
   //  alert(method);
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
  if (document.MM_returnValue)
  {
    //list_id主索引唯一碼,equipment_id設備的ID
    //'reservation_del.php', {'list_id':'".$value2['list_id']."','equipment_id':'".$value2['equipment_id']."'}
    post_to_urlForCancel(path, params, method);//使用POST取值
  }
}
//------把大項與細項的函數切開20121112
  //------重要的函數當網頁切換的時候要去設定屬性當submit時候;由php程式去擷取資訊
	function post_to_url(path, params, method) 
  {
    //alert(path);
    //alert(params);//無意義
    //alert(method);//無意義
	 //20121111修改 因為是用GET取;若下post就要用$_post[page]
		method = method || "get"; // Set method to post by default, if not specified.
    //alert(method);
		// The rest of this code assumes you are not using a library.
		// It can be made less wordy if you use one.
		var form = document.createElement("form");
		form.setAttribute("method", method);
	//	alert(method);
		form.setAttribute("action", path);
    //alert(path);
    //想成參數陣列
		for(var key in params) 
    {
				var hiddenField = document.createElement("input");
				hiddenField.setAttribute("type", "hidden");
				hiddenField.setAttribute("name", key);
				hiddenField.setAttribute("value", params[key]);

				form.appendChild(hiddenField);
		}
 //<input type=hidden name="" value=""> //這個要使用post
		document.body.appendChild(form);    // Not entirely sure if this is necessary
		form.submit();
		//alert('提交GET!!');
	}
	//-----For 取消訂約記錄
 	function post_to_urlForCancel(path, params, method) 
  {
    //alert(path);
    //alert(params);//無意義
    //alert(method);//無意義
	 //20121111修改 因為是用GET取;若下post就要用$_post[page]
		method = method || "post"; // Set method to post by default, if not specified.
    //alert(method);
		// The rest of this code assumes you are not using a library.
		// It can be made less wordy if you use one.
		var form = document.createElement("form");
		form.setAttribute("method", method);
	//	alert(method);
		form.setAttribute("action", path);
    //alert(path);
    //想成參數陣列 使用隱藏攔位帶參數; 給POST取出參數值
		for(var key in params) 
    {
				var hiddenField = document.createElement("input");
				hiddenField.setAttribute("type", "hidden");
				hiddenField.setAttribute("name", key);
				hiddenField.setAttribute("value", params[key]);
				form.appendChild(hiddenField);
		}
 //<input type=hidden name="" value=""> //這個要使用post
		document.body.appendChild(form);    // Not entirely sure if this is necessary
		form.submit();
		//alert('提交GET!!');
	}

//------把大項與細項的函數切開20121112
//-->
</script>
<link href="CSS/link.css" rel="stylesheet" type="text/css" />
<link href="CSS/define.css" rel="stylesheet" type="text/css" />
</head>

<!--<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif','img/BTN/already_dn.png')">-->
 <body>
  <!--<table border="0" align="center" cellpadding="0" cellspacing="0" id="allpic">-->
  <table>
    <?php //include('pic1_template.php'); ?>
    <?php //include('pic2_template.php'); ?>
    <tr>
      <td height="420">
				<div id="pic3">
						
						<?php 
            /*
            2012.11.11
            使用Form method=Get方式,所以轉址要帶?equipment_id參數;若是點開放設備清單就不帶equipment_id參數
            
            */
            ?>
            
					<!--<div id="pic3_left"></div>-->
					<div id="pic3_right" style="width:750px;border:0px;padding:0px;border-spacing:0px">
						<div style="height: 50px;">
              <div style="height: 30px; padding-top: 10px">
                
                <div style="width: 45%; float: left; padding-top: 7px">
                  <img src="img/img/q_BTN.png" align="absmiddle" /><span class="org">已被預約的時段</span>
                </div>
                
                <!-- <div style="width: 54%; float: left;">
                  <div style="width: 50%; float: left; text-align: center;">
                    <a href="reservation.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image27','','img/BTN/OPEN_dn.png',1)"> <img src="img/BTN/OPEN_up.png" name="Image27" width="130" height="30" border="0" /> </a>
                  </div>
                  <div style="width: 49%; float: left; text-align: center;">
                    <a href="reservation_list.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image28','','img/BTN/already_dn.png',1)"> <img src="img/BTN/already_dn.png" name="Image28" width="130" height="30" border="0" id="Image28" /> </a>
                  </div>
                  <div></div>
                </div>-->
                <div></div>
              </div>
						</div>
						<div style="height:360px;width:750px;">
										
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////?>
							<div style="float:left;width:520px"><!--520-->
								<div>
								<table style="padding:0 20px;width:100%">
									<thead>
										<tr>
											 
											<th scope="col" style="width:118px;">預約設備</th><!--118px-->
											<th scope="col" style="width:345px;">已被預約時間</th><!--345px  20121117:187+79在+79-->
										<!--	<th scope="col" style="width:79px;">預約數</th>-->
										<!--	<th scope="col" style="width:79px;">取消預約</th>-->
										</tr>
									</thead>
			<tbody>
			
			<?php
			//用 FUNCTION ShowBody()
			//時間未到現在(當天) 顯示紅色 時間>=現在 顯示綠色(明天)
			
			//增加當刪除的時候要回到哪個頁面 是細項還是大項
      //$type=(isset($equipment_id))?"PART":"ALL";
			//die($type);
      //$now_date = strtotime(date("Y-m-d 00:00:00"));
			//$now_datetime = strtotime(date("Y-m-d H:i:s"));
			
      if(is_array($array))//很重要的陣列判別由Control丟入VIEW
      {
          //$checklisttime=new processdbcols;//20121117
				//foreach($array as $key1 => $value1){
				//資料集合二維陣列 
					foreach($array as $key2 => $value2)//key2即ROW 指派給value2,然後資料庫使用$value2['攔位名稱'] 即可顯示 一維陣列;所以二維陣列只要一個迴圈 三維兩個迴圈
          {
						/*
            $db_datetime = strtotime(date($value2['list_datetime']));
						
						if($db_datetime>$now_date+86400)
            {
							echo '<tr bgcolor="#008888">'."\n";
						}
						elseif($db_datetime<$now_datetime)
            {
							echo '<tr bgcolor="#008800">'."\n";
						}
						else
            {
							echo '<tr bgcolor="#FF0000">'."\n";
						}
						*/
						echo '<td style="text-align: center;">'.$value2['equipment_name']."</td>\n";
						
						
					//202121117 顯示日期 起 時:分~結束 時:分
					 
           //$timeformat= $checklisttime->equipment_reservation_list_list_endtime($value2['list_endtime'],$value2['list_time'],$value2['advance_end'],$value2['equipment_id'],$value2['list_datetime']);
            echo '<td style="text-align: center;">'.$timeformatList[$key2]["0"]."</td>\n"; //$value2['list_datetime']
						//20121117
			
            //20121110 
            /*if($value2['equipment_exclusive']==1){
              $unit = "戶";
              echo '<td style="text-align: center;">1'.$unit."</td>\n";
            }
            else{
              $unit = "人";
              echo '<td style="text-align: center;">'.$value2['list_using_number'].$unit."</td>\n";
            }
            20121117註解掉
            if($value2['equipment_name']=="沛活鬥牛場"){
              $unit = "人";
              echo '<td style="text-align: center;">1'.$unit."</td>\n";
            }
            else{
              $unit = "戶";
              echo '<td style="text-align: center;">'.$value2['list_using_number'].$unit."</td>\n";
            }
             20121117註解掉
            */
            //-----------------------------20121114取消機制-----------------------------------------------------------
           
            /*
						if(!($db_datetime<$now_datetime))
            {
							echo '<td style="text-align: center;"><a href="#" onclick="'."tfm_confirmLink('你確定要取消預約???','reservation_del.php', {'list_id':'".$value2['list_id']."','equipment_id':'".$value2['equipment_id']."','type':'".$type."'})".'" >取消</a>'."</td>\n";
						}
						else
            {
							echo '<td style="text-align: center;">'."&nbsp;</td>\n";
						}
						*/
						//-----------------------------20121114取消機制-----------------------------------------------------------
						echo "</tr>\n";
					}
				//}
			}
			?>
			</tbody>
								</table>
								</div>
							<div style="float:right;"><?php //echo $Firstpage.$Listpage.$Endpage;?></div>
							 <?php
    for($i=1;$i<92;$i++)
    {
      echo "&nbsp";
    }
   ?>
   <input type="button" style="width: 50px" name="btnexit" id="btnexit" onclick="window.close();" value="離開"><!--style="width:20;height:50"<input type="text" style="width:200px;height:20px;border:solid 1px green">-->
							</div>
						</div>
					</div>
					
				</div>
      </td>
    </tr>
   
  </table>
 
</body>
</html>
