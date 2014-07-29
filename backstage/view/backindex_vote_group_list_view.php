<div>
  <form action="backstage_vote.php" method="post" name="topic_list">
    <input type="hidden" name="topic_id" value="<?php echo $topic_id?>" />
    <div>投票列表 -> 群組列表</div>
    <div>投票標題：<?php echo $topicData['topic_title'];?></div>
    <div><a href="#" class="a1" onclick="post_to_url('backindex_vote.php', {'action_mode':'add_group','topic_id':'<?php echo $topic_id;?>'})">新增群組</a></div>
    <div>
      <table style="width: 100%;" align="left" border="0" cellpadding="1" cellspacing="1">
        <thead> 
          <tr>
            <th style="text-align: left;">群組名稱</th>
            <th style="text-align: left;">選項複選</th>
            <th style="text-align: left;">設定群組</th>
            <th style="text-align: left;">查看結果</th>
            <th style="text-align: left;">刪除群組</th>
          </tr>
        </thead>
        <tbody>
        <?php
          if(isset($groupData)){
            foreach($groupData as $key => $value){
        ?>
          <tr>
            <td style="text-align: left;"><?php echo $value['group_name']; ?></td>
            <td style="text-align: left;"><?php echo $value['group_multiple'] == '0'?'否':'是'; ?></td>
            <td style="text-align: left;">設定</td>
            <td style="text-align: left;">查看</td>
            <td style="text-align: left;">刪除</td>
          </tr>
          <?php
          if(isset($optionsData)){
          ?>
          <tr>
            <td colspan="4">
            <table align="right" border="1" cellpadding="0" cellspacing="0" style="width: 700px;" >
            <?php
              if(is_array($groupData[$key]['options'])){
                $options = $groupData[$key]['options'];
                foreach($options as $key1 => $value1){

            ?>
                <tr><td><?php echo $value1[options_content]; ?></td><td style="width: 90px;">修改</td><td style="width: 90px;">刪除</td></tr>
            <?php
                    //echo '$value1['.$key2.']='.$value2."<br />\n";

                }
              }
            ?>
              </table>
            </td>
            <td></td>
          </tr>
          <?php
          }
          ?>
        <?php
            }
          }
        ?>
          <tr>
            <td colspan="5">

              </table>

            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </form>
</div>