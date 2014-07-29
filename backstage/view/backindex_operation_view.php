<script type="text/javascript">
function tfm_confirmLink(message, path, params, method) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
  if (document.MM_returnValue){
    post_to_url(path, params, method);
  }
}
</script>

<div id="right3_right" border="0" cellpadding="0" cellspacing="0" valign="top" >
  <div>操作手冊</div>
  <div><a href="#" class="btn btn-success" onclick="post_to_url('backindex_operation.php', {'action_mode':'add_photo_view'})" >新增總覽</a></div>
  <div>操作總覽</div>
  <table width="600" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="center">
      
      <table width="844" align="left">
        <tr>
          <th style="font-family: '微軟正黑體'; background:#000; color: #FFF;" scope="row">標題</th>
          <th style="background:#000;" >&nbsp;</th>
        </tr>
    <?php 
	if(isset($data)){
		foreach ($data as $k1 => $v1) {
		?>
			<tr height="40" style="text-align: left; color: #000; font-family: '微軟正黑體';">
			  <th width="500" ><a href="#" onclick="post_to_url('backindex_operation.php', {'action_mode':'view_select_data','album_id':'<?php echo $v1['album_id']; ?>'})"><?php echo $v1['album_title']; ?></a></th>
			  <th ><a href="#" class="btn btn-danger" onclick="tfm_confirmLink('你確定要刪除???','backindex_operation.php', {'action_mode':'delete','album_id':'<?php echo $v1['album_id']; ?>'})">刪除</a></th>
			</tr>
		<?php 
		} 
	}
	?>
      </table>
      </td>
    </tr>
  </table>
  <div style="width: 844px;">
  <p style="float: right;"><ul class="pagination"><?php echo $Firstpage . $Listpage . $Endpage . "<br>\n"?></ul></p>
  </div>
</div>
