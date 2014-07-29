<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;"><table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th class="a1" scope="row">規約辦法</th>
      </tr>
    </table>
    <p> 　　<a href="backindex_rule.php">新增規約辦法</a></p>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form action="backindex_rule.php" method="POST" enctype="multipart/form-data" name="form1" id="form1">
          <p>
            <label>　規約標題：
              <input name="r_title" type="text" id="r_title" value="<?php echo $row_Recordset['1']['r_title']; ?>" size="50" />
              <br />
              　修改日期：
              <input name="r_date" type="text" id="r_date" value="<?php echo date("Y-m-d"); ?>" readonly="readonly" />
              <br />
              　規約圖片：                              </label>
<?php if ($row_Recordset['1']['r_pic']!=""){ ?>
              <img name="" src="rule/<?php echo $row_Recordset['1']['r_pic']; ?>" width="100" height="100" alt="" />
<?php } ?>
              <input name="oldPic" type="hidden" id="oldPic" value="<?php echo $row_Recordset['1']['r_pic']; ?>" />
            <label>
              <input name="r_pic" type="file" id="r_pic" />
            </label>
          </p>
          <p>&nbsp; </p>
          <p>
            <label> 　　　　　　　　　　　　　　　　　
              <input type="submit" name="send" id="send" value="送出" />
            </label>
            <input name="r_id" type="hidden" id="r_id" value="<?php echo $row_Recordset['1']['r_id']; ?>" />
          </p>
          <input type="hidden" name="MM_update" value="form1" />
          <input type="hidden" name="action_mode" value="update" />
        </form></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
</table>
