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
<form action="backindexlife.php" name="form1" method="POST">
<input type="hidden" name="life_name" value="<?php echo $life_name;?>">
<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px;"><p>
    <a href="#" class="btn btn-success" onclick="post_to_url('backindexlife.php', {'life_name':'<?php echo $life_name;?>','action_mode':'add_things'})">新增<?php echo $life_cname;?></a></p>
      <p>&nbsp;</p>
      <table width="628" border="0" align="center" cellpadding="0" cellspacing="0">          
        <?php foreach($data as $V) { ?>
        <tr>
          <th width="33" height="31" scope="row"><img src="../img/btn2/MINI btn.gif" alt="" width="16" height="16" /></th>
          <th width="302" align="left" scope="row"><?php echo $V["$life_name".'_name']; ?></th>
          <th width="8" scope="row">&nbsp;</th>
          <th width="148" colspan="2" scope="row"><?php echo $V["$life_name".'_date']; ?></th>
          <th width="68" height="40" scope="row"><a href="#" class="btn btn-primary" onclick="post_to_url('backindexlife.php', {'life_name':'<?php echo $life_name;?>','action_mode':'edit_things','<?php echo "$life_name".'_id';?>':'<?php echo $V["$life_name".'_id'];?>'})">修改</a></th>
          <th width="69" height="40" scope="row"><a href="#" class="btn btn-danger" onclick="tfm_confirmLink('你確定要刪除???','backindexlife.php',{'life_name':'<?php echo $life_name;?>','action_mode':'delete','<?php echo "$life_name".'_id';?>':'<?php echo $V["$life_name".'_id'];?>'});">刪除</a></th>
        </tr>
        <?php } ?>
      </table>
      <div align="right"><ul class="pagination"><?php  echo $Firstpage.$Listpage.$Endpage."<br />\n";  ?></ul></div>
    </td>
  </tr>
</table>
</form>