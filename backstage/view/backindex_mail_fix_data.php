<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<script>
function checkFill(){
  var count_box=<?php echo count($chkbox);?>;
  var error_no=0;
  for(i=0;i<count_box;i++){
    receives_name = 'arr['+i+'][receives_name]';
    householder_no = 'arr['+i+'][householder_no]';
    letters_number = 'arr['+i+'][letters_number]';
    letter_category = 'arr['+i+'][letter_category]';
    letter_alt = 'arr['+i+'][letter_alt]';
    
    if(document.getElementById(householder_no).value==""){
      error_no++;
      alert("請輸入第 "+(i+1)+" 組住戶編號");
    }
    else if(document.getElementById(letter_category).value==""){
      error_no++;
      alert("請輸入第 "+(i+1)+" 組信件類別");
    }
    else if(document.getElementById(letter_alt).value==""){
      error_no++;
      alert("請輸入第 "+(i+1)+" 貨運公司");
    }    
    else if(document.getElementById(letters_number).value==""){
      error_no++;
      alert("請輸入第 "+(i+1)+" 組函件編號");
    }
    else if(document.getElementById(receives_name).value==""){
      error_no++;
      alert("請輸入第 "+(i+1)+" 組收件者姓名");
    }
    else if(error_no==0){
      document.myForm.submit();
    }
  }
}
</script>
<div align="center"><?php echo $main_name;?></div>
<div id="main">
    <div id="main_fix_table">
        <form name="myForm" method="post" action="backindex_mail.php">
          <input type="hidden" name="action_mode" value="fix">
          <table>
<?php
if(isset($data3)){
foreach ($data3 as $row){
  ?>        
          <tr>
            <td>編號：</td>
            <td><input name="" value='<?php echo $row["id"]; ?>' type='text' disabled='true'/><input name="arr[<?php echo $no; ?>][id]" value='<?php echo $row['id']; ?>' type='hidden' /></td>
          </tr>
          <tr>
            <td>收件時間：</td>
            <td><input name="" value='<?php echo $row['receives_time']; ?>' type='text' disabled='true'/><input name="arr[<?php echo $no; ?>][receives_time]" value='<?php echo $row['receives_time']; ?>' type='hidden' ></td>
          </tr>
          <tr>
            <td>信件取走時間：</td>
            <td><input name="arr[<?php echo $no; ?>][takes_time]" value='<?php echo $row['takes_time']; ?>' onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"></td>
          </tr>
          <tr>
            <td>寄件者姓名：</td>
            <td><input name="arr[<?php echo $no; ?>][sends_name]" value='<?php echo $row['sends_name']; ?>'></td>
          </tr>
          <tr>
            <td>寄件者地址：</td>
            <td><input name="arr[<?php echo $no; ?>][sends_add]" value='<?php echo $row['sends_add']; ?>'></td>
          </tr>
          <tr>
            <td>住戶編號：</td>
            <td>
              <select name="arr[<?php echo $no; ?>][householder_no]" id="arr[<?php echo $no; ?>][householder_no]" >
                <option <?php if($row['householder_no']==""){echo 'selected="selected"';}?> value=''>請選擇住戶</option>
<?php foreach($data2 as $v){ ?>
                <option value="<?php echo $v['m_address'].' - '.$v['m_username'];?>" <?php if($row['householder_no']==($v['m_address'].' - '.$v['m_username'])){echo 'selected="selected"';}?> ><?php echo $v['m_address'].' - '.$v['m_username'];?></option>
<?php }?>
              </select>
            </td>
          </tr>
          <tr>
            <td>信件類別：</td>
            <td>
              <select name="arr[<?php echo $no; ?>][letter_category]" id="arr[<?php echo $no; ?>][letter_category]">
                <option value=''>請選擇信件種類</option>
<?php foreach($data1 as $v) { ?>
                <option value="<?php echo $v['type'];?>" <?php if($row['letter_category']==$v['type']){echo "selected='selected'";}?> ><?php echo $v['type'];?></option>
<?php }?>
              </select>&nbsp;&nbsp;&nbsp;&nbsp;貨運公司：<input type="text" name="arr[<?php echo $no; ?>][letter_alt]" id="arr[<?php echo $no; ?>][letter_alt]" value='<?php echo $row['letter_alt']; ?>' />
            </td>
          </tr>
          <tr>
            <td>函件編號：</td>
            <td><input name="arr[<?php echo $no; ?>][letters_number]" id="arr[<?php echo $no; ?>][letters_number]" value='<?php echo $row['letters_number']; ?>'></td>
          </tr>
          <tr>
            <td>收件者姓名：</td>
            <td><input name="arr[<?php echo $no; ?>][receives_name]" id="arr[<?php echo $no; ?>][receives_name]" value='<?php echo $row['receives_name']; ?>'></td>
          </tr>
          <?php /*
          <tr>
            <td>管理員簽章：</td>
            <td><input name="arr[<?php echo $no; ?>][manager_signature]" value='<?php echo $row['manager_signature']; ?>'></td>
          </tr>
          */
          ?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
  <?php
		$no++;
    }
  }
?>
            <tr>
              <td></td>
              <td><input type="button" onClick="checkFill()" value="確定送出">&nbsp;<input type="reset" value="清除重填"></td>
            </tr>
          </table>       

        </form>
    </div>
</div>