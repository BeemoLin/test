<?php 
 include('CommFun.php');
 function CheckUserIsLegalSql($username,$passwd)//1.��check�ϥε�;�A�[CHECK���ID �A�[�P�Opnoneid=''�p�G�����ƶǦ^1 �L�Ǧ^0
 {
    return "SELECT * FROM memberdata WHERE m_username = '{$username}' and m_passwd = '{$passwd}'";
 }

 function Main()
 {
    OutputHeader();
  
    if(CheckUserValue())
    {
			list($username,$passwd,$phonenum,$phoneid,$whichdb)=GetCheckUserParameter();	
      $con=ConnectDb(); //�P�O�O�_�s�u,�n�[ if($con) //$con=true or false
      //if(!$con) die("");
            $rs = DbExcute(CheckUserIsLegalSql($username,$passwd));
            
            $tblmemberdatapen=GetRowsCount($rs);
          
            if (0<$tblmemberdatapen && $tblmemberdatapen<2)//�u���@�ձb���K�X
            {
                echo "0";//���\���U
      			}
            else 
            {
      				echo "1";//�ϥε۵L��
      			}	
      			CloseDb($con);	
		}
		else
		{
        	echo "1";//�ǻ��ѼƥX�{���D
    }
 }
 Main(); 
?>
