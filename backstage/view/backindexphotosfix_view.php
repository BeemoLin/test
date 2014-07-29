<?php //預定刪除  ?>
<style type="text/css">
<!--
.div {
    float: left;
    font-size: 12px;
    height: 200px;
    width: 150px;
}
-->
</style>

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
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;"><table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td><div class="subjectDiv"> 相簿管理界面-修改相簿資訊</div>
          <div class="actionDiv"></div>
          <form enctype="multipart/form-data" action="backindex_photo.php" method="post" name="form1" id="form1">
            <div class="normalDiv">
              <p class="heading">相簿內容</p>
              <p>相簿名稱：
                <input name="album_title" type="text" id="album_title" value="<?php echo $row_RecAlbum['1']['album_title']; ?>" />
                <input name="album_id" type="hidden" id="album_id" value="<?php echo $row_RecAlbum['1']['album_id']; ?>" />
              </p>
              <p>拍攝時間：
                <input name="album_date" type="text" id="album_date" value="<?php echo date("Y-m-d"); ?>" readonly="readonly" />
                拍攝地點 ：
                <input name="album_location" type="text" id="album_location" value="<?php echo $row_RecAlbum['1']['album_location']; ?>" />
              </p>
              <p>相簿說明：
                <textarea name="album_desc" id="album_desc" cols="45" rows="5"><?php echo $row_RecAlbum['1']['album_desc']; ?></textarea>
              </p>
            </div>
            <hr />
            <div class="normalDiv">
              <p class="heading">新增照片</p>
              <div class="clear"></div>
              <p>照片1
                <input type="file" name="ap_picurl[]" id="ap_picurl1">
                說明1：
                <input type="text" name="ap_subject[]" id="ap_subject1" />
              </p>
              <p>照片2
                <input type="file" name="ap_picurl[]" id="ap_picurl2">      
                說明2：
                <input type="text" name="ap_subject[]" id="ap_subject2" />
              </p>
              <p>照片3
                <input type="file" name="ap_picurl[]" id="ap_picurl3">      
                說明3：
                <input type="text" name="ap_subject[]" id="ap_subject3" />
              </p>
              <p>照片4
                <input type="file" name="ap_picurl[]" id="ap_picurl4">      
                說明4：
                <input type="text" name="ap_subject[]" id="ap_subject4" />
              </p>
              <p>照片5
                <input type="file" name="ap_picurl[]" id="ap_picurl5">      
                說明5：
                <input type="text" name="ap_subject[]" id="ap_subject5" />
              </p>
              <p>&nbsp;</p>
              <p>
                <input type="submit" name="button" id="button" value="更新及上傳資料" />
              </p>
            </div>
            <input type="hidden" name="MM_update" value="form1" />
            <input type="hidden" name="action_mode" value="update" />
          </form>
          <hr />

          <div>
            <p class="heading">管理照片</p>
            <?php
            if(isset($row_RecPhoto)){
              foreach($row_RecPhoto as $k1 => $v) { 
            ?>
            <div class="div">
              <div class="picDiv"><img src="photos/<?php echo $v['ap_picurl']; ?>" alt="" width="100" height="100" border="0" /></div>
              <div class="albuminfo">
                <form action="backindex_photo.php" method="post" name="form3" id="form3">
                  <input name="ap_id" type="hidden" id="ap_id" value="<?php echo $v['ap_id']; ?>" />
                  <input name="album_id" type="hidden" id="album_id" value="<?php echo $v['album_id']; ?>" />
                  <input type="hidden" name="action_mode" value="update" />
                  <input name="ap_subject" type="text" id="ap_subject" value="<?php echo $v['ap_subject']; ?>" size="10" />
                  <input type="submit" name="button3" id="button3" value="更新" />
                  <a href="#" onclick="tfm_confirmLink('你確定要刪除???','backindex_photo.php',{'action_mode':'delete_image','album_id':'<?php echo $v['album_id']; ?>','ap_id':'<?php echo $v['ap_id']; ?>','ap_picurl':'<?php echo $v['ap_picurl']; ?>','img_dir':'news'});">刪除圖片</a>
                  <br />
                  <input type="hidden" name="MM_update" value="form3" />
                </form>
                <p><br />
                </p>
              </div>
            </div>
            <?php 
              }
            }
            ?>
          </div>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
