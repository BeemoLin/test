<?php 
//���n��ECHO
//header("Content-type: text/xml"); 
//header("Cache-Control: no-cache");
//$xml = true;
//require_once('define.php');
//require_once(CONNSQL);
//require_once(PAGECLASS);
function Remark()
{
//header("Content-type: text/xml"); 
//header("Cache-Control: no-cache");
//$xml = true;
//require_once('define.php');
//require_once(CONNSQL);
//require_once(PAGECLASS);

   /*$sql = "
			SELECT data AS `base64data1`,`mode`,`lock`
			FROM `writeboard` 
			WHERE `id` = '1' AND `lock`='0'
		";*/
    //$returnData = mysql_query(GetSqlString());//�y�k: int mysql_query(string query, int [link_identifier]);
		

    //----if(mysql_getrow>0) ; lock=1,row=0
	  /*
    if(mysql_num_rows($returnData)>0)  //�p�G��Ƶ��ƥX�L0�A�N�����
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
    //else LCOK
    
  /*  
    //ajax readystaus �ݩ�=4 �B status=0(���ݰ���{��)��200�N�������` ���ɦA��xml.responseText �~�i�HŪ�줺�e�_�h�b�o���󤧥~���L�kŪ�줺�e;���n���[��
    xmlhttp.onreadystatechange=function()
  {
  alert("Ready:"+xmlhttp.readyState);
   alert("status:"+xmlhttp.status);
  if (xmlhttp.readyState==4 && (xmlhttp.status==0||xmlhttp.status==200))
    {
    document.getElementById("myDiv").innerHTML="11";//xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","http://localhost/writeboard.php;",true);
xmlhttp.send();
*/
}
function GetPostVarible()
{
  if(isset($_POST))
  {
    foreach($_POST as $key => $value){
      $$key = $value;
      //echo '$'.$key.'='.$value."<br />\n";
    }
  }
  return array($command, $mode, $base64code);
}
function GetMysqlVarible()
{
  $Server = "localhost";
  $DbName = "ttest";
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
        $sqlstring = "UPDATE `writeboard` SET `mode` = '".$mode."',`lock` = '0' WHERE `writeboard`.`id` =1 LIMIT 1";
      break;
    case "WillSend":
        $sqlstring="UPDATE `writeboard` SET `lock` = '1' WHERE `writeboard`.`id` =1 LIMIT 1";
      break;
    case "Sended":
        $base64code=str_replace(" ", "+",$base64code);
        $sqlstring="UPDATE `writeboard` SET `lock` = '0',`data` = '".$base64code."' WHERE `writeboard`.`id` =1 LIMIT 1";
        //echo $base64code;
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
 // mysql_query("SET NAMES UTF8");
  
  list($command, $mode, $base64code)=GetPostVarible();
 // echo $command."--".$mode."--".$base64code;
  
  $sqlstring=GetSqlString($command, $mode, $base64code);
 
  if($sqlstring!="")
  {
    //echo $sqlstring;
    $returnData = mysql_query($sqlstring,$conn);//�y�k: int mysql_query(string query, int [link_identifier]);
  }
  mysql_close ($conn);
}

ProcessDb();
?>
    

