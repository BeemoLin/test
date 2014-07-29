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

    <div style="width: 844px;" border="0" cellspacing="0" cellpadding="0">規約辦法</div>
    <div><a href="#" onclick="post_to_url('backindex_rule.php', {'action_mode':'add'})">新增規約辦法</a></div>
    <div style="width: 844px; float: left">
    <table width="840px" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <th style="background-position: left; background-repeat: no-repeat; background:#000; color: #FFF;" scope="row">標題</th>
        <th width="189" style="background-position: center; background:#000; background-repeat: repeat-x; color: #FFF;" scope="row">&nbsp;</th>
        <th width="45" style="background-position: right center; background:#000; background-repeat: no-repeat;" scope="row">&nbsp;</th>
      </tr>
      <?php
	  if(isset($data)){
		  foreach ($data as $k1 => $v1) { ?>
			<tr style="text-align: left">
			  <th height="20" colspan="2" align="left" scope="row"> <a href="#" onclick="post_to_url('backindex_rule.php', {'action_mode':'view_select_data','r_id':'<?php echo $v1['r_id']; ?>'})"><?php echo $v1['r_title']; ?></a></th>
			  <th width="45" align="left" scope="row"><?php if($_SESSION['MM_UserGroup']=='權限管理者'){?><a href="#" onclick="tfm_confirmLink('您確定要刪除???','backindex_rule.php', {'action_mode':'delete','r_id':'<?php echo $v1['r_id']; ?>'})">刪除</a><?php }?></th>
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


