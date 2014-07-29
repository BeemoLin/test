<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);

if(isset($_GET)){
	foreach($_GET as $key => $value){
		$$key = $value;
		//echo '$'.$key.'='.$value."<br />\n";
	}
}

if(isset($_GET['page'])){
  $page = $_GET['page'];
}else{
  $page = 1;
}

$m_id = $_SESSION['MM_UserID'];
$logoutAction = 'logout.php';

function select_sql($equipment_picture = NULL){
	return $a = "
		SELECT *
		FROM `equipment_reservation`
		WHERE 
			`equipment_hidden` = '0'
		AND
			`equipment_disable` = '0'
		".$equipment_picture."
		ORDER BY
			`equipment_reservation`.`equipment_id` ASC
	";
}

$equ_menu_sql = select_sql();
$equ_menu_data = mysql_query($equ_menu_sql) or die(mysql_error());


	$select = '
		`equipment_reservation_list`.*, 
		`equipment_reservation`.`equipment_name`,	
		`equipment_reservation`.`equipment_exclusive`,	
		`equipment_reservation`.`equipment_max_people`,	
		`memberdata`.`m_username`
	';
	
	$from_DB = '
		`equipment_reservation_list` 
		LEFT JOIN `equipment_reservation` 
			ON `equipment_reservation_list`.`equipment_id` = `equipment_reservation`.`equipment_id` 
		LEFT JOIN `memberdata`
			ON `equipment_reservation_list`.`m_id` = `memberdata`.`m_id`
	';

	$pages = new sam_pages_class;
if(isset($equipment_id)){
	$where = "
		AND 
			`equipment_reservation_list`.`equipment_id` = '".$equipment_id."'
		AND
			`equipment_reservation_list`.`m_id` = '".$m_id."'
		ORDER BY 
			`equipment_reservation_list`.`list_datetime` DESC, 
			`equipment_reservation_list`.`equipment_id`  ASC
		";
  $pages->setDb($from_DB, $where, $select);
  $pages->setPerpage(10,$page);
  $pages->set_base_page("reservation_list.php?equipment_id=".$equipment_id);
  $Firstpage = $pages->getFirstpage3();
  $Listpage = $pages->getListpage3($page,2);
  $Endpage = $pages->getEndpage3();
  $array = $pages->getData();
}
else{
	$where = "
		AND
			`equipment_reservation_list`.`m_id` = '".$m_id."'
		ORDER BY 
			`equipment_reservation_list`.`list_datetime` DESC, 
			`equipment_reservation_list`.`equipment_id`  ASC
		";
  $pages->setDb($from_DB, $where, $select);
  $pages->setPerpage(10,$page);
  $pages->set_base_page("reservation_list.php");
  $Firstpage = $pages->getFirstpage();
  $Listpage = $pages->getListpage($page,2);
  $Endpage = $pages->getEndpage();
  $array = $pages->getData();
}


?>
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

function tfm_confirmLink(message, path, params, method) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
  if (document.MM_returnValue){
    post_to_url(path, params, method);
  }
}

	function post_to_url(path, params, method) {
		method = method || "post"; // Set method to post by default, if not specified.

		// The rest of this code assumes you are not using a library.
		// It can be made less wordy if you use one.
		var form = document.createElement("form");
		form.setAttribute("method", method);
		form.setAttribute("action", path);

		for(var key in params) {
				var hiddenField = document.createElement("input");
				hiddenField.setAttribute("type", "hidden");
				hiddenField.setAttribute("name", key);
				hiddenField.setAttribute("value", params[key]);

				form.appendChild(hiddenField);
		}

		document.body.appendChild(form);    // Not entirely sure if this is necessary
		form.submit();
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
					<div id="pic3_right" style="width:750px;border:0px;padding:0px;border-spacing:0px">
						<div style="height: 50px;">
              <div style="height: 30px; padding-top: 10px">
                <div style="width: 45%; float: left; padding-top: 7px">
                  <img src="img/img/q_BTN.png" align="absmiddle" /><span class="org">開放設備清單</span>
                </div>
                <div style="width: 54%; float: left;">
                  <div style="width: 50%; float: left; text-align: center;">
                    <a href="reservation.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image27','','img/BTN/OPEN_dn.png',1)"> <img src="img/BTN/OPEN_up.png" name="Image27" width="130" height="30" border="0" /> </a>
                  </div>
                  <div style="width: 49%; float: left; text-align: center;">
                    <a href="reservation_list.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image28','','img/BTN/already_dn.png',1)"> <img src="img/BTN/already_dn.png" name="Image28" width="130" height="30" border="0" id="Image28" /> </a>
                  </div>
                  <div></div>
                </div>
                <div></div>
              </div>
						</div>
						<div style="height:360px;width:750px;">
						
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////?>
							<div style="float:left;width:230px">
								<?php 
								if(isset($equ_menu_data)){
									while ($equ_menu = mysql_fetch_assoc($equ_menu_data)) {
										?>
										<div style="text-align: center;<?php echo $equ_menu['equipment_id']==$equipment_id?'background-color:#222222;':'';?>">
											<span class="white">
												<a href="reservation_list.php?equipment_id=<?php echo $equ_menu['equipment_id']; ?>"> 
													<?php echo $equ_menu['equipment_name']; ?> 
												</a> 
											</span>
										</div>
										<div>
											<hr />
										</div>
								<?php 
									}
								}
								?>
							</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////?>
							<div style="float:left;width:520px">
								<div>
								<table style="padding:0 20px;width:100%">
									<thead>
										<tr>
											<th scope="col" style="width:118px;">預約設備</th>
											<th scope="col" style="width:187px;">預約時間</th>
											<th scope="col" style="width:79px;">預約數</th>
											<th scope="col" style="width:79px;">取消預約</th>
										</tr>
									</thead>
			<tbody>
			<?php
			$now_date = strtotime(date("Y-m-d 00:00:00"));
			$now_datetime = strtotime(date("Y-m-d H:i:s"));
			if(is_array($array)){
				//foreach($array as $key1 => $value1){
					foreach($array as $key2 => $value2){
						$db_datetime = strtotime(date($value2['list_datetime']));
						
						if($db_datetime>$now_date+86400){
							echo '<tr bgcolor="#008888">'."\n";
						}
						elseif($db_datetime<$now_datetime){
							echo '<tr bgcolor="#008800">'."\n";
						}
						else{
							echo '<tr bgcolor="#FF0000">'."\n";
						}
						
						echo '<td style="text-align: center;">'.$value2['equipment_name']."</td>\n";
						echo '<td style="text-align: center;">'.$value2['list_datetime']."</td>\n";
            if($value2['equipment_exclusive']==1){
              $unit = "戶";
              echo '<td style="text-align: center;">1'.$unit."</td>\n";
            }
            else{
              $unit = "人";
              echo '<td style="text-align: center;">'.$value2['list_using_number'].$unit."</td>\n";
            }
						if(!($db_datetime<$now_datetime)){
							echo '<td style="text-align: center;"><a href="#" onclick="'."tfm_confirmLink('你確定要取消預約???','reservation_del.php', {'list_id':'".$value2['list_id']."','equipment_id':'".$value2['equipment_id']."'})".'" >取消</a>'."</td>\n";
						}
						else{
							echo '<td style="text-align: center;">'."&nbsp;</td>\n";
						}
						echo "</tr>\n";
					}
				//}
			}
			?>
			</tbody>
								</table>
								</div>
							<div style="float:right;"><?php echo $Firstpage.$Listpage.$Endpage;?></div>
							</div>
						</div>
					</div>
					
				</div>
      </td>
    </tr>
  </table>
</body>
</html>
