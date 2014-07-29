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
    <table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th class="555" scope="row"><span class="a">問卷調查</span></th>
      </tr>
    </table>
      <br />
      <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="150" scope="row">檢視問卷資料</th>
          <td width="150" align="center"><a href="#" class="btn btn-success" onclick="post_to_url('backindex_QA.php', {'action_mode':'add'})">新增問卷資料</a></td>
        </tr>
        <tr>
          <th colspan="2" scope="row">&nbsp;</th>
        </tr>
      </table>
      <table width="364" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th scope="row"><table width="341" border="0" cellspacing="0" cellpadding="0">
            <?php 
			if(isset($data)){
				foreach ($data as $k1 => $v1) { 
				?>
				<tr>
				  <th width="29" height="40" scope="row"><img src="../img/btn2/MINI btn.gif" alt="" width="16" height="16" /></th>
				  <td width="257" align="left"><a href="#" onclick="post_to_url('backindex_QA.php', {'action_mode':'view_select_data','qa_id':'<?php echo $v1['qa_id']; ?>'})"><?php echo $v1['qa_type']; ?></a></td>
        <?php 
          if($_SESSION['MM_UserGroup'] == '權限管理者'){
        ?>
				  <td width="55" align="left"><a href="#" class="btn btn-danger" onclick="tfm_confirmLink('你確定要刪除???','backindex_QA.php', {'action_mode':'delete','qa_id':'<?php echo $v1['qa_id']; ?>'})">刪除</a></td>
        <?php
          }
        ?>
				</tr>
				<?php
				} 
			}
			?>
          </table></th>
        </tr>
    </table>
    </td>
  </tr>
</table>
