<div class="panel panel-default">
  <div class="panel-heading">保養設備列表</div>
  <div class="panel-body">
    <a href="#" class="btn btn-success" onclick="post_to_url('backindex_maint.php', {'action_mode':'new'});">新增保養設備</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>設備名稱</th>
          <th>保養廠商</th>
          <th>保養週期</th>
          <th>保養日期</th>
          <th>社區參與人員</th>
          <th>設定</th>
          <th>驗收狀態</th>
          <th>查看</th>
        </tr>
      </thead>
      <tbody>
      <?php
			if(is_array($maintData)){
        foreach ($maintData as $key => $value){
      ?>
        <tr>
          <td><?php echo $value['maint_name']; ?></td>
          <td><?php echo $value['maint_co']; ?></td>
          <td><?php echo $cycle_list[$value['maint_cycle']]; ?></td>
          <td><?php echo ($value['maint_cycle']=='0') ? $week_list[$value[maint_date]] : $value['maint_date']."號"; ?></td>
          <td><?php echo $value['maintainer']; ?></td>
          <td><a href="#" class="btn btn-default" onclick="post_to_url('backindex_maint.php', {'action_mode':'edit', 'maint_id':'<?php echo $value['maint_id']; ?>'});">設定</a></td>
          <td>
          <?php if($value['maint_state']=="1"){ ?>
            <a href="#" class="btn btn-success" onclick="post_to_url('backindex_maintlog.php', {'action_mode':'index', 'equipment_id':'<?php echo $value['maint_id']; ?>'});">已驗收</a>
          <?php }else{ ?>
            <a href="#" class="btn btn-default" onclick="post_to_url('backindex_maintlog.php', {'action_mode':'index', 'equipment_id':'<?php echo $value['maint_id']; ?>'});">未驗收</a>
          <?php } ?>
          </td>
          <td><a href="#" class="btn btn-default" onclick="post_to_url('backindex_maintlog.php', {'action_mode':'checkequyes', 'equipment_id':'<?php echo $value['maint_id']; ?>'});">查看</a> </td>
				  <?php if($_SESSION['MM_UserGroup']=='權限管理者'){ ?>
          <td><a href="#" class="btn btn-danger" onclick="confirm_delete(<?php echo $value['maint_id']; ?>);">刪除設備</a></td>
          <?php } ?>
        </tr>
      <?php }} ?>
      </tbody>
    </table>
    <div align="right"><ul class="pagination"><?php echo $Firstpage.$Listpage.$Endpage."<br />\n";?></ul></div>
  </div>
</div>
<script type="text/javascript">
function confirm_delete(maint_id) {
  var result = confirm('請確認是否刪除?');
  if(result)
  {
    post_to_url('backindex_maint.php', {'action_mode':'delete', 'maint_id':maint_id});
  }
}
</script>
