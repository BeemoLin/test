<?php

require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
require_once(INCLUDES.'/processdbcols.php');
require_once('includes/authorization.php');
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);


function CrossRowColor($yesno){
   return ($yesno>0)?"'##008888'":"'#AA0000'";
}
function ShowEquCheck($page,$equipment_id,&$equname,&$data,&$Firstpage,&$Listpage,&$Endpage){

  if(isset($equipment_id)){
    $data_function = new data_function; //建立資料庫物件
    $data_function->setDb("maintain");
    $where_expression = "AND `maint_id` = '".$equipment_id."' ";
    $dataequ = $data_function->select($where_expression);
    $equname=$dataequ[1]["maint_name"];
  
  
  	$where = " AND `maint_id` = ".$equipment_id." AND check_state	=1 ORDER BY `uid` DESC";
    $pages = new sam_pages_class;
    $pages->setDb("maintainlog", $where, "*");
    $pages->setPerpage(10,$page);
    $pages->set_base_page("checkmaintlist.php");
    $pages->action_mode("view_equipment_detail");

    $Firstpage = $pages->getFirstpage3($equipment_id);
    $Listpage = $pages->getListpage3($equipment_id,$page,2);
    $Endpage = $pages->getEndpage3($equipment_id);
    
    $data = $pages->getData(); 
    
  }
}

if(isset($_POST)){
	foreach($_POST as $key => $value){
		$$key = $value;
	}
}

$page=(isset($_POST['page']))?$_POST['page']:1;
$m_id = $_SESSION['MM_UserID'];
$logoutAction = 'logout.php';


 ShowEquCheck($page,$equipment_id,$equname,$data,$Firstpage,$Listpage,$Endpage);
 //var_dump($page.$equipment_id.$data);
 //die();
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
		method = method || "post"; // Set method to post by default, if not specified.
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

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif','img/BTN/already_dn.png')">
<?php include('layout/template.html'); ?>
</body>
</html>
