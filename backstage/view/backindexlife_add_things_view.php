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
<script>
<!--
function tfm_confirmLink(message, path, params, method) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
  if (document.MM_returnValue){
    post_to_url(path, params, method);
  }
}
//-->
  function check(){
    var my_name = document.getElementById("name");
    var my_time = document.getElementById("time");
    var my_adj = document.getElementById("adj");
    if(my_name.value.length < 3){
      alert('請輸入名稱，最少3個字~!!');
    }
    else if(my_time.value.length < 4){
      alert('請輸入營業時間，最少4個字~!!');
    }
    else if(my_adj.value.length < 20){
      alert('請輸入資訊，最少20個字~!!');
    }
    else{
      document.form1.submit();
    }
    return false;
  }
</script>

<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td>
    <table style="width: 844px;" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td align="left">
          新增修改<?php echo $life_cname;?>
          <form action="backindexlife.php" method="post" name="form1" id="form1">
            <input name="life_name" type="hidden" value="<?php echo $life_name;?>" />
            <input name="action_mode" type="hidden" value="add" />
            <?php if(!empty($id_name) && !empty($id)){?>
            <input name="<?php echo $id_name;?>" type="hidden" value="<?php echo $id;?>" />
            <?php }?>
            <div class="show">
            <p>
              名稱
              <input name="name" id="name" type="text" value="<?php echo $name;?>" size="40" />
              日期
              <input name="date" id="date" type="text" readonly="readonly" value="<?php echo date("Y-m-d H:i:s");?>" />
            </p>
            <p>
              電話
              <input name="phone" id="phone" type="text" value="<?php echo $phone;?>" size="20" />
            </p>
            <p>
              傳真
              <input name="copyphone" id="copyphone" type="text" value="<?php echo $copyphone;?>" size="20" />
            </p>
            <p>
              位置
              <input name="address" id="address" type="text" value="<?php echo $address;?>" size="40" />
            </p>
            <p>營業時間
              <input name="time" id="time" type="text" value="<?php echo $time;?>" size="20" />
            </p>
            <p>
              網址
              <label>
                <input name="url" id="url" type="text" value="<?php echo $url;?>" size="40" />
              </label>
            </p>
            <p>資訊</p>
            <p>
              <textarea name="adj" id="adj" cols="50" rows="5"><?php echo $adj;?></textarea>
            </p>
            <p>&nbsp;</p>
            <p>
              <input type="button" class="btn btn-success" name="button" id="button" value="新增修改" onClick="check();" />
              <input type="button" class="btn btn-danger" name="button2" id="button2" value="回上一頁" onclick="window.history.back();" />
            </p>
            <input type="hidden" name="MM_upsert" value="form1" />
            <hr />
            </div>
          </form >
          <form enctype="multipart/form-data" action="backindexlife.php" method="post" name="form3" id="form3">
            <input name="life_name" type="hidden" value="<?php echo $life_name;?>" />
            <input name="action_mode" type="hidden" value="add" />
            <input type="hidden" name="MM_upsert" value="form3" />
            <?php if(!empty($id_name) && !empty($id)){?>
            <input name="<?php echo $id_name;?>" type="hidden" value="<?php echo $id;?>" />

              <p class="heading">新增照片</p>

              <?php
              $no = 0;
              foreach($data as $v){ 
              $no++;
              ?>
                <div class="div">
                  <img src="<?php echo $life_name.'/'.$v['ap_picurla']; ?>" alt="" width="100" height="100" border="0" />
                  <input type="button" class="btn btn-danger" name="button" id="button" value="刪除" onclick="tfm_confirmLink('你確定要刪除???','backindexlife.php',{'life_name':'<?php echo $life_name;?>','action_mode':'delete_image','<?php echo $id_name;?>':'<?php echo $id;?>','ap_picurla':'<?php echo $v['ap_picurla'];?>','app_id':'<?php echo $v['app_id'];?>'});" />
                </div>
              <?php 
              }
              ?>
              <br/>
              <div class="show">
                <?php
                $show_no = 1;
                for($no;$no<5;$no++){
                ?>
                <p>照片<?php echo $show_no;?>：
                  <input type="file" name="ap_picurl[]" id="<?php echo 'ap_picurl'.$show_no;?>">
                </p>
                <?php
                  $show_no++;
                }
                ?>
                <input type="submit" class="btn btn-success" name="button" id="button" value="新增修改" />
              </div>
            <?php }?>
          </form>
          </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
