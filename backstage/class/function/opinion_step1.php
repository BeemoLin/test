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
    <td align="left" valign="top" style="width: 665px; height: 600px; position: absolute; overflow: auto;"><table width="330" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th width="330" align="left" class="555" scope="row"><span class="a">意見反應</span></th>
      </tr>
    </table>
      <p>&nbsp;</p>
      <table width="659" border="0" align="right" cellpadding="0" cellspacing="0">
        <tr>
          <th width="659" colspan="4" scope="row"><table width="628" border="0" align="center" cellpadding="0" cellspacing="0">
            <?php do { ?>
            <tr>
              <th width="29" height="31" scope="row"><img src="../img/btn2/MINI btn.gif" alt="" width="16" height="16" /></th>
              <th width="223" align="left" scope="row"><?php echo $row_RecNews['opinion_type']; ?></th>
              <th width="81" scope="row"><?php echo $row_RecNews['opinion_name']; ?></th>
              <th colspan="2" scope="row"><?php echo $row_RecNews['opinion_date']; ?></th>
              <th width="41" scope="row"><a href="backindexopinionre.php?<?php echo $MM_keepNone.(($MM_keepNone!="")?"&":"")."opinion_id=".urlencode($row_RecNews['opinion_id']) ?>">回覆</a></th>
              <th width="51" scope="row"><a href="#" onclick="tfm_confirmLink('你確定要刪除???','backindex.php', {'getpage':'opinion','step':'1','tblname':'opinion','acttype':'delete','album_id':'<?php echo $row_RecNews['album_id']; ?>'})">刪除</a></th>
            </tr>
            <?php } while ($row_RecNews = mysql_fetch_assoc($RecNews)); ?>
            <tr>
              <th colspan="4" scope="row">&nbsp;
                記錄 <?php echo ($startrow_Recordset + 1) ?> 到 <?php echo min($startrow_Recordset + $maxRows_Recordset, $totalRows_Recordset) ?> 共 <?php echo $totalRows_Recordset ?></th>
              <th colspan="3" scope="row">&nbsp;
                <table border="0">
                  <tr>
                    <td><?php if ($pageNum_RecNews > 0) { // Show if not first page ?>
                      <a href="#" onclick="post_to_url('backindex.php', {'getpage':'opinion','step':'1','tblname':'opinion','acttype':'select','pageNum_RecNews':'0','totalRows_RecNews':'<?php echo $totalRows_RecNews;?>'})" >第一頁</a>
                      <?php } // Show if not first page ?></td>
                      
                    <td><?php if ($pageNum_RecNews > 0) { // Show if not first page ?>
                      <a href="#" onclick="post_to_url('backindex.php', {'getpage':'opinion','step':'1','tblname':'opinion','acttype':'select','pageNum_RecNews':'<?php echo max(0, $pageNum_RecNews - 1);?>','totalRows_RecNews':'<?php echo $totalRows_RecNews;?>'})" >上一頁</a>
                      <?php } // Show if not first page ?></td>
                      
                    <td><?php if ($pageNum_RecNews < $totalPages_RecNews) { // Show if not last page ?>
                      <a href="#" onclick="post_to_url('backindex.php', {'getpage':'opinion','step':'1','tblname':'opinion','acttype':'select','pageNum_RecNews':'<?php echo min($totalPages_RecNews, $pageNum_RecNews + 1);?>','totalRows_RecNews':'<?php echo $totalRows_RecNews;?>'})" >下一頁</a>
                      <?php } // Show if not last page ?></td>
                      
                    <td><?php if ($pageNum_RecNews < $totalPages_RecNews) { // Show if not last page ?>
                      <a href="#" onclick="post_to_url('backindex.php', {'getpage':'opinion','step':'1','tblname':'opinion','acttype':'select','pageNum_RecNews':'<?php echo $totalPages_RecNews;?>','totalRows_RecNews':'<?php echo $totalRows_RecNews;?>'})" >最後一頁</a>
                      <?php } // Show if not last page ?></td>
                  </tr>
                </table>
                </th>
            </tr>
          </table></th>
        </tr>
      </table>
    <p>&nbsp;</p></td>
  </tr>
</table>
