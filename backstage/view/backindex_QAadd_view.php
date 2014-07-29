<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <th width="328" align="left" scope="row">
        <form id="form1" name="form1" method="post" action="backindex_QA.php">
          <p>　新增問卷資料</p>
          <table width="484" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th width="100" valign="top" scope="row">問卷標題</th>
              <td width="384"><label>
                <input name="qa_type" type="text" id="qa_type" value="" size="45" />
              </label></td>
            </tr>
          </table>
          <table width="484" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th width="100" valign="top" scope="row">問卷內容</th>
              <td width="384"><label>
                <textarea name="qa_content" id="qa_content" cols="45" rows="3"></textarea>
              </label></td>
            </tr>
          </table>
          <p><br />
            <label>　發布時間　
              <input name="qa_date" type="text" id="qa_date" value="<?php echo date("Y-m-d H:i:s");?>" readonly="readonly" />
            </label>
          </p>
          <p><br />
            <label></label>
            
            <input type="submit" class="btn btn-success" name="button" id="button" value="完成" />
          </p>
          <input type="hidden" name="MM_insert" value="form1" />
          <input type="hidden" name="action_mode" value="add_qa" />
        </form></th>
      </tr>
    </table></td>
  </tr>
</table>
