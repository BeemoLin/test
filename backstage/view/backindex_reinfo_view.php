<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; position: absolute; overflow: auto;"><table width="555" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr valign="top">
        <td style="background:url(images/newsback.png); background-position:bottom right; background-repeat:no-repeat"><p class="title">新增網址</p>
          <form action="backindex_info.php" method="post" id="form1" name="form1">
            <p>網站名稱
              <input name="info_name" type="text" id="info_name" value="<?php echo $row_RecInfo['1']['info_name']; ?>" size="40" />
              <input name="info_id" type="hidden" id="info_id" value="<?php echo $row_RecInfo['1']['info_id']; ?>" />
            </p>
            <p>網址
              <input name="info_url" type="text" id="info_url" value="<?php echo $row_RecInfo['1']['info_url']; ?>" size="80" />
            </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>
              <input type="submit" class="btn btn-success" name="button" id="button" value="送出資料" />
              <input type="button" class="btn btn-danger" name="button2" id="button2" onclick="window.history.back()" l="l" value="回上一頁" />
            </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <input type="hidden" name="MM_update" value="form1" />
            <input type="hidden" name="action_mode" value="update" />
          </form></td>
      </tr>
      <tr>
        <th scope="row">&nbsp;</th>
      </tr>
    </table></td>
  </tr>
</table>
