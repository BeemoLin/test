<script>
  function check(){
    n2 = document.form1.m_passwd.value.length;
    n2_1 = document.form1.m_passwd.value;
    n4 = document.form1.m_name.value.length;
    n5 = document.form1.m_nick.value.length;
    n6 = document.form1.m_email.value;
    n7 = n6.match(/^\S+@\S+\.+\S+$/);
    //n8 = document.form1.m_phone.value;
    //n9 = n8.match(/^\(\d{2}\)\d{6,9}$/);
    //n10 = document.form1.m_cellphone.value;
    //n11 = n10.match(/^09\d{2}-\d{6}$/);
    //n12 = document.form1.m_joinDate.value.length;
    n13 = document.form1.p_ip.value.length;

    
    if( !n4 || n4 <= 2 ){
      alert('真實姓名 需要有一個值。(最少三個字)');
    }
    else if( !n5 || n5 <= 2 ){
      alert('暱稱 需要有一個值。(最少三個字)');
    }
    else if( !n6 || !n7 ){
      alert('請確定此 電子郵件 為可使用狀態。');
    }
    //else if( !n8 || !n9 ){
      //alert('電話 格式無效。');
    //}
    //else if( !n10 || !n11 ){
      //alert('行動電話 格式無效。');
    //}
    //else if( !n12 || n12 < 2 ){
      //alert('住址 需要有一個值。');
    //}
    else if( !n13 || n13 < 2 ){
      alert('網路卡 需要有一個值。(最少三個字)');
    }
    else{
      if(document.form1.m_passwd.value.length != 0){
        if( !n2 || n2 < 2 ){
          alert('密碼 需要有一個值。未達到字元數目的最小值。');
          return false;
        }
        else if ( !n2 || n2 > 10 ){
          alert('密碼 已超出字元數目的最大值。');
          return false;
        }
      }
      document.form1.submit();
    }
    return false;
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
            <input name="action_mode" type="hidden" id="action_mode" value="edit_user" /></td>
        </tr>
        <tr valign="baseline">
          <th width="94" align="left">密碼</th>
          <td colspan="3" align="left"><p>
            <input name="m_passwd" type="password" class="normalinput" id="m_passwd" />
            <br />
            需要修改密碼才填寫此欄。</p>
            <p>填入4~10個字元的英文字母、數字及符號。 </p>
            <p>用英文開頭並與數字並用。</p></td>
        </tr>
        <tr class="head1">
          <td width="94" align="left">個人資料</td>
          <td colspan="3" align="left">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <th width="94" align="left">真實姓名</th>
          <td colspan="3" align="left"><span id="sprytextfield1">
            <input name="m_name" type="text" class="normalinput" id="m_name" value="<?php echo $row_RecUser['1']['m_name']; ?>" />
            </span><font color="#FF0000">*</font></td>
        </tr>
        <tr valign="baseline">
          <th width="94" align="left">暱稱</th>
          <td colspan="3" align="left"><span id="sprytextfield2">
            <input name="m_nick" type="text" class="normalinput" id="m_nick" value="<?php echo $row_RecUser['1']['m_nick']; ?>" />
            </span><font color="#FF0000">*</font></td>
        </tr>
        <tr valign="baseline">
          <th align="left">網路卡</th>
          <td colspan="3" align="left">
          <input name="p_ip" type="text" class="normalinput" id="p_ip" value="<?php echo $row_RecUser['1']['p_ip']; ?>"/>
          <font color="#FF0000">*</font></td>
        </tr>
        <tr valign="baseline">
          <th width="94" align="left">電子郵件</th>
          <td colspan="3" align="left"><span id="sprytextfield4">
            <input name="m_email" type="text" class="normalinput" id="m_email" value="<?php echo $row_RecUser['1']['m_email']; ?>" />
            </span><font color="#FF0000">*</font> <br />
            請確定此電子郵件為可使用狀態，以方便未來系統使用，如補寄會員密碼信。</td>
        </tr>
        <tr valign="baseline">
          <th width="94" align="left">電話</th>
          <td colspan="3" align="left"><span id="sprytextfield6">
            <input name="m_phone" type="text" class="normalinput" id="m_phone" value="<?php echo $row_RecUser['1']['m_phone']; ?>" />
            </span>如 (00)0000000</td>
        </tr>
        <tr valign="baseline">
          <th width="94" align="left">行動電話</th>
          <td colspan="3" align="left"><span id="sprytextfield7">
            <input name="m_cellphone" type="text" class="normalinput" id="m_cellphone" value="<?php echo $row_RecUser['1']['m_cellphone']; ?>" />
            </span>如 0911-111111</td>
        </tr>
        <tr valign="baseline">
          <th width="94" align="left">住址</th>
          <td colspan="3" align="left"><input name="m_address" type="text" class="normalinput" id="m_address" value="<?php echo $row_RecUser['1']['m_address']; ?>" size="40" />
            <input name="m_joinDate" type="hidden" id="m_joinDate" value="<?php echo date("Y-m-d H:i:s");?>" /></td>
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
        <tr valign="middle">
          <td width="94" align="left">車位編號</td>
          <td align="left"><input name="m_moto1" type="text" class="normalinput" id="m_moto1" value="<?php echo $row_RecUser['1']['m_moto1']; ?>" /></td>
          <td align="left">汽車車號</td>
          <td align="left"><input name="m_motomum1" type="text" class="normalinput" id="m_motomum1" value="<?php echo $row_RecUser['1']['m_motomum1']; ?>" /></td>
        </tr>
        <tr valign="middle">
          <td width="94" align="left">車位編號</td>
          <td align="left"><input name="m_moto2" type="text" class="normalinput" id="m_moto2" value="<?php echo $row_RecUser['1']['m_moto2']; ?>" /></td>
          <td align="left">汽車車號</td>
          <td align="left"><input name="m_motomum2" type="text" class="normalinput" id="m_motomum2" value="<?php echo $row_RecUser['1']['m_motomum2']; ?>" /></td>
        </tr>
        <tr valign="middle">
          <td width="94" align="left">機車編號</td>
          <td align="left"><input name="m_moto3" type="text" class="normalinput" id="m_moto3" value="<?php echo $row_RecUser['1']['m_moto3']; ?>" /></td>
          <td align="left">機車車號</td>
          <td align="left"><input name="m_motomum3" type="text" class="normalinput" id="m_motomum3" value="<?php echo $row_RecUser['1']['m_motomum3']; ?>" /></td>
        </tr>
        <tr valign="middle">
          <td width="94" align="left">機車編號</td>
          <td align="left"><input name="m_moto4" type="text" class="normalinput" id="m_moto4" value="<?php echo $row_RecUser['1']['m_moto4']; ?>" /></td>
          <td align="left">機車車號</td>
          <td align="left"><input name="m_motomum4" type="text" class="normalinput" id="m_motomum4" value="<?php echo $row_RecUser['1']['m_motomum4']; ?>" /></td>
        </tr>
        <tr valign="middle">
          <td width="94" align="left">機車編號</td>
          <td align="left"><input name="m_moto5" type="text" class="normalinput" id="m_moto5" value="<?php echo $row_RecUser['1']['m_moto5']; ?>" /></td>
          <td align="left">機車車號</td>
          <td align="left"><input name="m_motomum5" type="text" class="normalinput" id="m_motomum5" value="<?php echo $row_RecUser['1']['m_motomum5']; ?>" /></td>
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
