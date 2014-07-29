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
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;"><p>&nbsp;</p>
      <table width="587" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr height="40">
          <td>
            <button type="button" class="btn btn-success" href="#" onclick="post_to_url('backindexauthority.php', {'action_mode':'add_user_view'})">新增管理者</button>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th width="40"  style="background:#000; color: #FFF;">&nbsp;</th>
          <th width="173" style="background:#000; color: #FFF;">帳號</th>
          <th style="background:#000; color: #FFF;">&nbsp;</th>
          <td width="100" style="background:#000; color: #FFF;text-align: center;">姓名</td>
          <td width="140" style="background:#000; color: #FFF;text-align: center;">編輯</td>
        </tr>
        <?php foreach ($data as $V) { ?>
        <tr height="40">
          <th width="40" scope="row">&nbsp;</th>
          <th width="173" scope="row"><?php echo $V['m_username']; ?></th>
          <th scope="row"><?php echo $V['m_level']; ?></th>
          <td width="100" style="text-align: center; font-size: 18px; font-weight: bold;"><?php echo $V['m_name']; ?></td>
          <td width="70" style="text-align: center; font-size: 14px; font-weight: bold;">
            <a type="button" class="btn btn-primary" onclick="post_to_url('backindexauthority.php', {'action_mode':'edit_user_view','m_id':'<?php echo $V['m_id'];?>'})">修改</a>
            <a type="button" class="btn btn-danger" onclick="tfm_confirmLink('你確定要刪除???','backindexauthority.php',{'action_mode':'delete_user','m_id':'<?php echo $V['m_id']; ?>'});">刪除</a>
          </td>
        </tr>
        <?php }  ?>
      </table>
      <div class="text-center">
        <ul class="pagination"><?php echo $Firstpage . $Listpage . $Endpage . "<br>\n"?></ul>
      </div>
    </td>
  </tr>
</table>
