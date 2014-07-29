<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);
$logoutAction = 'logout.php';
$row_RecUser['m_username'] = $_SESSION['MM_Username'];
$UID = $_SESSION['MM_UserID'];
$pages = new sam_pages_class;

if (isset($_GET['ot1_id'])) {
  $ot1_id = $_GET['ot1_id'];
}
else{
  if(isset($_POST['ot1_id'])){
    $ot1_id = $_POST['ot1_id'];
  }
  else{
    header("Location: beemotest.php");
    exit();
  }
}

if (isset($_POST['content'])) {
  $page = new data_function;
  $content = $_POST['content'];
  $now = date('Y-m-d H:i:s', time());
  $page->setDb('opinion_tab2');

  $insert_expression = "`ot1_id` = '".$ot1_id."', `ot2_uid` = '".$UID."', `ot2_content` = '".$content."', `ot2_datetime` = '".$now."'  ";
  //die($insert_expression);
  $page->insert($insert_expression);

}

//"SELECT * FROM opinion_tab1 WHERE ot1_id = '".$ot1_id."'";

//$row_RecOpinion = mysql_fetch_assoc($RecOpinion);


$pages->setDb('opinion_tab1',"AND ot1_id  = '".$ot1_id."'",'*');
$data = $pages->getData();
$title = $data[1]['ot1_title'];
/*
 foreach($data as $key1 => $value1){
 foreach ($value1 as $key2 =>$value2){
 echo '$data['.$key1.']['.$key2.']='.$value2."<br />\n";
 }
 }
 */
//die($title);
$title_datetime = $data[1]['ot1_datetime'];
$type = $data[1]['type'];
$ot1_disable = $data[1]['ot1_disable'];

//$pages->setDb('opinion_tab2',"AND ot1_id  = '".$ot1_id."' ORDER BY ot2_datetime DESC",'*');
$pages->setDb('`opinion_tab2` as `t1` INNER JOIN `memberdata` AS `t2` ON `t1`.`ot2_uid`=`t2`.`m_id`', "AND `ot1_id` = '".$ot1_id."' ORDER BY `ot2_datetime` ASC",'`t1`.* ,`t2`.`m_username`');

//SELECT t1.* ,t2.m_username FROM opinion_tab2 as t1 INNER JOIN member AS t2 ON t1.ot2_uid=t2.m_id  where 1 = 1 AND ot1_id = '1' ORDER BY ot2_datetime DESC
/*
 SELECT
 `t1`.* ,`t2`.`m_username`
 FROM
 `opinion_tab2` as `t1` INNER JOIN `memberdata`
 AS `t2` ON `t1`.`ot2_uid`=`t2`.`m_id`
 where
 1 = 1 AND `ot1_id` = '1'
 ORDER BY
 `ot2_datetime` DESC
 */

//die($pages->sql);
$pages->setPerpage(10,$page);
$data = $pages->getData();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>beemo</title>
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
//-->
function check(){
  var c_value = document.getElementById("content").value.length;
  if(c_value==0){
    location.href = 'beemotest.php';
  }
  else{
    document.forms["form1"].submit()
  }
}

function go(){
  location.href = 'beemotest.php';
}

</script>
<link href="CSS/link.css" rel="stylesheet" type="text/css" />
<link href="CSS/define.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.s {
   color: #FFF;
   font-family: "微軟正黑體";
}
-->
</style>
</head>

<body style="vertical-align: top" onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif')">
  <?php include('layout/template.html'); ?>
   

</body>
</html>
