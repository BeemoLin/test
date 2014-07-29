<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);

if(isset($_GET)){
	foreach($_GET as $key => $value){
		$$key = $value;
		echo '$'.$key.'='.$value."<br />\n";
	}
}
$sql="
DELETE FROM `equipment_reservation_list` 
WHERE `equipment_reservation_list`.`list_id` = ".$list_id." 
";

mysql_query($sql, $connSQL) or die(mysql_error());

    header("Location: reservation_list.php?equipment_id=".$equipment_id);
    exit('This mail send to your E-mail.');
?>