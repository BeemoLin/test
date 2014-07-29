<div>
    <form action="backstage_vote" method="post" name="vote_options`">
      <input type="hidden" name="action_mode" value="<?php echo $action_mode?>" />
      <input type="hidden" name="topic_id" value="<?php echo $topic_id;?>">
    <?php
      if(isset($data)){
        foreach($data as $key => $value){
    ?>
      <div>投票列表 -> 群組列表 -> 選項列表 -> 新增選項</div>
      <div>投票標題：<?php echo $value['vote_title'];?></div>
      <div>投票群組：<?php echo $value['group_name'];?></div>
      <div>投票選項：<input name="options_content" type="text" /></div>
    <?php
        }
      }
    ?>

    </form>
</div>