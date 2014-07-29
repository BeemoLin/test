<?php
session_start();
$_SESSION['from_web'] = 'index.php';
require_once('../define.php');
//require_once(CONNSQL);
//require_once(PAGECLASS);
$loginFormAction = 'login.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台管理</title>
<style type="text/css">
<!--
body {

	
}

#body_1{
	font-size: 24px;
	background-image: url(images/backstage_login.jpg);
	background-position:center;
	background-repeat:no-repeat;
	font-family: "微軟正黑體";
	height:500px;
	width:1024px;
	margin:auto;

}

#login{
	text-align:center;
	padding-top:140px

}


-->
</style>
<script language="JavaScript" type="text/javascript">
//更換驗證碼圖片
function RefreshImage(valImageId) {
	var objImage = document.images[valImageId];
	if (objImage == undefined) {
		return;
	}
	var now = new Date();
	objImage.src = objImage.src.split('?')[0] + '?width=100&height=40&characters=5&s=' + new Date().getTime();
}
</script>
</head>

<body >
<div id="body_1">
<div id="login">
<form id="form1" name="form1" method="post" action="<?php echo $loginFormAction; ?>">
	帳號 <input name="username" type="text" class="logintext" id="username" /><br/>
	密碼 <input name="passwd" type="password" class="logintext" id="passwd" /><br/>
      <p> &nbsp;<img src="CaptchaSecurityImages.php?width=100&height=40&characters=5" style="width:100px;height:40px;"; name="imgCaptcha" id="imgCaptcha" /><a href="javascript:void(0)" onclick="RefreshImage('imgCaptcha')" style="font-size:9pt">更換圖片<br />
      </a>
        <input name="security_code" type="text" id="security_code" value="請輸入上方驗證碼" maxlength="10" onfocus="this.value=''" />
      </p>
      <p>
        <input type="submit" name="button2" id="button2" value="登入管理" />
      </p>
</form>
</div>
</div>
</body>
<?php die();?>
</html>
