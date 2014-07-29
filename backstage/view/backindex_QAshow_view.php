<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;"><table width="364" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <th colspan="2" scope="row"><p>&nbsp;</p>
          <table width="340" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th width="63" scope="row">標題：</th>
              <td width="277"><?php echo $row_Recordset['1']['qa_type']; ?></td>
            </tr>
            <tr>
              <th height="90" valign="top" scope="row">內容：</th>
              <td valign="top"><?php echo $row_Recordset['1']['qa_content']; ?></td>
            </tr>
          </table>
          <p>&nbsp;</p></th>
      </tr>
      <tr>
       <th width="160" scope="row"> 同意</th>
        <td width="204" align="center"><?php echo $yes['1']['total']; ?> 票</th>
      </tr>
      <tr>
        <th width="160" scope="row">不同意</th>
        <td width="204" align="center"><?php echo $no['1']['total']; ?> 票</td>
      </tr>
      <tr>
        <th width="160" scope="row">沒意見</th>
        <td width="204" align="center"><?php echo $no_opinion['1']['total']; ?> 票</td>
      </tr>
      
      
      <tr>
      <th width="160">  </th>
      <th width="204" scope="row"><input type="button" name="goback" class="btn btn-danger" value="回上一頁" onclick="window.history.back();"></th>
      </tr>
    </table></td>
  </tr>
</table>
