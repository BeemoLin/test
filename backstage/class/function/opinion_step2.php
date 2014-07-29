<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 665px; height: 600px; position: absolute; overflow: auto;"><table width="555" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr valign="top">
        <td align="left" style="background:url(images/newsback.png); background-position:bottom right; background-repeat:no-repeat; color: #000;"><p class="title">管理者回復</p>
          <form action="<?php echo $editFormAction; ?>" method="post" id="form1" name="form1">
            <p> <span class="s">住戶名稱
              <input name="opinion_name" type="text" id="opinion_name" value="<?php echo $row_Recordset1['opinion_name']; ?>" size="15" readonly="readonly" />
              </span>
              <input name="opinion_id" type="hidden" id="opinion_id" value="<?php echo $row_Recordset1['opinion_id']; ?>" />
            </p>
            <p class="s">標題
              <input name="opinion_type" type="text" id="opinion_type" value="<?php echo $row_Recordset1['opinion_type']; ?>" size="40" readonly="readonly" />
            </p>
            <p class="s">日期
              <input name="opinion_date" type="text" id="opinion_date" value="<?php echo $row_Recordset1['opinion_date']; ?>" readonly="readonly" />
            </p>
            <table width="500" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="78" class="s">內容</td>
                <td width="422" class="s"><textarea name="opinion_content" cols="45" rows="5" readonly="readonly" id="opinion_content"><?php echo $row_Recordset1['opinion_content']; ?></textarea></td>
              </tr>
            </table>
            <table width="500" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th align="left" scope="row"><span class="title">版主回應</span></th>
                <th align="left" scope="row"><span class="title">
                  <textarea name="opinion_response" cols="45" rows="5" id="opinion_response"><?php echo $row_Recordset1['opinion_response']; ?></textarea>
                </span></th>
              </tr>
              <tr>
                <th width="77" align="left" scope="row">&nbsp;</th>
                <th width="423" align="left" scope="row">回應時間<span class="s">
                  <input name="opinion_time" type="text" id="opinion_time" value="<?php echo date("Y-m-d H:i:s");?>" readonly="readonly" />
                </span></th>
              </tr>
            </table>
            <p>&nbsp;</p>
            <p> <span class="s">
              <input name="button" type="submit" id="button" onclick="tfm_makeAllLinksConfirmable('','','')" value="送出資料" />
              <input type="button" name="button2" id="button2" onclick="window.history.back()" value="回上一頁" />
            </span></p>
            <input type="hidden" name="MM_update" value="form1" />
          </form></td>
      </tr>
      <tr>
        <th height="19" scope="row">&nbsp;</th>
      </tr>
    </table></td>
  </tr>
</table>
