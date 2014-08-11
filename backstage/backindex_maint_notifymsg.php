<?php 
//header('Content-Type:text/html; charset=utf-8');
define("Monday","0");
define("Tuesday","1");
define("Wednesday","2");
define("Thursday","3");
define("Friday","4");
define("Saturday","5");
define("Sunday","6");
  
define("AWeek","0");
define("AMonth","1");
define("ASeason","2");
define("AHalfYear","3");
define("AYear","4");



function GetToday(&$todayweek){
  //$todayweek=date("l");
  $weekarray=array(7,1,2,3,4,5,6);  
  $todayweek=$weekarray[date("w")];
}
function GetMysqlVarible(){
  $Server = "localhost";
  $DbName = "ttest";
  $User = "root";  
  $PassWord = "Tcwa0428742715";
  return array($Server, $DbName, $User,$PassWord);
}

function GetSqlString($command, $para1, $para2){
  switch($command){
    case "SeekEqu":   
        $sql = "SELECT * FROM  `maintain` ORDER BY  `maint_id`";//where  `maint_id`=14 
        break;
    case "InsertLog":  
       $sql= "INSERT INTO `maintainlog` SET `maint_id`=".(int)$para1.",`maint_time`='".$para2."'";
       //echo  $sql;
      break;
    case "SeekMember":
        $sql="SELECT * FROM `maintainer` WHERE `maint_id`=".(int)$para1 ;
      break;
   
    default:
       $sql="";
  }
  return $sql;
}
 //1.週期種類 2.預約日 3.今天的星期 4.提早日 5.傳回訊息
 //mktime的傳入參數分別為(時,分,秒,月,日,年)
function TransformDuty($duty,$listday,$todayweek,$preday,&$msg){
  switch($duty){ 
      case AWeek:   //每周
        $num=(int)$todayweek+(int)$preday;
        $num=($num>7)?(int)$num-7:(int)$num;
        $msg=((int)$listday==$num)?"Yes":"No";
        
       /* $num=(int)$listday-(int)$preday;    
        $num=($num>0)?(int)$num:(int)$num+7;
        $msg=($todayweek==$num)?"Yes":"No";*/
        
        break;
      //----------------------------------------
      case AMonth:  //每月以後
        $aday= date("d" , mktime(0,0,0,date("m"),date("d")+(int)$preday,date("Y")) );
        $msg=((int)$listday==(int)$aday)?"Yes":"No";
      
        break;
      
      case ASeason:   
      case AHalfYear:
      case AYear:
         $aday=date("m-d",mktime(0,0,0,date("m"),date("d")+(int)$preday,date("Y")));
         $adaylist=split("-",$aday);
         //當月的月份座落在指定的每季
         
         $msg=((int)$adaylist[1]==(int)$listday && in_array((int)$adaylist[0],$todayweek))?"Yes":"No"; //$todayweek 整數陣列 
         
        break;     
  }
}
//紀錄LOG檔案 
function InsetLog($conn,$equid,$maintdate){
  $sql=GetSqlString("InsertLog",$equid,$maintdate);
  $result = mysql_query($sql,$conn) or die("InsertLog Err"); 
}
//送簡訊
function NotifyMsg($conn,$equid,$equname){
  $UserID="23294915";
  $Passwd="0423294915";
  $letter=urlencode("通知設備保養,設備名稱:".$equname);
  
    $sql=GetSqlString("SeekMember",$equid);
    $memberdata = mysql_query($sql,$conn) or die("SeekMember Err"); 
    while($row = mysql_fetch_assoc($memberdata)){
        
        $value=$row["phone"];
        if(is_null($value) || empty($value)) {
        }else{
          
            $net="http://smexpress.mitake.com.tw:9600/SmSendGet.asp?username=".$UserID."&password=".$Passwd."&dstaddr=".$value."&encoding=UTF8&DestName=AKAI&smbody=".$letter;
            $buffer = file_get_contents($net);
          
        }
        echo $equname."-".$value."\n";
    } 
}
 

function TranWeekToint($tweek){
    switch($tweek){ 
      case Monday:   
        $num = 1;
        break;
      case Tuesday:  
        $num = 2;
        break;
      case Wednesday:   
        $num = 3;
        break;
      case Thursday:   
        $num = 4;
        break;
      case Friday:  
        $num = 5;
        break;
      case Saturday:  
        $num = 6;
        break;
      case Sunday:  
        $num = 7;
        break;
      }
      return $num;
}
//1.保養週期種類 2.設備的新增日期  3.傳回區間日期
function GetTodayWeek($duty,$block,&$todayweek){
    switch($duty){ 
      case AWeek:   
        GetToday($todayweek);
        break;
      case AMonth:  
        $todayweek = "";
        break;
      case ASeason:   
        $amonth= split("-",$block);
        
        $blockmonth=array();
        $blockmonth[0]=(int)$amonth[1];
    
        $summonth=(int)$amonth[1]+3;
        $blockmonth[1]=($summonth>12)?$summonth-12:$summonth;
        
        $summonth=(int)$amonth[1]+6;
        $blockmonth[2]=($summonth>12)?$summonth-12:$summonth;
        
        $summonth=(int)$amonth[1]+9;
        $blockmonth[3]=($summonth>12)?$summonth-12:$summonth;
    
          
        $todayweek =$blockmonth;// array("02","05","08","11");;
        break;
      case AHalfYear:   
        $amonth= split("-",$block);
      
        $blockmonth=array();
        $blockmonth[0]=(int)$amonth[1];
         
        $summonth=(int)$amonth[1]+6;
        $blockmonth[1]=($summonth>12)?$summonth-12:$summonth; 
         
         
        $todayweek = $blockmonth;//array("02","08");
        break;

      case AYear:  
         $amonth= split("-",$block);
         
         $blockmonth=array();
         $blockmonth[0]=(int)$amonth[1];
        
        $todayweek =$blockmonth;// array("08");
        break;
      }
}
//1.保養週期種類 2.週期選擇的日子(星期一~星期日)或著(1日~31日)  3.傳回預約的日子
function GetListday($duty,$block,&$listday){
    switch($duty){ 
      case AWeek:   
        $listday=TranWeekToint($block); 
        break;
      case AMonth:  
      case ASeason:
      case AHalfYear:
      case AYear:
        $listday = $block;
        break;
      }
}


function MARK(){
        //type 1
       //GetToday($todayweek);
       //$listday=TranWeekToint("Sunday"); //"Sunday" 帶資料庫的欄位 放到TransformDuty裏面
       //TransformDuty("1",$listday,$todayweek,3,$msg); //"1",,1(提早天數) 帶資料庫的欄位
       
       //type 2
       // $todayweek="";
       //$listday="10";
       //TransformDuty("2",$listday,$todayweek,10,$msg);
       
       // type 3 4 5 一樣
       //type 3
       //$listday="10";
       //$listseason=array("02","05","08","11");
       //TransformDuty("3",$listday,$listseason,10,$msg);
      
       //type 4
       //$listday="10";
       //$listseason=array("02","08");
       //TransformDuty("4",$listday,$listseason,10,$msg);
       
       //type 5
      // $listday="10";
       //$listseason=array("08");
       //TransformDuty("5",$listday,$listseason,10,$msg);
    /*function GetPostVarible()
    {
      if(isset($_POST))
      {
        foreach($_POST as $key => $value){
          $$key = $value;
          //echo '$'.$key.'='.$value."<br />\n";
        }
      }
      return array($command, $mode, $base64code);
    }*/
}




function ProcessDb(){
  list($Server,$DbName,$User,$PassWord)=GetMysqlVarible();
  $conn = mysql_connect($Server, $User, $PassWord); 
  mysql_select_db($DbName,$conn); 
  mysql_query("SET NAMES UTF8");
  
  $sql=GetSqlString("SeekEqu","");
  $returnData = mysql_query($sql,$conn) or die("SeekEqu Err"); 
  
    while($row = mysql_fetch_assoc($returnData)){
      
      $maint_id=$row["maint_id"];
      $maint_name=$row["maint_name"];
      $maint_cycle=$row["maint_cycle"];
      $maint_date=$row["maint_date"];
      $maint_notice=$row["maint_notice"];
      $update_at=$row["update_at"];
      
       GetTodayWeek($maint_cycle,$update_at,$todayweek);
      
       GetListday($maint_cycle,$maint_date,$listday); //$row["maint_date"] start at index=0(week); start at index=1 (month)
       
       TransformDuty($maint_cycle,$listday,$todayweek,$maint_notice,$msg);
       
       if($msg=="Yes"){ 
          $maintdate=date("Y-m-d" ,mktime(0,0,0,date("m"),date("d")+(int)$maint_notice,date("Y")) );
          InsetLog($conn,$maint_id,$maintdate);
          NotifyMsg($conn,$maint_id,$maint_name);
        }     
    }
  mysql_close ($conn);
}


ProcessDb();
echo "\nOK";
?>
