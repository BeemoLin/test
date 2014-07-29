<?php //可寫成class $con 與 $rs封裝在內部
 function ConnectDb()
 {
    $hostname_connSQL = "localhost";
    $database_connSQL = "cctest";//cctest";                                       //資料庫名稱     (如有新建案 請改此處)
    $username_connSQL = "root";//root";                                       //資料庫帳號名稱 (如有新建案 請改此處)
    $password_connSQL = "Tcwa0428742715";//123456";                                       //資料庫帳號密碼 (如有新建案 請改此處)
    $connSQL = mysql_connect($hostname_connSQL, $username_connSQL, $password_connSQL) or trigger_error(mysql_error(),E_USER_ERROR); 
    mysql_query("SET NAMES UTF8");
    mysql_select_db($database_connSQL, $connSQL);
    return  $connSQL;
 } 
 function DbExcute($sql)
 {
   return mysql_query($sql); //傳回什麼東西,當作是否執行伺服器成功的依據 int(true:1,false:0)
 }

 function GetRowsCount($rs)
 {
   return mysql_num_rows($rs);
 }
 function GetRowsData($rs)
 {
 
    return  mysql_fetch_assoc($rs);//使用過此函是資料庫的指標就會往下移動直到結尾
 }

 function CloseDb($con)
 {
   mysql_close($con);
 }
 //--------------------------------------------------------------------------------------------
 //參數都要有值才能進入;重要
 
 function OutputHeader()
 {
  header('Content-type:text/html; charset=utf-8');//語系統一UTF8 ,中文才不會亂碼
 }
 function CheckUserValue() 
 {
	  $flag1=(isset($_REQUEST['username']) && $_REQUEST['username']!="")?true:false;
    $flag2=(isset($_REQUEST['passwd']) && $_REQUEST['passwd']!="")?true:false;
    $flag3=(isset($_REQUEST['phonenum']))?true:false; //&& $_REQUEST['phonenum']!=""
    $flag4=(isset($_REQUEST['phoneid']) && $_REQUEST['phoneid']!="")?true:false;
    return $flag1 && $flag2 && $flag3 && $flag4;
 }
 function GetCheckUserParameter() 
 {
		  $username = $_REQUEST['username'];
		  $passwd = $_REQUEST['passwd'];
		  $phonenum = $_REQUEST['phonenum'];
			$phoneid = $_REQUEST['phoneid'];
			$whichdb="cctest";//$_REQUEST['phoneid'];
      return array($username, $passwd, $phonenum,$phoneid,$whichdb);
 }
 function GetTblchildmemberdataCount($mid)
 {
    return "SELECT * FROM childmemberdata WHERE m_id={$mid}";  
 }
 //---------------------------------------------------------------------
 function GetUserMid($username)//passwd會變
 {
    return  $sql = "SELECT * FROM memberdata " . 
			"WHERE m_username='{$username}' ";
 }
 function CheckAPhoneIdIsExit($userphoneid,$phoneid)
 {
    if(is_null($phoneid)) return false;
     
    return ($userphoneid==$phoneid)?true:false;
 }
 function CheckPhoneIdIsExit($rs,$pen,$phoneid)
 {
    if(is_null($phoneid)) return false; //若http://....沒打參數
    
    for($i=1;$i<=$pen;$i++)
    {
        $matchphoneid=GetRowsData($rs);
        
        if($matchphoneid['m_cellphoneid']==$phoneid)
        {
          return true;//當有此phoneid則跳開
        }
    }
     return false;
 }
 
 function CheckUserPhoneIdIsReal()
 {
    OutputHeader();
    if(CheckUserValue())
    {
		    list($username,$passwd,$phonenum,$phoneid,$whichdb)=GetCheckUserParameter();
		    
	       //$con=ConnectDb(); 
	
          $rs=DbExcute(GetUserMid($username));
      	  $tbluseridpen=GetRowsCount($rs);
      	  if(0<$tbluseridpen && $tbluseridpen<2)//代表有此USER
      	  {
      	    $tblmemberdatarow = GetRowsData($rs);
            $mid=$tblmemberdatarow['m_id'];
            $userphoneid=$tblmemberdatarow['m_cellphoneid'];
      	      
            $rss = mysql_query(GetTblchildmemberdataCount($mid));
            $tblchildmemberdatapen=GetRowsCount($rss);//取得筆數
      	     
              if(CheckAPhoneIdIsExit($userphoneid,$phoneid) || CheckPhoneIdIsExit($rss,$tblchildmemberdatapen,$phoneid))//代表有此PHONEID
      	      {
              		return true;
              }
              else
              {
                  return false;
                   //echo "1";//無效使用著
              }
          }
          else
          {
                   return false;//echo "1";//無效使用著
          }
          //CloseDb($con);
    }
    else
    {
        return false;//echo "1";//傳遞參數出現問題
    }
  
 }
 //---------------------------------------------------------------------
/* function SynchronizeDataLog($sqldata,$path="")//同步化 Appserver與Webserver
 {
    //$fp=fopen("C:\\tcwa\\".$path."\\SynData.txt","a+");
    $fp=fopen("C:\\tcwa\\Appser\\SynData.txt","a+");
    $nowtime=date("Y-m-d H:i:s");
    fwrite($fp,$sqldata.":".$nowtime."\n");
    fclose($fp);
 }*/ 
 
?>
