<?php 
 include('CommFun.php');
 function CheckUserIsLegalSql($username,$passwd)//1.先check使用著;再加CHECK手機ID 再加判別pnoneid=''如果有筆數傳回1 無傳回0
 {
    return "SELECT * FROM memberdata WHERE m_username = '{$username}' and m_passwd = '{$passwd}'";
 }

 function Main()
 {
    OutputHeader();
  
    if(CheckUserValue())
    {
			list($username,$passwd,$phonenum,$phoneid,$whichdb)=GetCheckUserParameter();	
      $con=ConnectDb(); //判別是否連線,要加 if($con) //$con=true or false
      //if(!$con) die("");
            $rs = DbExcute(CheckUserIsLegalSql($username,$passwd));
            
            $tblmemberdatapen=GetRowsCount($rs);
          
            if (0<$tblmemberdatapen && $tblmemberdatapen<2)//只有一組帳號密碼
            {
                echo "0";//成功註冊
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
