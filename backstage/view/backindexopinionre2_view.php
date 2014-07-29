<script type="text/javascript">
function check(){
  var c_value = document.getElementById("content").value.length;
  if(c_value==0){
    location.href = 'backindexopinion2.php';
  }
  else{
    var xx = document.getElementById('content').value;
    post_to_url('backindexopinion2.php', {'action_mode':'insert','ot1_id':'<?php echo $ot1_id; ?>','content': xx });
  }
}
function go(){
  location.href = 'backindexopinion2.php';
}
</script>
<div id="right3_right">      
  <div class="subjectDiv">管理者回覆</div>
  <div class="actionDiv"></div>
  <div class="normalDiv">
<table border="0" cellpadding="0" cellspacing="0" id="pic3">
  <tr>
    <td style="color:rgb(0,0,0);vertical-align:top;padding: 10px;">
    <div style="text-align:center;padding: 10px;" class="title">
      <strong>
      <?php
      echo $title;
      ?>
      </strong>
    </div>
    <hr />
    <?php
    if(isset($row_Recordset)){
      foreach($row_Recordset as $key => $value){
    ?>
    <div onmouseover="this.style.backgroundColor='rgb(255,128,128)';" onmouseout="this.style.backgroundColor='rgb(255,255,255)'" style="vertical-align:text-top; margin-bottom: 20px;" class="column">
      <div class="opinion_column_top">
        <div style="float:right">
          <abbr title="<?php echo $value['ot2_datetime'];?>"><?php echo substr($value['ot2_datetime'],0,10);?></abbr>
        </div>
        <?php
        if($value['m_username']==$row_RecUser['m_username']){
          echo '<strong style="color:rgb(255,0,0);">'.$value['m_username'].'</strong>';
           
        }
        else{
          echo '<strong style="color:rgb(0,0,255);">'.$value['m_username'].'</strong>';
           
        }
        ?>
      </div>
      <div style="padding-left: 20px;" class="opinion_column_bottom">
        <div class="content" id="" style="width:730px;overflow-x: auto;" >
          <p><?php echo $value['ot2_content'];?></p>
        </div>
      </div>
    </div>
    <hr />
  <?php
    }
  }
  ?>
    </td>
  </tr>
  <tr>
    <td>
      <?php
      if($type==0){
      ?>
      <form action="opinionsee2.php" method="post" name="form1" id="form1">
        <div style="margin:16px 0px 16px 0px;">
          <input type="hidden" name="ot1_id" id="ot1_id" value="<?php echo $ot1_id;?>">
          <input type="hidden" name="action_mode" value="insert">
          <strong>留言</strong>
          <textarea style="width:750px;height:60px" name="content" id="content"></textarea>
          <div >
            <input type="button" class="btn btn-success" value="確定送出" onclick="check()" ></input>
            <input type="button" class="btn btn-danger" value="回上一頁" onclick="go()"></input>
          </div>
        </div>
      </form>
      <?php
      }
      ?>
    </td>
  <tr>
</table>


  </div>
</div>

