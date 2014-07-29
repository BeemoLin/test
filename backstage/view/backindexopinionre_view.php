<div id="right3_right">      
  <div class="subjectDiv">管理者回復</div>
  <div class="actionDiv"></div>
  <div class="normalDiv">
    <form action="backindexopinion.php" method="post" name="form1" id="form1">
      <input type="hidden" name="action_mode" value="update">
      
      <span class="s">住戶名稱
        <input name="opinion_name" type="text" id="opinion_name" value="<?php echo $row_Recordset['1']['opinion_name']; ?>" size="15" readonly="readonly" />
      </span>
      <input name="opinion_id" type="hidden" id="opinion_id" value="<?php echo $row_Recordset['1']['opinion_id']; ?>" />
      <div class="s">標題
        <input name="opinion_type" type="text" id="opinion_type" value="<?php echo $row_Recordset['1']['opinion_type']; ?>" size="40" readonly="readonly" />
      </div>
      <div class="s">日期
        <input name="opinion_date" type="text" id="opinion_date" value="<?php echo $row_Recordset['1']['opinion_date']; ?>" readonly="readonly" />
      </div>

      
      <table width="500" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="78" class="s">內容</td>
          <td width="422" class="s"><textarea name="opinion_content" cols="45" rows="5" readonly="readonly" id="opinion_content"><?php echo $row_Recordset['1']['opinion_content']; ?></textarea></td>
        </tr>
      </table>
      
      <table width="500" border="0" cellspacing="0" cellpadding="0">
      
        <tr>
          <th align="left" scope="row">版主回應</th>
          <th align="left" scope="row"><textarea name="opinion_response" cols="45" rows="5" id="opinion_response"><?php echo $row_Recordset['1']['opinion_response']; ?></textarea>
          </th>
        </tr>
        
        <tr>
          <th width="77" align="left" scope="row">&nbsp;</th>
          <th width="423" align="left" scope="row">回應時間
            <input name="opinion_time" type="text" id="opinion_time" value="<?php echo date("Y-m-d H:i:s");?>" readonly="readonly" />
          </th>
        </tr>
        
      </table>
      
      
      <p>
        <input type="submit" name="button" id="button" value="確定新增" />
        <input type="button" name="button2" id="button2" value="回上一頁" onclick="window.history.back();" />
      </p>
    </form>
  </div>
</div>

