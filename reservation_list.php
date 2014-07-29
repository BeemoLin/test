<?php
/*
20121110:因為後台設備 改戶 只有沛活鬥牛場是人;頁數元件有問題
此模式使用GET模式,所以網址是用?參數=....方式

20121112:切換頁面BUG

20121114:撈資料還要判別攔位`list_disable` = '0' 顯示 '1'不顯示

20121117:增加起迄時間把預約數註解
*/

require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
require_once(INCLUDES.'/processdbcols.php');
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);

//取HTML所有物件的內容使用action=get
if(isset($_GET)){
	foreach($_GET as $key => $value){
		$$key = $value;
		//echo '$'.$key.'='.$value."<br />\n";
	}
}

$page=(isset($_GET['page']))?$_GET['page']:1;
/*
if(isset($_GET['page'])){
  $page = $_GET['page'];
}else{
  $page = 1;
}
*/
//echo "頁數問題:".$page;


$m_id = $_SESSION['MM_UserID'];
$logoutAction = 'logout.php';


//跑左邊的LIST設備名稱
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
function ShowRunMachine($value2,$type,$equipment_id){
  $showtxt="";
  if($type=="PART" && $equipment_id=="1000" && $value2['list_disable']=="1"){
    
     $date= split("-",$value2['list_date']);
     $time= split(":",$value2['list_time']);
     $listdate=(int)$date[0].$date[1].$date[2];
     $listtime=(int)$time[0].$time[1];//.$time[2];
     
     
     $savetime=split(" ", $value2['save_datetime']) ;
     
     $date=split("-",$savetime[0]);
     $time=split(":",$savetime[1]);
     
     $canceldate=(int)$date[0].$date[1].$date[2];
     $canceltime=(int)$time[0].$time[1];//.$time[2];
     
     if($canceldate<$listdate){
          $showtxt="已取消預約";
     }else if($canceldate==$listdate){
          $showtxt=($canceltime<$listtime)?"已取消":"有預約但未來使用";
     }
  }
  return $showtxt; 
}

$equ_menu_sql = select_sql();
$equ_menu_data = mysql_query($equ_menu_sql) or die(mysql_error());
//跑左邊的LIST設備名稱


//開始撈表身資料
	$select = '
		`equipment_reservation_list`.*, 
		`equipment_reservation`.`equipment_name`,	
		`equipment_reservation`.`equipment_exclusive`,	
		`equipment_reservation`.`equipment_max_people`,	
		`equipment_reservation`.`advance_end`,	
		`memberdata`.`m_username`
	';
	//equipment_reservation_list(訂約記錄) 與 equipment_reservation(設備資料) 聯集 條件是1.住戶自己的ID與訂約的住戶ID與2.設備的ID與訂約的設備ID
	$from_DB = '
		`equipment_reservation_list` 
		LEFT JOIN `equipment_reservation` 
			ON `equipment_reservation_list`.`equipment_id` = `equipment_reservation`.`equipment_id` 
		LEFT JOIN `memberdata`
			ON `equipment_reservation_list`.`m_id` = `memberdata`.`m_id`
	';

$pages = new sam_pages_class;
//---------------------------------------------------------------------
//當點已預約清單全撈
//超連結 a href="" 使用轉址,所以重要 href屬性很重要(a href="#")


//區分跑步機,與其他設備的顯示不一樣:    where條件


if(isset($equipment_id))
{
  //echo  "設備名稱:".$equipment_id;
  //die("各項設備名稱");
  //	AND
	//		`equipment_reservation_list`.`list_disable` = '0'
	$where = "
		AND 
			`equipment_reservation_list`.`equipment_id` = '".$equipment_id."'
		AND
			`equipment_reservation_list`.`m_id` = '".$m_id."'
		AND ";
		
    
    $sql=($equipment_id=="1000")? " 1 ":"`equipment_reservation_list`.`list_disable` = '0'";
		$sort=" ORDER BY 
			`equipment_reservation_list`.`list_datetime` DESC, 
			`equipment_reservation_list`.`equipment_id`  ASC
		";
    $where=$where.$sql.$sort;
    //die($where);
	//die($select.$from_DB.$where);
  $pages->setDb($from_DB, $where, $select);
  
  $pages->setPerpage(10,$page);//每頁10筆
  
  $pages->set_base_page("reservation_list.php?equipment_id=".$equipment_id);
  
  $pages->action_mode("view_equipment_detail");
 //20121110函數要帶入什麼參數;這要給參數,因為要帶?equipment_id參數這樣才能isset($equipment_id)選擇正確
 //20121111代這個參數
  $Firstpage = $pages->getFirstpage3($equipment_id);//第一頁
  //die($Firstpage);
   //$equipment_id,
  $Listpage = $pages->getListpage3($equipment_id,$page,2);//數字:1,2,3....$page點到的頁數
  //die($Listpage);
  
  $Endpage = $pages->getEndpage3($equipment_id);//;//最終頁
   //die($Endpage);
   
  $array = $pages->getData(); //取得內容
  
}
//點設備則撈自己的設備
else
{
    //echo  "無設備名稱";
 //die("點選已預約清單全撈項目");
   //	AND
	//		`equipment_reservation_list`.`list_disable` = '0'
	$where = "
		AND
			`equipment_reservation_list`.`m_id` = '".$m_id."'
		AND
    	`equipment_reservation_list`.`list_disable` = '0'
    ORDER BY 
			`equipment_reservation_list`.`list_datetime` DESC, 
			`equipment_reservation_list`.`equipment_id`  ASC
		";
  $pages->setDb($from_DB, $where, $select);
  $pages->setPerpage(10,$page);
   
 // echo "頁數".$page;
  $pages->set_base_page("reservation_list.php");//設定sumbit出去的網頁名稱;再使用?參數=....
  
  $Firstpage = $pages->getFirstpage();//第一頁
  $Listpage = $pages->getListpage($page,2);//數字:1,2,3....
  //echo $Listpage;
  $Endpage = $pages->getEndpage();//最終頁
  // echo $Endpage;
  $array = $pages->getData();
}
//---------------------------------------------------------------------

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

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif','img/BTN/already_dn.png')">
<?php include('layout/template.html'); ?>
</body>
</html>
