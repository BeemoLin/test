<?php 
//header('Content-type:text/html; charset=utf-8');
 include('CommFun.php');
 
/* function CheckUserIsLegalSql($username,$passwd)//1.先check使用著;再加CHECK手機ID 再加判別pnoneid=''如果有筆數傳回1 無傳回0
 {
    return "SELECT * FROM memberdata WHERE m_username = '{$username}' and m_passwd = '{$passwd}'";
 }
 
 function CheckAPhoneIdIsNotExit($userphoneid,$phoneid)
 {
    if(is_null($phoneid)) return false; //若http://....沒打參數
    if(is_null($userphoneid)) return true;
        
    return ($userphoneid==$phoneid)?false:true; //當有此phoneid則跳開
 }
 
 function CheckPhoneIdIsNotExit($rs,$pen,$phoneid)
 {
    if(is_null($phoneid)) return false; //若http://....沒打參數
    
    for($i=1;$i<=$pen;$i++)
    {
        $matchphoneid=GetRowsData($rs);
        
        if(is_null($matchphoneid['m_cellphoneid']))  continue;
        
        if($matchphoneid['m_cellphoneid']==$phoneid)
        {
          return false;//當有此phoneid則跳開
        }
    }
    return true;
    
 }
// function AddTblchildmemberdata($username,$passwd,$phoneid,$phonenum)
 function AddTblchildmemberdata($mid,$phoneid,$phonenum)
 {
 
	return "INSERT INTO childmemberdata (m_id,m_cellphoneid,m_cellphone)" .
          							"VALUES ('{$mid}','{$phoneid}','{$phonenum}')";
 }
 function UpdTblmemberdata($mid,$phoneid,$phonenum)
 {
// 	$cdate = date("Y-m-d");
   return "UPDATE memberdata  SET m_cellphoneid='{$phoneid}',m_cellphone='{$phonenum}'" .
      							" WHERE m_id={$mid}";
 }*/
  function UpdResult()
 {
    /*
    $updflag=true;//如果前一筆執行失敗下面的就不執行
    $resultindex=0;
    foreach($packageList as $package)
    {    
      $sql= split (":", $package);
            //echo $sql[0]."---".$sql[1];
      if($updflag)
      {
        $flag=DbExcute($sql[1]);
      }
      if($flag)
      {
        $result[$resultindex]=$sql[0].":"."OK";
      }
      else
      {
              $result[$resultindex]=$sql[0].":"."NO";
              $updflag=false;//不再執行更新,只改變陣列狀態
      }
      $resultindex+=1;
    }
      //----顯示更新狀態
        foreach($result as $status)
        {
            echo $status;
        }
        */
 }
 function SynchronizeDataLog($sqltxt)
 {
 
 $sqltxt=str_replace ("'","''",$sqltxt);
/*  echo "INSERT INTO  syncsqltxtlog(sqltxt ,upddate) ".
          "VALUES ('".$sqltxt."', NOW( ))";*/
 //  'INSERT INTO childmemberdata (m_id,m_cellphoneid,m_cellphone)VALUES (''314'',''33'',''111'')',  '0', NOW( )

  return "INSERT INTO  syncsqltxtlog(sqltxt ,upddate) ".
          "VALUES ('".$sqltxt."', NOW( ))";
 }
 function AnalyzePackge($package)
 {
   $packageList = split ("kais;;kaie", $package);
   $i=0;
   foreach( $packageList as $value )
   {
      $packageList[$i]=str_replace("\'","'",$value);
      //echo "Value is $packageList[$i] <br />";
      $i+=1;
      //echo "Value is $value <br />";
   }
   return $packageList;
    /*$people = array("Peter", "Joe", "Glenn", "Cleveland");
    reset($people);
    
    while (list($key, $val) = each($people))
    {
      echo "$key => $val<br />";
    }*/
        //echo GetArraryLength($packageList);
		  /*foreach(AnalyzePackge(GetSqlTxt()) as $package)
      {
          echo $package."\n";
      }*/
		  // 
 }

 //傳回更新結果
 function UpdateResult($packageList)
 {
    $result="";
    foreach($packageList as $package)
    {    
      
      $sql= split ("{@@}", $package);
      //echo $sql[0]."---".$sql[1];
    // $flag=mysql_query($sql[1]);
      $flag=DbExcute($sql[1]);
      // echo $flag;
      if($flag)
      {
        $result=$result.$sql[0].";"; 
      }
      else
      {
         break;
      } 
    }
    if($result!="") $result="OK:".substr($result,0,-1);
    //die($result);
    return $result;
 }
 function Main()
 {
  OutputHeader();
  if(CheckSqlTxt())
  {
			list($username,$passwd,$phonenum,$phoneid,$whichdb)=GetCheckUserParameter();
		  //切封包
      $packageList=AnalyzePackge(GetSqlTxt());
  
		  if(GetArraryLength($packageList)>0)
		  {
		    //die("更新開始");
        $con=ConnectDb(); //判別是否連線,要加 if($con) //$con=true or false
        echo UpdateResult($packageList);
        CloseDb($con);
      }
      /*else
      {
        echo "ZeroList";//沒有切割的字串
      }*/
	}
	/*else
	{
    echo "ErrSql";//傳遞參數出現問題
  }*/
 }
 Main(); 
?>
