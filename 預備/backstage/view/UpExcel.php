<?php
//可能沒有用到了 ??????
mysql_connect("localhost","cc77","cc77") or die("連線失敗請洽系統管理員");
mysql_select_db("cc77");
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER_SET_CLIENT=utf8;"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf8;"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<script src="jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="ajaxupload.js"></script>
<script language="JavaScript" type="text/javascript">
$(document).ready(function(){
	new AjaxUpload('upbtn', {action: 'edupload.php',data: {uploaddir : 'up/'},onComplete: function(file, response){document.getElementById('text').value=file;}});
});
</script>
</head>

<body>
<p>
  <?php 
require_once 'Excel/reader.php'; 
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('UTF-8');//此处设置编码，一般都是gbk模式
$data->read('up/Book1.xls');//文件路径
 
error_reporting(E_ALL ^ E_NOTICE);
//这里我就只循环输出excel文件的内容了，要入库，只要把输出的地方，写一段mysql语句即可~
for ($i = 3; $i <= $data->sheets[0]['numRows']; $i++) {



for ($j = 3; $j <= $data->sheets[0]['numCols']; $j++) {

            echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";

           }

           echo "\n";
$sql = "INSERT INTO memberdata (m_name, m_nick, m_username, m_passwd, m_level, m_email, m_phone, m_cellphone, m_address, m_joinDate, m_car1, m_car2, m_car3, m_car4, m_car5, m_moto1, m_moto2, m_moto3, m_moto4, m_moto5, m_carmum1, m_carmum2, m_carmum3, m_carmum4, m_carmum5, m_motomum1, m_motomum2, m_motomum3, m_motomum4, m_motomum5, p_ip)VALUES('".

           //  $data->sheets[0]['cells'][$i][1]."')";
			// $data->sheets[0]['cells'][$i][1]."','".
			 $data->sheets[0]['cells'][$i][2]."','".
			 $data->sheets[0]['cells'][$i][3]."','".
			 $data->sheets[0]['cells'][$i][4]."','".
			 $data->sheets[0]['cells'][$i][5]."','".
			 $data->sheets[0]['cells'][$i][6]."','".
			 $data->sheets[0]['cells'][$i][7]."','".
			 $data->sheets[0]['cells'][$i][8]."','".
			 $data->sheets[0]['cells'][$i][9]."','".
			 $data->sheets[0]['cells'][$i][10]."','".
			 $data->sheets[0]['cells'][$i][11]."','".
			 $data->sheets[0]['cells'][$i][12]."','".
			 $data->sheets[0]['cells'][$i][13]."','".
			 $data->sheets[0]['cells'][$i][14]."','".
			 $data->sheets[0]['cells'][$i][15]."','".
			 $data->sheets[0]['cells'][$i][16]."','".
			 $data->sheets[0]['cells'][$i][17]."','".
			 $data->sheets[0]['cells'][$i][18]."','".
			 $data->sheets[0]['cells'][$i][19]."','".
			 $data->sheets[0]['cells'][$i][20]."','".
			 $data->sheets[0]['cells'][$i][21]."','".
			 $data->sheets[0]['cells'][$i][22]."','".
			 $data->sheets[0]['cells'][$i][23]."','".
			 $data->sheets[0]['cells'][$i][24]."','".
			 $data->sheets[0]['cells'][$i][25]."','".
			 $data->sheets[0]['cells'][$i][26]."','".
			 $data->sheets[0]['cells'][$i][27]."','".
			 $data->sheets[0]['cells'][$i][28]."','".
			 $data->sheets[0]['cells'][$i][29]."','".
			 $data->sheets[0]['cells'][$i][30]."','".
			 $data->sheets[0]['cells'][$i][31]."','".

             $data->sheets[0]['cells'][$i][32]."')";

            //     $data->sheets[0]['cells'][$i][3]."')";

    echo $sql.'<br />';


       $res = mysql_query($sql)or die(mysql_error());

}
?>
<script Language="JavaScript">

location.href= ('backindexhouseholderOK.php');

</script> 



</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>