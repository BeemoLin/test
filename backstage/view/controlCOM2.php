<script src="controlCOM2.js" ></script>
<div style="clear:both;" align="center"><?php echo $main_name;?></div>
<div id="main">
  <div id="main_index">
    <form method="post" action="backindex_mail.php" >
    <?php
      $no=0;
      foreach ($mail as $k1 => $v1){
        foreach ($v1 as $k2 => $v2){
          //$mail[$k1][$k2]=$v2;
          $no++;
          echo '<input name="mail" id="k'.$no.'" type="hidden" value="'.$v2.'" />'."<br />\n";
        }
      }
    ?>

	  請稍等一下，信件設定中。
      <div id="divAccount" style="float:left;margin-left:23px;"></div>
    </form>
	<script>
	  contorlCOM2();
	</script>
  </div>
</div>