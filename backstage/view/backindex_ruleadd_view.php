<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; position: absolute; overflow: auto;">
    <table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th class="a1" scope="row">規約辦法</th>
      </tr>
    </table>
    <table width="620" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr style="text-align: left">
        <th align="left" scope="row"><form action="backindex_rule.php" method="POST" enctype="multipart/form-data" name="form1" id="form1">
          <p>
            <label>
              <br />
              　規約標題：
              <input name="r_title" type="text" id="r_title" size="50" />
              <br />
               　發布時間：
               <input name="r_date" type="text" id="r_date" value="<?php echo date("Y-m-d"); ?>" readonly="readonly" />
               <br />
              　圖片上傳：
              <input type="file" name="r_pic" id="r_pic" />
              <br />
            </label>
          </p>
          <p>
            <label>
              　　　　　　　　　　　　　　　　　
                <input type="submit" name="send" id="send" value="送出" />
            </label>
          </p>
          <input type="hidden" name="action_mode" value="add_rule" />
        </form></th>
      </tr>
    </table>
    <p>&nbsp;</p></td>
  </tr>
</table>
