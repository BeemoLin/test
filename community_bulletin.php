<?php
require_once('define.php');
$_SESSION['from_web'] = 'index2_new.php';
require_once(CONNSQL);
require_once(PAGECLASS); 
require_once('basic_program_structure_head.php'); 
$pages = new data_function;

//$query_RecUser = sprintf("SELECT m_id, m_name, m_nick, m_username FROM memberdata WHERE m_username = %s", GetSQLValueString($colname_RecUser, "text"));
//$query_RecMember = sprintf("SELECT m_id, m_name, m_nick, m_username FROM memberdata WHERE m_username = %s", GetSQLValueString($colname_RecMember, "text"));
//$query_RecNews = "SELECT * FROM news_album ORDER BY album_date DESC";
//$query_Recmember = sprintf("SELECT * FROM memberdata WHERE m_username = %s", GetSQLValueString($colname_Recmember, "text"));


$pages->setDb('news_album');
$data1=$pages->select('ORDER BY `album_date` DESC LIMIT 0 , 2');
$pages->setDb('food');
$data2=$pages->select('ORDER BY `food_date` DESC LIMIT 0 , 1');
$pages->setDb('cloth');
$data3=$pages->select('ORDER BY `cloth_date` DESC LIMIT 0 , 1');
$pages->setDb('living');
$data4=$pages->select('ORDER BY `living_date` DESC LIMIT 0 , 1');
$pages->setDb('walk');
$data5=$pages->select('ORDER BY `walk_date` DESC LIMIT 0 , 1');
$pages->setDb('teach');
$data6=$pages->select('ORDER BY `teach_date` DESC LIMIT 0 , 1');
$pages->setDb('happy');
$data7=$pages->select('ORDER BY `happy_date` DESC LIMIT 0 , 1');
$pages->setDb(' `album` INNER JOIN `albumphoto` ON `album`.`album_id` = `albumphoto`.`album_id` ','`album`.`album_id`, `album`.`album_date`, `album`.`album_title`, (`albumphoto`.`ap_picurl`) AS album_photo');
$data8=$pages->select('GROUP BY  `album`.`album_id` ORDER BY `album`.`album_date` DESC LIMIT 0 , 2');

?>
<div id="body" style="width:770px">
  <div id="left_news" style="float:left;width:600px">
    <div style="float:left;"><img src="img/img/the newest.png"></div>
    <div style="clear:both;float:left;margin:20px;width:100%;height:300px;text-align:left;line-height:30px;font-size:20px;">
<?php
  if(isset($data1)){
    foreach($data1 as $v1){
      echo '<div ><a href="announcementshow.php?album_id='.$v1['album_id'].'" style="color:#FFFFFF;"><div style="width:350px;float:left;"><img src="img/btn2/services.png" width="16" height="16" />'.$v1['album_title'].'</div><div style="width:200px;float:left;">'.$v1['album_date'].'</div></a></div>'."\n";
    }
  }
  if(isset($data2)){
    foreach($data2 as $v1){
      echo '<div id="food" style="clear:both;"><a href="life_foodshow.php?food_id='.$v1['food_id'].'" style="color:#FFFFFF;"><div style="width:350px;float:left;"><img src="img/btn2/kugar.png" width="16" height="16" />'.$v1['food_name'].'</div><div style="width:200px;float:left;">'.$v1['food_date'].'</div></a></div>'."\n";
    }
  }
  if(isset($data3)){
    foreach($data3 as $v1){
      echo '<div id="cloth" style="clear:both;"><a href="life_clothshow.php?cloth_id='.$v1['cloth_id'].'" style="color:#FFFFFF;"><div style="width:350px;float:left;"><img src="img/btn2/kugar.png" width="16" height="16" />'.$v1['cloth_name'].'</div><div style="width:200px;float:left;">'.$v1['cloth_date'].'</div></a></div>'."\n";
    }
  }
  if(isset($data4)){
    foreach($data4 as $v1){
      echo '<div id="live" style="clear:both;"><a href="life_livingshow.php?living_id='.$v1['living_id'].'" style="color:#FFFFFF;"><div style="width:350px;float:left;"><img src="img/btn2/kugar.png" width="16" height="16" />'.$v1['living_name'].'</div><div style="width:200px;float:left;">'.$v1['living_date'].'</div></a></div>'."\n";
    }
  }
  if(isset($data5)){
    foreach($data5 as $v1){
      echo '<div id="walk" style="clear:both;"><a href="life_walkshow.php?walk_id='.$v1['walk_id'].'" style="color:#FFFFFF;"><div style="width:350px;float:left;"><img src="img/btn2/kugar.png" width="16" height="16" />'.$v1['walk_name'].'</div><div style="width:200px;float:left;">'.$v1['walk_date'].'</div></a></div>'."\n";
    }
  }
  if(isset($data6)){
    foreach($data6 as $v1){
      echo '<div id="teach" style="clear:both;"><a href="life_teachshow.php?teach_id='.$v1['teach_id'].'" style="color:#FFFFFF;"><div style="width:350px;float:left;"><img src="img/btn2/kugar.png" width="16" height="16" />'.$v1['teach_name'].'</div><div style="width:200px;float:left;">'.$v1['teach_date'].'</div></a></div>'."\n";
    }
  }
  if(isset($data7)){
    foreach($data7 as $v1){
      echo '<div id="happy" style="clear:both;"><a href="life_happyshow.php?happy_id='.$v1['happy_id'].'" style="color:#FFFFFF;"><div style="width:350px;float:left;"><img src="img/btn2/kugar.png" width="16" height="16" />'.$v1['happy_name'].'</div><div style="width:200px;float:left;">'.$v1['happy_date'].'</div></a></div>'."\n"; 
    }
  }
?>
    </div>
  </div>
  <div id="right_albums" style="float:left;width:170px">
<?php
  if(isset($data8)){
    foreach($data8 as $k1 => $v1){
?>
    <div>
      <a href="photosshow.php?<?php echo "album_id=".$v1['album_id'] ?>">
        <div style="height:120px;padding-top:25px;background-position: center; background-repeat: no-repeat; background-image: url(img/btn2/frame.gif);"><img src="backstage/photos/<?php echo $v1['ap_picurl']; ?>" width="100" height="95" border="0" /></div>
        <div style="color:#FFFFFF;"><?php echo $v1['album_title']; ?></div>
      </a>
    </div>
<?php
    }
  }
?>
  </div>
</div>
<?php require_once('basic_program_structure_foot.php'); ?>