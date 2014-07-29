<?php
class sam_class{
	function p_ip($get_p_ip){
		$qaz=$get_p_ip;
		$sql = "SELECT m_username, m_passwd, m_level, count(*) as inname FROM memberdata WHERE p_ip='$qaz' GROUP BY p_ip";
		$result = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$loginFoundUser = mysql_num_rows($result);
		if ($row["inname"] != 1){
			return "index.php";
		}
		else{
			if ($loginFoundUser) {
				$_SESSION['MM_Username'] = trim($row["m_username"]);
				$_SESSION['MM_UserGroup'] = trim($row["m_level"]);
				$_SESSION['enter_web'] = CONSTRUCTION_CASE;
				$_SESSION['from_web'] = "";
				$loginStrGroup = trim($row["m_level"]);
				return "index.php?masterpage=home";
			}
			else {
				$_SESSION['MM_Username'] = "";
				$_SESSION['MM_UserGroup'] = "";
				$_SESSION['enter_web'] = "";
				$_SESSION['from_web'] = "";
				return "index.php";
			}
		}
	}
	
	function masterpage($get_masterpage){
		if($get_masterpage=='home') {
			include 'include/first_page_template.php';
		}		
		elseif($get_masterpage=='announcement'){
			include 'include/announcement_template.php';
		}		
		elseif($get_masterpage=='opinion'){
			include 'include/opinion_template.php';
		}		
		elseif($get_masterpage=='order'){
			include 'include/order_template.php';
		}		
		elseif($get_masterpage=='share'){
			include 'include/share_template.php';
		}		
		elseif($get_masterpage=='life'){
			include 'include/life_template.php';
		}		
		elseif($get_masterpage=='photos'){
			include 'include/photos_template.php';
		}		
		elseif($get_masterpage=='money'){
			include 'include/money_template.php';
		}		
		elseif($get_masterpage=='online'){
			include 'include/online_template.php';
		}		
		elseif($get_masterpage=='QandA'){
			include 'include/QandA_template.php';
		}		
		elseif($get_masterpage=='rule'){
			include 'include/rule_template.php';
		}		
		elseif($get_masterpage=='info'){
			include 'include/info_template.php';
		}		
		else{
			include 'include/login_body_template.php';
		}
	}
	
	function checkuser($post_username,$post_password){
		$sql = "SELECT m_username, m_passwd, m_level, count(*) as inname  FROM memberdata WHERE m_username='$post_username' AND m_passwd='$post_password' GROUP BY p_ip";
		$result = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$loginFoundUser = mysql_num_rows($result);
		if ($row["inname"] != 1){
			return "index.php";
		}
		else{
			if ($loginFoundUser) {
				$_SESSION['MM_Username'] = trim($row["m_username"]);
				$_SESSION['MM_UserGroup'] = trim($row["m_level"]);
				$_SESSION['enter_web'] = CONSTRUCTION_CASE;
				$_SESSION['from_web'] = "";
				$loginStrGroup = trim($row["m_level"]);
				return "index.php?masterpage=home";
			}
			else {
				$_SESSION['MM_Username'] = "";
				$_SESSION['MM_UserGroup'] = "";
				$_SESSION['enter_web'] = "";
				$_SESSION['from_web'] = "";
				return "index.php";
			}
		}
	}
	
	function quotes_encode($content){
		if (!get_magic_quotes_gpc()) {
			if (is_array($content)) {
				foreach ($content as $key=>$value) {
					$content[$key] = addslashes($value);
				}
			}
			else {
				$content=addslashes($content);
			}
			echo "encode<br>\n";
		}
		return $content;
	}

	function quotes_decode($content){
		if (!get_magic_quotes_gpc()) {
			if (is_array($content)) {
				foreach ($content as $key=>$value) {
					$content[$key] = stripslashes($value);
				}
			}
			else {
				$content = stripslashes($content);	
			}
		echo "decode<br>\n";
		}
		return $content;
	}
}
?>