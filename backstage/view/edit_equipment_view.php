<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;">
      <table width="100" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th class="555" scope="row"><span class="a1">公設預約</span></th>
        </tr>
      </table>
      <p>&nbsp;</p>
      <form action="backindex_appointment.php" method="POST" enctype="multipart/form-data" name="form1" id="form1">
        <input type="hidden" name="action_mode" value="update1">
        <table width="551" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>設備名稱：
              <label>
                <input name="name" type="text" id="name" value="<?php echo $row_Recordset['1']['name']; ?>" />
                <input name="rulepic_id" type="hidden" id="rulepic_id" value="<?php echo $row_Recordset['1']['rulepic_id']; ?>" />
              </label>
            </td>
          </tr>
          <tr>
            <td>規約圖片：
              <?php if ($row_Recordset['1']['pic'] != "") { ?>
              <img src="upfildes/<?php echo $row_Recordset['1']['pic']; ?>" width="100" height="100" alt="" />
              <input name="old_Pic_name" type="hidden" id="old_Pic_name" value="<?php echo $row_Recordset['1']['pic']; ?>" />
              <?php } ?>
              <input type="file" name="pic" id="pic" />
            </td>
          </tr>
          <tr>
            <td>相關圖片：
              <?php if ($row_Recordset2['1']['oa_pic'] != "") { ?>
              <img src="newpic/<?php echo $row_Recordset2['1']['oa_pic']; ?>" width="100" height="100" alt="" />
              <input name="old_oa_pic_name" type="hidden" id="old_oa_pic_name" value="<?php echo $row_Recordset2['1']['oa_pic']; ?>" />
              <?php } ?>
              <input type="file" name="oa_pic" id="oa_pic" />

          <?php 
          /*
          if (empty($row_Recordset2['1']['oa_pic'])) { 
          ?>
              <table width="185" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center">
                 <!-- [<a href="#" onclick="post_to_url('backindex_share.php', {'action_mode':'update2','rulepic_id':'<?php echo $row_Recordset['1']['rulepic_id']; ?>','oa_name':'<?php echo $row_Recordset['1']['name']; ?>'})">新增相關圖片</a>] -->
                   <input type="file" name="pic2" id="pic2" />
                  </td>
                </tr>
              </table>
          <?php 
          } 
          else{ 
          ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="66%" align="center">
                      <img src="newpic/<?php echo $row_Recordset2['1']['oa_pic']; ?>" width="100" height="100" />
                  </td>
                  <td width="34%" align="center"><a href="deleteback/dele_order_pic.php?oa_id=<?php echo $row_Recordset2['1']['oa_id']; ?>&amp;oa_pic=<?php echo $row_Recordset2['1']['oa_pic']; ?>&amp;rulepic_id=<?php echo $row_Recordset2['1']['rulepic_id']; ?>">刪除</a></td>
                </tr>
              </table>
            <?php } 
            */
            ?>
            </td>
          </tr>
          <tr>
            <td>
              <label>
                <input type="submit" name="send" id="send" value="送出" />
              </label>
            </td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
      </form>
    </td>
  </tr>
</table>
