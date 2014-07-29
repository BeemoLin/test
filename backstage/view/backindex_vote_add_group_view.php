<div>
<form action="backstage_vote.php" method="post" name="group">
  <input type="hidden" name="action_mode" value="<?php echo $action_mode?>" />
  <input type="hidden" name="topic_id" value="<?php echo $topic_id?>" />
  <div>投票列表 -> 群組列表 -> 新增群組</div>
  <div>投票標題：<?php echo $topicData['topic_title'];?></div>
    <table align="left" border="0" cellpadding="1" cellspacing="1">
      <tbody>
        <tr>
          <th scope="row" style="text-align: left;">群組名稱</th>
          <td><input name="group_name" type="text"></td>
        </tr>
        <tr>
          <th scope="row" style="text-align: left;">群組內容</th>
          <td><textarea name="group_content"></textarea></td>
        </tr>
        <tr>
          <th scope="row" style="text-align: left;">是否複選</th>
          <td> &nbsp;
            <input checked="checked" name="group_muilte" value="0" type="radio">否 　　　
            <input name="group_m" value="0" type="radio">是
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" value="確定" />
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>