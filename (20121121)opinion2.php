<?php
require_once('define.php');
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);
require_once(CONNSQL);
require_once(PAGECLASS);

$logoutAction = 'logout.php';
$currentPage = $_SERVER["PHP_SELF"];
$m_username = $_SESSION['MM_Username'];
$ot1_uid = $_SESSION['MM_UserID'];

if(isset($_POST['page'])){
  $page = $_POST['page'];
}else{
  $page = 1;
}
$pages = new sam_pages_class;
//"SELECT * FROM opinion WHERE opinion_name = %s ORDER BY opinion_date DESC";
$pages->setDb('opinion_tab1',"AND ot1_uid  = '".$ot1_uid."' AND `ot1_disable` = '0' ORDER BY ot1_datetime DESC",'*');
//die($pages->sql);
$pages->setPerpage(10,$page);
$pages->set_base_page('opinion2.php');
//$pages->action_mode($action_mode);
$Firstpage = $pages->getFirstpage2();
$Listpage = $pages->getListpage2(2);
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
<title>意見分享</title>
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
  <table border="0" align="center" cellpadding="0" cellspacing="0" id="allpic">
    <?php include('pic1_template.php'); ?>
    <?php include('pic2_template.php'); ?>
    <tr>
      <td height="390">
        <table border="0" cellpadding="0" cellspacing="0" id="pic3">
          <tr>
            <td>
              <div>
                <div>
                  <div>
                    <a href="opinionadd2.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image26','','img/BTN/add_dn.png',1)"> <img src="img/BTN/add_up.png"  name="Image26" width="130" height="30" border="0" id="Image26" /> </a>
                  </div>
                  <div>
                    <div style="width: 19px; float: left;">&nbsp;</div>
                    <div style="width: 400px; float: left; text-align: left">標題</div>
                    <div style="width: 90px; float: left; text-align: center">處理狀態</div>
                    <div style="width: 238px; float: left; text-align: center">日期</div>
                  </div>
                  <div style="clear: both; width: 100%; border: 0px solid white; border-bottom-width: 4px; height: 4px"></div>
                  <div style="visibility: none; margin-top: 5px; margin-bottom: 5px; height:320px;">
                  <?php
                  if(isset($data)){
                    foreach($data as $key1 => $value) {
                      /*
                       foreach ($value as $key2 => $value2){
                       echo '$data['.$key1.']['.$key2.']='.$value2."<br>\n";
                       }
                       */
                      ?>
                    <div onMouseOver="mark(this,'#000000','#FFFFFF')" onMouseOut="mark(this,'','#FFFFFF')">
                      <div style="height: 20px; width: 19px; float: left; padding-top: 0px; margin-top: 5px; margin-bottom: 5px;">&nbsp;</div>
                      <div style="width: 400px; float: left;">
                        <a href="opinionsee2.php?ot1_id=<?php echo $value['ot1_id']; ?>"> <?php echo $value['ot1_title']; ?> </a>
                      </div>
                      <div style="width: 90px; float: left; text-align: center">
                      <?php if($value['ot1_type']==0){echo '未回覆';} elseif($value['ot1_type']==1){echo '已回覆';} else{ echo '處理中';} ?>
                      </div>
                      <div style="width: 238px; float: left; text-align: center">
                      <?php echo $value['ot1_datetime']; ?>
                      </div>
                    </div>
                    <div style="clear: both; height: 1px; border: 0px solid white; border-bottom-width: 1px;"></div>
                    <?php
                    }
                  }
                  ?>
                  </div>
                  <div style="float: right;margin: 16px;">
                  <?php echo $Firstpage . $Listpage . $Endpage . "<br>\n";?>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
