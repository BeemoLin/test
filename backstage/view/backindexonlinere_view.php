<div id="right3_right">
    <form id="form1" name="form1" method="post" action="backindexonline.php">
      <input type="hidden" name="action_mode" value="update">
      <h3 width="313" align="center" style="background-position: center center; background-repeat: no-repeat; background:#000; color: #FFF;"><?php echo $row_Rec_fix['1']['exl_exl']; ?></h3>
      <h3 width="97" style="background-position: right center; background-repeat: no-repeat; background:#000;">
        <input name="exl_id" type="hidden" id="exl_id" value="<?php echo $row_Rec_fix['1']['exl_id']; ?>" />
      </h3>
      <div style="float:right;">
        <h4>起始時間：<?php echo $maindata['1']['exl_date']; ?></h4>
        <h4>結束時間：<?php echo $maindata['1']['exl_repair']; ?></h4>
      </div>
      <h4>住戶名：<?php echo $row_Rec_fix['1']['exl_name']; ?></h4>
      <h4>電話：<?php echo $row_Rec_fix['1']['exl_phone']; ?></h4>
      <h4 height="45" colspan="2" align="left" scope="row">內容：<?php echo $row_Rec_fix['1']['exl_adj']; ?></h4>
      <h4>備註：<textarea name="exl_remark" id="exl_remark" cols="40" rows="6"><?php //echo $row_Rec_fix['1']['exl_remark']; ?></textarea>	</h4>
          
            <!-------------------------新增--------------------------------->
            <?php if(0){?>
            處理著：
            <select name="employees" id="employees">
            <?php foreach($worker as $arr1){ ?>
               <option value=<?php echo $arr1['id'];?>><?php echo $arr1['name'];?></option>
            <?php } ?>
            </select>
            <?}?>
            <!-------------------------新增-------------------------------->
          
          <h4>狀態：</h4>
            <select name="exl_yesno" id="exl_yesno">
              <option value="未處理" <?php if ($row_Rec_fix['1']['exl_yesno'] == '未處理' or $row_Rec_fix['1']['exl_yesno'] == 'no') {echo "selected=\"selected\"";} ?>>未處理</option>
              <option value="維修中" <?php if ($row_Rec_fix['1']['exl_yesno'] == '維修中') {echo "selected=\"selected\"";} ?>>維修中</option>
              <option value="已完成" <?php if ($row_Rec_fix['1']['exl_yesno'] == '已完成' or $row_Rec_fix['1']['exl_yesno'] == 'yes') {echo "selected=\"selected\"";} ?>>已完成</option>
            </select>
      <input type="submit" class="btn btn-success" name="Submit2" value="更新資料" />
      <input type ="button" class="btn btn-danger" onclick="history.back()" value="回到上一頁">
      <input type="hidden" name="MM_update" value="form1" />
    </form>

  <hr/>

  <h3>未處理</h3>
  <table class="table">
    <tr>
      <td>備註</td>
      <td width="20%">時間</td>
    </tr>
    <?php $item=1;?>
    <?php foreach($unfix as $arr){ ?>
      <tr>
        <td><?=$item.".".$arr['exl_remark']?></td>
        <td><?=$arr['exl_date']?></td>
      </tr>
    <?php $item+=1;} ?>
  </table>
  <h3>維修中</h3>
  <table class="table">
    <tr>
      <td>備註</td>
      <td width="20%">時間</td>
    </tr>
    <?php $item=1;?>
    <?php foreach($fixing as $arr) { ?>
      <tr>
        <td><?=$item.".".$arr['exl_remark']?></td>
        <td><?=$arr['exl_date']?></td>
      </tr>
    <?php $item+=1;} ?>
  </table>
  <h3>已完成</h3>
  <table class="table">
    <tr>
      <td>備註</td>
      <td width="20%">時間</td>
    </tr>
    <?php $item=1;?>
    <?php foreach($fixed as $arr) { ?>
      <tr>
        <td><?=$item.".".$arr['exl_remark']?></td>
        <td><?=$arr['exl_date']?></td>
      </tr>
    <?php $item+=1;} ?>
  </table>
</div>
