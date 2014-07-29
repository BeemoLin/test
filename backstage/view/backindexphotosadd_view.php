<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;"><table width="90%" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td><div class="subjectDiv"> 相簿管理-相增相簿</div>
          <div class="actionDiv"></div>
          <div class="normalDiv">
            <form action="backindex_photo.php" method="post" name="form1" id="form1">
              <input type="hidden" name="action_mode" value="add_photo">
              <p>相簿名稱：
                <input type="text" name="album_title" id="album_title" />
              </p>
              <p>發布時間：
                <input name="album_date" type="text" id="album_date" value="<?php echo date("Y-m-d"); ?>" readonly="readonly" />
                拍攝地點 ：
                <input type="text" name="album_location" id="album_location" />
              </p>
              <p>相簿說明：
                <textarea name="album_desc" id="album_desc" cols="45" rows="5"></textarea>
              </p>
              <p>&nbsp;</p>
              <p>
                <input type="submit" name="button" id="button" value="確定新增" />
                <input type="button" name="button2" id="button2" value="回上一頁" onclick="window.history.back();" />
              </p>
              <input type="hidden" name="MM_insert" value="form1" />
            </form>
          </div></td>
      </tr>
    </table></td>
  </tr>
</table>
