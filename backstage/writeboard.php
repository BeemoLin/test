<?php 
header("Content-type: text/xml"); 
header("Cache-Control: no-cache");
//$xml = true;
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
function GetMysqlVarible()
{
  $Server = "localhost";
  $DbName = "cc77";
  $User = "root";
  $PassWord = "Tcwa0428742715";
  return array($Server, $DbName, $User,$PassWord);
}

function GetSqlString($command, $mode, $base64code)
{
  switch($command)
  {
    case "Start":
    case "End":
        $sqlstring = "UPDATE `writeboard` SET `mode` = '".$mode."' WHERE `writeboard`.`id` =1 LIMIT 1";
      break;
    case "WillSend":
        $sqlstring="UPDATE `writeboard` SET `lock` = '1' WHERE `writeboard`.`id` =1 LIMIT 1";
      break;
    case "Sended":
        $sqlstring="UPDATE `writeboard` SET `lock` = '0',`data` = '".$base64code."' WHERE `writeboard`.`id` =1 LIMIT 1";
        //$sqlstring="UPDATE `writeboard` SET `data` = 'AAA',`lock` = '0' WHERE `writeboard`.`id` =1 LIMIT 1";
        break;
    default:
       $sqlstring="";
  }
  return $sqlstring;
}

function ProcessDb()
{
  list($Server,$DbName,$User,$PassWord)=GetMysqlVarible();
  $conn = mysql_connect($Server, $User, $PassWord); 
  mysql_select_db($DbName,$conn); 
  mysql_query("SET NAMES UTF8");
  
 
  
    
    //else LCOK
     // echo "STOP"; 
  
 
   
    
  
  mysql_close ($conn);
}

ProcessDb();
	*/
	
/*	
$sql = "
			SELECT data AS `base64data1`,`mode`,`lock`
			FROM `writeboard` 
			WHERE `id` = '1' AND `lock`='0'
		";
		//echo '<sql>'.$sql.'</sql>'; 
		$returnData = mysql_query($sql);//語法: int mysql_query(string query, int [link_identifier]);
		
		//----if(mysql_getrow>0) ; lock=1,row=0
	  if(mysql_num_rows($returnData)>0)  //如果資料筆數出過0，代表有資料
    {
      $datas = mysql_fetch_assoc($returnData);
			
      if($datas['mode']=="1")
      {
        echo $datas['base64data1'];   
      }
      else
      {
        echo "STOP"; 
      }
    }
   */
   $sql = "
			SELECT data AS `base64data1`,`mode`,`lock`
			FROM `writeboard` 
			WHERE `id` = '1' AND `mode`='1'
		";//mode=0 : Stop
		//echo '<sql>'.$sql.'</sql>'; 
		$returnData = mysql_query($sql);//語法: int mysql_query(string query, int [link_identifier]);
		
		//----if(mysql_getrow>0) ; lock=1,row=0
	  if(mysql_num_rows($returnData)>0)  //如果資料筆數出過0，代表有資料
    {
      $datas = mysql_fetch_assoc($returnData);
			
      if($datas['lock']=="0")
      {
        echo $datas['base64data1'];   
      }
      //===lock=1 代表在新增資料;不與寫入爭取
    }
    else
    {
      echo "STOP"; 
    }
   
   
   
   
   
   
   
	
?>
