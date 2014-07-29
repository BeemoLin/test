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
<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; position: absolute; overflow: auto;">
      <table width="400" height="39" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th width="134" scope="row">管理-住戶列表</th>
          <td width="140" align="center"><a type="button" class="btn btn-success" href="backindexhouseholderexcle.php">Excel匯入資料</a></td>
          <td width="126" align="center"><a type="button" class="btn btn-success" href="#" onclick="post_to_url('backindexhouseholder.php', {'action_mode':'add_user_view'})">新增會員</a></td>
        </tr>
      </table>
      <table width="508" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th width="40" style="text-align: center; background:#000; color: #FFF;">&nbsp;</th>
          <th style="text-align: center; background:#000; color: #FFF;">帳號</th>
          <td width="195" style="text-align: center; background:#000; color: #FFF;">姓名</td>
          <td width="140" style="text-align: center; background:#000; color: #FFF;">編輯</td>
        </tr>
        <?php foreach ($data as $v){ ?>
        <tr>
          <th width="40" scope="row">&nbsp;</th>
          <th width="116" align="center" scope="row"><?php echo $v['m_username']; ?></th>
          <td width="195" style="text-align: center; font-size: 18px; font-weight: bold;"><?php echo $v['m_name']; ?></td>
          <td width="140" height="40" style="text-align: center; font-size: 14px; font-weight: bold;">
            <a href="#" class="btn btn-primary" onclick="post_to_url('backindexhouseholder.php', {'action_mode':'edit_user_view','m_id':'<?php echo $v['m_id']; ?>'})">修改</a> 
            <a href="#" class="btn btn-danger" onclick="tfm_confirmLink('您確定要刪除???','backindexhouseholder.php', {'action_mode':'delete_user','m_id':'<?php echo $v['m_id']; ?>'})">刪除</a>
          </td>
        </tr>
        <?php } ?>
      </table>
  <div class="text-center">
    <ul class="pagination"><?php echo $Firstpage . $Listpage . $Endpage . "<br>\n"?></ul>
  </div>
    </td>
  </tr>
</table>
