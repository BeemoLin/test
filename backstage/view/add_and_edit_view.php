<style type="text/css">
<!--
.div {
    float: left;
    font-size: 12px;
    width: 168px;
    padding: 5px 0px 5px 0px;
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
    var my_title = document.getElementById("<?php echo $input_title;?>");
    var my_desc = document.getElementById("<?php echo $input_desc;?>");
    if(my_title.value.length < 3){
      alert('請輸入標題名稱，最少3個字~!!');
    }
    else if(my_desc.value.length < 3){
      alert('請輸入內容，最少3個字~!!');
    }
    else{
      document.form1.submit();
    }
    return false;
  }
  
function myhome(){
  location.href='<?php echo $form;?>';
}
function chang_pic_subject(path, input_id, pic_id, pic_subject_name){
  pic_subject = document.getElementById(pic_subject_name).value;
  post_to_url(path,{'action_mode':'update_pic_subject', '<?php echo $input_id;?>':input_id, '<?php echo $pic_id;?>':pic_id, '<?php echo $pic_subject;?>':pic_subject});
}

</script>
<div id="right3_right" >
  <div class="subjectDiv"><?php echo $subject?></div>
  <form enctype="multipart/form-data" action="<?php echo $form;?>" method="post" name="form1" id="form1">
    <input type="hidden" name="action_mode" value="<?php echo $action_mode;?>">
    <div class="normalDiv">
      <p class="heading">內容</p>
      <p><?php echo $title01;?>：
        <input name="<?php echo $input_title;?>" type="text" id="<?php echo $input_title;?>" value="<?php echo @$row_Rec['1'][$input_title]; ?>" />
        <input name="<?php echo $input_id;?>" type="hidden" id="<?php echo $input_id;?>" value="<?php echo @$row_Rec['1'][$input_id]; ?>" />
      </p>
      <p><?php echo $title02;?>：
        <input name="<?php echo $input_date;?>" type="text" id="<?php echo $input_date;?>" value="<?php echo (empty($row_Rec['1'][$input_date])) ? date("Y-m-d H:i:s") : $row_Rec['1'][$input_date] ;?>" readonly="readonly" />
      </p>
      <p><?php echo $title03;?>：
        <input name="<?php echo $input_location;?>" type="text" id="<?php echo $input_location;?>" value="<?php echo (empty($row_Rec['1'][$input_location])) ? $MM_UserGroup : $row_Rec['1'][$input_location] ; ?>" readonly="readonly" />
      </p>
      <p><?php echo $title04;?>：
        <textarea name="<?php echo $input_desc;?>" id="<?php echo $input_desc;?>" cols="45" rows="5"><?php echo @$row_Rec['1'][$input_desc]; ?></textarea>
      </p>
    </div>
  <hr />
    <div>
      <p class="heading"><?php if(isset($title05)){echo $title05;}else{echo '新增照片';} /* 目前用相容的方式，以後直接 echo $title05; */?></p>
    <?php
    $no = 0;
	if(isset($row_RecPhoto)){
		foreach($row_RecPhoto as $v){ 
		$no++;
		?>
		  <div class="div">
			<img src="<?php echo $img_dir.'/'.$v[$pic_url]; ?>" alt="" width="100" height="100" border="0" /><br />
			<input type="text" name="<?php echo $pic_subject.$no;?>" value="<?php echo $v[$pic_subject];?>" id="<?php echo $pic_subject.$no;?>" style="width:100px;" /><br />
			<input type="button" name="button" id="button" value="刪除" onclick="tfm_confirmLink('你確定要刪除???','<?php echo $form;?>',{'action_mode':'delete_image','<?php echo $input_id; ?>':'<?php echo $v[$input_id]; ?>','<?php echo $pic_id;?>':'<?php echo $v[$pic_id]; ?>','<?php echo $pic_url?>':'<?php echo $v[$pic_url]; ?>','img_dir':'<?php echo $img_dir;?>'});" />
			<input type="button" name="button2" id="button2" value="更新" onclick="chang_pic_subject('<?php echo $form;?>', '<?php echo $v[$input_id]; ?>', '<?php echo $v[$pic_id]; ?>', '<?php echo $pic_subject.$no;?>')"/>
		  </div>
		<?php 
		}
	}
    ?>
      <div class="show" style="clear:both;">
        <?php
        $show_no = 1;
        for($no;$no<$pic_max;$no++){
        ?>
        <p><?php if(isset($title06)){echo $title06;}else{echo '照片';}  echo $show_no; /* 目前用相容的方式，以後直接 echo $title06; */ ?>：
          <input type="file" name="<?php echo $pic_url.'[]';?>" id="<?php echo $pic_url.$show_no;?>" />
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php if($enable_pic_subject=='true'){ //開啟說明?>
          說明<?php echo $show_no;?>：
          <input type="text" name="<?php echo $pic_subject.$show_no;?>" id="<?php echo $pic_subject.$show_no;?>"/>
        <?php } ?>
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


