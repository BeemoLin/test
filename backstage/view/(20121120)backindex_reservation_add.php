<?php
/*20121119
使用Control(include View) + View 架構
if(isset($_POST["check"]))
{
//header("Location: http://plog.longwin.com.tw/");
//----新增資料庫--------
//header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
require_once(BCLASS.'/equipment_class.inc.php');

$data_function->setDb($photo_name);
 
      
          $expression = "`$input_id`='".$$input_id."', `$pic_url` = '".$new_filename."', `$pic_subject` = '".$$pic_subject."'";
          $data_function->insert($expression);




header("Location: http://www.google.com.tw/");
}
else
{
*/
?>



<script type="text/javascript" src="equipmentCheck.js"></script>
<script type="text/javascript">


//----20121107 修改日曆的時間顯示
//------引入AJAX做CHECK--------
//post_to_url函數包在class資料夾裡面的head.php
//var advance_start = '<?php echo $equipmentData['advance_start'];?>';
//var advance_end = '<?php echo $equipmentData['advance_end'];?>';

//alert(advance_start);
//alert(advance_start);

var advance_start; //宣告全域變數
var advance_end;

var advance_start_hour;
var advance_end_hour;

var equipment_max_people;

  function check()
  {
     
    //----------使用input type=hidden 隱藏元件記憶,回傳給Server做新增資料庫使用-----------
		var v1 = document.getElementById("m_id").value;
	//	alert(v1);
		var v2 = document.getElementById("set_equipment_id").value;
		var strList= v2.split(",");
		document.getElementById("set_equipment_id").value=strList[0];
	//	alert(v2);
		
		var v3 = document.getElementById("set_list_date").value;
//		alert(v3);
		var v4 = document.getElementById("set_list_time").value;
//		alert(v4);
	//	var v5 = document.getElementById("max_people_hidden").value;
    
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
    /*else if(document.getElementById("equipment_exclusive").value == "0" && v5 == ""){
      alert('請選擇人數');
    }*/
    else
    {
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
		
  
		if(list_date_value==year+"-"+month+"-"+date)
    {
    
     //20121109----前台要加這一段
  	 //{此段應該加在 if 裡面 }
  		nowhour=now.getHours();
  		nowhour=nowhour+1;
  		//alert(nowhour);
  		//alert(advance_start_hour);
  		//22 21;
  		//預約要在前一個小時 如8點則要再7點多預約
  		nowhour=(nowhour>advance_end_hour|nowhour<advance_start_hour)?24:nowhour;
  		nowhour =(nowhour<10)?'0'+nowhour+':00:00':nowhour+':00:00';
		  //----前台要加這一段
		  //alert(nowhour);
      
      
			//list_time.setAttribute("onfocus","WdatePicker({minDate:'{%H+3}:00:00 ',maxDate:'" + advance_end + "',dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..']})");
			//20121108
			
			//增加javascript now
      list_time.setAttribute("onfocus","WdatePicker({minDate:'"+nowhour+" ',maxDate:'" + advance_end + "',dateFmt:'HH:mm:00',disabledDates:['\:05\:','\:10\:','\:15\:','\:20\:','\:25\:','\:35\:','\:40\:','\:45\:','\:50\:','\:55\:']})");//,disabledDates:['"+advance_end+"\:..:\..','"+advance_end+"\:..:\..']
    }
		else
    {
		//	list_time.setAttribute("onfocus","WdatePicker({minDate:'" + advance_start +"',maxDate:'" + advance_end + "',dateFmt:'HH:00:00',disabledDates:['09\:..:\..','11\:..:\..','13\:..:\..','15\:..:\..','17\:..:\..','19\:..:\..','21\:..:\..']})");
			//20121108
			alert(advance_start);
      list_time.setAttribute("onfocus","WdatePicker({minDate:'" + advance_start +"',maxDate:'" + advance_end + "',dateFmt:'HH:mm:00',disabledDates:['\:05\:','\:10\:','\:15\:','\:20\:','\:25\:','\:35\:','\:40\:','\:45\:','\:50\:','\:55\:']})");
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
	
  
	function etime_yes()
  {
	//alert("TEST");
	  
		if(document.getElementById("list_time").value != "")
    {
      //alert("進入");
      document.getElementById("set_list_time").value = document.getElementById("list_time").value;
      document.getElementById("list_time_yes").disabled=true;
      //alert("進入");
      /*
      if(document.getElementById("equipment_exclusive").value == "1")
      {
        document.getElementById("list_time_yes").disabled=true;
        document.getElementById("set_list_time").value = document.getElementById("list_time").value;
        document.getElementById("list_time").disabled=true;
        document.getElementById("submit01").style.display="";
      }
      else if(document.getElementById("equipment_exclusive").value == "0")
      {
        document.getElementById("list_time_yes").disabled=true;
        document.getElementById("set_list_time").value = document.getElementById("list_time").value;
        document.getElementById("list_time").disabled=true;
        document.getElementById("equipment_max_people").disabled=false;
        
        document.getElementById("max_people_hidden").style.display="";
        document.getElementById("submit01").style.display="";
      }
		  return;
		   */
		  }
      //document.form1.summit();
      // alert("新增資料庫,並轉頁");
   }
		
 
	function etime_no()
  {
	   /*
      document.getElementById("list_time_yes").disabled=false;
      document.getElementById("list_date").disabled=true;
      document.getElementById("set_list_time").value = "";
      document.getElementById("list_time").disabled=false;
      document.getElementById("equipment_max_people").disabled=true;
      document.getElementById("accumulative").innerHTML = "";
      
      document.getElementById("max_people_hidden").style.display="none";
      document.getElementById("submit01").style.display="none";
      */
	}
	
	//-----當新增的時候是否會有問題 Option的ID--------
	function selectEquipment()
	{
    str= document.getElementById("equipment_id").value;
    // alert(str);
    var strList= str.split(",");
     //alert(strList[0]);
      //alert(strList[1]);
      //alert(strList[2]);../backstage/view/backindex_reservation_add.php
    advance_start=strList[1];  
    
    advance_start_hour= advance_start.split(":")[0];
  
    time= strList[2].split(":");
    time[0]=time[0]-1;
    advance_end_hour=time[0];
    
    advance_end =(time[0]<10)?'0'+time[0]+':00:00':time[0]+':00:00';
    //alert(advance_end);
    //advance_end=strList[2];
  }
</script>
<div>
	<form action="backindex_equipment.php" method="POST" name="form1"><!------轉到backindex_equipment.php-------->
	  <input type="hidden" name="action_mode" value="<?php echo $action_mode;?>"><!------重要;因為Submit出去會轉址並判別$_Post[action_mode]的值所以每個VIEW到要加這一行-------->
    <!--input type="hidden" name="action_mode" value="add_reservation_check"-->
    <input type="hidden" name="check_key" value="<?php echo $code;?>" >
    <input type="hidden" name="insertmode" value="1" >
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
            <td style="width: 120px;">
							<input id="m_id_yes" type="button" onclick="mid_yes();" value="確定">
							<input id="m_id_no" type="button"  onclick="mid_no();"  value="取消">
            </td>
            <td></td>
					</tr>
					<tr id="e_id_hidden" style="display:none;">
						<th scope="row" style="text-align: left;">設備名稱</th>
						<td>
              <input type="hidden" name="set_equipment_id" id="set_equipment_id" value="">
              <select id="equipment_id" onclick="selectEquipment();">
                <option value="0">請選擇</option>
                <?php 
                  foreach($equipmentData as $key => $value){
                    //輸出設備ID與設備名稱
                    echo '<option value="'.$value['equipment_id'].','.$value['advance_start'].','.$value['advance_end'].'">'.$value['equipment_name'].'</option>'."\n";
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
              <!-- <input id="list_time_yes" type="button" onclick="etime_yes();" name="check" value="確定"> -->
              <input id="list_time_yes" type="button" onclick="etime_yes();" value="確定">
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
							<textarea name="list_remarks" id="list_remarks" onkeyup="this.value = this.value.substring(0, 100)" style="width: 327px; height: 108px;"><?php// echo $value['list_remarks'];?></textarea>
						</td>
            <td></td>
            <td></td>
					</tr>

					<tr>
            <td></td>
            <td></td>
            <td></td>
						<td align="right" colspan="2" scope="row">
							<!--input type="button" value="確定" onclick="check()" id="submit01" style="display:none;" /-->
							<input type="button" id="submit01" name="submitAddBackindexReservation" value="確定" onclick="check()">
							<!---重要的action_mode--->
							<input type="button" value="回預約列表" onclick="post_to_url('backindex_equipment.php', {'action_mode':'view_reservation_data','equipment_id':'<?php echo $equipment_id;?>'})" />
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
</div>


