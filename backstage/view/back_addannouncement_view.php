<?php //預定刪除  ?>
<div id="right3_right">      
  <div class="subjectDiv"> 社區公告</div>
  <div class="actionDiv"></div>
  <div class="normalDiv">
    <form action="backindexannouncement.php" method="post" name="form1" id="form1">
      <input type="hidden" name="action_mode" value="add_category">
      <input type="hidden" name="tblname" value="news_album">
      <p>標題名稱：<input type="text" name="album_title" id="album_title" />
      </p>
      <p>發布時間：<input name="album_date" type="text" id="album_date" value="<?php echo date("Y-m-d");?>" readonly="readonly" />
      </p>
      <p>編輯者 ： <input name="album_location" type="text" id="album_location" value="管理員" readonly="readonly" />
      </p>
      <p>內容： <textarea name="album_desc" id="album_desc" cols="45" rows="5"></textarea>
      </p>
      <p>
        <input type="submit" class="btn btn-success" name="button" id="button" value="確定新增" />
        <input type="button" class="btn btn-danger" name="button2" id="button2" value="回上一頁" onclick="window.history.back();" />
      </p>
    </form>
  </div>
</div>
