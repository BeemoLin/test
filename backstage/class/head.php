<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $_SESSION['MM_UserGroup']; ?>物管系統</title>
		<style type="text/css">
			<!--
			body {
				background-image: url();
				background-repeat: no-repeat;
				font-family: "微軟正黑體";
				font-size: 16px;
			}
			img {
				BORDER: 0px;
			}
			#allleft {
				float:left;
				width:180px;
				height:753px;
			}
			#allleft_top {
        background-image: url(images/logo.gif);
				height:180px;
				width:180px;
			}
			#allleft_botton {
        padding-left:40px;
				height:533px;
				width:180px;
			}
			#bulletin #opinion #equipment #share #photo #money #fix #list #info #rule #power #set #food #liveing {
				width:100px; 
				height:40px;
				border:0px;
			}
			.left_botton {
				width:100px; 
				height:40px;
				float:left;
				clear:both;
			}
			
			#allright {
				float:right;
				height:753px;
				width:844px;
			}
			#right1 {
				height:70px;
				width:844px;
			}
			
			#toplogo {
				float: left;
				height: 70px;
				width: 200px;
				/*background-image: url(../img/glee_toplogo.jpg);*/
				background-repeat: no-repeat;
				background-position: center center;
			}
			#top2 {
				float:left;
				height:70px;
				width:34px;
			}
			#top3 {
				float:left;
				height:70px;
				width:110px;
			}
			#top4 {
				float:left;
				height:70px;
				width:110px;
			}
			#top5 {
				float:left;
				height:70px;
				width:110px;
			}
			#top6 {
				float:left;
				height:70px;
				width:110px;
			}
			#top7 {
				float:right;
				height:70px;
				width:100px;
			}
			#right2 {
				height:1px;
				width:844px;
			}
			#right3 {
				width:844px;
			}
			#right3_letf {
				float:left;
				width:109px;
			}
			#right3_right {
				float:left;
				width:844px;
			}
			#right4 {
				height:54px;
				width:774px;
			}
			-->
		</style>
    <script language="javascript" type="text/javascript" src="../includes/My97DatePicker/WdatePicker.js"></script>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="../includes/bootstrap/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="../includes/bootstrap/css/bootstrap-theme.min.css">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="../includes/bootstrap/js/bootstrap.min.js"></script>

		<script language="javascript"  type="text/javascript">
				<!--
				function onMouseOverImage(me) {
					var me=document.getElementById(me)
					me.src='images/back_btn/'+me.id+'_over.gif';
				}
				function onMouseOutImage(me) {
					var me=document.getElementById(me)
					me.src='images/back_btn/'+me.id+'_out.gif';
				}
				//-->
        <!--

        function post_to_url(path, params, method) {
            method = method || "post"; // Set method to post by default, if not specified.

            // The rest of this code assumes you are not using a library.
            // It can be made less wordy if you use one.
            var form = document.createElement("form");
            form.setAttribute("method", method);
            form.setAttribute("action", path);

            for(var key in params) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);

                form.appendChild(hiddenField);
            }

            document.body.appendChild(form);    // Not entirely sure if this is necessary
            form.submit();
        }
        
        function post_url(p1,path, params, method){
          if(p1){
            post_to_url(path, params, method);
          }
        }
        //-->
		</script>
    
    </head>

	<body>
		<!--<div id="" style="height:753px;width:1024px;border:0px;padding:0px;border-spcing:0px">-->
		<div id="all" style="width:1024px;border:0px;padding:0px;border-spcing:0px">
			<div id="allleft" >
			<div id="allleft_top" onclick="javascript:location.href='backindex.php'"></div>
		  <div id="allleft_botton">
					<div class="left_botton"><img name="bulletin" id="bulletin" alt="社區公告" src="./images/back_btn/bulletin_out.gif" onmouseover="onMouseOverImage('bulletin')" onmouseout="onMouseOutImage('bulletin')" onclick="post_to_url('backindexannouncement.php', {'action_mode':'view_all_data'})" /></div>
					<div class="left_botton"><img name="opinion" id="opinion" alt="意見反應" src="./images/back_btn/opinion_out.gif" onmouseover="onMouseOverImage('opinion')" onmouseout="onMouseOutImage('opinion')" onclick="post_to_url('backindexopinion2.php', {'action_mode':'view_all_data'})" /></div>
					<!-- <div class="left_botton"><img name="equipment" id="equipment" alt="公設預約" src="./images/back_btn/equipment_out.gif" onmouseover="onMouseOverImage('equipment')" onmouseout="onMouseOutImage('equipment')" onclick="post_to_url('backindex_appointment.php', {'action_mode':'view_all_data'})" /></div> -->
					<div class="left_botton"><img name="equipment" id="equipment" alt="公設預約" src="./images/back_btn/equipment_out.gif" onmouseover="onMouseOverImage('equipment')" onmouseout="onMouseOutImage('equipment')" onclick="post_to_url('backindex_equipment.php', {'action_mode':'view_equipment_data'})" /></div>
					<!-- // <div class="left_botton"><img name="share" id="share" alt="分享園地" src="./images/back_btn/share_out.gif" onmouseover="onMouseOverImage('share')" onmouseout="onMouseOutImage('share')" onclick="post_to_url('backindex_share.php', {'action_mode':'view_all_data'})" /></div> // -->
					<div class="left_botton"><img name="photo" id="photo" alt="社區剪影" src="./images/back_btn/photo_out.gif" onmouseover="onMouseOverImage('photo')" onmouseout="onMouseOutImage('photo')" onclick="post_to_url('backindex_photo.php', {'action_mode':'view_all_data'})" /></div>
					<div class="left_botton"><img name="money" id="money" alt="財務報表" src="./images/back_btn/money_out.gif" onmouseover="onMouseOverImage('money')" onmouseout="onMouseOutImage('money')" onclick="post_to_url('backindex_money.php', {'action_mode':'view_all_data'})" /></div>
					<div class="left_botton"><img name="fix" id="fix" alt="線上報修" src="./images/back_btn/fix_out.gif" onmouseover="onMouseOverImage('fix')" onmouseout="onMouseOutImage('fix')" onclick="post_to_url('backindexonline.php', {'action_mode':'view_all_data'})" /></div>
					<div class="left_botton"><img name="list" id="list" alt="問閱調查" src="./images/back_btn/list_out.gif" onmouseover="onMouseOverImage('list')" onmouseout="onMouseOutImage('list')" onclick="post_to_url('backindex_qa.php', {'action_mode':'view_all_data'})" /></div>
					<!--div class="left_botton"><img name="info" id="info" alt="資訊連結" src="./images/back_btn/info_out.gif" onmouseover="onMouseOverImage('info')" onmouseout="onMouseOutImage('info')" onclick="post_to_url('backindex_info.php', {'action_mode':'view_all_data'})" /></div-->
					<div class="left_botton"><img name="operation" id="operation" alt="操作手冊" src="./images/back_btn/operation_out.gif" onmouseover="onMouseOverImage('operation')" onmouseout="onMouseOutImage('operation')" onclick="post_to_url('backindex_operation.php', {'action_mode':'view_all_data'})" /></div>
          <!-- // <div class="left_botton"><img name="rule" id="rule" alt="規約辦法" src="./images/back_btn/rule_out.gif" onmouseover="onMouseOverImage('rule')" onmouseout="onMouseOutImage('rule')" onclick="post_to_url('backindex_rule.php', {'action_mode':'view_all_data'})" /></div> // -->
          <div class="left_botton"><img name="rule" id="rule" alt="規約辦法" src="./images/back_btn/rule_out.gif" onmouseover="onMouseOverImage('rule')" onmouseout="onMouseOutImage('rule')" onclick="post_to_url('backindex_rules.php', {'action_mode':'view_all_data'})" /></div>
          <div class="left_botton"><img name="mail" id="mail" alt="郵件管理" src="./images/back_btn/mail_out.gif" onmouseover="onMouseOverImage('mail')" onmouseout="onMouseOutImage('mail')" onclick="post_to_url('backindex_mail.php', {'action_mode':'view_all_data'})" /></div>
				</div>
			</div>
			<div id="allright" >
				<div id="right1" >	
					<div id="toplogo" >
					</div>
					<div id="top2" >
					</div>
					<div id="top3" ><img name="power" id="power" alt="權限管理" src="./images/back_btn/power_out.gif" osrc="./images/back_btn/power_out.gif" onmouseover="onMouseOverImage('power')" onmouseout="onMouseOutImage('power')" onclick="post_to_url('backindexauthority.php', {'action_mode':'view_all_data'})"/></div>
					<div id="top4" ><img name="set" id="set" alt="基本設定" src="./images/back_btn/set_out.gif" osrc="./images/back_btn/set_out.gif" onmouseover="onMouseOverImage('set')" onmouseout="onMouseOutImage('set')" onclick="post_to_url('backindexbasic.php', {'action_mode':'view_all_data'})"/></div>
					<div id="top5" ><img name="food" id="food" alt="生活資訊" src="./images/back_btn/food_out.gif" osrc="./images/back_btn/food_out.gif" onmouseover="onMouseOverImage('food')" onmouseout="onMouseOutImage('food')" onclick="post_to_url('backindexlife.php', {'action_mode':'view_all_data'})"/></div>
					<div id="top6" ><img name="liveing" id="liveing" alt="住戶管理" src="./images/back_btn/liveing_out.gif" osrc="./images/back_btn/liveing_out.gif" onmouseover="onMouseOverImage('liveing')" onmouseout="onMouseOutImage('liveing')" onclick="post_to_url('backindexhouseholder.php', {'action_mode':'view_all_data'})"/></div>
					<div id="top7"><a href="logout.php"><img height="30" alt="登出" src="./images/logout.gif" width="40" border="0" /></a><a href="../logout.php"><img height="30" alt="前台首頁" src="./images/homepage.gif" width="40" border="0" /></a></div>
				</div>
        <div id="right2">
				</div>
        <div id="right3" >
					<div id="right3_letf" style="display:none;">目前沒用到</div>
