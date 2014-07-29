<script type="text/javascript">
function tfm_confirmLink(message, path, params, method) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
  if (document.MM_returnValue){
    post_to_url(path, params, method);
  }
}
</script>

<div id="right3_right" border="0" cellpadding="0" cellspacing="0"  >
<div style="width: 844px;">
  <table width="844" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th class="555" scope="row"><span class="a1"><span class="a">分享園地</span></span></th>
    </tr>
  </table>
  <p>
    <a href="#" onclick="post_to_url('backindex_share.php', {'action_mode':'add_share_view'})">新增圖文分享</a> 　　
    <!--<a href="#" onclick="post_to_url('backindex_photo.php', {'action_mode':'movies_add_view'})">新增影片分享</a>-->
  </p>
  <table width="844" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr >
      <th colspan="2" style="background:#000; color: #FFF;" scope="row">標題</th>
      <th style="background:#000; color: #FFF;">人氣</th>
      <th width="189" style="background:#000; color: #FFF;">日期</th>
      <th width="45" style="background:#000; color: #FFF;">&nbsp;</th>
    </tr>
    <?php 
	if(isset($data)){
		foreach ($data as $k1 => $v1) { 
		?>
		<tr style="text-align: left">
		  <th width="9">&nbsp;</th>
		  <!--<th width="220" align="left"><a href="backindex_shareaddfix.php?<?php echo $MM_keepNone.(($MM_keepNone!="")?"&":"")."share_id=".urlencode($v1['share_id']) ?>">[<?php echo $v1['share_movie']; ?><?php echo $v1['share_picture']; ?>]<?php echo $v1['share_title']; ?><?php echo $v1['share_name']; ?></a></th>-->
		  <th width="220" align="left"><a href="#" onclick="post_to_url('backindex_share.php', {'action_mode':'view_select_data','share_id':'<?php echo $v1['share_id']; ?>'})"><?php echo $v1['share_title']; ?><?php echo $v1['share_name']; ?></a></th>
		  <th width="157" align="center"><?php echo $v1['share_hits']; ?></th>
		  <th align="center"><span style="font-family: '微軟正黑體';">[<?php echo $v1['share_date']; ?>]</span></th>
		  <th width="45" align="left"><a href="#" onclick="tfm_confirmLink('你確定要刪除???','backindex_share.php',{'action_mode':'delete','share_id':'<?php echo $v1['share_id']; ?>'});">刪除</a></th>
		</tr>
		<?php 
		} 
	}
	?>
  </table>
  </div>
<div style="width: 844px;">
  <div>
    <p style="float: right;"><ul class="pagination"><?php echo $Firstpage . $Listpage . $Endpage . "<br>\n"?></ul></p>
  </div>
</div>
</div>
