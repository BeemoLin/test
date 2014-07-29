<div id="menu" align="center" style="width:844px">
  <div style="float:left;">
    <a href="#" onclick="post_to_url('backindex_mail.php', {'action_mode':'select'})">
    <?php 
      if ($_POST['action_mode']=='select' || $_POST['action_mode']=='select_list'){
    ?>
      <img src="images/mail/menu/select_.gif" />
    <?php
      }
      else{
    ?>
      <img src="images/mail/menu/select.gif" />
    <?php }?>
    </a>
  </div>
  <div style="width:50px;float:left;">&nbsp;</div>
  <div style="float:left;">
    <a href="#" onclick="post_to_url('backindex_mail.php', {'action_mode':'add_data'})">
    <?php 
      if ($_POST['action_mode']=='add_data'){
    ?>
      <img src="images/mail/menu/add_.gif" />
    <?php
      }
      else{
    ?>
      <img src="images/mail/menu/add.gif" />
    <?php }?>
    </a>
  </div>
  <div style="width:50px;float:left;">&nbsp;</div>
  <div style="float:left;">
    <a href="#" onclick="post_to_url('backindex_mail.php', {'action_mode':'view_all_data'})">
    <?php 
      if ($_POST['action_mode']=='view_all_data'){
    ?>
      <img src="images/mail/menu/home_.gif" />
    <?php
      }
      else{
    ?>
      <img src="images/mail/menu/home.gif" />
    <?php }?>
    </a>
  </div>
  <div style="width:50px;float:left;">&nbsp;</div>
  <div style="float:left;">
    <a href="#" onclick="post_to_url('backindex_mail.php', {'action_mode':'key_selected'})">
    <?php 
      if ($_POST['action_mode']=='key_selected' || $_POST['action_mode']=='give_data'){
    ?>
      <img src="images/mail/menu/give_.gif" />
    <?php
      }
      else{
    ?>
      <img src="images/mail/menu/give.gif" />
    <?php }?>
    </a>
  </div>
  <div style="width:50px;float:left;">&nbsp;</div>
  <div style="float:left;">
    <a href="#" onclick="post_to_url('backindex_mail.php', {'action_mode':'undisable_list'})">
    <?php 
      if ($_POST['action_mode']=='undisable_list'){
    ?>
      <img src="images/mail/menu/undisable_.gif" />
    <?php
      }
      else{
    ?>
      <img src="images/mail/menu/undisable.gif" />
    <?php }?>
    </a>
  </div>
</div>
<?php
/*
<div id="menu" align="center">
  <span><a href="#" onclick="post_to_url('backindex_mail.php', {'action_mode':'select'})">搜尋資料</a></span><span style="width:50px;display: inline-block;"></span>
  <span><a href="#" onclick="post_to_url('backindex_mail.php', {'action_mode':'add_data'})">新增收件</a></span><span style="width:50px;display: inline-block;"></span>
  <span><a href="#" onclick="post_to_url('backindex_mail.php', {'action_mode':'view_all_data'})">返回首頁</a></span><span style="width:50px;display: inline-block;"></span>
  <span><a href="#" onclick="post_to_url('backindex_mail.php', {'action_mode':'give_list'})">信件發放</a></span><span style="width:50px;display: inline-block;"></span>
  <span><a href="#" onclick="post_to_url('backindex_mail.php', {'action_mode':'undisable_list'})">查詢發放信件</a></span>
</div>
*/
?>