<script>
  function check(){
    document.form1.submit();
  }
</script>
<table border="0" align="center" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 665px; position: absolute; overflow: auto;">
    <form action="backindexhouseholder.php" method="post" name="form1" id="form1">
    
      <table width="583" border="0" cellspacing="0" cellpadding="4">
        <tr class="head1">
          <td width="94" align="left">帳號資料</td>
          <td colspan="3" align="left">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <th width="94" align="left">使用帳號</th>
          <td colspan="3" align="left"><?php echo $row_RecUser['1']['m_username']; ?>
            <input name="m_id" type="hidden" id="m_id" value="<?php echo $row_RecUser['1']['m_id']; ?>" />
            <input name="action_mode" type="hidden" id="action_mode" value="set_contact" /></td>
        </tr>
        <tr class="head1">
          <td width="94" align="left">個人資料</td>
          <td colspan="3" align="left"><?php echo $row_RecUser['1']['m_nick']." : ".$row_RecUser['1']['m_name'] ?></td>
        </tr>
        <tr valign="middle">
          <td width="94" align="left">聯絡人姓名</td>
          <td width="185" align="left"><input name="m_car1" type="text" class="normalinput" id="m_car1" value="<?php echo $row_RecUser['1']['m_car1']; ?>" /></td>
          <td width="79" align="left">行動電話</td>
          <td width="193" align="left"><input name="m_carmum1" type="text" class="normalinput" id="m_carmum1" value="<?php echo $row_RecUser['1']['m_carmum1']; ?>" /></td>
        </tr>
        <tr valign="middle">
          <td width="94" align="left">聯絡人姓名</td>
          <td align="left"><input name="m_car2" type="text" class="normalinput" id="m_car2" value="<?php echo $row_RecUser['1']['m_car2']; ?>" /></td>
          <td align="left">行動電話</td>
          <td align="left"><input name="m_carmum2" type="text" class="normalinput" id="m_carmum2" value="<?php echo $row_RecUser['1']['m_carmum2']; ?>" /></td>
        </tr>
        <tr valign="middle">
          <td width="94" align="left">聯絡人姓名</td>
          <td align="left"><input name="m_car3" type="text" class="normalinput" id="m_car3" value="<?php echo $row_RecUser['1']['m_car3']; ?>" /></td>
          <td align="left">行動電話</td>
          <td align="left"><input name="m_carmum3" type="text" class="normalinput" id="m_carmum3" value="<?php echo $row_RecUser['1']['m_carmum3']; ?>" /></td>
        </tr>
        <tr valign="middle">
          <td width="94" align="left">聯絡人姓名</td>
          <td align="left"><input name="m_car4" type="text" class="normalinput" id="m_car4" value="<?php echo $row_RecUser['1']['m_car4']; ?>" /></td>
          <td align="left">行動電話</td>
          <td align="left"><input name="m_carmum4" type="text" class="normalinput" id="m_carmum4" value="<?php echo $row_RecUser['1']['m_carmum4']; ?>" /></td>
        </tr>
        <tr valign="middle">
          <td width="94" align="left">聯絡人姓名</td>
          <td align="left"><input name="m_car5" type="text" class="normalinput" id="m_car5" value="<?php echo $row_RecUser['1']['m_car5']; ?>" /></td>
          <td align="left">行動電話</td>
          <td align="left"><input name="m_carmum5" type="text" class="normalinput" id="m_carmum5" value="<?php echo $row_RecUser['1']['m_carmum5']; ?>" /></td>
        </tr>
        <tr align="left" valign="baseline">
          <td colspan="4"><hr size="1" noshade="noshade" />
            <input type="button" class="btn btn-success" name="Submit2" value="更新資料" onClick="check();" />
            <input type="reset" class="btn btn-warning" name="Submit3" value="重設資料" />
            <input type="button" class="btn btn-danger" name="Submit" value="回上一頁" onclick="window.history.back();" /></td>
        </tr>
        <tr align="left" valign="baseline">
          <td colspan="4">&nbsp;</td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1" />
    </form>
    </td>
  </tr>
</table>
