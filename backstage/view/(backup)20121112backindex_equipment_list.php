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
		設備列表<br />
		<br />
		<!-- <a href="#" onclick="post_to_url('backindex_equipment.php', {'action_mode':'view_equipment_data'})" >設備列表</a> 
    <a href="#" onclick="post_to_url('backindex_equipment.php', {'action_mode':'view_reservation_data'})" >綜合預約列表</a><br /> -->
		<a href="#" onclick="post_to_url('backindex_equipment.php', {'action_mode':'add_equipment'})" >新增設備</a><br />
		<table align="left" border="1" cellpadding="1" cellspacing="1" style="width: 100%;">
			<thead>
				<tr>
					<th scope="col">設備名稱</th>
					<th scope="col">設定</th>
					<th scope="col">預約</th>
					<th scope="col">專屬</th>
					<th scope="col">人數</th>
					<th scope="col">關閉</th>
					<th scope="col">隱藏</th>
					<th scope="col">預約列表</th>
				<?php if($_SESSION['MM_UserGroup']=='權限管理者'){?>
					<th scope="col">刪除</th>
				<?php }?>
				</tr>
			</thead>
      <?php
      if(is_array($data)){
      ?>
			<tbody>
      <?php
			if(is_array($data)){
        foreach ($data as $key => $value){
      ?>
				<tr>
					<td><?php echo $value['equipment_name'];?></td>
					<td style="text-align: center;"><a href="#" onclick="post_to_url('backindex_equipment.php', {'action_mode':'set_equipment','equipment_id':'<?php echo $value['equipment_id'];?>'})" >設定</a></td>
					<td style="text-align: center;"><?php echo $value['equipment_advance']=='0'? '否':'是';?></td>
					<td style="text-align: center;"><?php echo $value['equipment_exclusive']=='0'? '否':'是';?></td>
					<td style="text-align: center;"><?php echo $value['equipment_max_people'];?></td>
					<td style="text-align: center;"><?php echo $value['equipment_stop']=='0'? '否':'是';?></td>
					<td style="text-align: center;"><?php echo $value['equipment_hidden']=='0'? '否':'是';?></td>
					<?php
					if($value['equipment_advance']=='0'){
						echo '<td style="text-align: center;">&nbsp;</td>';
					}
					else{
						echo '<td style="text-align: center;"><a href="#" onclick="'."post_to_url('backindex_equipment.php', {'action_mode':'view_reservation_data','equipment_id':'".$value['equipment_id']."'})".'" >查看</a></td>'."\n";
					}
					?>
					<?php if($_SESSION['MM_UserGroup']=='權限管理者'){?><td style="text-align: center;"><a href="#" onclick="tfm_confirmLink('你確定要刪除???','backindex_equipment.php', {'action_mode':'del_equipment','equipment_id':'<?php echo $value['equipment_id'];?>'})" >刪除</a></td><?php }?>
				</tr>
      <?php
        }
			}
      ?>
      <div align="right"><?php echo $Firstpage.$Listpage.$Endpage."<br />\n";?></div>
			</tbody>
      <?php
      }
      ?>
		</table>
		&nbsp;</form>
</div>