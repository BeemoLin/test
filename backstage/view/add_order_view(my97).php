<!--
<link type="text/css" href="../system/jQuery/css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="../system/jQuery/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../system/jQuery/js/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="../system/jQuery/js/jquery.ui.datepicker-zh-TW.js"></script>
-->
<script>
	//$(function() {
		//$( "#Adate" ).datepicker({ dateFormat: 'yy-mm-dd' });
	//});
  
  function checkFill(){
    if(document.form1.rulepic_id.value==""){
      alert("請選擇設備");
      return false;
    }
    else if(document.form1.order_name.value==""){
      alert("請輸入用戶");
      return false;
    }
    else if(document.form1.Adate.value==""){
      alert("請選擇日期");
      return false;
    }
    else if(document.form1.order_time.value==""){
      alert("請選擇時間");
      return false;
    }
    document.form1.submit();
    return ture;
  }
  
  function AutoCheckTime(){
    var strDate1 = "2000-10-25";
    var now, s = "";
    now = new Date();
    var NowHour = now.getHour();
    if(NowHour>8)
    now.getMinute()
    now.setDate(now.getDate());
    s += now.getYear()+"-";
    s += (now.getMonth() + 101).toString().substring(1,3)+"-" ;
    s += (now.getDate()+ 100).toString().substring(1,3) ;
    strDate2 = s;
    strDate1=strDate1.replace(/-/g,"/");
    strDate2=strDate2.replace(/-/g,"/");
    var date1 = Date.parse(strDate1);
    var date2 = Date.parse(strDate2);
    if (Math.ceil((date2-date1)/(24*60*60*1000))<=6573) { //未滿18
    //alert('你未满18岁');
    }
  }
  
</script>
<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tbody>
    <tr>
      <td width="484" height="24">　　　<?php //equipment 設備?>
      <a href="#" onclick="post_to_url('backindex_appointment.php', {'action_mode':'add_equipment'})">新增設備</a>　　
      <a href="#" onclick="post_to_url('backindex_appointment.php', {'action_mode':'add_order_view'})">新增預約用戶</a> 　　
      <a href="#" onclick="post_to_url('backindex_appointment.php', {'action_mode':'order_show_view'})">設備清單列表</a></td>
    </tr>
    <tr>
      <td align="center" style="width: 844px; height: 600px; position: absolute; overflow: auto;" valign="top">
      <form action="backindex_appointment.php" method="POST" name="form1" id="form1">
        <input type="hidden" name="action_mode" value="add_order">
        <table border="0" cellpadding="0" cellspacing="0" width="660">
          <tbody>
            <tr>
              <th>
                <p>
                  <div style="float:left;">
                  預約設備  
                  <select id="rulepic_id" name="rulepic_id">
                    <option value="" selected="selected">請選擇</option>
                  <?php
                  foreach ($appointment_name as $k1 => $v1){
                    echo '<option value="'.$v1['rulepic_id'].'">'.$v1['name'].'</option>';
                  }
                  ?>
                  </select>
                  </div>
                </p>
              </th>
            </tr>
            <tr>
              <th>
                <p>
                  <div style="float:left;">
                  預約用戶 
                    <select id="order_name" name="order_name">
                      <option value="" selected="selected">請選擇</option>
                    <?php
                    foreach ($user_name as $k1 => $v1){
                      echo '<option value="'.$v1['m_username'].'">'.$v1['m_username'].'</option>';
                    }
                    ?>
                    </select>
                  </div>
                </p>
              </th>
            </tr>
            <tr>
              <th>
              <p>
                <div style="float:left;">
                預約日期
                <input name="Adate" type="text" id="Adate" size="15" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
                </div>
              </p>
              </th>
            </tr>
            <tr>
              <th>
              <p>
                <div id="apDiv2" style="float:left;">
                <?php
                /*
$now = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y")), "<br />\n"; 
$now0810 = mktime(8, 0, 0, date("m"), date("d"), date("Y")), "<br />\n"; 
$now1012 = mktime(10, 0, 0, date("m"), date("d"), date("Y")), "<br />\n"; 
$now1214 = mktime(12, 0, 0, date("m"), date("d"), date("Y")), "<br />\n"; 
$now1416 = mktime(14, 0, 0, date("m"), date("d"), date("Y")), "<br />\n"; 
$now1618 = mktime(16, 0, 0, date("m"), date("d"), date("Y")), "<br />\n"; 
$now1820 = mktime(18, 0, 0, date("m"), date("d"), date("Y")), "<br />\n"; 
$now2022 = mktime(20, 0, 0, date("m"), date("d"), date("Y")), "<br />\n"; 
*/
                ?>
                
                
                預約時間
                  <select id="order_time" name="order_time">
                    <option value="" selected="selected">請選擇</option>
                    <option value="08:00~10:00">08:00~10:00</option>
                    <option value="10:00~12:00">10:00~12:00</option>
                    <option value="12:00~14:00">12:00~14:00</option>
                    <option value="14:00~16:00">14:00~16:00</option>
                    <option value="16:00~18:00">16:00~18:00</option>
                    <option value="18:00~20:00">18:00~20:00</option>
                    <option value="20:00~22:00">20:00~22:00</option>
                  </select>
                </div>
              </p>
              </th>
            </tr>
          </tbody>
        </table> 
        <br /> 
        <input id="button2" name="button2" type="button" value="確定" onClick="checkFill()" /> 
        <input name="MM_insert" type="hidden" value="form1" />
      </form>
      </td>
    </tr>
  </tbody>
</table>

                  