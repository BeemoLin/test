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
    <td valign="top" style="width: 665px; height: 600px; position: absolute; overflow: auto;">
    
    <table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th class="555" scope="row"><span class="a">社區公告</span></th>
      </tr>
    </table>
    
      <p>&nbsp;</p>
      <p>　　<a href="#" class="a1" onclick="post_to_url('backindex.php', {'getpage':'bulletin','step':'2','tblname':'news_album','acttype':'insert'})">新增公告</a></p>
      <table width="628" border="0" align="left" cellpadding="0" cellspacing="0">
      
        <?php while($row_RecNews = mysql_fetch_assoc($RecNews)) { ?>
        <tr>
          <th width="32" height="31" scope="row"><img src="../img/btn2/MINI btn.gif" alt="" width="16" height="16" /></th>
          <th width="255" align="left" scope="row"><a href="#" onclick="post_to_url('backindex.php', {'getpage':'bulletin','step':'3','tblname':'news_album','acttype':'update','album_id':'<?php echo $row_RecNews['album_id']; ?>'})"><?php echo $row_RecNews['album_title']; ?></a></th>
          <th width="5" scope="row">&nbsp;</th>
          <th colspan="2" scope="row"><?php echo $row_RecNews['album_date']; ?></th>
          <th scope="row"><a href="#" onclick="tfm_confirmLink('你確定要刪除???','backindex.php', {'getpage':'bulletin','step':'1','tblname':'news_album','acttype':'delete','album_id':'<?php echo $row_RecNews['album_id']; ?>'})">刪除</a></th>
        </tr>
        <?php }  ?>
        
        <tr>
          <th colspan="4" scope="row">&nbsp;
          記錄 <?php echo ($startRow_RecNews + 1) ?> 到 <?php echo min($startRow_RecNews + $maxRows_RecNews, $totalRows_RecNews) ?> 共 <?php echo $totalRows_RecNews ?></th>
          <th colspan="2" scope="row">&nbsp;
          
            <table border="0">
              <tr>
                <td><?php if ($pageNum_RecNews > 0) { // Show if not first page ?>
                  <a href="#" onclick="post_to_url('backindex.php', {'getpage':'bulletin','step':'1','tblname':'news_album','acttype':'select','pageNum_RecNews':'0','totalRows_RecNews':'<?php echo $totalRows_RecNews;?>'})" >第一頁</a>
                  <?php } // Show if not first page ?></td>
                  
                <td><?php if ($pageNum_RecNews > 0) { // Show if not first page ?>
                  <a href="#" onclick="post_to_url('backindex.php', {'getpage':'bulletin','step':'1','tblname':'news_album','acttype':'select','pageNum_RecNews':'<?php echo max(0, $pageNum_RecNews - 1);?>','totalRows_RecNews':'<?php echo $totalRows_RecNews;?>'})" >上一頁</a>
                  <?php } // Show if not first page ?></td>
                  
                <td><?php if ($pageNum_RecNews < $totalPages_RecNews) { // Show if not last page ?>
                  <a href="#" onclick="post_to_url('backindex.php', {'getpage':'bulletin','step':'1','tblname':'news_album','acttype':'select','pageNum_RecNews':'<?php echo min($totalPages_RecNews, $pageNum_RecNews + 1);?>','totalRows_RecNews':'<?php echo $totalRows_RecNews;?>'})" >下一頁</a>
                  <?php } // Show if not last page ?></td>
                  
                <td><?php if ($pageNum_RecNews < $totalPages_RecNews) { // Show if not last page ?>
                  <a href="#" onclick="post_to_url('backindex.php', {'getpage':'bulletin','step':'1','tblname':'news_album','acttype':'select','pageNum_RecNews':'<?php echo $totalPages_RecNews;?>','totalRows_RecNews':'<?php echo $totalRows_RecNews;?>'})" >最後一頁</a>
                  <?php } // Show if not last page ?></td>
              </tr>
            </table>
            
            </th>
        </tr>
      </table>
    <p>&nbsp;</p>
    </td>
  </tr>
</table>
