<script language="javascript" type="text/javascript" src="jquery-1.6.4.js"></script>
<script>
<!--
var str, obj;
var countbox;
function checksubmit(){
  obj = document.getElementsByName('chkbox[]');
  countbox=0
  for(i=0;i<=obj.length;i++){
    if(document.getElementsByName('chkbox[]')[i]){
      checkbox=document.getElementsByName('chkbox[]')[i];
      if(checkbox.checked == true){
        countbox++;
      }
    }
  }
  if(countbox<1){
    return false;
  }
  else{
    //alert(countbox);
    //document.forms[0].submit();
    document.getElementById('form2').submit();
  }
}

function show_list_data(no){
  
  var myid='list_data'+no;
  var setid='';
    if(document.getElementsByName(myid)[0].style.display=='none'){
      for(i=0;i<=9;i++){
        setid='list_data'+i;
        if(document.getElementsByName(setid)[0]){
          document.getElementsByName(setid)[0].style.display='none';
          document.getElementsByName(setid)[1].style.display='none';
        }
        if(document.getElementById(setid)){
          if(i!=no){
            document.getElementById(setid).style.display='none';
          }
        }
      }
     
      document.getElementsByName(myid)[0].style.display='';
      document.getElementsByName(myid)[1].style.display='';
    }
    else if(document.getElementsByName(myid)[0].style.display==''){
      for(i=0;i<=9;i++){
        setid='list_data'+i;
        if(document.getElementsByName(setid)[0]){
          document.getElementsByName(setid)[0].style.display='none';
          document.getElementsByName(setid)[1].style.display='none';
        }
        if(document.getElementById(setid)){
          if(i!=no){
            document.getElementById(setid).style.display='';
          }
        }
      }

      document.getElementsByName(myid)[0].style.display='none';
      document.getElementsByName(myid)[1].style.display='none';
    }
    else{
      for(i=0;i<=9;i++){
        setid='list_data'+i;
        if(document.getElementsByName(setid)){
          document.getElementsByName(setid)[0].style.display='none';
          document.getElementsByName(setid)[1].style.display='none';
        }
      }
    }
}

function show(name){
  $('#viewpic')[0].src=name;
  $('#fastview').show();
}

function closepic(){
  $('#fastview').hide();
}

function showtotable(tb){
  var my=tb;
  document.getElementById('tb1').innerHTML=my.getAttribute('tb1');
  //document.getElementById('sends_add').innerHTML=my.getAttribute('sends_add');
  //document.getElementById('sends_name').innerHTML=my.getAttribute('sends_name');
  document.getElementById('sign_code').src=my.getAttribute('sign_code');
  document.getElementById('admin_sign_code').src=my.getAttribute('admin_sign_code');
}

function show(name){
  $('#viewpic')[0].src=document.getElementById(name).src;
  //alert('asg');
  locationX = document.documentElement.clientWidth/2-100;
  locationY = document.documentElement.clientHeight/2-100; //1,1
  $('#fastview').css({
    "position":"fixed",
    "top":+locationY+"px",
    "left":+locationX+"px"
  });
  $('#fastview').show();
}

function closepic(){
  $('#fastview').hide();
}
//-->
</script>
<div style="clear:both;" align="center"><?php echo $main_name;?></div>
<div id="main">
    
    <div id="main_unenable">
      <form method="post" action="backindex_maintlog.php">
        <input type="hidden" name="action_mode" value="checkequyes" />
        <input type="hidden" name="wkoa" value="keyin" />
        <input type="hidden" name="equipment_id" value="<?=$maint_id?>" />
        <input name="keyword" type="text" value="<?php if(isset($keyword)){echo $keyword; }?>" />
        <input name="name" class="btn btn-primary" type="submit" value="關鍵字搜尋" />
      </form>
      
      <form method="post" id="form2" action="backindex_maintlog.php">
        <input type="hidden" name="action_mode" value="cancelcheck">
      	<input type="hidden" name="wkoa" value="turn" />
      	<input type="hidden" name="equipment_id" value="<?=$maint_id?>" />
      	<input name="keyword" type="hidden" value="<?php if(isset($keyword)){echo $keyword; }?>" />
            
            <table width="100%" style="text-align:center;" border="1" cellspacing="1" cellpadding="1"  align="left">
                <thead>
                  <tr>
                    <td style="width:100px">驗收時間</td>
                     <td style="width:100px">設備名稱</td>
                    <td style="width:96px">保養廠商</td>
                    <td style="width:200px">備註</td>
                    <!--<td style="width:64px">貨運公司</td>
                    <td style="width:108px">函件編號</td>-->
                    <?php if ($_SESSION['MM_UserGroup'] == '權限管理者'){?><td style="width:32px">取消</td><?php } ?>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                          $color_no=0;
                       // if(isset($data)){
                          foreach($data as $row){
                              
                              $color=CrossRowColor($color_no);
                              
                              echo '<tr id="'.'list_data'.$color_no.'" 
                                    style="background-color:'.$color.';" 
                                          onClick="showtotable(this)" 
                                          onMouseOver="this.style.backgroundColor=\'#ffaaaa\'" 
                                          onMouseOut="this.style.backgroundColor=\''.$color.'\'" ';
                                    //if(empty($disable)||$disable=='0'){
                                    echo 'tb1="'.$row["maint_time"].'" ';
                                    //}
                                    //else{
                                    //echo 'tb1="'.$row["receives_time"].'" ';
                                    //}
                                    echo '
                                    sign_code="'.$row["maint_name"].'"
                                    admin_sign_code="'.$row["check_name"].'"
                                    >'."\n";  
                              
                              echo "<td id='pic".$color_no."' ".'onClick="show_list_data('.$color_no.')"'." >".$row["check_time"]."</td>\n";
                              echo "<td ".'onClick="show_list_data('.$color_no.')"'." >".$equname."</td>\n";
                              echo "<td ".'onClick="show_list_data('.$color_no.')"'." >".$coname."</td>\n";
                              echo "<td ".'onClick="show_list_data('.$color_no.')"'." >".$row["remark"]."</td>\n";
                              //echo "<td ".'onClick="show_list_data('.$color_no.')"'." >".$row["letter_alt"]."</td>\n";
                              //echo "<td ".'onClick="show_list_data('.$color_no.')"'." >".$row["letters_number"]."</td>\n";
                              if ($_SESSION['MM_UserGroup'] == '權限管理者'){echo "<td>"."&nbsp;".'<input type="checkbox" name="chkbox[]" value="'.$row["uid"].'" />'."</td>\n";}
                              echo "</tr>\n";
                              $color_no++;
                          }
                       // }
                    ?>
                </tbody>
                <tfoot>
                  <tr>
                  <td colspan="11">
                  <?php if ($_SESSION['MM_UserGroup'] == '權限管理者'){?>
                    <input type="submit" class="btn btn-success" value="確定送出">
                    <input type="reset" class="btn btn-warning" value="重新勾選">
                  <?php }?>
                    <input type="button" class="btn btn-danger" value="返回設備列表" onclick="post_to_url('backindex_maint.php', {'action_mode':'index'})" >
                  </td>
                  </tr>
                </tfoot>
            </table>
            <div align="right"><ul class="pagination"><?php echo $Firstpage.$Listpage.$Endpage."<br />\n";?></ul></div>

            <div style="">
              <table style="width:100%;padding:0px;text-align:center;" width="100%"  border="1" cellspacing="1" cellpadding="1" style="text-align:center">
              <tr>
      <?php
     /* if(empty($disable)||$disable=='0'){
      echo "          <td style=\"width:152px\">發件時間</td>\n";
      }
      else{
      echo "          <td style=\"width:152px\">收件時間</td>\n";
      }*/
      echo "          <td style=\"width:152px\">保養日期</td>\n";
      ?>
                <!--<td>寄件者地址</td>
                <td style="width:96px">寄件者姓名</td>-->
                <td style="width:155px">保養人簽章</td>
                <td style="width:155px">驗收人簽章</td>
              </tr>
              <tr style="height:70px;">
                <td><div id="tb1">&nbsp;</div></td>
               <!-- <td><div id="sends_add">&nbsp;</div></td>
                <td><div id="sends_name">&nbsp;</div></td>-->
                <td style="width:155px;padding:0px;" OnMouseOver="show('sign_code')" OnMouseOut="closepic()"><img style="width:150px;" id="sign_code" /></td>
                <td style="width:155px;padding:0px;" OnMouseOver="show('admin_sign_code')" OnMouseOut="closepic()"><img style="width:150px;" id="admin_sign_code" /></td>
              </tr>
              </table>
            </div>

             <!---->
    
            <div id="fastview" style="width:320px;height:240px;display: none;border: 2px solid gray;" >
              <img id="viewpic" name="viewpic" width="320" height="240" src=''></img>
            </div>
        </form>
    </div>
</div>
