<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
if (!function_exists("GetSQLValueString")) {
  include_once('includes/common.php');
}

$ii==0;
$query_Update = "UPDATE `rule` SET `r_hits` = `r_hits`+1 WHERE `r_id` = '".$_GET["r_id"]."'";
//$query_Update = "UPDATE `rule` SET r_hits=r_hits+1 WHERE r_id = ".$r_id;
$Result = mysql_query($query_Update) or die(mysql_error());
$ii++;

$colname_RecPhoto = "-1";
if (isset($_GET['r_id'])) {
  $colname_RecPhoto = $_GET['r_id'];
}

$query_RecPhoto = sprintf("SELECT * FROM rule WHERE r_id = %s", GetSQLValueString($colname_RecPhoto, "int"));
$RecPhoto = mysql_query($query_RecPhoto, $connSQL) or die(mysql_error());
$row_RecPhoto = mysql_fetch_assoc($RecPhoto);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>社區剪影</title>
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
  var d=document; 
  if(d.images){ 
    if(!d.MM_p) {
      d.MM_p=new Array();
    }
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; 
    for(i=0; i<a.length; i++){
      if (a[i].indexOf("#")!=0){ 
          d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];
      }
    }
  }
}
//-->
</script>
<link href="CSS/link.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#apDiv1 {
   position: relative;
   width: 32px;
   height: 73px;
   z-index: 1;
   left: 0px;
   top: 0px;
}

#apDiv2 {
   position: absolute;
   width: 200px;
   height: 115px;
   z-index: 1;
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
      <th scope="row">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th height="571" align="center" scope="row">
              <div>
                <div>
                  <img src="backstage/rule/<?php echo $row_RecPhoto['r_pic']; ?>" alt="" width="768" />
                  <div>
                    <table width="10%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td>
                          <div>
                            <div class="actionDiv">
                              <a href="javascript:window.history.back();"> <img src="img/BTN/back.png" width="110" height="30" border="0" /> </a>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </th>
          </tr>
        </table>
      </th>
    </tr>
    <tr>
      <th height="29" style="background-position: center; background-image: url(img/third/dn_bar.gif);" scope="row">&nbsp;</th>
    </tr>
  </table>

</body>
</html>
