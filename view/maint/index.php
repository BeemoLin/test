<div style="height:25px;">保養設備列表</div>
<div style="min-height:300px;float:left;">
  <table border="1" BORDERCOLOR="#FFF">
    <thead>
      <tr>
        <th>設備名稱</th>
        <th>保養廠商</th>
        <th>保養週期</th>
        <th>保養日期</th>
        <th>社區參與人員</th>
        <th>驗收狀態</th>
      </tr>
    </thead>
    <tbody>
    <?php
    if(is_array($maintData)){
      foreach ($maintData as $key => $value){
    ?>
      <tr>
        <td><?=$value['maint_name'];?></td>
        <td><?php echo $value['maint_co']; ?></td>
        <td><?php echo $cycle_list[$value['maint_cycle']]; ?></td>
        <td><?php echo ($value['maint_cycle']=='0') ? $week_list[$value[maint_date]] : $value['maint_date']."號"; ?></td>
        <td><?php echo $value['maintainer']; ?></td>
         
         <?php 
          $color=($value['maint_state']=="1")?"#00FF00":"#FF0000";
          $tdname=($value['maint_state']=="1")?"已驗收":"未驗收";
         ?>
         <td bgcolor="<?=$color?>"> <a href="#"  onclick="post_to_url('checkmaintlist.php', {'equipment_id':'<?=$value['maint_id']?>'});"><?=$tdname?></a>
  
        </td>
        
      </tr>
    <?php }} ?>
    </tbody>
  </table>
</div>
<div style="float:right;"><ul class="pagination"><?php echo $Firstpage.$Listpage.$Endpage."<br />\n";?></ul></div>
