<div style="height:80px;"><!--排版用空白區塊--></div>
<div id="main">
  <div id="main_search">
  <br />
    <form method="post" action="backindex_mail.php">
      <input type="hidden" name="action_mode" value="select_list">
	  
		<div style="margin-bottom:20px;">
			關鍵字搜尋：<input name="keyword">
		</div>
		
		<div style="margin-bottom:20px;">
		    收件期間：
            <input name="receives_time_start" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})"> ～ 
            <input name="receives_time_end" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
		</div>
		
		<div style="margin-bottom:20px;">
		    發件期間：
            <input name="takes_time_start" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})"> ～ 
            <input name="takes_time_end" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
		</div>
		
		<div style="margin-bottom:20px;">
		    寄件者姓名：<input name="sends_name">
		</div>
		
		<div style="margin-bottom:20px;">
			寄件者地址：<input name="sends_add">
		</div>
		
		<div style="margin-bottom:20px;">
			住戶住址：<input name="householder_no">
		</div>
		
		<div style="margin-bottom:20px;">
			住戶編號：<input name="m_username">
		</div>
		
		<div style="margin-bottom:20px;">
			信件類別：</td>
			<select name="letter_category">
				<option selected="selected" value=''>請選擇信件種類</option>
				<?php
					foreach($data as $v) {
						echo '<option value="'.$v['type'].'">'.$v['type'].'</option>';
					}
				?>
			</select>
		</div>
		
		<div style="margin-bottom:20px;">
			函件編號：<input name="letters_number">
		</div>
		
		<div style="margin-bottom:20px;">
			收件者姓名：<input name="receives_name">
		</div>
		
		<div style="margin-bottom:20px;">
			狀態：
			<input type="radio" name="disable" value='' checked="checked"> 未設定</input>
			<input type="radio" name="disable" value='0'> 未發 </input>
			<input type="radio" name="disable" value='1'> 己發 </input>
		</div>
		
		<div style="margin-bottom:20px;">
			狀態：
      <input type="submit" class="btn btn-success" value="確定搜尋">&nbsp;
      <input type="reset" class="btn btn-warning" value="清除重填">&nbsp;
      <input type="button" class="btn btn-danger" value="返回" onclick="post_to_url('backindex_mail.php', {'action_mode':'view_all_data'})" >
		</div>
		
      <br />
    </form>
  </div>
</div>
