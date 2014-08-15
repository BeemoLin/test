<?php
class equipment extends data_function{
	var $equipment_id;//設備ID
	var $equipment_max_people;
	var $list_date;//日期
	var $list_time;//時間
	var $list_datetime;//日期時間
	var $m_id;//用戶ID
	var $limit;//開始顯示筆數
	
  var $count;                 // 資料筆數搜尋語法
  var $page_name;							// 連結頁
  var $action_mode;           // action_mode 型態
  var $records_per_page;      // 每頁顯示筆數
  var $now_page;              // 目前所在頁數  
  var $total_records;         // 資料總數
  var $total_pages;           // 總分頁數
  var $view_page;             // 可顯示頁數

	
	function set_equipment_id($equipment_id){
		$this->equipment_id = $equipment_id;
	}
	
	function set_equipment_max_people($equipment_max_people){
		$this->equipment_max_people = $equipment_max_people;
	}
	
	function set_list_date($list_date){
		$this->list_date = $list_date;
	}
	
	function set_list_time($list_time){
		$this->list_time = $list_time;
	}
	
	function set_datetime2($list_datetime = null){
		if(is_null($list_datetime)){
			$this->list_datetime = $this->list_date." ".$this->list_time;
		}
		else{
			$this->list_datetime = $list_datetime;
		}
	}
	
	function set_m_id($m_id){
		$this->m_id = $m_id;
	}

	function e_max_people(){//單一設備最多使用者 (return array $arr[key1][key2]
		$this->setDb('`equipment_reservation`');
		$select_expression = "`equipment_max_people`";
		$where_expression = "AND `list_disable` = '0' AND `equipment_reservation`.`equipment_id` = '".$this->equipment_id."'";
		$e_max_people = $this->select($where_expression, $select_expression);
		return $e_max_people;
	}
	
	function sum_number(){//單一設備在單一時間點全部人數累加 (return int $int
		$this->setDb('`equipment_reservation_list`');
		$select_expression = "SUM(`list_using_number`) as `number`";
		$where_expression = "AND `list_disable` = '0' AND `equipment_reservation_list`.`equipment_id` = '".$this->equipment_id."' AND `list_datetime` = '".$this->list_datetime."'";
		$e_sum_number = $this->select($where_expression, $select_expression);
		return $e_sum_number[1]['number'];
	}
	
	function count_number(){//單一設備在單一時間點全部筆數 (return int $int
		$this->setDb('`equipment_reservation_list`');
		$select_expression = "COUNT(*) AS `count_number`";
		$where_expression = "AND `list_disable` = '0' AND `equipment_reservation_list`.`equipment_id` = '".$this->equipment_id."' AND `equipment_reservation_list`.`list_datetime` = '".$this->list_datetime."'";
		$e_count_number = $this->select($where_expression, $select_expression);
		return $e_count_number[1]['count_number'];
	}
	
	function e_list_datetime($page=null){//list_datetime 的列表 (return array $arr[key1][key2])
		$this->setDb('`equipment_reservation_list`');
		//$select_expression = "list_datetime";
		//$where_expression = "AND `list_disable` = '0' AND `equipment_reservation_list`.`equipment_id` = '".$this->equipment_id."' GROUP BY `equipment_reservation_list`.`list_datetime` ORDER BY `list_datetime` DESC, `save_datetime` ASC";
		//$e_datetime_data = $this->select($where_expression, $select_expression);
		//die($this->sql);
    $count_no = mysql_query($this->sql) or die(mysql_error()); 
    $i=0;
    while($data = mysql_fetch_assoc($count_no)){
      $i++;
      foreach ($data as $key => $value){
        $returnData["$i"]["$key"] = $value;
      }
    }
    return $returnData;
	}
	
	function e_datetime_data(){//單一設備在單一時間點全部資料 (return array $arr[key1][key2]
		$from_DB = '
			`equipment_reservation_list` 
			LEFT JOIN `equipment_reservation` 
				ON `equipment_reservation_list`.`equipment_id` = `equipment_reservation`.`equipment_id` 
			LEFT JOIN `memberdata`
				ON `equipment_reservation_list`.`m_id` = `memberdata`.`m_id`
		';
		$this->setDb($from_DB);
		$select_expression = "*";
		$where_expression = "AND `list_disable` != '' AND `equipment_reservation_list`.`equipment_id` = '".$this->equipment_id."' AND `equipment_reservation_list`.`list_datetime` = '".$this->list_datetime."' ORDER BY `list_datetime` DESC, `list_disable` ASC";

		$e_datetime_data = $this->select($where_expression, $select_expression);
		return $e_datetime_data;
	}
	
	function e_my_reservation(){//使用戶在單一日使用單一器材是否有重覆預約 (return int $int
		$this->setDb('`equipment_reservation_list`');
		$select_expression = "COUNT(*) AS `check_reservation`";
		$where_expression = "AND `list_disable` = '0' AND `equipment_reservation_list`.`equipment_id` = '".$this->equipment_id."' AND `equipment_reservation_list`.`m_id` = '".$this->m_id."' AND `list_date` = '".$this->list_date."'";
		$e_count_number = $this->select($where_expression, $select_expression);
		return $e_count_number[1]['check_reservation'];
	}


  function setPerpage($records_per_page, $now_page = 1){     //設定每頁顯示筆數及取得資料數量、最大頁數
    $this->records_per_page = $records_per_page; //每頁顯示項目數量
    $count_no = mysql_query($this->ccount); 
		//die($this->ccount);
    $data1 = mysql_fetch_row($count_no); 
    $this->total_records = $data1[0];            //資料總數
    $this->total_pages = ceil($this->total_records/$this->records_per_page); //總分頁數
    if (empty($now_page)){
      $this->now_page = 1;                  //目前頁數
    }
    else{
      $this->now_page = $now_page;                  //目前頁數
    }
    $start = ($this->now_page-1) * $this->records_per_page;
    $this->sql = $this->sql." LIMIT ".$start." , ".$this->records_per_page."";
  }
	
  function set_base_page($page_name){
    $this->page_name = $page_name;
  }
	
  function action_mode($action_mode){
    $this->action_mode = $action_mode;
  }
	
  function getFirstpage2($page_name = null){                                  //取得第一頁
    //$page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'page\':\'1\'})">第一頁</a>'."&nbsp;" ;
		$page='<a href="#" onclick="post_to_url'."('".$this->page_name."', {'action_mode':'".$this->action_mode."','equipment_id':'".$this->equipment_id."','equipment_max_people':'".$this->equipment_max_people."','page':'1'})".'">第一頁</a>';
    return $page;
  }
  
  function getEndpage2($page_name = null){                                    //取得最終頁
    //$page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'page\':\''.$this->total_pages.'\'})">第終頁</a>' ;
		$page='<a href="#" onclick="post_to_url'."('".$this->page_name."', {'action_mode':'".$this->action_mode."','equipment_id':'".$this->equipment_id."','equipment_max_people':'".$this->equipment_max_people."','page':'".$this->total_pages."'})".'">第終頁</a>';
    return $page;
  }
  
  function getListpage2($view_page,$page_name = null){               					//取得頁數列表
    $page='';
    $this->view_page = $view_page;
    if($this->now_page-$this->view_page>1){
      $page.="...&nbsp;";
    }
    for($i=$this->now_page-$this->view_page;$i<$this->now_page;$i++){
      if($i>0){
        //$page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'page\':\''.$i.'\'})">'.$i.'</a>'."&nbsp;" ;
				$page.='<a href="#" onclick="post_to_url'."('".$this->page_name."', {'action_mode':'".$this->action_mode."','equipment_id':'".$this->equipment_id."','equipment_max_people':'".$this->equipment_max_people."','page':'".$i."'})".'">'.$i."</a>";
      }
    }
    //$page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'page\':\''.$this->now_page.'\'})" style="font-weight:bold;color:red;">'.$this->now_page.'</a>'."&nbsp;" ;
		$page.='<a href="#" onclick="post_to_url'."('".$this->page_name."', {'action_mode':'".$this->action_mode."','equipment_id':'".$this->equipment_id."','equipment_max_people':'".$this->equipment_max_people."','page':'".$i."'})".'">'.$i."</a>";
    for($i=$this->now_page+1;$i<=$this->now_page+$this->view_page;$i++){
      if($i<=$this->total_pages){
        //$page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'page\':\''.$i.'\'})">'.$i.'</a>'."&nbsp;" ;
				$page.='<a href="#" onclick="post_to_url'."('".$this->page_name."', {'action_mode':'".$this->action_mode."','equipment_id':'".$this->equipment_id."','equipment_max_people':'".$this->equipment_max_people."','page':'".$i."'})".'">'.$i."</a>";
      }
    }
    if($this->now_page+$this->view_page<$this->total_pages){
      $page.="...&nbsp;";
    }
    return $page;
  }

  function getData(){
    $this->returnData=null;
    $count_no = mysql_query($this->sql); 
    //echo $this->sql."<br>\n";
    $i=0;
    while($data = mysql_fetch_assoc($count_no)){
      $i++;
      foreach ($data as $key => $value){
        $returnData["$i"]["$key"] = $value;
      }
    }
    if (isset($returnData)){
      return $returnData;
    }
  }
	
  function e_set_sql(){
		$where_expression = "AND `list_disable` != '' AND `equipment_reservation_list`.`equipment_id` = '".$this->equipment_id."' GROUP BY `equipment_reservation_list`.`list_datetime` ORDER BY `list_datetime` DESC,`save_datetime` ASC ";
		$this->count = "SELECT count(1) FROM ".$this->dbname." where 1 = 1 ".$where_expression." ";
		$this->ccount = "SELECT count(1) FROM (SELECT count(1) FROM ".$this->dbname." where 1 = 1 ".$where_expression.") as `tab` ";
		$this->sql = "SELECT * FROM ".$this->dbname." where 1 = 1 ".$where_expression." ";
  }
}
?>
