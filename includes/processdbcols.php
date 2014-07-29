<?php
/*
資料庫的欄位因為擴充,所以當之前的資料即要計算;之後的版本因為只用存入DB所以可以直接取出不需計算
之後欄位擴充的事情都到此檔案增加
*/
class processdbcols
{
 //函數命名:table's name+ new col name
  
  
//傳回字串或陣列 好用在於MVC架構 :VIEW只要PHP的變數或陣列


        
      //function equipment_reservation_list_list_endtime 傳回(日期 起:時分 迄:時分)
      //1.$list_endtime:訂約的結束時間
      //2.$list_time:訂約的起始時間
      //3.$advance_end:設備的結束時間
      //4.$equipment_id:設備ID
      //5.$list_datetime:訂約時間含日期+起始時間
        
       function equipment_reservation_list_list_endtime($list_endtime,$list_time,$advance_end,$equipment_id,$list_datetime)
       {                           //設定資料庫及取得搜尋語法
            //var_dump($list_endtime);
            if($list_endtime=="00:00:00")//表示之前的版本;無此攔位;只好靠計算
            {
              list($listhour, $listmin, $listsec) = split(':', $list_time); //好用的技巧
              list($endhour, $endmin, $endsec) = split(':', $advance_end);
               
              if($equipment_id=="10")//奧斯卡視聽室
              {
                $showhour=((int)$listhour+3>=(int)$endhour)?(int)$endhour:(int)$listhour+3;
                $showhour=((int)$showhour<10)?"0".(string)$showhour:(string)$showhour;
                $showmin=((int)$listhour+3>=(int)$endhour)?"00":$listmin;
              }
              else
              {
                $showhour=((int)$listhour+2>=(int)$endhour)?(int)$endhour:(int)$listhour+2;
                $showhour=((int)$showhour<10)?"0".(string)$showhour:(string)$showhour;
                $showmin=((int)$listhour+2>=(int)$endhour)?"00":$listmin;
              }
              //$showsec="00";
              //substr("abcde",0,-1);//abcd 代表從 index=0,從右邊扣一個字
              //substr("abcde",-1,-1);代表從 index=-1集右邊第一個字元,然後在從右邊扣一個字 輸出"";
              //substr(1,2,3)1:str 2:從哪個位置左還是右 3.從左或右取幾個字元 正數代表從左邊或從左邊取幾個字元,負數代表從右邊或從右邊扣掉幾個字元
              $starttime=substr($list_datetime,0,-3);
              $timeformat=$starttime."~".$showhour.":".$showmin;
            }
            else
            {
               //時間要做處理 成時分
               
               $starttime=substr($list_datetime,0,-3);
               $endtime=substr($list_endtime,0,-3);
               //var_dump($endtime);
               $timeformat=$starttime."~".$endtime; //新版本有結束時間的新增所以直接抓取
            }
            return $timeformat;
         }








}

?>
