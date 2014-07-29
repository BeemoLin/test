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

<div id="right3_right" border="0" cellpadding="0" cellspacing="0" valign="top" >
  <div width="844" border="0" cellspacing="0" cellpadding="0">社區公告</div>
  <div width="844"><a href="#" class="a1 btn btn-success" onclick="post_to_url('backindexannouncement.php', {'action_mode':'add_category_view'})">新增公告</a></div>
  <div style="width: 844px; float: left">
  <table width="844" border="0" align="left" cellpadding="0" cellspacing="0">
    <?php foreach ($data as $k1 => $v1) { ?>
    <tr height="40">
      <td width="32" height="31" scope="row"><img src="../img/btn2/MINI btn.gif" alt="" width="16" height="16" /></td>
      <td width="255" align="left" scope="row"><a href="#" onclick="post_to_url('backindexannouncement.php', {'action_mode':'view_select_data','album_id':'<?php echo $v1['album_id']; ?>'})"><?php echo $v1['album_title']; ?></a></td>
      <td width="5" scope="row">&nbsp;</td>
      <td colspan="2" scope="row"><?php echo $v1['album_date']; ?></td>
      <td scope="row"><a href="#" class="btn btn-danger" onclick="tfm_confirmLink('你確定要刪除???','backindexannouncement.php', {'action_mode':'delete_category','album_id':'<?php echo $v1['album_id']; ?>'})">刪除</a></td>
    </tr>
    <?php } ?>
  </table>
  </div>
  <div style="float: left;">
    <ul class="pagination"><?php echo $Firstpage . $Listpage . $Endpage . "<br>\n"?></ul>
  </div>
</div>  



