<script type="text/javascript">
  function check(){
    var equipment_name = document.getElementById("equipment_name");
    var equipment_rule_picture = document.getElementById("equipment_rule_picture");
    var equipment_max_people = document.getElementById("equipment_max_people");
    
    if(equipment_name.value.length < 3){
      alert('請輸入設備名稱，最少3個字~!!');
    }
    else if(equipment_rule_picture.value == ""){
      alert('請上傳規約圖');
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
    <input type="hidden" name="action_mode" value="add_equipment_check" >
		<input type="hidden" name="check_key" value="<?php echo $code;?>">
		<div>
			<table border="0" cellpadding="1" cellspacing="1" style="width: 100%;">
				<tbody>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">設備名稱</th>
						<td><input name="equipment_name" id="equipment_name" type="text"></td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">使用規約圖</th>
						<td><input name="equipment_rule_picture" id="equipment_rule_picture" type="file" /></td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">設備實體圖</th>
						<td><input name="equipment_picture" id="equipment_picture" type="file" /></td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">可預約時間</th>
						<td>
              <select name="advance_start">
                <option value="08:00:00" selected="selected" >08:00</option>
                <option value="10:00:00">10:00</option>
                <option value="12:00:00">12:00</option>
                <option value="14:00:00">14:00</option>
                <option value="16:00:00">16:00</option>
                <option value="18:00:00">18:00</option>
                <option value="20:00:00">20:00</option>
              </select>
              &nbsp; ~ &nbsp;
              <select name="advance_end">
                <option value="10:00:00">10:00</option>
                <option value="12:00:00">12:00</option>
                <option value="14:00:00">14:00</option>
                <option value="16:00:00">16:00</option>
                <option value="18:00:00">18:00</option>
                <option value="20:00:00">20:00</option>
                <option value="22:00:00" selected="selected" >22:00</option>
              </select>
            </td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">是否提前預約</th>
						<td>
							<input name="equipment_advance" type="radio" checked="checked" value="0" />否 　　　
							<input name="equipment_advance" value="1" type="radio">是
						</td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">是否為專屬預約</th>
						<td>
							<input name="equipment_exclusive" type="radio" onchange="selectShow();" value="0" />否 　　　
							<input name="equipment_exclusive" value="1" checked="checked" onchange="selectShow();" type="radio">是
						</td>
					</tr>
					<tr id="select_people">
						<th scope="row" style="width: 140px; text-align: left;"><nobr>使用人數上限</nobr></th>
						<td>
							<select name="equipment_max_people" id="equipment_max_people" >
								<option value="1" selected="selected">1人</option>
								<option value="2">2人</option>
								<option value="3">3人</option>
								<option value="4">4人</option>
								<option value="5">5人</option>
								<option value="6">6人</option>
								<option value="7">7人</option>
								<option value="8">8人</option>
								<option value="9">9人</option>
								<option value="10">10人</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">設備停用</th>
						<td>
							<input name="equipment_stop" type="radio" checked="checked" value="0" />否 　　　
							<input name="equipment_stop" value="1" type="radio">是
						</td>
					</tr>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">設備隱藏</th>
						<td>
							<input name="equipment_hidden" type="radio" checked="checked" value="0" />否 　　　
							<input name="equipment_hidden" value="1" type="radio">是
						</td>
					</tr>
					<tr>
						<th align="right" colspan="2" scope="row">
							<input type="button" class="btn btn-success" value="確定" onclick="check()" />
							<input type="button" class="btn btn-danger" value="回設備列表"  onclick="post_to_url('backindex_equipment.php', {'action_mode':'view_equipment_data'})" />
						</th>
					</tr>
				</tbody>
			</table>
			<br />
			&nbsp;</div>
	</form>
</div>
<script type="text/javascript">
  selectShow();
</script>
