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
  <table width="100" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th>社區剪影</th>
    </tr>
  </table>
  <table width="127" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="127">
      <a href="#" onclick="post_to_url('backindex_photo.php', {'action_mode':'add_photo_view'})" ><img src="../img/BTN/btn_up 2.gif" alt="" name="Image21" width="100" height="30" border="0" id="Image21" /></a></td>
    </tr>
  </table>
  <table width="600" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="188" >相簿總覽</td>
      <td></td>
    </tr>
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
			  <th width="500" ><a href="#" onclick="post_to_url('backindex_photo.php', {'action_mode':'view_select_data','album_id':'<?php echo $v1['album_id']; ?>'})"><?php echo $v1['album_title']; ?></a></th>
			  <th ><a href="#" class="btn btn-danger" onclick="tfm_confirmLink('你確定要刪除???','backindex_photo.php', {'action_mode':'delete','album_id':'<?php echo $v1['album_id']; ?>'})">刪除相簿</a></th>
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
