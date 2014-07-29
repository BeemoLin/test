<?php
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);
require_once(CONNSQL);
require_once(PAGECLASS);

$action_mode=(isset($_POST['action_mode']))?$_POST['action_mode']:null;
$page=(isset($_POST['page']))?$_POST['page']:1;
$files=(isset($_FILES))?$_FILES:null;



// 讀取總筆數範例
$page = new data_function;

$page->setDb('webcount');
$data = $page->total();

echo $data."</br>";

// insert 範例
$pages = new data_function;
$pages->setDb('webcount');

$ip_address = "127.0.0.1";
$login_time = date("Y-m-d H:i:s");

$expression=" `count_ip` = '$ip_address', `count_time` = '$login_time' ";
$pages->insert($expression);

// select 範例
$page = new data_function;

$page->setDb('webcount');

$where_expression = " ORDER BY `count_id` DESC limit 0,10 ";
$select_expression = "`count_id`, `count_ip`, `count_time`";

$data = $page->select($where_expression, $select_expression);

foreach($data as $value)
{
	echo "ID:".$value["count_id"];
	echo "IP:".$value["count_ip"];
	echo "TIME:".$value["count_time"];
	echo "</br>";
}

// delete 範例
$page = new data_function;

$page->setDb('webcount');

$where_expression = " limit 0,10 ";
$select_expression = "`count_id`, `count_ip`, `count_time`";

// 取出第一筆資料
$data = $page->select($where_expression, $select_expression);

$first_data_id = $data[1]["count_id"];

echo "</br>delete id:".$first_data_id."</br>";

$where_expression = "AND `count_id` = $first_data_id ";

$pages->delete($where_expression);

// delete 範例
$page = new data_function;

$page->setDb('webcount');

$where_expression = " ORDER BY `count_id` DESC limit 0,10 ";
$select_expression = "`count_id`, `count_ip`, `count_time`";

// 取出第一筆資料
$data = $page->select($where_expression, $select_expression);

$last_data_id = $data[1]["count_id"];

echo "</br>last id:".$last_data_id."</br>";

$where_expression = "AND `count_id` = $last_data_id ";
$update_expression = "`count_ip` = '123.0.0.1'";

$pages->update($where_expression, $update_expression);

// 讀取總筆數範例
$page = new data_function;

$page->setDb('webcount');
$data = $page->total();

echo $data."</br>";

?>