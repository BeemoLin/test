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
    <!--<form method="post" action="backindex_mail.php">
      <input type="hidden" name="action_mode" value="key_selected" />
      <input type="hidden" name="wkoa" value="keyin" />
      <input name="key" type="text" value="<?php //if(isset($keyword)){echo $keyword; }?>" />
      <input name="name" class="btn btn-primary" type="submit" value="關鍵字搜尋" />
    </form>-->
    <form method="post" id="form2" action="backindex_maintlog.php">
      <input type="hidden" name="action_mode" value="checkmaint">
      <!--<input type="hidden" name="equipment_id" value="<?//=$main_id?>">-->       
     <!-- <input type="hidden" name="wkoa" value="turn" />
      <input type="hidden" name="key" value="<?php //if(isset($keyword)){echo $keyword; }?>" />-->
      <table width="100%" border="1" cellspacing="1" cellpadding="1" align="left">
        <thead>
          <tr>
            <td style="width:32px">驗收</td>
            <td style="width:152px">保養日期</td>
            <td style="width:152px">設備名稱</td>
            <td style="width:96px">保養廠商</td>
            <td style="width:200px">備註</td>
           <!-- <td style="width:108px">函件編號</td>
            <td style="width:96px">寄件者</td>-->
          </tr>
        </thead>
        <tbody>
            <?php 
        
        //if(isset($data)){
          $color_no=0;
          foreach($maintData as $row){
         
            $color=ChangRowColor($row["maint_time"]);
            echo "<tr style='background-color:".$color.";' onMouseOver='this.style.backgroundColor=\"#ddddee\"' onMouseOut='this.style.backgroundColor=\"".$color."\"'>\n";
            echo "<td>"."&nbsp;".'<input type="radio" name="chkbox[]" onClick="checksubmit()" value="'.$row["uid"].'" />'."</td>\n"; //主索引 
            echo "<td>".$row["maint_time"]."</td>\n";
            echo "<td>".$equname."</td>\n";
            echo "<td>".$coname."</td>\n";
            echo "<td>".$row["remark"]."</td>\n";
            //echo "<td title='".$row["letter_alt"]."'>".$row["letter_category"]."</td>\n";
            // echo "<td>".$row["sends_name"]."</td>\n";
            echo "</tr>\n\n";
            //$color_no++;
          }
        //}
            ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="11">
              <!--把checkbox改成超連結訪社區公告<input type="button" class="btn btn-success" onClick="checksubmit()" value="確定送出">
              <input type="reset" class="btn btn-warning" value="重新勾選">-->
              <input type="button" class="btn btn-danger" value="返回設備列表" onclick="post_to_url('backindex_maint.php', {'action_mode':'index'})" >
            </td>
          </tr>
        </tfoot>
      </table>
      <div align="right"><ul class="pagination"><?php echo $Firstpage.$Listpage.$Endpage."<br />\n";?></ul></div>
    </form>
  </div>
</div>
        
