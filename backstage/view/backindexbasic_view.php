<table border="0" cellpadding="0" cellspacing="0" id="right3_right">
  <tr>
    <td valign="top" style="width: 844px; height: 600px; position: absolute; overflow: auto;">
    <table width="348" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <th scope="row">
        <form id="form1" name="form1" method="post" action="backindexbasic.php">
          <input type="hidden" name="action_mode" value="add">
    <?php
      $i = 0;
      foreach($data as $V) {
    ?>
    <?php 
      if($i == 1){ 
        echo "<hr style='border-color:#AAA;'/>";
      }
        $i++;
    ?>
      <p>（<?php echo $V['allname']; ?> ） </p>
      <p>
      <label>
        <input name="<?php echo 'id'.$V['id']?>" type="hidden" value="<?php echo $V['id']; ?>" />
        <textarea name="<?php echo 'mail'.$V['id']?>" cols="40" rows="6"><?php echo $V['mail']; ?></textarea>
      </label>
      </p>
   <?php }?>
          <p>
            <input class="btn btn-success" type="submit" name="button" id="button" value="送出資料" />
          </p>
          <input type="hidden" name="MM_update" value="form1" />
        </form>
        </th>
      </tr>
    </table>
    </td>
  </tr>
</table>
