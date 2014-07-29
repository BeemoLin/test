<div style="height:90px;"><!--排版用空白區塊--></div>
<div style="clear:both;" align="center"><?php echo $main_name;?></div>
<div id="main">
  <div id="main_index">
    <form method="post" action="index.php">
      <table width="100%" border="1" cellspacing="1" cellpadding="1" align="left">
        <thead>
          <tr style="text-align:center">
            <td style="width:152px">收件時間</td>
            <td>住戶住址</td>
            <td style="width:96px">收件者</td>
            <td style="width:64px">信件類別</td>
            <td style="width:108px">函件編號</td>
            <td style="width:96px">寄件者</td>
          </tr>
        </thead>
        <tbody>
        <?php
        //$color_no=0;
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
            
            echo '<tr id="'.'list_data'.$color_no.'" style="background-color:'.$color.';" onMouseOver="this.style.backgroundColor=\'#ddddee\'" onMouseOut="this.style.backgroundColor=\''.$color.'\'">'."\n";
            echo "<td id='pic".$color_no."' >".$row["receives_time"]."</td>\n";
            echo "<td>".$row["m_address"]." - ".$row["m_username"]."</td>\n";
            echo "<td>".$row["receives_name"]."</td>\n";
            echo "<td title='".$row["letter_alt"]."'>".$row["letter_category"]."</td>\n";
            echo "<td>".$row["letters_number"]."</td>\n";
            echo "<td>".$row["sends_name"]."</td>\n";
            echo "</tr>\n";
            //$color_no++;
          }
        }
        ?>
        </tbody>
      </table>
      <br />
      <div align="right"><ul class="pagination"><?php echo $Firstpage.$Listpage.$Endpage;?></ul></div>
    </form>
  </div>
</div>



