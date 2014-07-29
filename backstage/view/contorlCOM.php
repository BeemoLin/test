<script src="controlCOM.js" ></script>
<div style="clear:both;" align="center"><?php echo $main_name;?></div>
<div id="main">
  <div id="main_index">
    <form method="post" action="backindex_mail.php" >
	    <input name="key1" id="key1" type="hidden" value="<?php echo $key1;?>" />
	    <input name="key2" id="key2" type="hidden" value="<?php echo $key2;?>" />
      <div id="divAccount" style="float:left;margin-left:23px;">請稍等一下，信件設定中。</div>
    </form>
	<script>
	  contorlCOM();
	</script>
  </div>
</div>



