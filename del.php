<?php
/*
SELECT  album.album_id, 
        album.album_date, 
        album.album_title, 
        (albumphoto.ap_picurl) AS album_photo
FROM album 
INNER JOIN albumphoto ON album.album_id = albumphoto.album_id 
GROUP BY  album.album_id
  ORDER BY `album`.`album_date`  DESC
LIMIT 0 , 2
*/
?>
<?php do { ?>
  <?php if ($totalRows_RecAlbum > 0) { // Show if recordset not empty ?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="q1">
    <tr>
      <th height="115" align="center" valign="middle" style="background-position: center; background-repeat: no-repeat; background-image: url(img/btn2/frame.gif);" scope="row"><a href="photosshow.php?<?php echo "album_id=".urlencode($row_RecAlbum['album_id']) ?>"><img src="backstage/photos/<?php echo $row_RecAlbum['album_photo']; ?>" alt="{RecAlbum.album_title}" width="100" height="100" border="0" /></a></th>
      </tr>
    <tr>
      <th height="10" align="center" valign="top" scope="row"><p class="white"><?php echo $row_RecAlbum['album_title']; ?></p></th>
      </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<?php } while ($row_RecAlbum = mysql_fetch_assoc($RecAlbum)); ?>