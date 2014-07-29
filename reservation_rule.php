<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);



if (isset($_GET['equipment_id'])) {
  $equipment_id = $_GET['equipment_id'];
}
else{
	header('Location: reservation.php');
	exit();
}

mysql_select_db($database_connSQL, $connSQL);
$query_Recordset1 = "
	SELECT * 
	FROM `equipment_reservation`
	WHERE `equipment_id` = '".$equipment_id."' 
		AND `equipment_disable` = '0'
		AND `equipment_stop` = '0' 
		AND `equipment_hidden` = '0'
";

$Recordset1 = mysql_query($query_Recordset1, $connSQL) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

/*
$today = date('d');
$m = date('m');
$y = date('Y');
$id = $_GET['rulepic_id'];
$name = $_GET['name'];
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>視聽室</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-repeat: no-repeat;
	margin-left: 0px;
	margin-top: 0px;
	background-color: #000;
	color: #FFF;
}
.all {
	background-image: url(img/third/backgrondreal.jpg);
}
.white {
	color: #FFF;
	font-family: "微軟正黑體";
}
-->
</style>
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<link href="CSS/link.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#apDiv1 {
	position:relative;
	width:32px;
	height:73px;
	z-index:1;
	left: 0px;
	top: 0px;
}
#apDiv2 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:1;
	left: -258px;
	top: 115px;
	visibility: hidden;
}
-->
</style>
</head>

<body onload="MM_preloadImages('img/third/arrow_up(3).gif')">
<table width="770" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="row"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th height="571" align="center" scope="row"><div>
          <div>
            <div>
              <img src="backstage/newpic/<?php echo $row_Recordset1['equipment_rule_picture']; ?>" width="100%"  border="0" />
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
								<?php 
								if($row_Recordset1['equipment_advance']==0){
								?>
								<tr>
									<td width="100%" style="text-align: center;font-size:32px">
										<div class="actionDiv">
											<a href="reservation.php">
												可直接使用不用預約
											</a>
										</div>
									<td>
								</tr>
								<?php
								}
								elseif(isset($equipment_id)){
								?>
                <tr>
                  <td width="51%">
										<div>
											<div class="actionDiv" style="text-align: center;font-size:32px">
												<a href="reservation.php">
													回設備清單
												</a>
											</div>
                    </div>
									</td>
                  <td width="49%" align="right">
										<div style="text-align: center;font-size:32px">
											<a href="add_reservation.php?equipment_id=<?php echo $equipment_id ;?>">
											同意
											</a>
										</div>
									</td>
								</tr>
								<?php 
								}
								?>
              </table>
            </div>
          </div>
        </div></th>
        </tr>
    </table></th>
  </tr>
  <tr>
    <th height="29" style="background-position: center; background-image: url(img/third/dn_bar.gif);" scope="row">&nbsp;</th>
  </tr>
</table>

</body>
</html>
