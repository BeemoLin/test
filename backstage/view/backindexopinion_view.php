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
      foreach ($data as $k1 => $v1) { ?>
    <tr>
      <td width="29" height="31" scope="row"><img src="../img/btn2/MINI btn.gif" alt="" width="16" height="16" /></td>
      <td width="223" align="left" scope="row"><?php echo $v1['opinion_type']; ?></td>
      <td width="81" scope="row"><?php echo $v1['opinion_name']; ?></td>
      <td colspan="2" scope="row"><?php echo $v1['opinion_date']; ?></td>
      <td width="51" scope="row"><a href="#" onclick="post_to_url('backindexopinion.php', {'action_mode':'view_select_data','opinion_id':'<?php echo $v1['opinion_id']; ?>'})">回覆</a></td>
      <td width="51" scope="row"><a href="#" onclick="tfm_confirmLink('你確定要結案???','backindexopinion.php', {'action_mode':'disable','opinion_id':'<?php echo $v1['opinion_id']; ?>'})">結案</a></td>
      <?php if($_SESSION['MM_UserGroup']=='權限管理者'){?><td width="51" scope="row"><a href="#" onclick="tfm_confirmLink('你確定要刪除???','backindexopinion.php', {'action_mode':'delete','opinion_id':'<?php echo $v1['opinion_id']; ?>'})">刪除</a></td><?php }?>
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




