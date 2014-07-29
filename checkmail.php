<?php 
	include('CommFun.php');
  function CheckUserHavaAMail($username)
  {
    $sql="SELECT * FROM  `mail_management` ".
        "WHERE `m_username` =  '{$username}'".
        "AND  `disable` =  '0' AND `show`='1' order by id";//加是否通知住戶
    return 	$sql;
  }
 function GetUserMailPackage($rsmail)
 {
          //封包格式: 封數:函件編號1;函件編號2;.......
          // $datas = mysql_fetch_assoc($rsMail);
         $i=0;
	 $formats1="kais,,kaie";
	 $formats2="kais;;kaie";
			    while ($row = mysql_fetch_array($rsmail, MYSQL_ASSOC)) 
          {
              $i=$i+1;
              //修改
              //$letternum=$letternum.$row["letters_number"].",".$row["sends_name"].",".$row["letter_category"].",".$row["letter_alt"].",". substr($row["receives_time"],0,-3).";";
              //20130319 修改封包
              $letternum=$letternum.$row["letters_number"].$formats1.$row["receives_name"].$formats1.$row["sends_name"].$formats1.$row["letter_category"].$formats1. substr($row["receives_time"],0,-3).$formats2;
              //printf("編號".$i.": %s  函件編號: %s", $i, $row["letters_number"]);
          }
          $strpackge=$i."@@".substr($letternum,0,strlen($letternum)-10);//去掉最後一個分號
          //echo $strpackge;
          return  $strpackge;
 }
 function Main()
 {
    // 此處開始與遠端連線, 檢查是否有公告訊息
    // 有公告數 => n; 沒有 => 0
    // n:11111;2222;3333
    $con=ConnectDb();
    $flag=CheckUserPhoneIdIsReal();
    if($flag)
    {
        list($username,$passwd,$phonenum,$phoneid,$whichdb)=GetCheckUserParameter();
       // var_dump(CheckUserHavaAMail($username));
      	$rsMail = DbExcute(CheckUserHavaAMail($username));
        if (GetRowsCount($rsMail) > 0)
        {
          echo GetUserMailPackage($rsMail);
        }
        else
        {
          echo "0";//"NoMail";
        }
    }
    else
    {
        echo "1";
    }
    CloseDb($con);
 }
 Main(); 
?>
