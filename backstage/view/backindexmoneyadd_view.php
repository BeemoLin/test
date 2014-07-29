<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;">
    <table width="90%" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td><div class="subjectDiv"> 財務報表</div>
          <div class="actionDiv"><a href="#" onclick="window.history.back();">回上一頁</a></div>
          <div class="normalDiv">
            <form action="backindex_money.php" method="post" name="form1" id="form1">
            <input type="hidden" name="action_mode" value="add_money">
              <p>標題　：
                <input type="text" name="album_title" id="album_title" />
              </p>
              <p>發布時間　：
                <input name="album_date" type="text" id="album_date" value="<?php echo date("Y-m-d H:i:s");?>" readonly="readonly"/>
              </p>
              <p>說明：
                <textarea name="album_desc" id="album_desc" cols="45" rows="5"></textarea>
              </p>
              <p>&nbsp;</p>
              <p>
                <input type="submit" class="btn btn-success" name="button" id="button" value="確定新增" />
                <input type="button" class="btn btn-danger" name="button2" id="button2" value="回上一頁" onclick="window.history.back();" />
              </p>
              <input type="hidden" name="MM_insert" value="form1" />
            </form>
          </div></td>
      </tr>
    </table></td>
  </tr>
</table>
