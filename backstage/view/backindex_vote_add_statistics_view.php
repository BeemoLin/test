<?php
////////////////////////// no use
?>
<div>
    <form action="backstage_vote" method="post" name="vote_options`">
      <input type="hidden" name="action_mode" value="<?php echo $action_mode?>" />
      <input type="hidden" name="topic_id" value="<?php echo $topic_id;?>">
      <div>投票標題：$vote_title</div>
      <div>投票群組：$group_name</div>
      <div>投票內容(選項)：<input name="options_content" type="text"></div>
    </form>
</div>