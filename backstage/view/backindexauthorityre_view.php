<script>
  function check(){
    n2 = document.form1.m_passwd.value.length;
    n4 = document.form1.m_name.value.length;
    n5 = document.form1.m_nick.value.length;
    n6 = document.form1.m_email.value;
    n7 = n6.match(/^\S+@\S+\.+\S+$/);
    n13 = document.form1.p_ip.value.length;
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
    if( !n4 || n4 <= 2 ){
      alert('真實姓名 需要有一個值。(最少三個字)');
    }
    else if( !n5 || n5 <= 2 ){
      alert('暱稱 需要有一個值。(最少三個字)');
    }
    else if( !n6 || !n7 ){
      alert('請確定此 電子郵件 為可使用狀態。');
    }
    else if( !n13 || n13 < 2 ){
      alert('網路卡 需要有一個值。(最少三個字)');
    }
    else{
      document.form1.submit();
    }
    return false;
  }
</script>
<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; position: absolute; overflow: auto;">
      <form id="form1" name="form1" method="POST" action="#">
        <input type="hidden" name="action_mode" value="edit_user">
        <input name="m_id" type="hidden" id="m_id" value="<?php echo $row_RecPower['1']['m_id']; ?>" />
        <table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr class="head1">
            <td width="100">帳號資料</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <th width="100" align="right">使用帳號</th>
            <td align="left">
              <?php echo $row_RecPower['1']['m_username']; ?>
            </td>
          </tr>
          <tr valign="baseline">
            <th width="100" align="right">密碼</th>
            <td align="left">
              <input name="m_passwd" type="password" id="m_passwd" />
              <font color="#FF0000">*</font> <br />
              需要修改密碼才填寫此欄。<br />
              請填入2~10個字元的英文字母、數字及符號。<br />
              請用英文開頭並與數字並用。
            </td>
          </tr>
          <tr class="head1">
            <td style="text-align: right">權限配置</td>
            <td align="left">
              <label>
                <select name="m_level" id="m_level">
                  <option value="權限管理者" <?php echo ($row_RecPower['1']['m_level']=='權限管理者') ? ' selected="selected"' : '' ;?>>權限管理者</option>
                  <option value="使用發布者" <?php echo ($row_RecPower['1']['m_level']=='使用發布者') ? ' selected="selected"' : '' ;?>>使用發布者</option>
                </select>
              </label>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <hr/>
            </td>
          </tr>
          <tr class="head1">
            <td width="100">個人資料</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <th width="100" align="right">真實姓名</th>
            <td align="left">
              <input name="m_name" type="text" class="normalinput" id="m_name" value="<?php echo $row_RecPower['1']['m_name']; ?>"/><font color="#FF0000">*</font>
            </td>
          </tr>
          <tr valign="baseline">
            <th width="100" align="right">暱稱</th>
            <td align="left"><input name="m_nick" type="text" class="normalinput" id="m_nick" value="<?php echo $row_RecPower['1']['m_nick']; ?>"/>
              <font color="#FF0000">*</font>
            </td>
          </tr>
          <tr valign="baseline">
            <th width="100" align="right">電子郵件</th>
            <td align="left">
              <input name="m_email" type="text" class="normalinput" id="m_email" value="<?php echo $row_RecPower['1']['m_email']; ?>"/>
              <font color="#FF0000">*</font> <br />
            </td>
          </tr>
          <tr valign="baseline">
            <th width="100" align="right">電話</th>
            <td align="left">
              <input name="m_phone" type="text" class="normalinput" id="m_phone" value="<?php echo $row_RecPower['1']['m_phone']; ?>"/>
              如 (00)00000000</td>
          </tr>
          <tr valign="baseline">
            <th width="100" align="right">行動電話</th>
            <td align="left">
              <input name="m_cellphone" type="text" class="normalinput" id="m_cellphone" value="<?php echo $row_RecPower['1']['m_cellphone']; ?>" />
              如 0911-111111</td>
          </tr>
          <tr valign="baseline">
            <th width="100" align="right">住址</th>
            <td align="left"><input name="m_address" type="text" class="normalinput" id="m_address" value="<?php echo $row_RecPower['1']['m_address']; ?>" size="40" />
              <input name="m_joinDate" type="hidden" id="m_joinDate" value="<?php echo date("Y-m-d H:i:s");?>" /></td>
          </tr>
          <tr valign="middle">
            <td align="right">網路卡</td>
            <td align="left"><input name="p_ip" type="text" class="normalinput" id="p_ip" value="<?php echo $row_RecPower['1']['p_ip']; ?>"/></td>
          </tr>
          <tr valign="middle">
            <td align="right">&nbsp;</td>
            <td align="left"><font color="#FF0000">*</font> 表示為必填的欄位</td>
          </tr>
          <tr valign="baseline">
            <td colspan="2" align="center"><hr size="1" noshade="noshade" />
              <input type="button" class="btn btn-primary" name="Submit2" value="送出申請" onClick="check();" />
              <input type="reset" class="btn btn-warning" name="Submit3" value="重設資料" />
              <input type="button" class="btn btn-danger" name="Submit" value="回上一頁" onclick="window.history.back();" />
            </td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
    </td>
  </tr>
</table>

