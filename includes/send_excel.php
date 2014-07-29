<?php 
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('../define.php');
header("Cache-control:private");
require_once(CONNSQL);
//require_once(PAGECLASS);

 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$selectSQL = "SELECT * FROM exl WHERE 1=1";
  
	if(!empty($_POST['exl_name'])){
		$selectSQL .= " AND exl_name= '".$_POST['exl_name']."'";
	}
	if(!empty($_POST['exl_yesno'])){
		$selectSQL .= " AND exl_yesno='".$_POST['exl_yesno']."'";
	}
	if(!empty($_POST['from_date'])){
		$selectSQL .= " AND exl_date > '".$_POST['from_date']." 0:0:0'";
	}
	if(!empty($_POST['to_date'])){
		$selectSQL .= " AND exl_date < '".$_POST['to_date']." 23:59:59'";
	}
	if(!empty($_POST['from_date_repair'])){
		$selectSQL .= " AND exl_repair > '".$_POST['from_date_repair']." 0:0:0'";
	}
	if(!empty($_POST['to_date_repair'])){
		$selectSQL .= " AND exl_repair < '".$_POST['to_date_repair']." 23:59:59'";
	}	
	//$selectSQL .= ($_POST['from_date'] && $_POST['to_date'])? " AND exl_date BETWEEN ".GetSQLValueString($_POST['from_date'], "text")." and ".GetSQLValueString($_POST['to_date'], "text"):"";
	//echo($selectSQL); exit;
  
  $selectSQL .= " AND `disable` = '0' ORDER BY exl_date DESC";

	$result = mysql_query($selectSQL) or die(mysql_error());
	//die($selectSQL);
	if(!empty($_POST['send_excel'])){
		//include('Spreadsheet/Excel/Writer.php');
		include(INCLUDES.'/Spreadsheet2/Excel/Writer.php');
		$filename = date("Y-m-d");
		
		$workbook = new Spreadsheet_Excel_Writer(); // 初始化類
		$workbook->send($filename."(".E_SUBJECT.").xls"); // 發送 Excel 文件名供下載 (直接下載)
		$workbook->setVersion(8);
		
		$format_title =& $workbook->addFormat();
		$format_title->setBold();
		$format_title->setColor('black');
		//$format_title->setPattern(1);
		$format_title->setFgColor('aqua');
		//$format_title->setBorderColor('red');
		
		$worksheet = &$workbook->addWorksheet('Worksheet');
		$worksheet->setInputEncoding('utf-8');
		$worksheet->write(0, 0, '住戶編號',$format_title);
		$worksheet->write(0, 1, '維修狀態',$format_title);
		$worksheet->write(0, 2, '維修項目',$format_title);
		$worksheet->write(0, 3, '問題說明',$format_title);
		$worksheet->write(0, 4, '報修時間',$format_title);
		$worksheet->write(0, 5, '完修時間',$format_title);
		$worksheet->write(0, 6, '備註',$format_title);
		$Row_data = 1;
		
		 while ($row = mysql_fetch_assoc($result)){
			$Grid_data = 0 ;
			$worksheet->write($Row_data, $Grid_data, $row['exl_name']);
			$Grid_data++;
			$worksheet->write($Row_data, $Grid_data, $row['exl_yesno']);
			$Grid_data++;
			$worksheet->write($Row_data, $Grid_data, $row['exl_exl']);
			$Grid_data++;
			$worksheet->write($Row_data, $Grid_data, $row['exl_adj']);
			$Grid_data++;
			$worksheet->write($Row_data, $Grid_data, $row['exl_date']);
			$Grid_data++;
			$worksheet->write($Row_data, $Grid_data, $row['exl_repair']);
			$Grid_data++;
			$worksheet->write($Row_data, $Grid_data, $row['exl_remark']);
			$Grid_data++;
			$Row_data++;
		 }
    //$workbook->send($filename."(".E_SUBJECT.").xls"); // 發送 Excel 文件名供下載 (直接下載)
		$workbook->close();
	}
  
}
?>


