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
  document.getElementById('sends_add').innerHTML=my.getAttribute('sends_add');
  document.getElementById('sends_name').innerHTML=my.getAttribute('sends_name');
  document.getElementById('sign_code').src=my.getAttribute('sign_code');
  document.getElementById('admin_sign_code').src=my.getAttribute('admin_sign_code');
}

function show(name){
  $('#viewpic')[0].src=document.getElementById(name).src;
  //alert('asg');
  $('#fastview').css({
    "position":"fixed",
    "top":"1px",
    "left":"1px"
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
      <form method="post" action="backindex_mail.php">
        <input type="hidden" name="action_mode" value="undisable_list" />
        <input type="hidden" name="wkoa" value="keyin" />
        <input name="keyword" type="text" value="<?php if(isset($keyword)){echo $keyword; }?>" />
        <input name="name" type="submit" value="關鍵字搜尋" />
      </form>
        <form method="post" id="form2" action="backindex_mail.php">
        <input type="hidden" name="action_mode" value="undisable">
      	<input type="hidden" name="wkoa" value="turn" />
      	<input name="keyword" type="hidden" value="<?php if(isset($keyword)){echo $keyword; }?>" />
            <table width="100%" style="text-align:center;" border="1" cellspacing="1" cellpadding="1"  align="left">
                <thead>
                  <tr>
                    <td style="width:152px">發件時間</td>
                    <td>住戶住址</td>
                    <td style="width:96px">收件者姓名</td>
                    <td style="width:64px">信件類別</td>
                    <td style="width:64px">貨運公司</td>
                    <td style="width:108px">函件編號</td>
                    <?php if ($_SESSION['MM_UserGroup'] == '權限管理者'){?><td style="width:32px">取消</td><?php } ?>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                        $color_no=0;
                        if(isset($data)){
                          foreach($data as $row){
                              if(($color_no%2)==1){
                                $color = '#ddeedd';
                              }
                              else{
                                $color = '#ddddee';
                              }

                              echo '<tr id="'.'list_data'.$color_no.'" 
                                    style="background-color:'.$color.';" 
                                          onClick="showtotable(this)" 
                                          onMouseOver="this.style.backgroundColor=\'#ffaaaa\'" 
                                          onMouseOut="this.style.backgroundColor=\''.$color.'\'" ';
                                    //if(empty($disable)||$disable=='0'){
                                    echo 'tb1="'.$row["takes_time"].'" ';
                                    //}
                                    //else{
                                    //echo 'tb1="'.$row["receives_time"].'" ';
                                    //}
                                    echo '
                                    sends_add="'.$row["sends_add"].'"
                                    sends_name="'.$row["sends_name"].'"
                                    sign_code="'.$row["sign_code"].'"
                                    admin_sign_code="'.$row["admin_sign_code"].'"
                                    >'."\n";  
                              
                              echo "<td id='pic".$color_no."' ".'onClick="show_list_data('.$color_no.')"'." >".$row["takes_time"]."</td>\n";
                              echo "<td ".'onClick="show_list_data('.$color_no.')"'." >".$row["m_address"]." - ".$row["m_username"]."</td>\n";
                              echo "<td ".'onClick="show_list_data('.$color_no.')"'." >".$row["receives_name"]."</td>\n";
                              echo "<td ".'onClick="show_list_data('.$color_no.')"'." >".$row["letter_category"]."</td>\n";
                              echo "<td ".'onClick="show_list_data('.$color_no.')"'." >".$row["letter_alt"]."</td>\n";
                              echo "<td ".'onClick="show_list_data('.$color_no.')"'." >".$row["letters_number"]."</td>\n";
                              if ($_SESSION['MM_UserGroup'] == '權限管理者'){echo "<td>"."&nbsp;".'<input type="checkbox" name="chkbox[]" value="'.$row["id"].'" />'."</td>\n";}
                              echo "</tr>\n";
                              
                              /*
                              echo '<tr name="'.'list_data'.$color_no.'" style="display:none;" >'."\n";
                              echo "<td>收件時間</td>\n";
                              echo "<td>寄件者地址</td>\n";
                              echo "<td>寄件者姓名</td>\n";
                              echo "<td>編列序號</td>\n";
                              echo "<td>收件者簽章</td>\n";
                              echo "<td>管理員簽章</td>\n";
                              //if ($_SESSION['MM_UserGroup'] == '權限管理者'){echo "<td>&nbsp;</td>\n";}
                              echo "</tr>\n";
                              
                              echo '<tr name="'.'list_data'.$color_no.'" style="display:none;background-color:'.$color.';" >'."\n";
                              echo "<td>".$row["receives_time"]."</td>\n";
                              echo "<td>".$row["sends_add"]."</td>\n";
                              echo "<td>".$row["sends_name"]."</td>\n";
                              echo "<td>".$row["id"]."</td>\n";
                              echo "<td>\n";
                              echo '<div OnMouseOver="show(\''.$row["sign_code"].'\')" OnMouseOut="closepic()" style="width:155px;">'."\n";
                              echo '<img src="'.$row["sign_code"].'" width="155px" " >';
                              echo '</div>'."\n";
                              echo "</td>\n";
                              echo "<td>\n";
                              echo '<div  OnMouseOver="show(\''.$row["admin_sign_code"].'\')" OnMouseOut="closepic()" style="width:155px;">'."\n";
                              echo '<img src="'.$row["admin_sign_code"].'" width="155px" " >';
                              echo '</div>'."\n";
                              echo "</td>\n";
                              //if ($_SESSION['MM_UserGroup'] == '權限管理者'){echo "<td>&nbsp;</td>\n";}
                              echo "</tr>\n";
                              
                              */
                              $color_no++;
                          }
                        }
                    ?>
                </tbody>
                <tfoot>
                  <tr>
                  <td colspan="11">
                  <?php if ($_SESSION['MM_UserGroup'] == '權限管理者'){?>
                    <input type="submit" value="確定送出">
                    <input type="reset" value="重新勾選">
                  <?php }?>
                    <input type="button" value="返回" onclick="post_to_url('backindex_mail.php', {'action_mode':'undisable_list'})" >
                  </td>
                  </tr>
                </tfoot>
            </table>
            <div align="right"><?php echo $Firstpage.$Listpage.$Endpage."<br />\n";?></div>

            <div style="">
              <table style="width:100%;padding:0px;text-align:center;" width="100%"  border="1" cellspacing="1" cellpadding="1" style="text-align:center">
              <tr>
      <?php
      if(empty($disable)||$disable=='0'){
      echo "          <td style=\"width:152px\">發件時間</td>\n";
      }
      else{
      echo "          <td style=\"width:152px\">收件時間</td>\n";
      }
      ?>
                <td>寄件者地址</td>
                <td style="width:96px">寄件者姓名</td>
                <td style="width:155px">收件者簽章</td>
                <td style="width:155px">管理員簽章</td>
              </tr>
              <tr style="height:70px;">
                <td><div id="tb1">&nbsp;</div></td>
                <td><div id="sends_add">&nbsp;</div></td>
                <td><div id="sends_name">&nbsp;</div></td>
                <td style="width:155px;padding:0px;" OnMouseOver="show('sign_code')" OnMouseOut="closepic()"><img style="width:150px;" id="sign_code" /></td>
                <td style="width:155px;padding:0px;" OnMouseOver="show('admin_sign_code')" OnMouseOut="closepic()"><img style="width:150px;" id="admin_sign_code" /></td>
              </tr>
              </table>
            </div>

            
            <div id="fastview" style="display: none;border: 2px solid gray;" >
              <img id="viewpic" name="viewpic" width="700" src=''></img>
            </div>
        </form>
    </div>
</div>
