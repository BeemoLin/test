<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;"><table width="80%" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td height="376"><div class="subjectDiv">分享園地-圖文分享</div>
          <div class="actionDiv"></div>
          <div class="normalDiv">
            <form action="backindex_share.php" method="post" name="form1" id="form1">
              <p>標題名稱：
                <input type="hidden" name="action_mode" value="add_share" />
                <input type="text" name="share_title" id="share_title" />
              </p>
              <p>發布時間：
                <input name="share_date" type="text" id="share_date" value="<?php echo date("Y-m-d H:i:s");?>" />
              </p>
              <p>發表者 ：
                <input name="share_sharename" type="text" id="share_sharename" value="管理者" readonly="readonly" />
              </p>
              <p>內容：
                <textarea name="share_desc" id="share_desc" cols="45" rows="5"></textarea>
              </p>
              <p>&nbsp;</p>
              <p>
                <input type="button" name="button2" id="button2" value="回上一頁" onclick="window.history.back();" />
                <input type="submit" name="button" id="button" value="下一步" />
              </p>
              <p>
                <input type="hidden" name="MM_insert" value="form1" />
              </p>
              <div id="apDiv1">
                <label>
                  <input name="share_picture" type="hidden" id="share_picture" value="圖文" size="10" readonly="readonly" />
                </label>
              </div>
              <p>&nbsp; </p>
            </form>
          </div></td>
      </tr>
    </table>
    <p>&nbsp;</p></td>
  </tr>
</table>
