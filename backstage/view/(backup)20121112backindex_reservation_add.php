<script type="text/javascript" src="equipmentCheck.js"></script>
<script type="text/javascript">
var advance_start;
var advance_end;
var equipment_max_people;

  function check(){
		var v1 = document.getElementById("m_id").value;
		var v2 = document.getElementById("set_equipment_id").value;
		var v3 = document.getElementById("set_list_date").value;
		var v4 = document.getElementById("set_list_time").value;
		var v5 = document.getElementById("max_people_hidden").value;
    
    if(v1=="" || v1 == "0"){
      alert('請選擇住戶');
    }
    else if(v2 == "" || v2 == "0"){
      alert('請選擇設備');
    }
    else if(v3 == ""){
      alert('請選擇日期');
    }
    else if(v4 == ""){
      alert('請選擇時間');
    }
    else if(document.getElementById("equipment_exclusive").value == "0" && v5 == ""){
      alert('請選擇人數');
    }
    else{
      document.form1.submit();
    }
    return false;
  }

	
	function show_time(){
		var list_time = document.getElementById('list_time'); 
		list_time.setAttribute("style","visibility: visible");
		var list_date_value = document.getElementById('list_date').value;
		now = new Date();
		year = now.getYear()+1900;
		
		if((now.getMonth()+1)<10){
			month = now.getMonth()+1;
			month = '0'+month;
		}
		else{
			month = now.getMonth()+1;
		}
		
		if(now.getDate()<10){
			date = now.getDate();
			date = '0'+date;
		}
		else{
			date = now.getDate();
		}
		
		if(list_date_value==year+"-"+month+"-"+date){
			list_time.setAttribute("onfocus","WdatePicker({minDate:'{%H+3}:00:00 ',maxDate:'" + advance_end + "',dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..']})");
		}
		else{
			list_time.setAttribute("onfocus","WdatePicker({minDate:'" + advance_start +"',maxDate:'" + advance_end + "',dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..']})");
		}
		
	}

	function del_list_time_options(){
		var list_time_length = document.getElementById('equipment_max_people').length;
		for (i=0;i<list_time_length;i++){
			document.getElementById('equipment_max_people').options.remove(0)
		}
	}
	//.options[i].selected = true;
	function mid_yes(){
		if(document.getElementById("m_id").value != "0"){
			document.getElementById("set_m_id").value = document.getElementById("m_id").value;
			document.getElementById("m_id_yes").disabled=true;
			document.getElementById("m_id").disabled=true;
			document.getElementById("equipment_id").disabled=false;
			document.getElementById("list_date").disabled=false;
			document.getElementById("list_time").disabled=false;
			document.getElementById("equipment_max_people").disabled=true;
			
			document.getElementById("e_id_hidden").style.display="";
		}
	}	
	function mid_no(){
  //e_id_hidden
  //mid_yes 以及 mid_no 撰寫尚未完畢
		document.getElementById("set_m_id").value = "";
		document.getElementById("m_id_yes").disabled=false;
		document.getElementById("m_id").disabled=false;
		document.getElementById("equipment_id_yes").disabled=false;
    document.getElementById("list_date_yes").disabled=false;
    document.getElementById("list_time_yes").disabled=false;
		document.getElementById("set_equipment_id").value = "";
		document.getElementById("set_list_date").value = "";
		document.getElementById("set_list_time").value = "";
		document.getElementById("list_date").value = "";
		document.getElementById("list_time").value = "";
		document.getElementById("equipment_id").disabled=false;
		document.getElementById("list_date").disabled=true;
		document.getElementById("list_time").disabled=true;
		document.getElementById("equipment_max_people").disabled=true;
    document.getElementById("accumulative").innerHTML = "";
		
		document.getElementById("e_id_hidden").style.display="none";
		document.getElementById("list_date_hidden").style.display="none";
		document.getElementById("list_time_hidden").style.display="none";
		document.getElementById("max_people_hidden").style.display="none";
	}
  
  
	function eid_yes(){
		if(document.getElementById("equipment_id").value != ""){
			document.getElementById("equipment_id_yes").disabled=true;
			document.getElementById("set_equipment_id").value = document.getElementById("equipment_id").value;
			document.getElementById("equipment_id").disabled=true;
			document.getElementById("list_date").disabled=false;
			document.getElementById("list_time").disabled=true;
			document.getElementById("equipment_max_people").disabled=true;
			
			document.getElementById("list_date_hidden").style.display="";
		}
	}	
	function eid_no(){
		document.getElementById("equipment_id_yes").disabled=false;
    document.getElementById("list_date_yes").disabled=false;
    document.getElementById("list_time_yes").disabled=false;
		document.getElementById("set_equipment_id").value = "";
		document.getElementById("set_list_date").value = "";
		document.getElementById("set_list_time").value = "";
		document.getElementById("list_date").value = "";
		document.getElementById("list_time").value = "";
		document.getElementById("equipment_id").disabled=false;
		document.getElementById("list_date").disabled=true;
		document.getElementById("list_time").disabled=true;
		document.getElementById("equipment_max_people").disabled=true;
    document.getElementById("accumulative").innerHTML = "";
		
		document.getElementById("list_date_hidden").style.display="none";
		document.getElementById("list_time_hidden").style.display="none";
		document.getElementById("max_people_hidden").style.display="none";
	}
	
	
	function edate_yes(){
		if(document.getElementById("list_date").value != ""){
			document.getElementById("list_date_yes").disabled=true;
			document.getElementById("set_list_date").value = document.getElementById("list_date").value;
			document.getElementById("list_date").disabled=true;
			document.getElementById("list_time").disabled=false;
			document.getElementById("equipment_max_people").disabled=true;
			
			document.getElementById("list_time_hidden").style.display="";
		}
	}	
	function edate_no(){
		document.getElementById("list_date_yes").disabled=false;
    document.getElementById("list_time_yes").disabled=false;
		document.getElementById("set_list_date").value = "";
		document.getElementById("set_list_time").value = "";
		document.getElementById("list_time").value = "";
		document.getElementById("list_date").disabled=false;
		document.getElementById("list_time").disabled=true;
		document.getElementById("equipment_max_people").disabled=true;
    document.getElementById("accumulative").innerHTML = "";
		
		document.getElementById("list_time_hidden").style.display="none";
		document.getElementById("max_people_hidden").style.display="none";
	}
	
  
	function etime_yes(){
		if(document.getElementById("list_time").value != ""){
      if(document.getElementById("equipment_exclusive").value == "1"){
        document.getElementById("list_time_yes").disabled=true;
        document.getElementById("set_list_time").value = document.getElementById("list_time").value;
        document.getElementById("list_time").disabled=true;
        document.getElementById("submit01").style.display="";
      }
      else if(document.getElementById("equipment_exclusive").value == "0"){
        document.getElementById("list_time_yes").disabled=true;
        document.getElementById("set_list_time").value = document.getElementById("list_time").value;
        document.getElementById("list_time").disabled=true;
        document.getElementById("equipment_max_people").disabled=false;
        
        document.getElementById("max_people_hidden").style.display="";
        document.getElementById("submit01").style.display="";
      }
		}
	}
	function etime_no(){
      document.getElementById("list_time_yes").disabled=false;
      document.getElementById("list_date").disabled=true;
      document.getElementById("set_list_time").value = "";
      document.getElementById("list_time").disabled=false;
      document.getElementById("equipment_max_people").disabled=true;
      document.getElementById("accumulative").innerHTML = "";
      
      document.getElementById("max_people_hidden").style.display="none";
      document.getElementById("submit01").style.display="none";
	}
  
</script>
<div>
	<form action="backindex_equipment.php" method="POST" name="form1">
    <input type="hidden" name="action_mode" value="add_reservation_check" >
    <input type="hidden" name="check_key" value="<?php echo $code;?>" >
    <input type="hidden" name="equipment_id" value="<?php echo $equipment_id;?>" >
    <input type="hidden" id="equipment_exclusive" name="equipment_exclusive" value="<?php echo $equipment_exclusive;?>" >
    <!-- <input type="hidden" name="equipment_max_people" value="<?php echo $equipment_max_people;?>" > -->
		<div>
			<table border="0" cellpadding="1" cellspacing="1" style="width: 100%;">
				<tbody>
					<tr>
						<th scope="row" style="width: 140px; text-align: left;">選擇住戶</th>
						<td style="width: 360px;">
              <input type="hidden" name="set_m_id" id="set_m_id" value="">
              <select name="m_id" id="m_id" onchange="">
								<option value="0">請選擇</option>
								<?php 
									foreach($memberData as $key => $value){
										echo '<option value="'.$value['m_id'].'">'.$value['m_username'].'</option>'."\n";
									}
								?>
              </select>
						</td>
            <td style="width: 110px;">
							<input id="m_id_yes" type="button" onclick="mid_yes();" value="確定">
							<input id="m_id_no" type="button"  onclick="mid_no();"  value="取消">
            </td>
            <td></td>
					</tr>
					<tr id="e_id_hidden" style="display:none;">
						<th scope="row" style="text-align: left;">設備名稱</th>
						<td>
              <input type="hidden" name="set_equipment_id" id="set_equipment_id" value="">
              <select id="equipment_id" onchange="selectEquipment();">
                <option value="0">請選擇</option>
                <?php 
                  foreach($equipmentData as $key => $value){
                    echo '<option value="'.$value['equipment_id'].'">'.$value['equipment_name'].'</option>'."\n";
                  }
                ?>
              </select>
						</td>
            <td>
              <input id="equipment_id_yes" type="button" onclick="eid_yes();" value="確定">
              <input id="equipment_id_no" type="button"  onclick="eid_no();"  value="取消">
            </td>
            <td></td>
					</tr>
					<tr id="list_date_hidden" style="display:none;">
            <th scope="row" style="text-align: left;"> 預約日期：</th>
            <td>
              <input type="hidden" name="set_list_date" id="set_list_date" value="">
              <input name="list_date" id="list_date" type="text" class="Wdate" onFocus="var list_time=$dp.$('list_time');WdatePicker({onpicked:function(){show_time();  },minDate:'%y-%M-%d',dateFmt:'yyyy-MM-dd'})">
            </td>
            <td>
              <input id="list_date_yes" type="button" onclick="edate_yes();" value="確定">
              <input id="list_date_no" type="button"  onclick="edate_no();"  value="取消">
            </td>
            <td></td>
          </tr>
					<tr id="list_time_hidden" style="display:none;">
            <th scope="row" style="text-align: left;"> 預約時間：</th>
            <td>
              <div style="float:left;">
                <input type="hidden" name="set_list_time" id="set_list_time" value="">
                <input name="list_time" id="list_time" type="text" class="Wdate" >
              </div>
            </td>
            <td>
              <!-- <input id="list_time_yes" type="button" onclick="etime_yes();" value="確定"> -->
              <input id="list_time_yes" type="button" onclick="checkNumber();" value="確定">
              <input id="list_time_no" type="button"  onclick="etime_no();"  value="取消">
            </td><td>
              <div style="float:left;" id="accumulative"></div>
            </td>
          </tr>
					<tr id="max_people_hidden" style="display:none;">
						<th scope="row" style="text-align: left;">使用人數</th>
						<td>
							<div>
								<select id="equipment_max_people" name="equipment_max_people" ></select>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row" style="text-align: left;">備註</th>
						<td>
							<textarea name="list_remarks" id="list_remarks" onkeyup="this.value = this.value.substring(0, 100)" style="width: 327px; height: 108px;"><?php echo $value['list_remarks'];?></textarea>
						</td>
            <td></td>
            <td></td>
					</tr>

					<tr>
            <td></td>
            <td></td>
            <td></td>
						<td align="right" colspan="2" scope="row">
							<input type="button" value="確定" onclick="check()" id="submit01" style="display:none;" />
							<input type="button" value="回預約列表" onclick="post_to_url('backindex_equipment.php', {'action_mode':'view_reservation_data','equipment_id':'<?php echo $equipment_id;?>'})" />
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
</div>

