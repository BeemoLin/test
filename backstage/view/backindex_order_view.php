<script type="text/javascript">
function tfm_confirmLink(message, path, params, method) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
  if (document.MM_returnValue){
    post_to_url(path, params, method);
  }
}
</script>
<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;">
      <table width="100" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th class="555" scope="row"><span class="a1">公設預約</span></th>
        </tr>
      </table>
      <table width="484" height="111" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="484" height="24">　　　<?php //equipment 設備?>
          <a href="#" onclick="post_to_url('backindex_appointment.php', {'action_mode':'add_equipment'})">新增設備</a>　　
          <a href="#" onclick="post_to_url('backindex_appointment.php', {'action_mode':'add_order_view'})">新增預約用戶</a> 　　
          <a href="#" onclick="post_to_url('backindex_appointment.php', {'action_mode':'order_show_view'})">設備清單列表</a></td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
        </tr>
        <?php 
		if(isset($data)){
			foreach ($data as $k1 => $v1) { 
			?>
			<tr>
			  <td height="21">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td width="69%">　　　
					  <a href="#" onclick="post_to_url('backindex_appointment.php', {'action_mode':'edit_equipment','rulepic_id':'<?php echo $v1['rulepic_id']; ?>'})" ><?php echo $v1['name']; ?></a>
					</td>
					<td width="18%" align="center">&nbsp;</td>
					<td width="13%" align="center">
					  <?php if($_SESSION['MM_UserGroup']=='權限管理者'){?><a href="#" onclick="tfm_confirmLink('你確定要刪除???','backindex_appointment.php',{'action_mode':'deltree_appointment','rulepic_id':'<?php echo $v1['rulepic_id']; ?>'});">刪除</a><?php }?>
					</td>
				  </tr>
				</table>
				<hr />
			  </td>
			</tr>
			<?php 
			} 
		}
		?>
      </table>
    </td>
  </tr>
</table>
