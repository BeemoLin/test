<script type="text/javascript">
<!--
function myhome(){
  post("backindex_appointment.php", {action_mode:"order_show_view"}) ;
}
function post(URL, PARAMS) {
	var temp=document.createElement("form");
	temp.action=URL;
	temp.method="POST";
	temp.style.display="none";
	for(var x in PARAMS) {
		var opt=document.createElement("textarea");
		opt.name=x;
		opt.value=PARAMS[x];
		temp.appendChild(opt);
	}
	document.body.appendChild(temp);
	temp.submit();
	return temp;
}

//-->
</script>
<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;"><table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th class="555" scope="row"><span class="a1">公設預約</span></th>
      </tr>
    </table>
      <table width="629" height="196" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <th width="629" height="40" scope="row"><p>&nbsp;</p>
          <table width="420" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th align="left" scope="row"><?php echo $_GET['name']; ?></th>
              </tr>
          </table></th>
      </tr>
      <tr>
        <th height="156" scope="row"><table width="607" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th colspan="2" scope="row">日期</th>
            <td width="165" align="center">時間</td>
            <td width="174" align="center">住戶名稱</td>
            <td width="72">&nbsp;</td>
          </tr>
          <tr>
            <th width="20" scope="row">&nbsp;</th>
            <th width="134" scope="row"><?php echo $row_Recbody['1']['o_time']; ?></th>
            <td align="center"><?php echo $row_Recbody['1']['order_time']; ?></td>
            <td align="center"><?php echo $row_Recbody['1']['order_name']; ?></td>
            <td colspan="2" align="center">&nbsp;</td>
          </tr>
          <tr>
            <th colspan="6" scope="row">&nbsp;</th>
          </tr>
          <tr>
            <th colspan="6" scope="row">
            <form id="form1" name="form1" method="post" action="backindex_appointment.php">
            <input type="hidden" name="action_mode" value="edit_ps">
            <input type="hidden" name="order_id" value="<?php echo $order_id;?>">
            <input type="hidden" name="rulepic_id" value="<?php echo $rulepic_id;?>">
            <input name="disable" type="radio" value="0" <?php if($row_Recbody['1']['disable']==0){ echo 'checked="checked"'; }?>/>保持預約 
            <input name="disable" type="radio" value="1" <?php if($row_Recbody['1']['disable']==1){ echo 'checked="checked"'; }?>/>取消預約
            <br />
            備註欄位
              <br />
                <label>
                  <textarea name="o_ps" id="o_ps" cols="45" rows="5"><?php echo $row_Recbody['1']['o_ps']; ?></textarea>
                </label>
              <p>
                <?php 
$today = date('d');
$m = date('m');
$y = date('Y');
$all = $y.$m.$today;
if ($row_Recbody['o_time'] >= $all){			  
?>
                <label>
                  <input type="submit" name="send" id="send" value="送出" />
                </label>
                <?php }
else {} ?>
                <input type="submit" name="button2" id="button2" value="確定"/>
                <input type="button" name="gohome" id="gohome" onClick="myhome();" value="返回預約" />
                <input name="order_id" type="hidden" id="order_id" value="<?php echo $row_Recbody['1']['order_id']; ?>" />
              </p>
              <input type="hidden" name="MM_update" value="form1" />
            </form>
            </th>
          </tr>
        </table></th>
      </tr>
    </table></td>
  </tr>
</table>
