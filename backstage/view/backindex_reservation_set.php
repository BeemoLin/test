<script type="text/javascript">
</script>
<div>
	<form action="backindex_equipment.php" enctype="multipart/form-data" method="POST" name="form1">
    <input type="hidden" name="action_mode" value="update_reservation_check" >
    <input type="hidden" name="list_id" value="<?php echo $value['list_id'];?>" >
    <input type="hidden" name="equipment_id" value="<?php echo $equipment_id;?>" >
    <!-- <input type="hidden" name="equipment_max_people" value="<?php echo $equipment_max_people;?>" > -->
		<div>
			<table border="0" cellpadding="1" cellspacing="1" style="width: 100%;">
				<tbody>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">用戶名稱</th>
						<td><?php echo $value['m_username'];?></td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">設備名稱</th>
						<td><?php echo $value['equipment_name'];?></td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">預約時間</th>
						<td><?php echo $value['list_datetime'];?></td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">預約人數</th>
						<td><?php echo $value['list_using_number'];?></td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">備註</th>
						<td><textarea name="list_remarks" id="list_remarks"onkeyup="this.value = this.value.substring(0, 100)" style="width: 327px; height: 108px;"><?php echo $value['list_remarks'];?></textarea></td>
					</tr>
					<tr>
						<td align="right" colspan="2">
							<input type="submit" value="確定"/>
							<input type="button" value="回設備列表" onclick="post_to_url('backindex_equipment.php', {'action_mode':'view_reservation_data','equipment_id':'<?php echo $equipment_id;?>'})" />
						</td>
					</tr>
				</tbody>
			</table>
			<br />
			&nbsp;</div>
	</form>
</div>
