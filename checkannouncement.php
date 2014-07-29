<?php 
	include('CommFun.php');
  function HavaAnAnnouncement()
  {
    $sql="SELECT * FROM  `news_album` ".
        "order by album_id";//加是否通知住戶
    return 	$sql;
  }
  
  function HavaAnAnnouncementPic($album_id)
  {
    $sql="SELECT * FROM  `news_photo` ".
       "WHERE  `album_id` =".$album_id.
       " ORDER BY `ap_id`";
    return 	$sql;
  }
  function GetAnnouncementPicName($rsAnnouncementPic)
  {
    $formats1="kais..kaie";
    $formats2="kais::kaie";
    while ($row = mysql_fetch_array($rsAnnouncementPic, MYSQL_ASSOC)) 
    {
               
        $PicName=$PicName.$row["ap_picurl"].$formats1.$row["ap_subject"].$formats2;
        //printf("編號".$i.": %s  函件編號: %s", $i, $row["letters_number"]);
    }
    return substr($PicName,0,strlen($PicName)-10);
  } 

 function GetAnnouncementPackage($rsAnnouncement)
 {
          //封包格式: 封數:函件編號1;函件編號2;.......
          // $datas = mysql_fetch_assoc($rsMail);
         $i=0;
	 $formats1="kais,,kaie";
	 $formats2="kais;;kaie";
			    while ($row = mysql_fetch_array($rsAnnouncement, MYSQL_ASSOC)) 
          {
              $i=$i+1;
              //修改
              //$letternum=$letternum.$row["letters_number"].",".$row["sends_name"].",".$row["letter_category"].",".$row["letter_alt"].",". substr($row["receives_time"],0,-3).";";
              //20130319 修改封包
              
              //關聯
              $PicName="";
              $rsAnnouncementPic = DbExcute(HavaAnAnnouncementPic($row["album_id"]));  
              if (GetRowsCount($rsAnnouncementPic) > 0)
              {
                  $PicName=GetAnnouncementPicName($rsAnnouncementPic);
              }
              $announcement=$announcement.$row["album_id"].$formats1.$row["album_title"].$formats1.$row["album_desc"].$formats1.$row["album_hits"].$formats1. $row["album_date"].$formats1.$PicName.$formats2;
              //printf("編號".$i.": %s  函件編號: %s", $i, $row["letters_number"]);
          }
          $strpackge=$i."@@".substr($announcement,0,strlen($announcement)-10);//去掉最後一個分號
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
        $rsAnnouncement = DbExcute(HavaAnAnnouncement());   
        if (GetRowsCount($rsAnnouncement) > 0)
        {
          echo GetAnnouncementPackage($rsAnnouncement);
        }
        else
        {
          echo "0";//"無公告訊息"
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
