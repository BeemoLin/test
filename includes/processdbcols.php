<?php
/*
��Ʈw�����]���X�R,�ҥH���e����ƧY�n�p��;���᪺�����]���u�Φs�JDB�ҥH�i�H�������X���ݭp��
��������X�R���Ʊ����즹�ɮ׼W�[
*/
class processdbcols
{
 //��ƩR�W:table's name+ new col name
  
  
//�Ǧ^�r��ΰ}�C �n�Φb��MVC�[�c :VIEW�u�nPHP���ܼƩΰ}�C


        
      //function equipment_reservation_list_list_endtime �Ǧ^(��� �_:�ɤ� ��:�ɤ�)
      //1.$list_endtime:�q���������ɶ�
      //2.$list_time:�q�����_�l�ɶ�
      //3.$advance_end:�]�ƪ������ɶ�
      //4.$equipment_id:�]��ID
      //5.$list_datetime:�q���ɶ��t���+�_�l�ɶ�
        
       function equipment_reservation_list_list_endtime($list_endtime,$list_time,$advance_end,$equipment_id,$list_datetime)
       {                           //�]�w��Ʈw�Ψ��o�j�M�y�k
            //var_dump($list_endtime);
            if($list_endtime=="00:00:00")//��ܤ��e������;�L���d��;�u�n�a�p��
            {
              list($listhour, $listmin, $listsec) = split(':', $list_time); //�n�Ϊ��ޥ�
              list($endhour, $endmin, $endsec) = split(':', $advance_end);
               
              if($equipment_id=="10")//�����d��ť��
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
              //substr("abcde",0,-1);//abcd �N��q index=0,�q�k�䦩�@�Ӧr
              //substr("abcde",-1,-1);�N��q index=-1���k��Ĥ@�Ӧr��,�M��b�q�k�䦩�@�Ӧr ��X"";
              //substr(1,2,3)1:str 2:�q���Ӧ�m���٬O�k 3.�q���Υk���X�Ӧr�� ���ƥN��q����αq������X�Ӧr��,�t�ƥN��q�k��αq�k�䦩���X�Ӧr��
              $starttime=substr($list_datetime,0,-3);
              $timeformat=$starttime."~".$showhour.":".$showmin;
            }
            else
            {
               //�ɶ��n���B�z ���ɤ�
               
               $starttime=substr($list_datetime,0,-3);
               $endtime=substr($list_endtime,0,-3);
               //var_dump($endtime);
               $timeformat=$starttime."~".$endtime; //�s�����������ɶ����s�W�ҥH�������
            }
            return $timeformat;
         }








}

?>
