<div>
<form name="form" class="form" role="form" action="./backindex_maint.php" method="post">
  <input type="hidden" name="action_mode" value="<?php if($action_mode == "new"){ echo "create"; }else{ echo "update"; } ?>"/>
  <input type="hidden" name="maint_id" value="<?php if(isset($data[1]['maint_id'])){ echo $data[1]['maint_id']; } ?>"/>
  <div class="panel panel-default" style="width:80%;">
    <div class="panel-heading">
    <h3 class="panel-title">保養設備<?php echo $action_mode == "new" ? " (新增保養設備)" : " (修改保養設備)"; ?></h3>
    </div>
    <div class="panel-body">
      <div class="form-group form-inline">
        <label>設備名稱</label>
        <input name="maint_name" type="text" class="form-control" style="width:70%" placeholder="設備名稱" 
          <?php if(isset($data[1]['maint_name'])){echo "value=".$data[1]['maint_name'];} ?>>
      </div>
      <div class="form-group form-inline">
        <label>保養週期</label>
        <select name="maint_cycle" id="maint_cycle" class="form-control" onchange="option_add();">
          <option value="0" selected="selected">每週</option>
          <option value="1">每月</option>
          <option value="2">每季</option>
          <option value="3">每半年</option>
          <option value="4">每年</option>
        </select>
      </div>
      <div class="form-group form-inline">
        <label>保養日期</label>
        <select name="maint_date" id="maint_date" class="form-control">
          <option>請先選擇保養週期</option>
        </select>
      </div>
      <div class="form-group form-inline">
        <label>前台顯示</label>
        <div class="radio">
          <label>
            <input type="radio" name="maint_period" id="maint_period_am" value="0" checked>上午</input> 
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="maint_period" id="maint_period_pm" value="1">下午</input>
          </label>
        </div>
      </div>
      <div class="form-group form-inline">
        <label>保養提前通知</label>
        <select name="maint_notice" id="maint_notice" class="form-control">
          <option>請先選擇保養日期</option>
        </select><span> 天前</span>
      </div>
      <div class="form-group form-inline">
        <label>前台顯示</label>
        <div class="radio">
          <label>
            <input type="radio" name="maint_visible" id="maint_visible_true" value="1" checked>是</input> 
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="maint_visible" id="maint_visible_false" value="0">否</input>
          </label>
        </div>
      </div>
    </div>
  </div>

  <div class="panel panel-default" style="width:80%;">
    <div class="panel-heading">
      <h3 class="panel-title">保養廠商</h3>
    </div>
    <div class="panel-body">
      <div class="form-group form-inline">
        <label>廠商名稱:</label>
        <input name="maint_co" type="text" class="form-control" placeholder="廠商名稱"
          <?php if(isset($data[1]['maint_co'])){ echo "value=".$data[1]['maint_co'];} ?>>
        </input>
        <label>廠商電話:</label>
        <input name="maint_co_tel" type="text" class="form-control" placeholder="廠商電話"
          <?php if(isset($data[1]['maint_co_tel'])){ echo "value=".$data[1]['maint_co_tel'];} ?>>
        </input>
      </div>
      <hr/>
      <div class="form-group form-inline">
        <input type="hidden" name="staff_uid[]" value="<?php if(isset($staff_data[1]['uid'])){ echo $staff_data[1]['uid']; } ?>"/>
        <label>保養人姓名:</label>
        <input name="staff_name[]" type="text" class="form-control" placeholder="姓名"
          <?php if(isset($staff_data[1]['name'])){ echo "value=".$staff_data[1]['name'];} ?>>
        </input>
        <label>保養人電話:</label>
        <input name="staff_tel[]" type="text" class="form-control" placeholder="電話"
          <?php if(isset($staff_data[1]['phone'])){ echo "value=".$staff_data[1]['phone'];} ?>>
        </input>
      </div>
      <div class="form-group form-inline">
        <input type="hidden" name="staff_uid[]" value="<?php if(isset($staff_data[2]['uid'])){ echo $staff_data[2]['uid']; } ?>"/>
        <label>保養人姓名:</label>
        <input name="staff_name[]" type="text" class="form-control" placeholder="姓名"
          <?php if(isset($staff_data[2]['name'])){ echo "value=".$staff_data[2]['name'];} ?>>
        </input>
        <label>保養人電話:</label>
        <input name="staff_tel[]" type="text" class="form-control" placeholder="電話"
          <?php if(isset($staff_data[2]['phone'])){ echo "value=".$staff_data[2]['phone'];} ?>>
        </input>
      </div>
      <div class="form-group form-inline">
        <input type="hidden" name="staff_uid[]" value="<?php if(isset($staff_data[3]['uid'])){ echo $staff_data[3]['uid']; } ?>"/>
        <label>保養人姓名:</label>
        <input name="staff_name[]" type="text" class="form-control" placeholder="姓名"
          <?php if(isset($staff_data[3]['name'])){ echo "value=".$staff_data[3]['name'];} ?>>
        </input>
        <label>保養人電話:</label>
        <input name="staff_tel[]" type="text" class="form-control" placeholder="電話"
          <?php if(isset($staff_data[3]['phone'])){ echo "value=".$staff_data[3]['phone'];} ?>>
        </input>
      </div>
      <div class="form-group form-inline">
        <input type="hidden" name="staff_uid[]" value="<?php if(isset($staff_data[4]['uid'])){ echo $staff_data[4]['uid']; } ?>"/>
        <label>保養人姓名:</label>
        <input name="staff_name[]" type="text" class="form-control" placeholder="姓名"
          <?php if(isset($staff_data[4]['name'])){ echo "value=".$staff_data[4]['name'];} ?>>
        </input>
        <label>保養人電話:</label>
        <input name="staff_tel[]" type="text" class="form-control" placeholder="電話"
          <?php if(isset($staff_data[4]['phone'])){ echo "value=".$staff_data[4]['phone'];} ?>>
        </input>
      </div>
      <div class="form-group form-inline">
        <input type="hidden" name="staff_uid[]" value="<?php if(isset($staff_data[5]['uid'])){ echo $staff_data[5]['uid']; } ?>"/>
        <label>保養人姓名:</label>
        <input name="staff_name[]" type="text" class="form-control" placeholder="姓名"
          <?php if(isset($staff_data[5]['name'])){ echo "value=".$staff_data[5]['name'];} ?>>
        </input>
        <label>保養人電話:</label>
        <input name="staff_tel[]" type="text" class="form-control" placeholder="電話"
          <?php if(isset($staff_data[5]['phone'])){ echo "value=".$staff_data[5]['phone'];} ?>>
        </input>
      </div>
    </div>
  </div>

  <div class="panel panel-default" style="width:80%;">
    <div class="panel-heading">
      <h3 class="panel-title">社區參與人員</h3>
    </div>
    <div class="panel-body">
      <div class="form-group form-inline">
        <input type="hidden" name="manager_uid[]" value="<?php if(isset($manager_data[1]['uid'])){ echo $manager_data[1]['uid']; } ?>"/>
        <label>姓名:</label>
        <input name="manager_name[]" type="text" class="form-control" placeholder="姓名"
          <?php if(isset($manager_data[1]['name'])){ echo "value=".$manager_data[1]['name'];} ?>>
        </input>
        <label>電話:</label>
        <input name="manager_tel[]" type="text" class="form-control" placeholder="電話"
          <?php if(isset($manager_data[1]['phone'])){ echo "value=".$manager_data[1]['phone'];} ?>>
        </input>
      </div>
      <div class="form-group form-inline">
        <input type="hidden" name="manager_uid[]" value="<?php if(isset($manager_data[2]['uid'])){ echo $manager_data[2]['uid']; } ?>"/>
        <label>姓名:</label>
        <input name="manager_name[]" type="text" class="form-control" placeholder="姓名"
          <?php if(isset($manager_data[2]['name'])){ echo "value=".$manager_data[2]['name'];} ?>>
        </input>
        <label>電話:</label>
        <input name="manager_tel[]" type="text" class="form-control" placeholder="電話"
          <?php if(isset($manager_data[2]['phone'])){ echo "value=".$manager_data[2]['phone'];} ?>>
        </input>
      </div>
      <div class="form-group form-inline">
        <input type="hidden" name="manager_uid[]" value="<?php if(isset($manager_data[3]['uid'])){ echo $manager_data[3]['uid']; } ?>"/>
        <label>姓名:</label>
        <input name="manager_name[]" type="text" class="form-control" placeholder="姓名"
          <?php if(isset($manager_data[3]['name'])){ echo "value=".$manager_data[3]['name'];} ?>>
        </input>
        <label>電話:</label>
        <input name="manager_tel[]" type="text" class="form-control" placeholder="電話"
          <?php if(isset($manager_data[3]['phone'])){ echo "value=".$manager_data[3]['phone'];} ?>>
        </input>
      </div>
      <div class="form-group form-inline">
        <input type="hidden" name="manager_uid[]" value="<?php if(isset($manager_data[4]['uid'])){ echo $manager_data[4]['uid']; } ?>"/>
        <label>姓名:</label>
        <input name="manager_name[]" type="text" class="form-control" placeholder="姓名"
          <?php if(isset($manager_data[4]['name'])){ echo "value=".$manager_data[4]['name'];} ?>>
        </input>
        <label>電話:</label>
        <input name="manager_tel[]" type="text" class="form-control" placeholder="電話"
          <?php if(isset($manager_data[4]['phone'])){ echo "value=".$manager_data[4]['phone'];} ?>>
        </input>
      </div>
      <div class="form-group form-inline">
        <input type="hidden" name="manager_uid[]" value="<?php if(isset($manager_data[5]['uid'])){ echo $manager_data[5]['uid']; } ?>"/>
        <label>姓名:</label>
        <input name="manager_name[]" type="text" class="form-control" placeholder="姓名"
          <?php if(isset($manager_data[5]['name'])){ echo "value=".$manager_data[5]['name'];} ?>>
        </input>
        <label>電話:</label>
        <input name="manager_tel[]" type="text" class="form-control" placeholder="電話"
          <?php if(isset($manager_data[5]['phone'])){ echo "value=".$manager_data[5]['phone'];} ?>>
        </input>
      </div>
    </div>
  </div>
  <button type="submit" class="btn btn-success">確認</button>
  <a href="#" class="btn btn-danger" onclick="post_to_url('backindex_maint.php', {'action_mode':'index'});">取消</a>
</form>
</div>
<script type="text/javascript">

  function main_option_read() {
    var select = "<?php echo $data[1]['maint_cycle']; ?>";
    if (select != '' && parseInt(select)) {
        document.getElementById('maint_cycle').selectedIndex = select;
    }
  }
  
  function option_read() {
    var select_cycle = "<?php echo $data[1]['maint_cycle']; ?>";

    var select_date = "<?php echo $data[1]['maint_date']; ?>";
    if (select_date != '' && parseInt(select_date)) {
        if(select_cycle > 0)
        {
          select_date = select_date - 1;
        }      

        document.getElementById('maint_date').selectedIndex = select_date;
    }
    
    var select_notice = "<?php echo $data[1]['maint_notice']; ?>";
    if (select_notice != '' && parseInt(select_notice)) {
      if(select_cycle <= 0)
      {
        select_notice = select_notice - 1;
      }
      else
      {
        select_notice = select_notice - 5;
      }
      document.getElementById('maint_notice').selectedIndex = select_notice;
    }
    
    var select_visible = "<?php echo $data[1]['maint_period']; ?>";
    if (select_visible != '') {
      if(select_visible == 0)
      {
        document.getElementById("maint_period_am").checked = true;
      }
      else
      {
        document.getElementById("maint_period_pm").checked = true;
      }
    }
    
    var select_visible = "<?php echo $data[1]['maint_visible']; ?>";
    if (select_visible != '') {
      if(select_visible == 1)
      {
        document.getElementById("maint_visible_true").checked = true;
      }
      else
      {
        document.getElementById("maint_visible_false").checked = true;
      }
    }
  }

  function option_add() {
    var cycle = form.maint_cycle.value;
    var date = document.getElementById('maint_date');
    var notice = document.getElementById('maint_notice');

    date.options.length = 0;
    notice.options.length = 0;

    if(cycle === '0')
    {
      var week = ['週一', '週二', '週三', '週四', '週五', '週六', '週日'];
      for (i=0; i<7; i=i+1)
      {
        if(i === 0)
        {
          var new_option = new Option(week[i], i, false, true);
        }
        else
        {
          var new_option = new Option(week[i], i);
        }

        date.options.add(new_option);
      }

      for(i=1;i<=5;i=i+1)
      {
        if(i === 0)
        {
          var new_option = new Option(i, i, false, true);
        }
        else
        {
          var new_option = new Option(i, i, false, true);
        }

        notice.options.add(new_option);
      }
    }
    else
    {
      for (i=1; i<=30; i=i+1)
      {
        var new_option = new Option(i+"號",i);
        date.options.add(new_option);
      }
      
      for(i=5;i<=15;i=i+1)
      {
        var new_option = new Option(i, i);
        notice.options.add(new_option);
      }
    }
  }

  main_option_read();
  option_add();
  option_read();

</script>
