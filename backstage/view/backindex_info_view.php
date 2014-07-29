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
    <div style="width: 844px;" border="0" cellspacing="0" cellpadding="0">資訊連結</div>
    <div><a href="#" class="btn btn-success" onclick="post_to_url('backindex_info.php', {'action_mode':'add','r_id':'<?php echo $v1['r_id']; ?>'})">新增連結網址</a></div>
    <div style="width: 844px; float: left">
      <table width="844" border="0" cellspacing="0" cellpadding="0">
        <?php foreach ($data as $k1 => $v1) { ?>
        <tr>
          <th width="210" height="40" scope="row"><?php echo $v1['info_name']; ?></th>
          <td width="278" align="left"><?php echo $v1['info_url']; ?></td>
<!--      <td width="112" align="center"><a href="backindex_reinfo.php?<?php echo $MM_keepNone.(($MM_keepNone!="")?"&":"")."info_id=".urlencode($v1['info_id']) ?>">修改</a>　<a href="backindex_info.php?dele=true&amp;info_id=<?php echo $v1['info_id']; ?>" onclick="tfm_confirmLink('');return document.MM_returnValue">刪除</a></td> -->
          <td width="112" align="center">
            <a href="#" class="btn btn-warning" onclick="post_to_url('backindex_info.php', {'action_mode':'view_select_data','info_id':'<?php echo $v1['info_id']; ?>'})">修改</a>　
            <a href="#" class="btn btn-danger" onclick="tfm_confirmLink('你確定要刪除???','backindex_info.php', {'action_mode':'delete','info_id':'<?php echo $v1['info_id']; ?>'})">刪除</a></td>
        </tr>
        <?php } ?>
      </table>
  </div>
  <div style="width: 844px;">
  <p style="float: right;"><ul class="pagination"><?php echo $Firstpage . $Listpage . $Endpage . "<br>\n"?></ul></p>
  </div>

</div>



