<div>
    <form action="backindex_vote.php" method="post" name="form1" id="form1">
      <input type="hidden" name="action_mode" value="<?php echo $action_mode?>" />
      <div>投票列表 -> 新增投票</div>
      <table border="0" cellpadding="1" cellspacing="1">
        <tbody>
          <tr>
            <th scope="row" style="text-align: left;"> 投票標題：</th>
            <td> <input name="topic_title" type="text"></td>
          </tr>
          <tr>
            <th scope="row" style="text-align: left;"> 投票內容：</th>
            <td> <textarea name="topic_content"></textarea></td>
          </tr>
          <tr>
            <th scope="row" style="text-align: left;"> 投票期間：</th>
            <td>
              <input name="topic_period_start" id="topic_period_start" type="text" class="Wdate" onFocus="WdatePicker({minDate:'%y-%M-%d',maxDate:'#F{$dp.$D(\'topic_period_end\',{H:-1})||$dp.$DV(\'2030-4-3 00:00:00\',{H:-1})}',dateFmt:'yyyy-MM-dd HH:00:00'})">　～　
              <input name="topic_period_end"   id="topic_period_end"   type="text" class="Wdate" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'topic_period_start\',{H:1});}',maxDate:'2020-4-3',dateFmt:'yyyy-MM-dd HH:00:00'})">
            </td>
          </tr>
          <tr>
            <th scope="row" style="text-align: left;"> 是否公佈：</th>
            <td> <input checked="checked" name="topic_publish" value="0" type="radio">否 　　　<input name="vote_publish" value="1" type="radio">是</td>
          </tr>
          <tr>
            <th scope="row" style="text-align: left;"> 是否為短期發佈：</th>
            <td> <input checked="checked" name="topic_short_time" value="0" type="radio">否 　　　<input name="topic_short_time" value="1" type="radio">是</td>
          </tr>
          <tr>
            <th scope="row" style="text-align: left;"> 短期發佈期間：</th>
            <td>
              <input name="topic_show_start" id="topic_show_start" type="text" class="Wdate" onFocus="WdatePicker({minDate:'%y-%M-%d',maxDate:'#F{$dp.$D(\'topic_show_end\',{H:-1})||$dp.$DV(\'2030-4-3 00:00:00\',{H:-1})}',dateFmt:'yyyy-MM-dd HH:00:00'})">　～　
              <input name="topic_show_end"   id="topic_show_end"   type="text" class="Wdate" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'topic_show_start\',{H:1});}',maxDate:'2020-4-3',dateFmt:'yyyy-MM-dd HH:00:00'})">
            </td>
          </tr>
          <tr>
            <th scope="row" style="text-align: left;"> 是否投票期間可更改：</th>
            <td> <input checked="checked" name="topic_chang" value="0" type="radio">否 　　　<input name="topic_chang" value="1" type="radio">是</td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" value="確定"></td>
          </tr>
        </tbody>
      </table>
      </form>
</div>