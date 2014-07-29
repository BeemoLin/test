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
			if(is_array($array)){
				foreach($array as $key1 => $value1){
					foreach($value1 as $key2 => $value2){
						$db_datetime = strtotime(date($value2['list_datetime']));
						
						if($db_datetime>$now_date+86400){
							echo '<tr bgcolor="#FFFFCC">'."\n";
						}
						elseif($db_datetime<$now_datetime){
							echo '<tr bgcolor="#CCFFCC">'."\n";
						}
						else{
							echo '<tr bgcolor="#FFCCCC">'."\n";
						}
						
						//echo '<td style="text-align: center;">'.$value2['equipment_name']."</td>\n";
						echo '<td style="text-align: center;">'.$value2['m_username']."</td>\n";
						echo '<td style="text-align: center;">'.$value2['list_datetime']."</td>\n";
						echo '<td style="text-align: center;">'.$value2['save_datetime']."</td>\n";
            if($value2['equipment_exclusive']==1){
            	echo '<td style="text-align: center;">1戶'."</td>\n";
              if(isset($value2['count_number'])){
                if($value2['sum_number']>1){
                  echo '<td style="text-align: center;" rowspan="'.$value2['count_number'].'"><span style="color: red;">'.$value2['sum_number']."戶</span></td>\n";
                }
                else{
                  echo '<td style="text-align: center;" rowspan="'.$value2['count_number'].'">'.$value2['sum_number']."戶</td>\n";
                }
              }

            }
            else{
            	echo '<td style="text-align: center;">'.$value2['list_using_number']."人</td>\n";
              if(isset($value2['count_number'])){
                if($value2['sum_number']>$equipment_max_people){
                  echo '<td style="text-align: center;" rowspan="'.$value2['count_number'].'"><span style="color: red;">'.$value2['sum_number']."人</span></td>\n";
                }
                else{
                  echo '<td style="text-align: center;" rowspan="'.$value2['count_number'].'">'.$value2['sum_number']."人</td>\n";
                }
              }
            }
            


            
						echo '<td style="text-align: center;"><a href="#" onclick="'."post_to_url('backindex_equipment.php', {'action_mode':'set_reservation','list_id':'".$value2['list_id']."','equipment_id':'".$equipment_id."'})".'" >備註</a>'."</td>\n";
						if(!($db_datetime<$now_datetime)){
							echo '<td style="text-align: center;"><a href="#" onclick="'."tfm_confirmLink('你確定要取消預約???','backindex_equipment.php', {'action_mode':'disable_reservation','list_id':'".$value2['list_id']."','equipment_id':'".$equipment_id."'})".'" >取消</a>'."</td>\n";
						}
						else{
							echo '<td style="text-align: center;">'."&nbsp;</td>\n";
						}
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