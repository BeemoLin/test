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
    <td valign="top" style="width: 844px; ">
    <table width="134" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th width="134" class="555" scope="row"><span class="a">　財務報表</span></th>
      </tr>
    </table>
      <p>&nbsp;</p>
      <table width="150" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td height="40">
            <a href="#" class="btn btn-success" onclick="post_to_url('backindex_money.php', {'action_mode':'add_money_view'})">新增報表</a>
          </td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <div>
      <table width="844" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th colspan="2" style="font-family: '微軟正黑體'; background:#000; color: #FFF;">標題</th>
          <th style="font-family: '微軟正黑體'; background:#000; color: #FFF;">人氣</th>
          <th width="264" style="font-family: '微軟正黑體'; background:#000; color: #FFF;">日期</th>
          <th width="96" style="background:#000;">&nbsp;</th>
        </tr>
        <?php 
        if(isset($data)){
          foreach ($data as $k1 => $v1) { 
        ?>
        <tr height="40" style="text-align: left; color: #000; font-family: '微軟正黑體';">
          <th width="15" scope="row"><img src="../img/btn2/MINI btn.gif" alt="a" width="16" height="16" /></th>
          <th width="212" align="left" scope="row"><a href="#" onclick="post_to_url('backindex_money.php', {'action_mode':'view_select_data','album_id':'<?php echo $v1['album_id']; ?>'})"><?php echo $v1['album_title']; ?></a></th>
          <th width="35" scope="row"><?php echo $v1['album_hits']; ?></th>
          <th align="center" scope="row"><span style="color: #000;">[<?php echo $v1['album_date']; ?>]</span></th>
          <th align="left" scope="row"><a href="#" class="btn btn-danger" onclick="tfm_confirmLink('你確定要刪除???','backindex_money.php', {'action_mode':'delete','album_id':'<?php echo $v1['album_id']; ?>'})">刪除</a></th>
        </tr>
        <?php 
          }
        } 
        ?>
      </table>
      </div>
      <div style="float: right;">
        <ul class="pagination"><?php echo $Firstpage . $Listpage . $Endpage . "<br>\n"?></ul>
      </div>
     </td>
  </tr>
</table>

