<?php 
define("Gym","1000");
define("PartyRoom","1003");
define("HearCenter","1002");
define("Barbecue","1001");
function GetEquMoney($equid,&$money){
     switch($equid){
          case Gym:
            $money=20;
            break;
          case PartyRoom:
          case HearCenter:
            $money=100;
            break;
          case Barbecue:
            $money=300;
            break;
          default:
            $money=0;
        }
}
function GetUnit($equid,&$unit){
     switch($equid){
          case Barbecue:
            $unit="爐";
            break;
          case Gym:
            $unit="人";
            break;
          case PartyRoom:
            $unit="間";
            break;
          case HearCenter:
            $unit="間";
            break;
          default:
            $unit="人";
            break;
        }
}
GetEquMoney($equipment_id,&$money);
GetUnit($equipment_id,&$unit);
?>
<script type="text/javascript">
<!--
function tfm_confirmLink(message, path, params, method) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
  if (document.MM_returnValue){
    post_to_url(path, params, method);
  }
}
//-->
</script>
<div id="pic3">
	<form action="backindex_equipment" id="form1" method="post" name="form1">
		<a href="#" onclick="post_to_url('backindex_equipment.php', {'action_mode':'view_equipment_data'})" >設備列表</a> -> 預約列表&nbsp;&nbsp;（<?php echo $equipment_name;?>）<br />
		<br />
		<a href="#" onclick="post_to_url('backindex_equipment.php', {'action_mode':'add_reservation','equipment_id':'<?php echo $equipment_id;?>'})" >新增預約</a><br />
		<table border="1" cellpadding="1" cellspacing="1" style="width: 100%;">
			<thead>
				<tr>
					<!-- <th scope="col">預約設備</th> -->
					<th scope="col">預約用戶</th>
					<th scope="col">預約時間</th>
					<th scope="col">存檔時間</th>
					<th scope="col">預約數</th>
					<th scope="col">累計數</th>
          <th scope="col">備註</th>
          <th scope="col">付費狀況</th>
					<th scope="col">取消預約</th>
				<?php if($_SESSION['MM_UserGroup']=='權限管理者'){?>
					<th scope="col">刪除</th>
				<?php }?>
				</tr>
			</thead>
			<tbody>
			<?php
			$now_date = strtotime(date("Y-m-d 00:00:00"));
			$now_datetime = strtotime(date("Y-m-d H:i:s"));
			if(is_array($array))
      {
      //3維陣列
				foreach($array as $key1 => $value1)
        {
					foreach($value1 as $key2 => $value2)
          {
            //預約時間>現在時間 預約時間<現在時間 預約時間=現在時間
            $processTime= split("~", $value2['list_datetime']);
            //20121121ADD
						//$db_datetime = strtotime(date($value2['list_datetime']));
						$db_datetime = strtotime(date($processTime[0]));
						if($db_datetime>$now_date+86400){
							echo '<tr bgcolor="#FFFFCC">'."\n";
						}
						elseif($db_datetime<$now_datetime){
							echo '<tr bgcolor="#CCFFCC">'."\n";
						}
						else{
							echo '<tr bgcolor="#FFCCCC">'."\n";
						}
						 //預約時間>現在時間 預約時間<現在時間 預約時間=現在時間
						 
						//echo '<td style="text-align: center;">'.$value2['equipment_name']."</td>\n";
						echo '<td style="text-align: center;">'.$value2['m_username']."</td>\n";
						echo '<td style="text-align: center;">'.$value2['list_datetime']."</td>\n"; 
						echo '<td style="text-align: center;">'.$value2['save_datetime']."</td>\n";
							
            if($value2['equipment_exclusive']==1)//專屬預約
            {
            	echo '<td style="text-align: center;">1戶'."</td>\n";
              if(isset($value2['count_number'])){
                if($value2['sum_number']>1)
                {
                  echo '<td style="text-align: center;"><span style="color: red;">'.$value2['sum_number']."戶</span></td>\n";
                }
                else
                {
                  echo '<td style="text-align: center;">'.$value2['sum_number']."戶</td>\n";
                }
              }
              else
              {
                echo "<td></td>";
              }
            }
            else //非專屬預約
            {
            	echo '<td style="text-align: center;">'.$value2['list_using_number'].$unit."</td>\n";
              
              //調整ROWSPAN
              if(isset($value2['count_number'])){
                if($value2['sum_number']>$equipment_max_people){  
                  $rownum=$value2['count_number'];
                  echo '<td style="text-align: center;" rowspan="'.$rownum.'"><span style="color: red;">'.$value2['sum_number'].$unit."</span></td>\n";
                  $rownum-=1;
                }
                else{
                  $sumnum=($value2['sum_number']=="")?"0":$value2['sum_number'];
                  $rownum=($value2['count_number']=="0" || $value2['count_number']=="")?"1":$value2['count_number'];
                  echo '<td style="text-align: center;" rowspan="'.$rownum.'">'.$sumnum.$unit."</td>\n";
                  $rownum-=1;
                }
              }
              elseif($value2['count_number']==1){
                echo "<td></td>";
              }else{
                   $coltxt=($rownum>0)?"":"<td></td>";
                   echo $coltxt;
                   $rownum-=1;
              }
              //調整ROWSPAN
            }
           


            
						echo '<td style="text-align: center;"><a href="#" class="btn btn-default" onclick="'."post_to_url('backindex_equipment.php', {'action_mode':'set_reservation','list_id':'".$value2['list_id']."','equipment_id':'".$equipment_id."'})".'" >備註</a>'."</td>\n";
            
            $showm=$money*(int)$value2['list_using_number'];
            $showm=($showm>0)?$showm:"";
            
            if($value2['ispay']==0)
            {
            
              echo '<td style="text-align: center;"><a href="#" class="btn btn-danger" onclick="'."post_to_url('backindex_equipment.php', {'action_mode':'pay','list_id':'".$value2['list_id']."','equipment_id':'".$equipment_id."'})".'" >未付費'.$showm.'</a>'."</td>\n";
            }
            else
            {
              echo '<td style="text-align: center;"><a href="#" class="btn btn-success" onclick="'."post_to_url('backindex_equipment.php', {'action_mode':'unpay','list_id':'".$value2['list_id']."','equipment_id':'".$equipment_id."'})".'" >已付費'.$showm.'</a>'."</td>\n";
            }

             $canceltxt="";
             if(!($db_datetime<$now_datetime)){
                
                 if($value2['list_disable']=='1'){
                      $canceltxt=($value2['disable_man']!=null)?'<td style="text-align: center;">'."管理者取消預約&nbsp;</td>\n":'<td style="text-align: center;">'."住戶取消預約&nbsp;</td>\n";
                 }else{
                    $canceltxt='<td style="text-align: center;"><a href="#" onclick="'."tfm_confirmLink('你確定要取消預約???','backindex_equipment.php', {'action_mode':'disable_reservation','list_id':'".$value2['list_id']."','equipment_id':'".$equipment_id."'})".'" >取消</a>'."</td>\n";
                 }
                 
              }else{
                     if($value2['list_disable']=='1'){
                          $canceltxt=($value2['disable_man']!=null)?'<td style="text-align: center;">'."管理者取消預約&nbsp;</td>\n":'<td style="text-align: center;">'."住戶取消預約&nbsp;</td>\n";
                      }else{
                        $canceltxt='<td style="text-align: center;">'."&nbsp;</td>\n";
                      }
              }
              echo $canceltxt;
            
						if($_SESSION['MM_UserGroup']=='權限管理者'){
							echo '<td style="text-align: center;"><a href="#" onclick="'."tfm_confirmLink('你確定要刪除預約???','backindex_equipment.php', {'action_mode':'del_reservation','list_id':'".$value2['list_id']."','equipment_id':'".$equipment_id."'})".'">刪除</a>'."</td>\n";
						}
						echo "</tr>\n";
					}
				}
			}
			?>
			</tbody>
		</table>
		<div><?php echo $all_page;?></div>
	</form>
</div>
