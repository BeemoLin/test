<table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
                    <td height="320">
                     
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>
                           <!-- <table border="0" cellpadding="0" cellspacing="0" id="pic3_left">
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                            </table>-->
                            <table border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td height="40"><img src="img/img/q_BTN.png" align="absmiddle" /> <span class="org"> <?=$equname?> </span>
                                      </td>
                                    </tr>
                                   <!-- <tr>
                                      <td height="30">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="38%" height="30" align="center">發佈時間：<?php //echo $row_RecAlbum['album_date']; ?>
                                            </td>
                                            <td width="62%">說明內容：<?php //echo nl2br(htmlspecialchars($row_RecAlbum['album_desc'])); ?>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>-->
                                    <tr>
                                      <td>
                                        <hr />
                                      </td>
                                    </tr>
                                   
				<!------------------------------------>


 				<tr>
          <td height="240">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
					                               <tr>
                                            <td width="13%" height="240">&nbsp;</td>
                                            <td width="79%" align="left" valign="top">
              
                                              <div class="popshow">
                                              <?php foreach($dataphoto as $key => $value){?>
                                                <div class="q">
                                                  <img src="backstage/maintlog_photo/<?=$value['check_picurl']?>" width="80" height="80"  rel="backstage/maintlog_photo/<?=$value['check_picurl']?>" /> <br />
                                                  <div class="albuminfo">
                                                  <?=$value['check_picurl_subject']?>
                                                  </div>
                                                </div>
                                                <?php }?>
                                              </div>
              
                                              <div id="next" class="more" style="display: none"></div>
                                              <div id="prev" class="more" style="display: none"></div>
                                            </td>
                                            <td width="8%">&nbsp;</td>
                                          </tr>
                                        </table>
            </td>
          </tr>
				<!------------------------------------->
                                    <tr>
                                      <td height="30">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                          
                                            <td width="19%" align="right"><input type="button" value="返回" onclick="post_to_url('checkmaintlist.php', {'equipment_id':'<?=$equipment_id?>'});">
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                    
                                    
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
    </tr>
                
</table>
