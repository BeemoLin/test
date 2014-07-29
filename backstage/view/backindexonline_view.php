<script type="text/javascript">
<!--
function tfm_confirmLink(message, path, params, method) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
  if (document.MM_returnValue){
    post_to_url(path, params, method);
  }
}
//-->
</script>
<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px;"><table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th class="555" scope="row"><span class="a">線上報修</span></th>
      </tr>
    </table>
      <p><img src="images/btn2/報修單列表_.jpg" />　　<a href="#" onclick="post_to_url('backindexonline.php', {'action_mode':'select_data'})"><img src="images/btn2/搜尋報修單.jpg" /></a></p>
      <p>
        <?php 
        if($action_mode != 'view_all_data') { 
        ?>
        <a href="#" onclick="post_to_url('backindexonline.php', {'action_mode':'view_all_data'})"><img src="images/btn2/未分類.jpg" /></a>
        <?php 
        } 
        else{ echo '<img src="images/btn2/未分類_.jpg" />'; } 
        ?>&nbsp;
        <?php 
        if($action_mode != 'view_all_data_yes') { 
        ?>
        <a href="#" onclick="post_to_url('backindexonline.php', {'action_mode':'view_all_data_yes'})"><img src="images/btn2/已完成.jpg" /></a>
        <?php 
        } 
        else{ echo '<img src="images/btn2/已完成_.jpg" />'; } 
        ?>&nbsp;
        <?php 
        if($action_mode != 'view_all_data_unknow') { 
        ?>
        <a href="#" onclick="post_to_url('backindexonline.php', {'action_mode':'view_all_data_unknow'})"><img src="images/btn2/維修中.jpg" /></a>
        <?php 
        } 
        else{ echo '<img src="images/btn2/維修中_.jpg" />'; } 
        ?>&nbsp;
        <?php 
        if($action_mode != 'view_all_data_no') { 
        ?> 
        <a href="#" onclick="post_to_url('backindexonline.php', {'action_mode':'view_all_data_no'})"><img src="images/btn2/未處理.jpg" /></a>
        <?php 
        } 
        else{ echo '<img src="images/btn2/未處理_.jpg" />'; } 
        ?>&nbsp;
      </p>
      <table style="width: 844px;" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th align="left" style="background-position: left center; background-repeat: no-repeat; background:#000; color: #FFF;" scope="row">　<span class="white">住戶</span></th>
          <th style="background-position: center center; background-repeat: no-repeat; background:#000; color: #FFF;" scope="row">問題</th>
          <th style="background-position: right center; background-repeat: no-repeat; background:#000; color: #FFF;" scope="row">時間</th>
          <th style="background-position: right center; background-repeat: no-repeat; background:#000; color: #FFF;"></th>
        </tr>

            <?php
            $color_number=0;            
            if(isset($data)){
              foreach ($data as $k1 => $v1) { 
              ?>
              <tr <?php echo $color_number%2==0?'style=" background-color:#FF6;"':''; ?>>
                <th height="48" scope="row"><?php echo $v1['exl_name']; ?></th>
                <td><a href="#" onclick="post_to_url('backindexonline.php', {'action_mode':'edit','exl_id':'<?php echo $v1['exl_id'];?>'})"><?php echo $v1['exl_exl']; ?>
                  <?php if ($v1['exl_yesno'] == 'no' or $v1['exl_yesno'] == '未處理'){ ?>
                  <img src="../img/btn2/not com.gif" alt="" width="40" height="20" border="0" align="right" />
                  <?php }  ?>
                  
                  <?php if ($v1['exl_yesno'] == '維修中'){ ?>
                  <img src="../img/btn2/Processing.gif" alt="" width="40" height="20" border="0" align="right" />
                  <?php } ?>
                  
                  <?php if ($v1['exl_yesno'] == 'yes' or $v1['exl_yesno'] == '已完成'){ ?>
                  <img src="../img/btn2/complete.gif" alt="" width="40" height="20" border="0" align="right" />
                  <?php }  ?>
                </a></td>
                <td><?php echo $v1['exl_date']; ?></td>
                <td><?php if($_SESSION['MM_UserGroup']=='權限管理者'){?><a href="#" onclick="tfm_confirmLink('你確定要刪除???','backindexonline.php', {'action_mode':'delete','exl_id':'<?php echo $v1['exl_id']; ?>'})">刪除</a><?php }?></td>
              </tr>
              <?php 
                $color_number++;
              }  
            }
            ?>
            

    </table>
    <div style="width: 844px;">
    <p style="float: right;"><ul class="pagination"><?php echo $Firstpage . $Listpage . $Endpage . "<br>\n"?></ul></p>
    </div>
    </td>
  </tr>
</table>
