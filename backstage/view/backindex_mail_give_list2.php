<script>
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
</script>
<div style="height:80px;"><!--排版用空白區塊--></div>
<div style="clear:both;" align="center"><?php echo $main_name;?></div>
<div id="main">
  <div id="main_fix">
    <form method="post" action="backindex_mail.php">
      <input type="hidden" name="action_mode" value="key_selected" />
      <input type="hidden" name="wkoa" value="keyin" />
      <input name="key" type="text" value="<?php if(isset($keyword)){echo $keyword; }?>" />
      <input name="name" class="btn btn-primary" type="submit" value="關鍵字搜尋" />
    </form>
    <form method="post" id="form2" action="backindex_mail.php">
      <input type="hidden" name="action_mode" value="give_data" />
      <input type="hidden" name="wkoa" value="turn" />
      <input type="hidden" name="key" value="<?php if(isset($keyword)){echo $keyword; }?>" />
      <table width="100%" border="1" cellspacing="1" cellpadding="1" align="left">
        <thead>
          <tr>
            <td style="width:32px">發放</td>
            <td style="width:152px">收件時間</td>
            <?php /*?><td>編列序號</td><?php */ ?>
            <td>住戶住址</td>
            <td style="width:96px">收件者</td>
            <td style="width:64px">信件類別</td>
            <td style="width:108px">函件編號</td>
            <td style="width:96px">寄件者</td>
          </tr>
        </thead>
        <tbody>
            <?php 
        $color_no=0;
        if(isset($data)){
          foreach($data as $row){
            /*
            if(($color_no%2)==1){
              $color = '#ddeedd';
            }
            else{
              $color = '#ddddee';
            }
            */
            $year = substr($row["receives_time"], 0 ,4);
            $month = substr($row["receives_time"], 5 ,2);
            $day = substr($row["receives_time"], 8 ,2);
            $timesub = mktime(0,0,0, date("m"), date("d"), date("Y") ) - mktime(0,0,0, $month, $day , $year );
            //$timesub = time() - mktime(0, 0,0 ,$month, $day , $year );
            
            if($timesub>(86400*3)){
              $color = '#ffaaaa';
            }
            else{
              $color = '#ddeedd';
            }
            
            echo "<tr style='background-color:".$color.";' onMouseOver='this.style.backgroundColor=\"#ddddee\"' onMouseOut='this.style.backgroundColor=\"".$color."\"'>\n";
            echo "<td>"."&nbsp;".'<input type="checkbox" name="chkbox[]" value="'.$row["id"].'" />'."</td>\n";
            echo "<td>".$row["receives_time"]."</td>\n";
            /*echo "<td>".$row["id"]."</td>\n";*/
            echo "<td>".$row["m_address"]." - ".$row["m_username"]."</td>\n";
            echo "<td>".$row["receives_name"]."</td>\n";
            echo "<td title='".$row["letter_alt"]."'>".$row["letter_category"]."</td>\n";
            echo "<td>".$row["letters_number"]."</td>\n";
            echo "<td>".$row["sends_name"]."</td>\n";
            echo "</tr>\n\n";
            //$color_no++;
          }
        }
            ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="11">
              <input type="button" class="btn btn-success" onClick="checksubmit()" value="確定送出">
              <input type="reset" class="btn btn-warning" value="重新勾選">
              <input type="button" class="btn btn-danger" value="返回" onclick="post_to_url('backindex_mail.php', {'action_mode':'view_all_data'})" >
            </td>
          </tr>
        </tfoot>
      </table>
      <div align="right"><ul class="pagination"><?php echo $Firstpage.$Listpage.$Endpage."<br />\n";?></ul></div>
    </form>
  </div>
</div>
        
