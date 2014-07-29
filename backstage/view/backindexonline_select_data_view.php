<link type="text/css" href="../system/jQuery/css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="../system/jQuery/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../system/jQuery/js/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="../system/jQuery/js/jquery.ui.datepicker-zh-TW.js"></script>
<script type="text/javascript">
function flevSubmitForm(){//v2.0
// Copyright 2002-2004, FlevOOware (www.flevooware.nl/dreamweaver/)
  var v1=arguments;
  if(v1[2]=="county"){
    //alert("T");
    document.getElementById('list_mode').value="allrefresh";
  }
  document.getElementById('action_mode').value="select_data";
  document.form1.submit();
}

function check_all(){
   document.getElementById('action_mode').value="selected_view";
    
    bigindex=document.getElementById('county').selectedIndex;
    midindex=document.getElementById('town').selectedIndex;
    smallindex=document.getElementById('zip').selectedIndex;

   document.getElementById('bigdetail').value=(bigindex>0)?document.getElementById('county').options[document.getElementById('county').selectedIndex].text:"";
   document.getElementById('middetail').value=(midindex>0)?document.getElementById('town').options[document.getElementById('town').selectedIndex].text:"";
   document.getElementById('smalldetail').value=(smallindex>0)?document.getElementById('zip').options[document.getElementById('zip').selectedIndex].text:"";
  
   document.form1.submit();
}
//-->
</script>
<script>
	$(function() {
		$( "#datepicker_from" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$( "#datepicker_to" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$( "#datepicker_from_repair" ).datepicker({ dateFormat: 'yy-mm-dd' });
		$( "#datepicker_to_repair" ).datepicker({ dateFormat: 'yy-mm-dd' });
	});
	</script>
<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;">
    <table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th class="555" scope="row"><span class="a">線上報修</span></th>
      </tr>
    </table>
      <p><a href="#" onclick="post_to_url('backindexonline.php', {'action_mode':'view_all_data'})" ><img src="images/btn2/報修單列表.jpg" /></a>　　<img src="images/btn2/搜尋報修單_.jpg" /></p>

<form id="form1" name="form1" method="post" action="backindexonline.php" >
<input type="hidden" name="action_mode" id="action_mode" value=""><!--selected_view-->

<!--201407 by akai-->
<input type="hidden" name="list_mode" id="list_mode" value="">

<input type="hidden" name="bigdetail" id="bigdetail" value="">
<input type="hidden" name="middetail" id="middetail" value="">
<input type="hidden" name="smalldetail" id="smalldetail" value="">
<!--201407 by akai-->

<table width="540" border="0" align="right" cellpadding="0" cellspacing="0">
  
  
    <tr>
    
    <!----2014/07/14 akai---->
      <!--<th width="270" align="left" scope="row">住戶編號</th>
      <th width="270" align="left" scope="row"><input name="exl_name" type="text" id="exl_name" value="" size="10"/></th>-->
    
    <th width="270" align="left" scope="row">住戶編號</th>
     <th width="270" align="left" scope="row">
           <select id="exl_name" name="exl_name" style="width:155px">
            <option selected="selected" value=''>-</option>
            <?php foreach ($houser as $row){ ?>
               
            <option value="<?php echo $row['m_username'];?>"  <?php if (!(strcmp($row['m_username'], @$_POST['exl_name']))) {echo "selected=\"selected\"";} ?> >
            <?php echo $row['m_username'];?></option>
            <?php }?>
          </select>
      </th> 
    <!----2014/07/14 akai---->
    </tr>
    <tr>
      <th align="left" scope="row">維修進度</th>
      <th align="left" scope="row">
        <select name="exl_yesno" id="exl_yesno">
          <option value="">-</option>
          <option value="未處理"  <?php if (@$_POST['exl_yesno']=="未處理"){echo "selected=\"selected\"";} ?>>未處理</option>
          <option value="維修中" <?php if (@$_POST['exl_yesno']=="維修中"){echo "selected=\"selected\"";} ?>>維修中</option>
          <option value="已完成" <?php if (@$_POST['exl_yesno']=="已完成"){echo "selected=\"selected\"";} ?>>已完成</option>
        </select>
    </th>
    </tr>
    <tr>
      <th align="left" scope="row">報修時間（起）&nbsp;</th>
      <th align="left" scope="row"><input name="from_date" type="text" id="datepicker_from" value="<?=@$_POST['from_date']?>" size="15"/></th>
    </tr>
    <tr>
      <th align="left" scope="row">報修時間（迄）&nbsp;</th>
      <th align="left" scope="row"><input name="to_date" type="text" id="datepicker_to" value="<?=@$_POST['to_date']?>" size="15"/></th>
    </tr>
    <tr>
      <th align="left" scope="row">完修時間（起）&nbsp;</th>
      <th align="left" scope="row"><input name="from_date_repair" type="text" id="datepicker_from_repair" value="<?=@$_POST['from_date_repair']?>" size="15"/></th>
    </tr>
    <tr>
      <th align="left" scope="row">完修時間（迄）&nbsp;</th>
      <th align="left" scope="row"><input name="to_date_repair" type="text" id="datepicker_to_repair" value="<?=@$_POST['to_date_repair']?>" size="15"/></th>
    </tr>
    
    <!--------201407 by akai------------>
                              <tr>
                                <th align="left" scope="row">報修位置</th> <th><select name="county" id="county" onchange="flevSubmitForm('form1','backindexonline.php','county');return document.MM_returnValue">
                                <?php
                                  foreach($re_fix1 as $row){
                                  ?>
                                    <option value="<?php echo $row['cID']?>" <?php if (!(strcmp($row['cID'], @$_POST['county']))) {echo "selected=\"selected\"";} ?>>
                                    <?php echo $row['cName']?>
                                    </option>
                                    <?php
                                    }
                                ?>
                                </select> 
                                </th>
                              </tr>
                              <tr>
                                <th align="left" scope="row">報修類別</th><th> <select name="town" id="town" onchange="flevSubmitForm('form1','backindexonline.php','');return document.MM_returnValue">
                                <?php
                                //do {
                                foreach($re_fix2 as $row){
                                  ?>
                                    <option value="<?php echo $row['tID']?>" <?php if (!(strcmp($row['tID'], @$_POST['town']))) {echo "selected=\"selected\"";} ?>>
                                    <?php echo $row['tName']?>
                                    </option>
                                    <?php
                                    }
                                /*} while ($row_re_fix2 = mysql_fetch_assoc($re_fix2));
                                $rows = mysql_num_rows($re_fix2);
                                if($rows > 0) {
                                  mysql_data_seek($re_fix2, 0);
                                  $row_re_fix2 = mysql_fetch_assoc($re_fix2);
                                }*/
                                ?>
                                </select>  
                                </th>
                              </tr>
                              <tr>
                                <th align="left" scope="row">報修細類</th> <th><select name="zip" id="zip">
                                <?php
                                //do {
                                 foreach($re_fix3 as $row){
                                  ?>
                                    <option value="<?php echo $row['zCode']?>" <?php if (!(strcmp($row['zCode'], @$_POST['zip']))) {echo "selected=\"selected\"";} ?>>
                                    <?php echo $row['zName']?>
                                    </option>
                                    <?php
                                    }
                                /*} while ($row_re_fix3 = mysql_fetch_assoc($re_fix3));
                                $rows = mysql_num_rows($re_fix3);
                                if($rows > 0) {
                                  mysql_data_seek($re_fix3, 0);
                                  $row_re_fix3 = mysql_fetch_assoc($re_fix3);
                                }*/
                                ?>
                                </select> 
                                </th>
                              </tr>
     <!--------201407 by akai------------>
    <tr>
      <th colspan="2" align="right" scope="row"><!--<input type="submit" name="submit" value="搜尋報修資料" />-->
      <input type="button" name="button1" id="button1" class="btn btn-info btn-sm" value="搜尋報修資料" onclick="check_all();" /> </th>
    </tr>
   
    </td>
  </tr>
</table>
