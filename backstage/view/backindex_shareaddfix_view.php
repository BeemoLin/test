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
function tfm_confirmLink(message, path, params, method) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
  if (document.MM_returnValue){
    post_to_url(path, params, method);
  }
}
  function check(){
    var my_title = document.getElementById("share_title");
    var my_desc = document.getElementById("share_desc");
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
  location.href='backindex_share.php';
}
</script>



<div id="right3_right" >
  <div class="subjectDiv">分享園地</div>
  <form enctype="multipart/form-data" action="backindex_share.php" method="post" name="form1" id="form1">
    <input type="hidden" name="action_mode" value="<?php echo $action_mode;?>">
    <div class="normalDiv">
      <p class="heading">內容</p>
      <p>標題名稱：
        <input name="share_title" type="text" id="share_title" value="<?php echo $row_RecShare['1']['share_title']; ?>" />
        <input name="share_id" type="hidden" id="share_id" value="<?php echo $row_RecShare['1']['share_id']; ?>" />
      </p>
      <p>發佈時間：
        <input name="share_date" type="text" id="share_date" value="<?php echo (empty($row_RecShare['1']['share_date'])) ? date("Y-m-d H:i:s") : $row_RecShare['1']['share_date'] ;?>" readonly="readonly" />
      </p>
      <p>發表者：
        <input name="share_sharename" type="text" id="share_sharename" value="<?php echo (empty($row_RecShare['1']['share_sharename'])) ? $MM_UserGroup : $row_RecShare['1']['share_sharename'] ; ?>" readonly="readonly" />
      </p>
      <p>內容：
        <textarea name="share_desc" id="share_desc" cols="45" rows="5"><?php echo $row_RecShare['1']['share_desc']; ?></textarea>
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
                  <input type="button" name="button" id="button" value="刪除" onclick="tfm_confirmLink('你確定要刪除???','backindex_share.php',{'action_mode':'delete_image','share_id':'<?php echo $v['share_id']; ?>','ap_id':'<?php echo $v['ap_id']; ?>','ap_picurl':'<?php echo $v['ap_picurl']; ?>','img_dir':'share'});" />
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
                <input type="button" name="button" id="button" onClick="check();" value="新增修改" />
                <input type="button" name="gohome" id="gohome" onClick="myhome();" value="返回公告" />
              </div>
             </div>
          </form>
</div>


