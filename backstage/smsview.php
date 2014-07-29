<?php
//定義action
//送簡訊是不是可以不用這一行;或著要用big5送
//輸出HTML
function ViewLayout($data){
              echo "<html>";
              echo "<body>";
              //---include html 使用迴圈跑
              //die($pages->sql);
              for($i=1;$i<50;$i++){
                $space=$space."&nbsp;";
              }
              //post 提交的時候可以取出html所有元素值
              echo "<form action='smsview.php' name='myForm' method='post'>"; //action 使用sumbmit導到傳送簡訊的程式
              echo "<table>";
              foreach($data as $value){ //$data 2維陣列;使用foreach走訪;$value降為1維陣列
              
                //var_dump($value['m_cellphone']);is_null
                /*if(is_null($value['m_cellphone'])){
                  echo "F";
                }else{
                  echo "T"; 變數空白,不是null
                }*/
                if($value['m_cellphone']<>"") {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='phonea[]' value='".$value['m_cellphone']."'></td><td>".$value['m_username']."</td><td>".$space."</td><td>".$value['m_cellphone']."</td>";
                    
                    echo "</tr>";
                    //echo "<input type='checkbox' name='phonea[]' value='".$value['m_cellphone']."'>".$value['m_username'].$space.$value['m_cellphone'];
                    
                    //echo "<br>";
                }
                if ($value['m_carmum1']<>"") {
                     echo "<tr>";
                
                    echo "<td><input type='checkbox' name='phonea[]' value='".$value['m_carmum1']."'></td><td>".$value['m_car1']."</td><td>".$space."</td><td>".$value['m_carmum1']."</td>";
               
                       echo "</tr>";
                
                  //echo "<input type='checkbox' name='phonea[]' value='".$value['m_carmum1']."'>".$value['m_car1'].$space.$value['m_carmum1'];
                  //echo "<br>";
                }
                if ($value['m_carmum2']<>"") {
                  
                   echo "<tr>";
                   echo "<td><input type='checkbox' name='phonea[]' value='".$value['m_carmum2']."'></td><td>".$value['m_car2']."</td><td>".$space."</td><td>".$value['m_carmum2']."</td>";
                   
                   
                   echo "</tr>";
                  //echo "<input type='checkbox' name='phonea[]' value='".$value['m_carmum2']."'>".$value['m_car2'].$space.$value['m_carmum2'];
                  //echo "<br>";
                }
                if ($value['m_carmum3']<>"") {
                   echo "<tr>";
                   echo "<td><input type='checkbox' name='phonea[]' value='".$value['m_carmum3']."'></td><td>".$value['m_car3']."</td><td>".$space."</td><td>".$value['m_carmum3']."</td>";
                  
                   echo "</tr>";
                  //echo "<input type='checkbox' name='phonea[]' value='".$value['m_carmum3']."'>".$value['m_car3'].$space.$value['m_carmum3'];
                }
                
                
              }
              echo "</table>";
              
              echo  "<input type='hidden' name='action' value='sendsms'>"; //如果有多個button可以透過javascript去onclick改變value值再去submit
              echo "<br>";
              
              echo "<input type='radio' name='yn[]' value='y'>是";
              echo "<input type='radio' name='yn[]' value='n' checked>否";
              echo  "<input type='submit'  value='送出簡訊'>";
              echo "</form>";
              echo "</body>";
              echo "</html>";
}
//查詢餘額
function SeekCoda($UserID,$Passwd){
    
  $net="http://smexpress.mitake.com.tw:9600/SmQueryGet.asp?username=".$UserID."&password=".$Passwd;
  $buffer = file_get_contents($net); //將網址讀入buffer變數
  //echo $buffer;
  //$notifycoda=false;
  if(strpos($buffer,"Point=")>0){
    list($title, $scoda) = split("=", $buffer);
    $coda=(int)$scoda;
    //echo "Month:".$title."Day:".$coda;
    if($coda<101){
       return true; 
    }else{
       return false; 
    }
  }
}
 
//點數不足,發送簡訊給物管人員
 function Notifymanager($UserID,$Passwd){
 
        require_once('define.php');
        //require_once(CONNSQL);session檢查的機制
        require_once(PAGECLASS);
        $pages = new data_function;
        ////////////////////////////////
        $pages->setDb('memberdata');
        $data = $pages->select("AND m_name='物管人員'");//是不是取fsc就是物館人員以後就不用更動
        
        $body=urlencode("點數不足,請儘快與廠商連絡,補足點數");
        foreach($data as $value){ //只有一筆
          
         //  echo $value['m_username'];
          if($value['m_cellphone']<>""){
              
              //$net="location:http://smexpress.mitake.com.tw:9600/SmSendGet.asp?username=".$UserID."&password=".$Passwd."&dstaddr=".$value['m_cellphone']."&DestName=AKAI&smbody=".$body;
              //echo $net;
              //header($net);
              //echo $net;
              
              $net="http://smexpress.mitake.com.tw:9600/SmSendGet.asp?username=".$UserID."&password=".$Passwd."&dstaddr=".$value['m_cellphone']."&encoding=UTF8&DestName=AKAI&smbody=".$body;
              $buffer = file_get_contents($net);
              //echo $buffer;
              
          }
        }
 }
 //寄信給住戶
  function SendMsgToHouser($UserID,$Passwd,$phone){
  
   $letter=urlencode("您有一封掛號信");//剩下編碼問題
    foreach ($phone as $value) {
           //  echo "號碼 : ".$value."<br />";
        $net="location:http://smexpress.mitake.com.tw:9600/SmSendGet.asp?username=".$UserID."&password=".$Passwd."&dstaddr=".$value."&DestName=AKAI&smbody=".$letter;
        //header($net);
        $net="http://smexpress.mitake.com.tw:9600/SmSendGet.asp?username=".$UserID."&password=".$Passwd."&dstaddr=".$value."&encoding=UTF8&DestName=AKAI&smbody=".$letter;
        $buffer = file_get_contents($net);
    }
  
  }
//關閉視窗
 function ExitWindow(){
 
  //header("Location: ../ch4/ex04_01.php");
  $net="location:http://www.lohaslife.com.tw/test/backstage/exit.php";
  //$net="refresh:5;url=http://www.lohaslife.com.tw/cc80/backstage/exit.php";
  header($net);
 }
 
 
header('Content-type:text/html; charset=utf-8');
$action_mode=(isset($_POST['action']))?$_POST['action']:null;
//die();
if($action_mode=='sendsms'){//送簡訊
  
  //有勾選才會有值,不勾沒值
  $phone = $_POST['phonea'];
  //var_dump($phone); 
  $yn = (isset($_POST['yn']))?$_POST['yn']:null;
  /* foreach ($yn as $value) {
             echo "是否 : ".$value."<br />";
        } */
    //var_dump($yn);    
  if($yn[0]=="y"){
    //送簡訊
    //echo "ok";
    $UserID="23294915";
    $Passwd="0423294915";
    // echo $letter;
    //echo urldecode($letter);
    if(SeekCoda($UserID,$Passwd)){
         Notifymanager($UserID,$Passwd);
    }
    SendMsgToHouser($UserID,$Passwd,$phone);
  }
  ExitWindow();
  //sleep(3);
}else{//初始
          require_once('define.php');
          //require_once(CONNSQL);session檢查的機制
          require_once(PAGECLASS);
          //require_once(INCLUDES.'/processdbcols.php');
          //取HTML所有物件的內容使用action=get
          if(isset($_GET)){
          	foreach($_GET as $key => $value){
          		$$key = $value;
          		//echo '$'.$key.'='.$value."<br />\n";
          	}
          }
              $pages = new data_function;
              ////////////////////////////////
              $pages->setDb('memberdata');
              $data = $pages->select("AND m_username='".$member."'");
              ViewLayout($data);
}

?>
