<?php //預定刪除  ?>
<style type="text/css">
<!--
.div {
    float: left;
    font-size: 12px;
    width: 20%;
}
.show {
    float: left;
    width: 650px;
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
  function check(){
    var my_title = document.getElementById("album_title");
    var my_desc = document.getElementById("album_desc");
    if(my_title.value.length < 3){
      alert('請輸入標題名稱，最少3個字~!!');
    }
    else if(my_desc.value.length < 10){
      alert('請輸入內容，最少10個字~!!');
    }
    else{
      document.form1.submit();
    }
    return false;
  }
  
function myhome(){
  location.href='backindexannouncement.php';
}
//-->
</script>
<div id="right3_right" >
  <div class="subjectDiv"> 社區公告</div>
  <form enctype="multipart/form-data" action="backindexannouncement.php" method="post" name="form1" id="form1">
    <input type="hidden" name="action_mode" value="<?php echo $action_mode;?>">
    <div class="normalDiv">
      <p class="heading">內容</p>
      <p>標題名稱：
        <input name="album_title" type="text" id="album_title" value="<?php echo $row_RecAlbum['1']['album_title']; ?>" />
        <input name="album_id" type="hidden" id="album_id" value="<?php echo $row_RecAlbum['1']['album_id']; ?>" />
      </p>
      <p>發佈時間：
        <input name="album_date" type="text" id="album_date" value="<?php echo (empty($row_RecAlbum['1']['album_date'])) ? date("Y-m-d") : $row_RecAlbum['1']['album_date'] ;?>" readonly="readonly" />
      </p>
      <p>編輯者 ：
        <input name="album_location" type="text" id="album_location" value="<?php echo (empty($row_RecAlbum['1']['album_location'])) ? $MM_UserGroup : $row_RecAlbum['1']['album_location'] ; ?>" readonly="readonly" />
      </p>
      <p>內容：
        <textarea name="album_desc" id="album_desc" cols="45" rows="5"><?php echo $row_RecAlbum['1']['album_desc']; ?></textarea>
      </p>
    </div>
  <hr />

             <div>
              <p class="heading">新增照片</p>
              <?php
              $no = 0;
              foreach($row_RecPhoto as $v){ 
              $no++;
              ?>
                <div class="div">
                  <img src="<?php echo $img_dir.'/'.$v['ap_picurl']; ?>" alt="" width="100" height="100" border="0" />
                  <input type="button" name="button" id="button" value="刪除" onclick="tfm_confirmLink('你確定要刪除???','backindexannouncement.php',{'action_mode':'delete_image','album_id':'<?php echo $v['album_id'];?>','ap_picurl':'<?php echo $v['ap_picurl'];?>','ap_id':'<?php echo $v['ap_id'];?>'});" />
                </div>
              <?php 
              }
              ?>
              <div class="show">
                <?php
                $show_no = 1;
                for($no;$no<10;$no++){
                ?>
                <p>照片<?php echo $show_no;?>：
                  <input type="file" name="ap_picurl[]" id="<?php echo 'ap_picurl'.$show_no;?>">
                </p>
                <?php
                  $show_no++;
                }
                ?>
                <input type="button" class="btn btn-success" name="button" id="button" onClick="check();" value="新增修改" />
                <input type="button" class="btn btn-danger" name="gohome" id="gohome" onClick="myhome();" value="返回公告" />
              </div>
             </div>
          </form>
</div>
