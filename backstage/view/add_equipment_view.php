<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;">
      <table width="100" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th class="555" scope="row"><span class="a1">公設預約</span></th>
        </tr>
      </table>
      <p>&nbsp;</p>
      <table width="432" height="111" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="432" height="24">新增設備</td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
        </tr>
        <tr>
          <td>
            <form action="backindex_appointment.php" method="POST" enctype="multipart/form-data" name="form1" id="form1">
              <input type="hidden" name="action_mode" value="add">
              <p> 　　設備名稱： 
                <label>
                  <input type="text" name="name" id="name" />
                </label>
              </p>
              <p>設備規則圖片：
                <label>
                  <input type="file" name="pic" id="pic" />
                </label>
              </p>
              <p>&nbsp;</p>
              <p>
                <label>
                  <input type="submit" class="btn btn-success" name="send" id="send" value="送出" />
                </label>
              </p>
              <input type="hidden" name="MM_insert" value="form1" />
            </form>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>