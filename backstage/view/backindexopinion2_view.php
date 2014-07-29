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
  <div width="844" border="0" cellspacing="0" cellpadding="0">意見反應</div>
  <div style="width: 844px; float: left">
  <table width="844" border="0" align="left" cellpadding="0" cellspacing="0">
    <?php 
    if (is_array($data)){
      foreach ($data as $k1 => $v1) { 
    ?>
    <tr height="40">
      <td width="29" height="31" scope="row"><img src="../img/btn2/MINI btn.gif" alt="" width="16" height="16" /></td>
      <td width="223" align="left" scope="row"><?php echo $v1['ot1_title']; ?></td>
      <td width="81" scope="row"><?php echo $v1['m_username']; ?></td>
      <td colspan="2" scope="row"><?php echo $v1['ot1_datetime']; ?></td>
      <td width="70" scope="row"><a href="#" class="btn btn-warning" onclick="post_to_url('backindexopinion2.php', {'action_mode':'view_select_data','ot1_id':'<?php echo $v1['ot1_id']; ?>'})">回覆</a> </td>
      <!-- <td width="51" scope="row"><a href="#" onclick="tfm_confirmLink('你確定要結案???','backindexopinion2.php', {'action_mode':'disable','ot1_id':'<?php echo $v1['ot1_id']; ?>'})">結案</a></td> -->
      <?php if($_SESSION['MM_UserGroup']=='權限管理者'){?><td width="70" scope="row"><a href="#" class="btn btn-danger" onclick="tfm_confirmLink('你確定要刪除???','backindexopinion2.php', {'action_mode':'delete','ot1_id':'<?php echo $v1['ot1_id']; ?>'})">刪除</a></td><?php }?>
    </tr>
    <?php 
      } 
    }
    ?>
  </table>
  </div>
  <div style="width: 844px;">
  <p style="float: right;"><ul class="pagination"><?php echo $Firstpage . $Listpage . $Endpage . "<br>\n"?></ul></p>
  </div>
</div>  




