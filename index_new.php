<?php
require_once('define.php');
$_SESSION['from_web'] = 'index_new.php';
$_SESSION['enter_web'] = '';
require_once(CONNSQL);
require_once(PAGECLASS);

if (isset($_GET['p_ip'])) {
  $p_ip = trim($_GET['p_ip']);
  $pages = new sam_pages_class;
  $pages->sql = "SELECT m_username, m_level, m_level, count(*) as inname  FROM memberdata WHERE p_ip='$p_ip' GROUP BY p_ip";
  $result = $pages->getData();

  if ($result['1']["inname"] != 1){
    header("Location: index_new.php");
    exit();
  }
  else{
    $_SESSION['MM_Username'] = trim($result['1']["m_username"]);
    $_SESSION['MM_UserGroup'] = trim($result['1']["m_level"]);
    $_SESSION['enter_web'] = CONSTRUCTION_CASE;
    header("Location: index2.php");
    exit();
  }
}
require_once('basic_program_structure_head.php');
?>
<div>
  <div style="width: 350px; height: 300px; margin: 0 auto; background-repeat: no-repeat; background-image: url(img/btn2/login_bg4.gif);">
    <form action="login_new.php" id="form1" name="form1" method="post">
      <div style="width: 350px; border: 0px; padding-top: 110px; border-collpase: collpase;">
        <div>
          <img src="img/life2/account.gif" width="50" height="30" style="vertical-align: middle;" /> <input name="username" type="text" class="logintext" id="username" />
        </div>
        <div>
          <img src="img/life2/code.gif" width="50" height="30" style="vertical-align: middle;" /> <input name="password" type="password" class="logintext" id="password" />
        </div>
        <div>
          <input name="button" type="submit" id="button" value="登入" />
        </div>
        <div>
          <span class="white"> <span style="color: red;">※</span> <span style="color: white;">忘記密碼請洽櫃檯<?php echo @$rename;?> </span> </span>
        </div>
      </div>
    </form>
  </div>
</div>
<?php //require_once('basic_program_structure_foot.php'); ?>