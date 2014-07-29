<div name="">
  <form action="backstage_vote.php" method="post" name="topic_list"> 
    <div style="lineHeight:50px;">投票列表</div>
    <div><a href="#" class="a1" onclick="post_to_url('backindex_vote.php', {'action_mode':'add_topic'})">新增投票</a><div>
    <div>
      <table align="left" border="1" cellpadding="1" cellspacing="1">
        <thead>
          <tr>
            <th scope="col"> 投票名稱</th>
            <th scope="col"> 投票期間</th>
            <th scope="col"> 設定群組項目</th>
            <th scope="col"> 設定規則</th>
            <th scope="col"> 查看結果</th>
            <th scope="col"> 刪除投票</th>
          </tr>
        </thead>
        <tbody>

          <?php
          if(isset($data)){
            foreach($data as $key1 =>$value){
          ?>
          <tr>
            <td><?php echo $value['topic_title'];?></td>
            <td><?php echo $value['topic_period_start'];?> - <?php echo $value['topic_period_end'];?></td>
            <td style="text-align: center;" ><a href="#" onclick="post_to_url('backindex_vote.php', {'action_mode':'group_list','topic_id':'<?php echo $value['topic_id'];?>'})">新增</a></td>
            <td style="text-align: center;" ><a href="#" onclick="post_to_url('backindex_vote.php', {'action_mode':'set_topic','topic_id':'<?php echo $value['topic_id'];?>'})">設定</a></td>
            <td style="text-align: center;" ><a href="#" onclick="post_to_url('backindex_vote.php', {'action_mode':'view_vote','topic_id':'<?php echo $value['topic_id'];?>'})">查看</a></td>
            <td style="text-align: center;" ><a href="#" onclick="post_to_url('backindex_vote.php', {'action_mode':'del','topic_id':'<?php echo $value['topic_id'];?>'})">刪除</a></td>
          </tr>
          <?php
            }
          }
          ?>

        </tbody>
      </table>
    </div>
    <div style="width: 844px;">
    <p style="float: right;"><ul class="pagination"><?php echo $Firstpage . $Listpage . $Endpage . "<br>\n"?></ul></p>
    </div>
  </form>
</div>