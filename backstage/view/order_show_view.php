<table border="0" cellpadding="0" cellspacing="0" id="right3_right">

  <tr>
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;">
    <table width="484" height="24" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="484" height="24">　　　<?php //equipment 設備?>
          <a href="#" onclick="post_to_url('backindex_appointment.php', {'action_mode':'add_equipment'})">新增設備</a>　　
          <a href="#" onclick="post_to_url('backindex_appointment.php', {'action_mode':'add_order_view'})">新增預約用戶</a> 　　
          設備清單列表</td>
        </tr>
    </table>
      <table width="629" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th scope="row">
            <table width="607" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th></th>
                <th align="center">設備</th>
                <th width="165" align="center">日期</th>
                <td width="174" align="center">時間</td>
                <td width="72" align="center">住戶名稱</td>
                <td >備註及取消</td>
              </tr>
              <?php
			  if(isset($data)){
                foreach ($data as $V){
              ?>
              <tr>
                <th width="20" scope="row"><img src="../img/btn2/MINI btn.gif" alt="" width="16" height="16" /></th>
                <th ><?php echo $V['name']?></th>
                <th ><?php echo $V['o_time']?></th>
                <td align="center"><?php echo $V['order_time']?></td>
                <td align="center"><?php echo $V['order_name']?></td>
                <td align="center">
                  <a href="#" onclick="post_to_url('backindex_appointment.php', {'action_mode':'order_show_ps','rulepic_id':'<?php echo $V['rulepic_id']?>','order_id':'<?php echo $V['order_id']?>'})">
                  <?php if($V['disable']==1){echo "已取消";}else{echo "預約";}?>
                  </a>
                </td>
<?php /*?>                <td align="center"><a href="#" onclick="post_to_url('backindex_appointment.php', {'action_mode':'disable','rulepic_id':'<?php echo $V['rulepic_id']?>','order_id':'<?php echo $V['order_id']?>'})">刪除</a></td> <?php */?>
              </tr>
              <?php
                }
			  }
              ?>
            </table>
            </th>
        </tr>
      </table>
      <div style="width: 844px;">
        <div>
          <p style="float: right;"><?php echo $Firstpage . $Listpage . $Endpage . "<br>\n"?></p>
        </div>
      </div>
    </td>
  </tr>
</table>
