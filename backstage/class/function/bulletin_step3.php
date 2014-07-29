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
<div id="right3_right" style="width: 665px; height: 600px; position: absolute; overflow: auto;">
  <div class="subjectDiv"> 社區公告</div>
  <div class="actionDiv">相片總數:0</div>
  <form enctype="multipart/form-data" action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <input type="hidden" name="getpage" value="bulletin">
    <input type="hidden" name="step" value="3">
    <input type="hidden" name="acttype" value="update">
    <input type="hidden" name="tblname" value="news_album">
    <input type="hidden" name="img_dir" value="news">
    <input type="hidden" name="MM_update" value="form1" />
    <div class="normalDiv">
      <p class="heading">內容</p>
      <p>標題名稱：
        <input name="album_title" type="text" id="album_title" value="<?php echo $row_RecAlbum['album_title']; ?>" />
        <input name="album_id" type="hidden" id="album_id" value="<?php echo $row_RecAlbum['album_id']; ?>" />
      </p>
      <p>發佈時間：
        <input name="album_date" type="text" id="album_date" value="<?php echo date("Y-m-d H:i:s");?>" readonly="readonly" />
      </p>
      <p>編輯者 ：
        <input name="album_location" type="text" id="album_location" value="<?php echo $row_RecAlbum['album_location']; ?>" />
      </p>
      <p>內容：
        <textarea name="album_desc" id="album_desc" cols="45" rows="5"><?php echo $row_RecAlbum['album_desc']; ?></textarea>
      </p>
    </div>
    <hr />
    <div class="normalDiv">
      <p class="heading">新增照片</p>
      <div class="clear"></div>
      <p>照片1
        <input type="file" name="ap_picurl1" id="ap_picurl1">
        說明1：
        <input type="text" name="ap_subject1" id="ap_subject1" />
      </p>
      <p>照片2
        <input type="file" name="ap_picurl2" id="ap_picurl2">      
        說明2：
        <input type="text" name="ap_subject2" id="ap_subject2" />
      </p>
      <p>照片3
        <input type="file" name="ap_picurl3" id="ap_picurl3">      
        說明3：
        <input type="text" name="ap_subject3" id="ap_subject3" />
      </p>
      <p>照片4
        <input type="file" name="ap_picurl4" id="ap_picurl4">      
        說明4：
        <input type="text" name="ap_subject4" id="ap_subject4" />
      </p>
      <p>照片5
        <input type="file" name="ap_picurl5" id="ap_picurl5">      
        說明5：
        <input type="text" name="ap_subject5" id="ap_subject5" />
      </p>
      <p>&nbsp;</p>
      <p>
        <input type="submit" name="button" id="button" value="更新及上傳資料" />
      </p>
    </div>
  </form>
  <hr />
  <?php if ($totalRows_RecPhoto > 0) { // Show if recordset not empty ?>
  <div class="normalDiv">
    <p class="heading">管理照片</p>
    <?php do { ?>
    <div class="div">
      <div class="picDiv"><img src="news/<?php echo $row_RecPhoto['ap_picurl']; ?>" alt="" width="100" height="100" border="0" /></div>
      <div class="albuminfo">
        <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
          <input type="hidden" name="getpage" value="bulletin">
          <input type="hidden" name="step" value="3">
          <input type="hidden" name="acttype" value="update">
          <input type="hidden" name="tblname" value="news_album">
          <input type="hidden" name="MM_update" value="form3" />
          <input type="hidden" name="img_dir" value="news">
          <input type="hidden" name="album_id" value="<?php echo $row_RecPhoto['album_id']; ?>">
          <input name="ap_id" type="hidden" id="ap_id" value="<?php echo $row_RecPhoto['ap_id']; ?>" />
          <input name="ap_subject" type="text" id="ap_subject" value="<?php echo $row_RecPhoto['ap_subject']; ?>" size="10" />
          <input name="button3" type="submit" id="button3" value="更新" />
          <a href="#" onclick="tfm_confirmLink('你確定要刪除???','backindex.php',{'getpage':'bulletin','step':'3','tblname':'news_album','acttype':'delete_photo','album_id':'<?php echo $row_RecPhoto['album_id']; ?>','ap_id':'<?php echo $row_RecPhoto['ap_id']; ?>','ap_picurl':'<?php echo $row_RecPhoto['ap_picurl']; ?>','img_dir':'news'});">刪除圖片</a>
        </form>
        <p><br />
        </p>
      </div>
    </div>
    <?php } while ($row_RecPhoto = mysql_fetch_assoc($RecPhoto)); ?>
  </div>
  <?php } // Show if recordset not empty ?>  
</div>
