<?php
header('Content-type:text/html; charset=utf-8');

require_once('../define.php');

$arr_j = array(
  "A" => "1" ,
  "B" => "2" ,
  "C" => "3" ,
  "D" => "4" ,
  "E" => "5" ,
  "F" => "6" ,
  "G" => "7" ,
  "H" => "8" ,
  "I" => "9" ,
  "J" => "10" ,
  "K" => "11" ,
  "L" => "12" ,
  "M" => "13" ,
  "N" => "14" ,
  "O" => "15" ,
  "P" => "16" ,
  "Q" => "17" ,
  "R" => "18" ,
  "S" => "19" ,
  "T" => "20" ,
  "U" => "21" ,
  "V" => "22" ,
  "W" => "23" ,
  "X" => "24" ,
  "Y" => "26" ,
  "Z" => "26"
);


$now_time = date("Y-m-d H:i:s");
$yesterday = date("Y-m-d H:i:s", mktime(0, 0 ,0, date("m"), date("d")-1, date("Y")));
if(empty($_POST['recheck'])){
  //die();
}
$dbname = 'mail_management';
$where_expression1 = " AND `m_username` NOT IN (SELECT `m_username` FROM `mail_management` where 1 = 1 AND `show` = '1' AND `disable` = '0' GROUP BY `m_username`) GROUP BY `m_username";
$where_expression2 = " AND `show` = '1' AND `disable` = '0' GROUP BY `m_username`";
$select_expression = "`receives_time` , `takes_time` , `id` , `m_username` , `show` , `disable`";

$data_function = new data_function;
$data_function->setDb($dbname);




$returnData = $data_function->select($where_expression1,$select_expression);
echo($data_function->sql."<br />\n");  //查看語法
foreach($returnData as $key1 => $value1){
  /*
  foreach($value1 as $key2 => $value2){
    //echo '$returnData['.$key1.']['.$key2.']='.$value2."<br />\n"; //查看資料
  }
  */
  echo $value1['m_username']."<br />\n";
  $check_type1 = mb_substr($value1['m_username'],0,1);
  $check_type2 = (int) mb_substr($value1['m_username'],1,1);

  if(($check_type1 == 'S' || $check_type1 == 'T') && is_numeric($check_type2)){
    $i_uper = strtoupper(mb_substr($value1['m_username'],0,1));
    $j = mb_substr($value1['m_username'],1,1);
    $i = $arr_j[$i_uper];
    //die('2');
  }
  else{
    $new_username = str_pad($value1['m_username'],3,"0",STR_PAD_LEFT);
    $i = mb_substr($new_username,0,2);
    $j_uper = strtoupper(mb_substr($new_username,2,1));
    $j = $arr_j[$j_uper];
    //die('3');
  }
  
  $k = 1;
  $l = 4;
  $key1 = $i;
  $key2 = (int)((string)$j.(string)$k.(string)$l);
  $key1 = strtoupper(dechex($key1));//轉換大小寫(數值轉16進位($key1))
  $key1 = str_pad($key1,2,"0",STR_PAD_LEFT);
  $key2 = strtoupper(dechex($key2));//轉換大小寫(數值轉16進位($key2))
  $key2 = str_pad($key2,4,"0",STR_PAD_LEFT);

  $mail[] = array(
    "key1" => "$key1",
    "key2" => "$key2"
  );

}
echo "<br />\n";



$returnData = $data_function->select($where_expression2,$select_expression);
echo($data_function->sql."<br />\n");  //查看語法

foreach($returnData as $key1 => $value1){
/*
  foreach($value1 as $key2 => $value2){
    //echo '$returnData['.$key1.']['.$key2.']='.$value2."<br />\n"; //查看資料
  }
*/
  echo $value1['m_username']."<br />\n";
  $check_type1 = mb_substr($value1['m_username'],0,1);
  $check_type2 = (int) mb_substr($value1['m_username'],1,1);

  if(($check_type1 == 'S' || $check_type1 == 'T') && is_numeric($check_type2)){
    $i_uper = strtoupper(mb_substr($value1['m_username'],0,1));
    $j = mb_substr($value1['m_username'],1,1);
    $i = $arr_j[$i_uper];
    //die('2');
  }
  else{
    $new_username = str_pad($value1['m_username'],3,"0",STR_PAD_LEFT);
    $i = mb_substr($new_username,0,2);
    $j_uper = strtoupper(mb_substr($new_username,2,1));
    $j = $arr_j[$j_uper];
    //die('3');
  }
  
  $k = 1;
  $l = 3;
  $key1 = $i;
  $key2 = (int)((string)$j.(string)$k.(string)$l);
  $key1 = strtoupper(dechex($key1));//轉換大小寫(數值轉16進位($key1))
  $key1 = str_pad($key1,2,"0",STR_PAD_LEFT);
  $key2 = strtoupper(dechex($key2));//轉換大小寫(數值轉16進位($key2))
  $key2 = str_pad($key2,4,"0",STR_PAD_LEFT);
  
  $mail[] = array(
    "key1" => "$key1",
    "key2" => "$key2"
  );
  
}
echo "<br />\n";
echo "<br />\n";
echo "<br />\n";

/*
$auot_post = "";
$i = 1;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/auto_get_mail.php");
curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
foreach($mail as $key1 => $value1){
  foreach($value1 as $key2 => $value2){
    echo '$mail['.$key1.']['.$key2.']='.$value2."<br />\n";
    $auot_post["key".$i] = $value2;
    $i++;
  }
  echo "<br>\n";
}
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($auot_post));
curl_exec($ch);
curl_close($ch);
*/
?>

<?php
class data_function{

  var $dbname;
  var $sql;

  function setDb($dbname){
    $this->dbname = $dbname;
  }

  function query(){
    mysql_query($this->sql); 
  }
  
  function select($where_expression,$select_expression = null){
    if($select_expression == null){
      $this->sql = "SELECT * FROM ".$this->dbname." where 1 = 1 ".$where_expression." ";
    }
    else{
      $this->sql = "SELECT ".$select_expression." FROM ".$this->dbname." where 1 = 1 ".$where_expression." ";
    }
    //die($this->sql);
    $count_no = mysql_query($this->sql) or die(mysql_error()); 
    $i=0;
    while($data = mysql_fetch_assoc($count_no)){
      $i++;
      foreach ($data as $key => $value){
        $returnData["$i"]["$key"] = $value;
      }
    }
    if (isset($returnData)){
      return $returnData;
    }
  }

  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>無標題文件</title>
    </head>
	<body>


<script src="controlCOM2.js" ></script>
<div style="clear:both;" align="center"><?php echo $main_name;?></div>
<div id="main">
  <div id="main_index">
    <form method="post" action="backindex_mail.php" >
    <?php
      $no=0;
      foreach ($mail as $k1 => $v1){
        foreach ($v1 as $k2 => $v2){
          //$mail[$k1][$k2]=$v2;
          $no++;
          echo '<input name="mail" id="k'.$no.'" type="hidden" value="'.$v2.'" />'."<br />\n";
        }
      }
    ?>

	  請稍等一下，信件設定中。
      <div id="divAccount" style="float:left;margin-left:23px;"></div>
    </form>
	<script>
	  contorlCOM2();
	</script>
  </div>
</div>

	</body>
</html>