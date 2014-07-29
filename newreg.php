<?php 
 include('CommFun.php');
 function CheckUserIsLegalSql($username,$passwd)//1.先check使用著;再加CHECK手機ID 再加判別pnoneid=''如果有筆數傳回1 無傳回0
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
 	/*$cdate = date("Y-m-d");
	return "INSERT INTO childmemberdata (m_username,m_passwd,m_cellphoneid,m_cellphone,p_joinDate)" .
							"VALUES ('{$username}','{$passwd}','{$phoneid}','{$phonenum}','{$cdate}')";*/
	return "INSERT INTO childmemberdata (m_id,m_cellphoneid,m_cellphone,regDate)" .
          							"VALUES ('{$mid}','{$phoneid}','{$phonenum}',NOW( ))";
 }
 function UpdTblmemberdata($mid,$phoneid,$phonenum)
 {
// 	$cdate = date("Y-m-d");
   return "UPDATE memberdata  SET m_cellphoneid='{$phoneid}',m_cellphone='{$phonenum}',regDate = NOW( )" .
      							" WHERE m_id={$mid}";
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
 
 
 
 function Main()
 {
  OutputHeader();
  if(CheckUserValue())
  {
			list($username,$passwd,$phonenum,$phoneid,$whichdb)=GetCheckUserParameter();
			//include('CommFun.php');
		
      $con=ConnectDb(); //判別是否連線,要加 if($con) //$con=true or false
      //if(!$con) die("");
      
            $rs = DbExcute(CheckUserIsLegalSql($username,$passwd));
            
            $tblmemberdatapen=GetRowsCount($rs);
          
            if (0<$tblmemberdatapen && $tblmemberdatapen<2)//只有一組帳號密碼
            {
                
                $tblmemberdatarow = GetRowsData($rs);//移到CommFun裡面
                $mid=$tblmemberdatarow['m_id'];
                $userphoneid=$tblmemberdatarow['m_cellphoneid'];
                
               // die("筆數".$mid);
                $rss = DbExcute(GetTblchildmemberdataCount($mid));
                $tblchildmemberdatapen=GetRowsCount($rss);//取得筆數
                //echo $tblchildmemberdatapen;
                //checkphoneidisexit
                if(CheckAPhoneIdIsNotExit($userphoneid,$phoneid) &&  CheckPhoneIdIsNotExit($rss,$tblchildmemberdatapen,$phoneid))
                {
                        //---------------------------------------此段要與webserver同步-------------------------------
                        if(is_null($userphoneid))//欄位的型態預設值為NULL
                        {
                        //---------ADD---------------
                          $sql=UpdTblmemberdata($mid,$phoneid,$phonenum);
                          $flag=DbExcute($sql);
                          if($flag)
                          {
                              //記錄LOG檔
                              DbExcute(SynchronizeDataLog($sql));
                              echo "0";//成功註冊
                          }
                        //---------ADD---------------
                        }
                        else
                        {   
                            //先check是否4筆
                            if((int)$tblchildmemberdatapen > 3)
                            {
                               echo "1";//已超過筆數 
                            }
                            else
                            {
                                //---------ADD---------------
                                $sql=AddTblchildmemberdata($mid,$phoneid,$phonenum);
                                //echo $sql;
                                $flag=DbExcute($sql);//判別是否執行新增,要加	
                        				if($flag)
                                {
                                    //記錄LOG檔
                                    DbExcute(SynchronizeDataLog($sql));
                                    
                                    echo "0";
                                }
                        				//---------ADD---------------
                            }              
                        }
                }
                else
                {
                  echo "0";//已有註冊過
                }
      			}
            else 
            {
      				echo "1";//使用著無效
      			}	
      			CloseDb($con);	
		}
		else
		{
        	echo "1";//傳遞參數出現問題
    }
 }
 Main(); 
?>
