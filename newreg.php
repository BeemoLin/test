<?php 
 include('CommFun.php');
 function CheckUserIsLegalSql($username,$passwd)//1.��check�ϥε�;�A�[CHECK���ID �A�[�P�Opnoneid=''�p�G�����ƶǦ^1 �L�Ǧ^0
 {
    return "SELECT * FROM memberdata WHERE m_username = '{$username}' and m_passwd = '{$passwd}'";
 }
 
 function CheckAPhoneIdIsNotExit($userphoneid,$phoneid)
 {
    if(is_null($phoneid)) return false; //�Yhttp://....�S���Ѽ�
    if(is_null($userphoneid)) return true;
        
    return ($userphoneid==$phoneid)?false:true; //����phoneid�h���}
 }
 
 function CheckPhoneIdIsNotExit($rs,$pen,$phoneid)
 {
    if(is_null($phoneid)) return false; //�Yhttp://....�S���Ѽ�
    
    for($i=1;$i<=$pen;$i++)
    {
        $matchphoneid=GetRowsData($rs);
        
        if(is_null($matchphoneid['m_cellphoneid']))  continue;
        
        if($matchphoneid['m_cellphoneid']==$phoneid)
        {
          return false;//����phoneid�h���}
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
		
      $con=ConnectDb(); //�P�O�O�_�s�u,�n�[ if($con) //$con=true or false
      //if(!$con) die("");
      
            $rs = DbExcute(CheckUserIsLegalSql($username,$passwd));
            
            $tblmemberdatapen=GetRowsCount($rs);
          
            if (0<$tblmemberdatapen && $tblmemberdatapen<2)//�u���@�ձb���K�X
            {
                
                $tblmemberdatarow = GetRowsData($rs);//����CommFun�̭�
                $mid=$tblmemberdatarow['m_id'];
                $userphoneid=$tblmemberdatarow['m_cellphoneid'];
                
               // die("����".$mid);
                $rss = DbExcute(GetTblchildmemberdataCount($mid));
                $tblchildmemberdatapen=GetRowsCount($rss);//���o����
                //echo $tblchildmemberdatapen;
                //checkphoneidisexit
                if(CheckAPhoneIdIsNotExit($userphoneid,$phoneid) &&  CheckPhoneIdIsNotExit($rss,$tblchildmemberdatapen,$phoneid))
                {
                        //---------------------------------------���q�n�Pwebserver�P�B-------------------------------
                        if(is_null($userphoneid))//��쪺���A�w�]�Ȭ�NULL
                        {
                        //---------ADD---------------
                          $sql=UpdTblmemberdata($mid,$phoneid,$phonenum);
                          $flag=DbExcute($sql);
                          if($flag)
                          {
                              //�O��LOG��
                              DbExcute(SynchronizeDataLog($sql));
                              echo "0";//���\���U
                          }
                        //---------ADD---------------
                        }
                        else
                        {   
                            //��check�O�_4��
                            if((int)$tblchildmemberdatapen > 3)
                            {
                               echo "1";//�w�W�L���� 
                            }
                            else
                            {
                                //---------ADD---------------
                                $sql=AddTblchildmemberdata($mid,$phoneid,$phonenum);
                                //echo $sql;
                                $flag=DbExcute($sql);//�P�O�O�_����s�W,�n�[	
                        				if($flag)
                                {
                                    //�O��LOG��
                                    DbExcute(SynchronizeDataLog($sql));
                                    
                                    echo "0";
                                }
                        				//---------ADD---------------
                            }              
                        }
                }
                else
                {
                  echo "0";//�w�����U�L
                }
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
