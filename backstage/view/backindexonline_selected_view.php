


<div id="right3_right" border="0" cellpadding="0" cellspacing="0" valign="top" >
    <div style="width: 844px;" border="0" cellspacing="0" cellpadding="0">線上報修</div>
    <div><a href="#" onclick="post_to_url('backindexonline.php', {'action_mode':'view_all_data'})" >報修單列表</a>　　搜尋報修單</div>
    <div style="width: 844px; float: left">
<?php 
if(isset($data)){
  foreach ($data as $k1 => $v1) { 
?>

        <table width="540" border="1" cellpadding="0" cellspacing="0" style="margin-bottom: 30px">
          <tr>
            <th width="270" align="left">住戶編號</th>
            <th width="270" align="left"><?php echo $v1['exl_name']; ?></th>
            <th width="270" align="left">維修狀態</th>
            <th width="270" align="left"><?php echo $v1['exl_yesno']; ?></th>
          </tr>
          <tr>
            <th width="270" align="left">維修項目</th>
            <th width="270" align="left"colspan="3"><?php echo $v1['exl_exl']; ?></th>
          </tr>	
          <tr>
            <th width="270" align="left">問題說明</th>
            <th width="270" align="left"colspan="3"><?php echo $v1['exl_adj']; ?></th>
          </tr>	
          <tr>
            <th width="270" align="left">報修時間</th>
            <th width="270" align="left"colspan="3"><?php echo $v1['exl_date']; ?></th>
          </tr>	
          <tr>
            <th width="270" align="left">完修時間</th>
            <th width="270" align="left" colspan="3"><?php echo $v1['exl_repair']; ?></th>
          </tr>	
          <tr>
            <th width="270" align="left">備註</th>
            <th width="270" align="left" colspan="3"><?php echo nl2br($v1['exl_remark']); ?></th>
          </tr>
        </table>
        
<?php 
  }
}
?>
    </div>
    <div>
						<table width="540" align="right" cellpadding="0" cellspacing="0" style="margin-bottom: 30px">
							<tr>
								<td align="right" >

									<form id="form2" name="form2" method="post" action="../includes/send_excel.php">
                    <input type="hidden" name="action_mode" value="to_excel" >
										<input type="hidden" name="exl_yesno" value="<?php echo  $_POST['exl_yesno']?>" />
										<input type="hidden" name="exl_name" value="<?php echo $_POST['exl_name']?>" />
										<input type="hidden" name="from_date" value="<?php echo $_POST['from_date']?>" />
										<input type="hidden" name="to_date" value="<?php echo $_POST['to_date']?>" />
										<input type="hidden" name="from_date_repair" value="<?php echo $_POST['from_date_repair']?>" />
										<input type="hidden" name="to_date_repair" value="<?php echo $_POST['to_date_repair']?>" />
										<input type="hidden" name="send_excel" value="10" >
										<?php
											if(isset($_POST['send_excel']) && $_POST['send_excel'] != ""){
												echo '<div id="dumiao"></div>'."\n";
											}										
										?>
										<input type="submit" name="submit2" class="btn btn-success" value="匯出報表" />
										<input type="button" name="submit2" class="btn btn-danger" value="回上一頁" onclick="window.history.back();"/>
									</form>

								</td>
							</tr>
            </table>
    </div>


</div>
