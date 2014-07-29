<script type="text/javascript">
  function check(){
    var equipment_name = document.getElementById("equipment_name");
    var equipment_max_people = document.getElementById("equipment_max_people");
    
    if(equipment_name.value.length < 3){
      alert('請輸入設備名稱，最少3個字~!!');
    }
    else if(equipment_max_people.value.length < 1){
      alert('請輸入人數上限');
    }
    else if(isNaN(equipment_max_people.value)){
      alert('人數上限請輸入數字');
    }
    else{
      document.form1.submit();
    }
    return false;
  }
	
	function chang_rule_picture(path, input_id, pic_id, pic_subject_name){
		post_to_url(path,{'action_mode':'update_pic_subject', 'equipment_id':input_id, 'equipment_rule_picture':pic_id});
	}
	
	function chang_equipment_picture2(path, input_id, pic_id, pic_subject_name){
		post_to_url(path,{'action_mode':'update_pic_subject', 'equipment_id':input_id, 'equipment_picture':pic_id});
	}
	
	function delete_equipment_picture(){
		tfm_confirmLink('你確定要刪除???','backindex_equipment.php',{'action_mode':'delete_pic','equipment_id':'<?php echo $value['equipment_id'];?>','equipment_picture':'<?php echo $value['equipment_picture'];?>'});
	}
	
	function chang_equipment_picture(){
		document.getElementById("new_equipment_picture").click();
		var new_equipment_picture = document.getElementById("new_equipment_picture").value;
		alert(new_equipment_picture);
		post_to_url('backindex_equipment.php', {'action_mode':'chang_pic','equipment_id':'<?php echo $value['equipment_id'];?>','equipment_picture':'<?php echo $value['equipment_picture'];?>','new_equipment_picture': new_equipment_picture });
	}
	
	function chang_equipment_picture123(){
		document.getElementById("new_equipment_picture").click();
	}


	function chang_pic_clock(){
		if(document.getElementById("new_equipment_picture").value == ''){
			setTimeout("chang_pic_clock();",1000);
		}
		else{
			alert('按下確定後，檔案開始上傳，請耐心等待!!');
			post_files_to_url('backindex_equipment.php', {'action_mode':'chang_pic','equipment_id':'<?php echo $value['equipment_id'];?>','equipment_picture':'<?php echo $value['equipment_picture'];?>'});
		}
	}	
	
	function tfm_confirmLink(message, path, params, method) { //v1.0
		if(message == "") message = "Ok to continue?";	
		document.MM_returnValue = confirm(message);
		if (document.MM_returnValue){
			post_to_url(path, params, method);
		}
	}
	
	function post_files_to_url(path, params) {
			method = "post"; 
			encoding = "multipart/form-data";
			enctype = "multipart/form-data";
 
			var form = document.createElement("form");
			form.setAttribute("method", method);
			form.setAttribute("action", path);
			form.setAttribute("encoding", encoding);
			form.setAttribute("enctype", enctype);

			//////////////////////////////////////////////////////////////
            for(var key in params) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);
                form.appendChild(hiddenField);
            }
			//////////////////////////////////////////////////////////////
				clone_new_equipment_picture = document.getElementById("new_equipment_picture").cloneNode(true);
				form.appendChild(clone_new_equipment_picture);
			//////////////////////////////////////////////////////////////
			document.body.appendChild(form); 

			form.submit();
  }

  function selectShow(){
    var exclusive_type = document.form1.equipment_exclusive;

    
    var select_people = document.getElementById('select_people');

    var val;
    for(var i = 0; i < exclusive_type.length; i++){
        if(exclusive_type[i].checked){
                val = exclusive_type[i].value;
            }
    }
 
    if(val == 1)
    {
      select_people.style.visibility="hidden";
    } 
    else
    {
      select_people.style.visibility="visible";
    }
  }


</script>
<div>
	<form action="backindex_equipment.php" enctype="multipart/form-data" method="POST" name="form1">
    <input type="hidden" name="action_mode" value="update_equipment_check" >
    <input type="hidden" name="equipment_id" value="<?php echo $value['equipment_id'];?>" >
		<div>
			<table border="0" cellpadding="1" cellspacing="1" style="width: 100%;">
				<tbody>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">設備名稱</th>
						<td><input name="equipment_name" id="equipment_name" type="text" value="<?php echo $value['equipment_name'];?>" ></td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">使用規約圖</th>
						<td>
							<div style="width: 100px">
								<img src="newpic/<?php echo $value['equipment_rule_picture'];?>" height="100" width="100" />
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">設備實體圖</th>
						<td>
							<div style="width: 110px">
								<div style="width: 100px;height: 100px;">
								<img src="newpic/<?php echo @$value['equipment_picture'];?>" height="100" width="100" />
								</div>
								<div>
									<div style="float:left">
            <?php 
              if(isset($value['equipment_picture'])){
								echo '<input type="button" value="刪除" class="btn btn-default" onclick="tfm_confirmLink'."('你確定要刪除???','backindex_equipment.php',{'action_mode':'delete_pic','equipment_id':'".$value['equipment_id']."','equipment_picture':'".$value['equipment_picture']."'});".'" />'."\n";
              }
            ?>
									</div>
									<div style="float:left">
										<input name="new_equipment_picture" id="new_equipment_picture" type="file" style="display:none"/>
										<input type="button" value="更新" class="btn btn-default" style="" onclick="chang_equipment_picture123()" style="bottom:2px" />
									</div>
								</div>
							</div>
            </td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">可預約時間</th>
						<td>
              <select name="advance_start">
                <option value="08:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='08:00:00'? 'selected="selected"':''):'';?> >08:00</option>
                <option value="09:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='09:00:00'? 'selected="selected"':''):'';?> >09:00</option>
                <option value="10:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='10:00:00'? 'selected="selected"':''):'';?> >10:00</option>
                <option value="11:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='11:00:00'? 'selected="selected"':''):'';?> >11:00</option>
                <option value="12:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='12:00:00'? 'selected="selected"':''):'';?> >12:00</option>
                <option value="13:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='13:00:00'? 'selected="selected"':''):'';?> >13:00</option>
                <option value="14:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='14:00:00'? 'selected="selected"':''):'';?> >14:00</option>
                <option value="15:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='15:00:00'? 'selected="selected"':''):'';?> >15:00</option>
                <option value="16:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='16:00:00'? 'selected="selected"':''):'';?> >16:00</option>
                <option value="17:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='17:00:00'? 'selected="selected"':''):'';?> >17:00</option>
                <option value="18:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='18:00:00'? 'selected="selected"':''):'';?> >18:00</option>
                <option value="19:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='19:00:00'? 'selected="selected"':''):'';?> >19:00</option>
                <option value="20:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='20:00:00'? 'selected="selected"':''):'';?> >20:00</option>
                <option value="21:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='21:00:00'? 'selected="selected"':''):'';?> >21:00</option>
                <option value="22:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='22:00:00'? 'selected="selected"':''):'';?> >22:00</option>
                <option value="23:00:00" <?php echo isset($value['advance_start'])? ($value['advance_start']=='23:00:00'? 'selected="selected"':''):'';?> >23:00</option>
              </select>
              &nbsp; ~ &nbsp;
              <select name="advance_end">
                <option value="09:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='09:00:00'? 'selected="selected"':''):'';?> >09:00</option>
                <option value="10:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='10:00:00'? 'selected="selected"':''):'';?> >10:00</option>
                <option value="11:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='11:00:00'? 'selected="selected"':''):'';?> >11:00</option>
                <option value="12:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='12:00:00'? 'selected="selected"':''):'';?> >12:00</option>
                <option value="13:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='13:00:00'? 'selected="selected"':''):'';?> >13:00</option>
                <option value="14:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='14:00:00'? 'selected="selected"':''):'';?> >14:00</option>
                <option value="15:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='15:00:00'? 'selected="selected"':''):'';?> >15:00</option>
                <option value="16:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='16:00:00'? 'selected="selected"':''):'';?> >16:00</option>
                <option value="17:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='17:00:00'? 'selected="selected"':''):'';?> >17:00</option>
                <option value="18:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='18:00:00'? 'selected="selected"':''):'';?> >18:00</option>
                <option value="19:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='19:00:00'? 'selected="selected"':''):'';?> >19:00</option>
                <option value="20:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='20:00:00'? 'selected="selected"':''):'';?> >20:00</option>
                <option value="21:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='21:00:00'? 'selected="selected"':''):'';?> >21:00</option>
                <option value="22:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='22:00:00'? 'selected="selected"':''):'';?> >22:00</option>
                <option value="23:00:00" <?php echo isset($value['advance_end'])? ($value['advance_end']=='23:00:00'? 'selected="selected"':''):'';?> >23:00</option>
              </select>
            </td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">是否提前預約</th>
						<td>
              <input name="equipment_advance" value="0" type="radio" <?php echo $value['equipment_advance']=='0'? 'checked="checked"':''; ?> />否 　　　
              <input name="equipment_advance" value="1" type="radio" <?php echo $value['equipment_advance']=='1'? 'checked="checked"':''; ?> />是
            </td>
					</tr>
						<th scope="row" style="width: 140px; text-align: left;">是否為專屬預約</th>
						<td>
              <input name="equipment_exclusive" value="0" onchange="selectShow();" type="radio" <?php echo $value['equipment_exclusive']=='0'? 'checked="checked"':''; ?> />否 　　　
              <input name="equipment_exclusive" value="1" onchange="selectShow();" type="radio" <?php echo $value['equipment_exclusive']=='1'? 'checked="checked"':''; ?> />是
            </td>
					</tr>
					
          
          <tr id="select_people" >
					<?php //if($value['equipment_name']=="沛活鬥牛場") {?>
					<?php if(true) {?>
					 <th scope="row" style="width: 140px; text-align: left;">使用人數上限</th>
          
          	<td>
							<select name="equipment_max_people" id="equipment_max_people" >
								<option value="1" <?php echo $value['equipment_max_people']=='1'? 'selected="selected"':''; ?> >1人</option>
								<option value="2" <?php echo $value['equipment_max_people']=='2'? 'selected="selected"':''; ?> >2人</option>
								<option value="3" <?php echo $value['equipment_max_people']=='3'? 'selected="selected"':''; ?> >3人</option>
								<option value="4" <?php echo $value['equipment_max_people']=='4'? 'selected="selected"':''; ?> >4人</option>
								<option value="5" <?php echo $value['equipment_max_people']=='5'? 'selected="selected"':''; ?> >5人</option>
								<option value="6" <?php echo $value['equipment_max_people']=='6'? 'selected="selected"':''; ?> >6人</option>
								<option value="7" <?php echo $value['equipment_max_people']=='7'? 'selected="selected"':''; ?> >7人</option>
								<option value="8" <?php echo $value['equipment_max_people']=='8'? 'selected="selected"':''; ?> >8人</option>
								<option value="9" <?php echo $value['equipment_max_people']=='9'? 'selected="selected"':''; ?> >9人</option>
								<option value="10" <?php echo $value['equipment_max_people']=='10'? 'selected="selected"':''; ?> >10人</option>
							</select>
						</td>
					
				 
					<?php }  else { ?>
         
            	<th scope="row" style="width: 140px; text-align: left;">使用戶數上限</th>
						<td>
							<select name="equipment_max_people" id="equipment_max_people" >
								<option value="1" <?php echo $value['equipment_max_people']=='1'? 'selected="selected"':''; ?> >1戶</option>
								<option value="2" <?php echo $value['equipment_max_people']=='2'? 'selected="selected"':''; ?> >2戶</option>
								<option value="3" <?php echo $value['equipment_max_people']=='3'? 'selected="selected"':''; ?> >3戶</option>
								<option value="4" <?php echo $value['equipment_max_people']=='4'? 'selected="selected"':''; ?> >4戶</option>
								<option value="5" <?php echo $value['equipment_max_people']=='5'? 'selected="selected"':''; ?> >5戶</option>
								<option value="6" <?php echo $value['equipment_max_people']=='6'? 'selected="selected"':''; ?> >6戶</option>
								<option value="7" <?php echo $value['equipment_max_people']=='7'? 'selected="selected"':''; ?> >7戶</option>
								<option value="8" <?php echo $value['equipment_max_people']=='8'? 'selected="selected"':''; ?> >8戶</option>
								<option value="9" <?php echo $value['equipment_max_people']=='9'? 'selected="selected"':''; ?> >9戶</option>
								<option value="10" <?php echo $value['equipment_max_people']=='10'? 'selected="selected"':''; ?> >10戶</option>
							</select>
						</td>
				
					<?php } ?>
          </tr>
          
          <tr>
						<th scope="row" style="width: 140px; text-align: left;">設備停用</th>
						<td>
              <input name="equipment_stop" type="radio" value="0" <?php echo $value['equipment_stop']=='0'? 'checked="checked"':''; ?> />否 　　　
              <input name="equipment_stop" type="radio" value="1" <?php echo $value['equipment_stop']=='1'? 'checked="checked"':''; ?> />是
            </td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">設備隱藏</th>
						<td>
              <input name="equipment_hidden" type="radio" value="0" <?php echo $value['equipment_hidden']=='0'? 'checked="checked"':''; ?> />否 　　　
              <input name="equipment_hidden" type="radio" value="1" <?php echo $value['equipment_hidden']=='1'? 'checked="checked"':''; ?> />是
            </td>
					</tr>
					<tr>
						<th align="right" colspan="2" scope="row">
							<input type="button" class="btn btn-success" value="確定" onclick="check()" />
							<input type="button" class="btn btn-danger" value="回設備列表" onclick="location.href='backindex_equipment.php';" />
						</th>
					</tr>
				</tbody>
			</table>
			<br />
			&nbsp;</div>
	</form>
</div>
<script type="text/javascript">
chang_pic_clock();
selectShow();
</script>
