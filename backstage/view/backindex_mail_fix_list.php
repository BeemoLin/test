<?php 
//應該不會再使用
?>

<div align="center"><?php echo $main_name;?></div>
<div id="main">
    <div id="main_fix">
        <form method="post" action="backindex_mail.php">
        <input type="hidden" name="action_mode" value="fix_data">
            <table width="100%" border="1" cellspacing="1" cellpadding="1" align="left">
                <thead>
                    <tr>
                        <td>修    改</td>
                        <td>收件時間</td>
                        <!--<td>編列序號</td>-->
                        <td>住戶編號</td>
                        <td>收件者姓名</td>
                        <td>信件類別</td>
                        <td>函件編號</td>
                        <td>寄件者姓名</td>
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
                        echo "<tr style='background-color:".$color.";' onMouseOver='this.style.backgroundColor=\"#ffaaaa\"' onMouseOut='this.style.backgroundColor=\"".$color."\"'>\n";
                        echo "<td>"."&nbsp;".'<input type="checkbox" name="chkbox[]" value="'.$row["id"].'" />'."</td>\n";
                        echo "<td>".$row["receives_time"]."</td>\n";
                        //echo "<td>".$row["id"]."</td>\n";
                        echo "<td>".$row["householder_no"]."</td>\n";
                        echo "<td>".$row["receives_name"]."</td>\n";
                        echo "<td title='".$row["letter_alt"]."'>".$row["letter_category"]."</td>\n";
                        echo "<td>".$row['letters_number']."</td>\n";
                        echo "<td>".$row["sends_name"]."</td>\n";
                        echo "</tr>\n\n";
                        $color_no++;
                      }
                    }
                    ?>
                </tbody>
                <thead>
                  <tr>
                    <td colspan="11">
                      <input type="submit" value="確定送出">
                      <input type="reset" value="重新勾選">
                    </td>
                  </tr>
                </thead>
            </table>
            <div align="right"><ul class="pagination"><?php echo $Firstpage.$Listpage.$Endpage."<br />\n";?></ul></div>
        </form>
    </div>
</div>