<?php
/*
20121115 增加刪除 但資料庫還存在記錄

*/
require_once('define.php');
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);
require_once(CONNSQL);
require_once(PAGECLASS);

$logoutAction = 'logout.php';
$currentPage = $_SERVER["PHP_SELF"];
$m_username = $_SESSION['MM_Username'];
$ot1_uid = $_SESSION['MM_UserID'];
//var_dump($ot1_uid);住戶ID,只撈出自己發出的意見其它部撈

//-----------思考可以用嘟個網頁 無論是 GET 或 POST submit的方式都先經過兩關check
//-----當client使用 get方式 則 post就無值 反之當client使用 post方式 則 get就無值 
//$page=(isset($_GET['page']))?$_GET['page']:1;
//var_dump("GET->".$page);
$page=(isset($_POST['page']))?$_POST['page']:1;
//var_dump("POST->".$page);
/*
if(isset($_POST['page'])){
  $page = $_POST['page'];
}else{
  $page = 1;
}*/

//Table:opinion_tab1
$pages = new sam_pages_class;
//"SELECT * FROM opinion WHERE opinion_name = %s ORDER BY opinion_date DESC";
$pages->setDb('opinion_tab1',"AND ot1_uid  = '".$ot1_uid."' AND `ot1_disable` = '0' ORDER BY ot1_datetime DESC",'*');
//die($pages->sql);
$pages->setPerpage(6,$page);
$pages->set_base_page('beemotest.php');
//$pages->action_mode($action_mode);
$Firstpage = $pages->getFirstpage2();
$Listpage = $pages->getListpage2(2);//從第2頁開始
$Endpage = $pages->getEndpage2();
$data = $pages->getData();
/*
 $pages2->count = "
 SELECT count(1)
 FROM `mail_management`
 WHERE `disable` = '0'
 ";
 $pages2->sql="
 SELECT
 `a`.`receives_time`,
 `b`.`m_address`,
 `b`.`m_username`,
 `a`.`receives_name`,
 `a`.`letter_category`,
 `a`.`letter_alt`,
 `a`.`letters_number`,
 `a`.`sends_name`
 FROM `mail_management` AS `a`
 LEFT JOIN `memberdata` AS `b`
 ON `a`.`m_username` = `b`.`m_username`
 WHERE `disable` = '0'
 ORDER BY `a`.`receives_time` DESC
 ";
 */
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
function mark(face,field_color,text_color){
  if (document.documentElement){//if browser is IE5+ or NS6+
    face.style.backgroundColor=field_color;
    face.style.color=text_color;
  }
}


function tfm_confirmLink(message, path, params, method) 
{ //v1.0

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

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif','img/BTN/add_dn.png')">
   
    <?php include('layout/template.html'); ?>

</body>
</html>
