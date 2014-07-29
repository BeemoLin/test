<script language="javascript" type="text/javascript" src="jquery-1.6.4.js"></script>
<?php
//感想：jquery不是必要的，但有了jquery真的很方便......
//光是篩選元素就省了不少功
//Bootstrap也很讚!
?>
<script>
<!--
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

function checkwords(obj){
//var obj;
//var max=10;
//obj.value=obj.value.substring(0,max);
}
//-->
</script>
<div style="clear:both;" align="center"><?php echo $main_name;?></div>
<div id="main">
  <div id="main_search_inc">
    <form method="post" action="">
      <table width="100%" border="1" cellspacing="1" cellpadding="1">
        <thead>
          <tr style="text-align:center">
            <?php if (empty($disable)||$disable=='0'){?><td style="width:152px">收件時間</td><?php }else{?><td style="width:152px">發件時間</td><?php }?>
            <td>住戶住址</td>
            <td style="width:96px">收件者</td>
            <td style="width:64px">信件類別</td>
            <td style="width:64px">貨運公司</td>
            <td style="width:108px">函件編號</td>
            <td style="width:48px">狀態</td>
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
            if(empty($disable)||$disable=='0'){
            echo 'tb1="'.$row["takes_time"].'" ';
            }
            else{
            echo 'tb1="'.$row["receives_time"].'" ';
            }
            echo '
            sends_add="'.$row["sends_add"].'"
            sends_name="'.$row["sends_name"].'"
            sign_code="'.$row["sign_code"].'"
            admin_sign_code="'.$row["admin_sign_code"].'"
            >'."\n";
            if(empty($disable)||$disable=='0'){echo "<td>".$row["receives_time"]."</td>\n";}else{echo "<td>".$row["takes_time"]."</td>\n";}
            //echo "<td>".$row["receives_time"]."</td>\n";
            echo "<td>".$row["m_address"]." - ".$row["m_username"]."</td>\n";
            echo "<td style=\"text-align:center\">".$row["receives_name"]."</td>\n";
            echo "<td style=\"text-align:center\">".$row["letter_category"]."</td>\n";
            echo "<td style=\"text-align:center\">".$row["letter_alt"]."</td>\n";
            echo "<td style=\"text-align:center\">".$row["letters_number"]."</td>\n";
            echo  "<td width=\"50px\" style=\"text-align:center\">";
            if($row["disable"]=="0"){
              echo "未發信";
            }else{
              echo "已發信";
            }
            echo  "</td>\n";
            echo "</tr>\n\n";
            $color_no++;
          }
        }
        ?>
        </tbody>
      </table>
      <div>
        <div align="right"><ul class="pagination"><?php echo $Firstpage.$Listpage.$Endpage."<br />\n";?></ul></div>
      </div>
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
      <div id="fastview" name="fastview" style="display: none;border: 2px solid gray;" >
        <img id="viewpic" name="viewpic" width="700" src='' />
      </div>
    </form>
  </div>
</div>