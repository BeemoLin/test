<?php //�i�g��class $con �P $rs�ʸ˦b����
 function ConnectDb()
 {
    $hostname_connSQL = "localhost";
    $database_connSQL = "cctest";//cctest";                                       //��Ʈw�W��     (�p���s�خ� �Ч惡�B)
    $username_connSQL = "root";//root";                                       //��Ʈw�b���W�� (�p���s�خ� �Ч惡�B)
    $password_connSQL = "Tcwa0428742715";//123456";                                       //��Ʈw�b���K�X (�p���s�خ� �Ч惡�B)
    $connSQL = mysql_connect($hostname_connSQL, $username_connSQL, $password_connSQL) or trigger_error(mysql_error(),E_USER_ERROR); 
    mysql_query("SET NAMES UTF8");
    mysql_select_db($database_connSQL, $connSQL);
    return  $connSQL;
 } 
 function DbExcute($sql)
 {
   return mysql_query($sql); //�Ǧ^����F��,��@�O�_������A�����\���̾� int(true:1,false:0)
 }

 function GetRowsCount($rs)
 {
   return mysql_num_rows($rs);
 }
 function GetRowsData($rs)
 {
 
    return  mysql_fetch_assoc($rs);//�ϥιL����O��Ʈw�����дN�|���U���ʪ��쵲��
 }

 function CloseDb($con)
 {
   mysql_close($con);
 }
 //--------------------------------------------------------------------------------------------
 //�ѼƳ��n���Ȥ~��i�J;���n
 
 function OutputHeader()
 {
  header('Content-type:text/html; charset=utf-8');//�y�t�Τ@UTF8 ,����~���|�ýX
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
 function GetUserMid($username)//passwd�|��
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
    if(is_null($phoneid)) return false; //�Yhttp://....�S���Ѽ�
    
    for($i=1;$i<=$pen;$i++)
    {
        $matchphoneid=GetRowsData($rs);
        
        if($matchphoneid['m_cellphoneid']==$phoneid)
        {
          return true;//����phoneid�h���}
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
      	  if(0<$tbluseridpen && $tbluseridpen<2)//�N����USER
      	  {
      	    $tblmemberdatarow = GetRowsData($rs);
            $mid=$tblmemberdatarow['m_id'];
            $userphoneid=$tblmemberdatarow['m_cellphoneid'];
      	      
            $rss = mysql_query(GetTblchildmemberdataCount($mid));
            $tblchildmemberdatapen=GetRowsCount($rss);//���o����
      	     
              if(CheckAPhoneIdIsExit($userphoneid,$phoneid) || CheckPhoneIdIsExit($rss,$tblchildmemberdatapen,$phoneid))//�N����PHONEID
      	      {
              		return true;
              }
              else
              {
                  return false;
                   //echo "1";//�L�Ĩϥε�
              }
          }
          else
          {
                   return false;//echo "1";//�L�Ĩϥε�
          }
          //CloseDb($con);
    }
    else
    {
        return false;//echo "1";//�ǻ��ѼƥX�{���D
    }
  
 }
 //---------------------------------------------------------------------
/* function SynchronizeDataLog($sqldata,$path="")//�P�B�� Appserver�PWebserver
 {
    //$fp=fopen("C:\\tcwa\\".$path."\\SynData.txt","a+");
    $fp=fopen("C:\\tcwa\\Appser\\SynData.txt","a+");
    $nowtime=date("Y-m-d H:i:s");
    fwrite($fp,$sqldata.":".$nowtime."\n");
    fclose($fp);
 }*/ 
 
?>
