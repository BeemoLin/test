  <table border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr>
      <td height="320">
        <div id="pic3">
            <div style="height:360px;width:560px;">
                    						
                 		<div style="float:left;width:560px">
                    	<div>
                        <table style="padding:0 20px;width:100%">
                    									<thead>
                    										<tr>
                    											<th scope="col" style="width:118px;">預約設備</th>
                    											<th scope="col" style="width:240px;">保養日期</th>
                    											<th scope="col" style="width:79px;">是否驗收</th>
                    										</tr>
                    									</thead>
                    			<tbody>
                    			
                    			<?php
                     
                              $no=0;
                    					foreach($data as $key => $value){
                    					$color=CrossRowColor((int)$value['check_state']);
                    					$yesno=((int)$value['check_state']>0)?"是":"否";
                    					$maintdate=split(" ",$value['maint_time']);
                             	  echo "<tr bgcolor=".$color.">"."\n";
                    						echo '<td style="text-align: center;">'.$equname."</td>\n";
                                echo '<td style="text-align: center;">'.$maintdate[0]."</td>\n";
                    					 	echo '<td style="text-align: center;">'.$yesno."</td>\n";
                    						echo "</tr>\n";
                    						$no++;
                    					}
                    			?>
                    			</tbody>
                    		</table>
                    	</div>
                    	<div style="float:right;"><?php echo $Firstpage.$Listpage.$Endpage;?></div>
                    	<div style="border: 0px solid; width: 1px; height: 30px;"></div>
                      <div style="float:right;"> <input type="button"  value="返回" onclick="post_to_url('maint.php', {'action_mode':'index'})" ></div>
                    </div>
              </div>
            </div>
          </div>
      </td>
    </tr>
</table>
