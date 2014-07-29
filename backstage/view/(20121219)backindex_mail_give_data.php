<script language="javascript" type="text/javascript" src="jquery-1.6.4.js"></script>
<script type="text/javascript" src="../includes/chkMail2.js"></script>
<script>
  $(function () {
    
    //取得canvas context
    
    var ctxfirstopen = 0;
    var ctx2firstopen = 0;
    var $canvas = $("#cSketchPad");
    var $canvas2 = $("#cSketchPad2");
    var ctx = $canvas[0].getContext("2d");
    var ctx2 = $canvas2[0].getContext("2d");
    
    var testleft;
    var testsetwidth;
    var testsetheight;
      var myw;
      var myh;
      var test01;

        var closetop;
        var closeleft;
        var cleartop;
        var clearleft;
        
    ctx.lineCap = "round";
    ctx2.lineCap = "round";
    ctx.fillStyle = "white"; //整個canvas塗上白色背景避免PNG的透明底色效果
    ctx2.fillStyle = "white"; //整個canvas塗上白色背景避免PNG的透明底色效果
    ctx.fillRect(0, 0, $canvas.width(), $canvas.height());
    ctx2.fillRect(0, 0, $canvas2.width(), $canvas2.height());
    var drawMode = false;
    
    
    //canvas點選、移動、放開按鍵事件時進行繪圖動作
    $canvas.mousedown(function (e) {
      ctx.beginPath();
      ctx.strokeStyle = "black";
      ctx.lineWidth = "6";
      ctx.moveTo(e.pageX - $canvas.position().left, e.pageY - $canvas.position().top);
      drawMode = true;
    })
    .mousemove(function (e) {
      if (drawMode) {
        ctx.lineTo(e.pageX - $canvas.position().left, e.pageY - $canvas.position().top);
        ctx.stroke();
      }
    })
    .mouseup(function (e) {
      drawMode = false;
    });
    
    $canvas2.mousedown(function (e) {
      ctx2.beginPath();
      ctx2.strokeStyle = "black";
      ctx2.lineWidth = "6";
      ctx2.moveTo(e.pageX - $canvas2.position().left, e.pageY - $canvas2.position().top);
      drawMode = true;
    })
    .mousemove(function (e) {
      if (drawMode) {
        ctx2.lineTo(e.pageX - $canvas2.position().left, e.pageY - $canvas2.position().top);
        ctx2.stroke();
      }
    })
    .mouseup(function (e) {
      drawMode = false;
    });
    
    
    //利用.toDataqURL()將繪圖結果轉成圖檔
    $("#bGenImage").click(function () {
      var error_no=0;
      //var no_pic='data:image/png;base64,';
      var no_pic='';
      $("#sign_code")[0].value=$canvas[0].toDataURL();
      $("#admin_sign_code")[0].value=$canvas2[0].toDataURL();
     
      
      if($("#sign_code")[0].value==no_pic){
        error_no++;
        alert("請收件者簽名");
      }
      else if($("#admin_sign_code")[0].value==no_pic){
        error_no++;
        alert("請管理員簽名");
      }
      else if(error_no==0){
        $('#form').submit();
      }
      return false;
    });
    
    
    //清空頁面
    $("#bClearAll").click(function () {
      ctx.fillRect(0, 0, $canvas.width(), $canvas.height());
      ctx2.fillRect(0, 0, $canvas2.width(), $canvas2.height());
    });
    $("#bClear1").click(function () {
      ctx.fillStyle = "white"; 
      ctx.fillRect(0, 0, $canvas.width(), $canvas.height());
    });
    $("#bClear2").click(function () {
      ctx.fillStyle = "white"; 
      ctx2.fillRect(0, 0, $canvas2.width(), $canvas2.height());
    });

///////////////////////////////////////////////////////////////////////
    
    $('#show_pic01').click(function(){
      window.document.documentElement.scrollTop = 0;
      $('#write01').show();
      $('#write01').css({
        "position":"fixed",
        "top":"1px",
        "left":"1px"
      });
      if(ctxfirstopen==0){
        testsetwidth = document.documentElement.clientWidth;
        testsetheight = document.documentElement.clientHeight;
        if(testsetwidth>=testsetheight){
          testleft = testsetheight;
        }
        else{
          testleft = testsetwidth;
        }
        closetop=testsetheight-60;
        closeleft=testsetwidth-107;
        cleartop=10;
        clearleft=testsetwidth-107;
        $('#saveclose01').attr("style","position:absolute;left:"+closeleft+"px;top:"+closetop+"px;");
        $('#bClear1').attr("style","position:absolute;left:"+clearleft+"px;top:"+cleartop+"px;");
        $canvas.attr("height",testsetheight+"px");
        $canvas.attr("width",testsetwidth+"px");
        $canvas.attr("style","position:absolute;left:0px;top:0px;width:"+testsetwidth+"px;height:"+testsetheight+"px;border:2px solid gray;");
        ctxfirstopen++;
        ctx.fillStyle = "white"; 
        ctx.fillRect(0, 0, $canvas.width(), $canvas.height());
        $("#space1_code")[0].value=$canvas[0].toDataURL();
      }
    });
    
    
    $('#show_pic02').click(function(){
      window.document.documentElement.scrollTop = 0;
      $('#write02').show();
      $('#write02').css({
        "position":"fixed",
        "top":"1px",
        "left":"1px"
      });
      if(ctx2firstopen==0){
        testsetwidth = document.documentElement.clientWidth;
        testsetheight = document.documentElement.clientHeight;
        if(testsetwidth>=testsetheight){
          testleft = testsetheight;
        }
        else{
          testleft = testsetwidth;
        }
        closetop=testsetheight-60;
        closeleft=testsetwidth-107;
        cleartop=10;
        clearleft=testsetwidth-107;
        $('#saveclose02').attr("style","position:absolute;left:"+closeleft+"px;top:"+closetop+"px;");
        $('#bClear2').attr("style","position:absolute;left:"+clearleft+"px;top:"+cleartop+"px;");
        $canvas2.attr("height",testsetheight+"px");
        $canvas2.attr("width",testsetwidth+"px");
        $canvas2.attr("style","position:absolute;left:0px;top:0px;width:"+testsetwidth+"px;height:"+testsetheight+"px;border:2px solid gray;");
        ctx2firstopen++;
        ctx2.fillStyle = "white"; 
        ctx2.fillRect(0, 0, $canvas2.width(), $canvas2.height());
        $("#space2_code")[0].value=$canvas2[0].toDataURL();
      }
    });
    
    $('#saveclose01').mousedown(function () {
      $("#sign_code")[0].value=$canvas[0].toDataURL();
      $("#pic01")[0].src=$canvas[0].toDataURL();
      ctx.save();
      $('#write01').hide();
    });
    
    $('#saveclose02').mousedown(function () {
      $("#admin_sign_code")[0].value=$canvas2[0].toDataURL();
      $("#pic02")[0].src=$canvas2[0].toDataURL();
      ctx2.save();
      $('#write02').hide();
    });
  });

///////////////////////////////////////////////////////////////////////////////////////////////////////////  
  
function CheckMaxlength(oInObj){
  var iMaxLen = parseInt(oInObj.getAttribute('maxlength'));
  //var iMaxLen = 10;
  var iCurLen = oInObj.value.length;

  if ( oInObj.getAttribute && iCurLen > iMaxLen ){
    oInObj.value = oInObj.value.substring(0, iMaxLen);
  }
}

function categoryChange(s,t,u){
  if (s == '住戶代轉'){
    document.getElementById("alt_option").disabled = "";
    document.getElementById("alt_option").style.display = "";
    document.getElementById(t).value = "管理室";
    document.getElementById(u).value = "NOW( )";
    document.getElementById('letter_alt_table').style.display = "none";
    document.getElementById('letters_number_table').style.display = "none";
    
  }
  else{
    document.getElementById("alt_option").style.display = "none";
    document.getElementById("alt_option").disabled = "disabled";
    document.getElementById(t).options[0].selected = true;
    document.getElementById('letter_alt_table').style.display = "";
    document.getElementById('letters_number_table').style.display = "";
  }
}


</script>
<div style="clear: both;" align="center"><?php echo $main_name;?></div>
<div id="main">
  <div id="main_fix_table">
    <form name="form" id="form" method="post" action="backindex_mail.php">
      <input type="hidden" name="action_mode" value="fix">
      <div style="float: left; width: 300px;" id="signature">
<?php
      if(isset($data3)){
        foreach($data3 as $row) {
?>
        <div>
          編號　　　：<input name="" value='<?php echo $row["id"]; ?>' type='text' disabled='true' /><br /> 
                  <input name="arr[<?php echo $no; ?>][id]" value='<?php echo $row['id']; ?>' type='hidden' />
        </div>
        <div>
          收件時間　：<input name="" value='<?php echo $row['receives_time']; ?>' disabled='true'><br /> 
                  <input name="arr[<?php echo $no; ?>][receives_time]" value='<?php echo $row['receives_time']; ?>' type='hidden'>
        </div>
        <div>
          <font style="color: red">*</font>信件類別 ：<select name="arr[<?php echo $no; ?>][letter_category]" id="arr[<?php echo $no; ?>][letter_category]" onchange="categoryChange(this.value,'arr[<?php echo $no; ?>][letter_alt]','arr[<?php echo $no; ?>][letters_number]')">
            <option value=''>請選擇信件種類</option>
            <?php foreach($data1 as $v) { ?>
            <option value="<?php echo $v['type'];?>" <?php if($row['letter_category']==$v['type']){echo "selected='selected'";}?>>
            <?php echo $v['type'];?>
            </option>
            <?php }?>
          </select>
        </div>

        <div id="letter_alt_table" <?php if($row['letter_category']=="住戶代轉"){echo 'style="display:none"' ; } ?>>
          <font style="color: red">*</font>貨運公司 ：<select name="arr[<?php echo $no; ?>][letter_alt]" id="arr[<?php echo $no; ?>][letter_alt]">
            <option value=''>請選擇公司名稱</option>
            <?php foreach($data4 as $v) { ?>
            <option value="<?php echo $v['Logistics_Company_Name'];?>" <?php if($row['letter_alt']==$v['Logistics_Company_Name']){echo "selected='selected'";}?>>
            <?php echo $v['Logistics_Company_Name'];?>
            </option>
            <?php }?>
            <option id="alt_option" value="管理室" <?php if($row['letter_alt']=='管理室'){echo "selected='selected'";}?>>管理室</option>
          </select>
        </div>
        <div>
          <font style="color: red">*</font>收件者姓名：<input name="arr[<?php echo $no; ?>][receives_name]" id="arr[<?php echo $no; ?>][receives_name]" value='<?php echo $row['receives_name']; ?>'>
        </div>
        <div>
          <font style="color: red">*</font>住戶住址 ： <select name="arr[<?php echo $no; ?>][m_username]" id="arr[<?php echo $no; ?>][m_username]">
            <option <?php if($row['m_username']==""){echo 'selected="selected"';}?> value=''>請選擇住戶</option>
            <?php foreach($data2 as $v){ ?>
            <option value="<?php echo $v['m_username'];?>" <?php if($row['m_username']==($v['m_username'])){echo 'selected="selected"'; $_SESSION['arr'.$no]['old_username'] = $v['m_username']; }?>>
            <?php echo $v['m_address'].' - '.$v['m_username'];?>
            </option>
            <?php }?>
          </select><br />
        </div>
        <div id="letters_number_table" <?php if($row['letter_category']=="住戶代轉"){echo 'style="display:none"' ; } ?>>
          <div>
            <font style="color: red">*</font>函件編號 ：<input name="arr[<?php echo $no; ?>][letters_number]" id="arr[<?php echo $no; ?>][letters_number]" myid="<?php echo $row['id'];?>" myno="<?php echo $no;?>" onkeyup="chkMail(this)" AutoComplete="Off" value='<?php echo $row['letters_number']; ?>'>
          </div>
          <div id="arr[<?php echo $no; ?>][check]">&nbsp;</div>
        </div>
        <div>
          &nbsp;&nbsp;寄件者姓名：<input name="arr[<?php echo $no; ?>][sends_name]" maxlength="10" onkeyup="CheckMaxlength(this);" value='<?php echo $row['sends_name']; ?>'><br />
        </div>
        <div>
          &nbsp;&nbsp;寄件者地址：<input name="arr[<?php echo $no; ?>][sends_add]" value='<?php echo $row['sends_add']; ?>'><br />
        </div>
        <div>
          &nbsp;&nbsp;信件取走時間：<input name="arr[<?php echo $no; ?>][takes_time]" value='<?php echo $row['takes_time']; ?>' onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"><br />
        </div>
        <div>
          <font style="color: red">*</font>是否通知住戶：<input type="radio" name="arr[<?php echo $no; ?>][show]" id="arr[<?php echo $no; ?>][show][1]" value='1' <?php if($row['show']=='1'){ echo 'checked="checked"'; }?> />是&nbsp;<input type="radio" name="arr[<?php echo $no; ?>][show]" id="arr[<?php echo $no; ?>][show][0]" value='0' <?php if($row['show']=='0'){ echo 'checked="checked"'; }?> />否<br />
        </div>
        <br />
        <?php
        $no++;
        }
      }
      ?>
        <div style="float: left">
          <input type="hidden" name='sign_code' id="sign_code" />
          <input type="hidden" name='admin_sign_code' id="admin_sign_code" />
          <input type="hidden" name='space1_code' id="space1_code" />
          <input type="hidden" name='space2_code' id="space2_code" />
          <input type="button" id="bGenImage" value="確定送出">
          <input type="reset" value="清除重填">
          <input type="button" id="back" value="回上一頁" onClick="post_to_url('backindex_mail.php', {'action_mode':'give_list'})" />

        </div>
      </div>
      <div style="float: right; width: 450px; height: 950px;">

        <div name="write01" id="write01" style="display: none; position: absolute; left: 0px; top: 0px;">
          <div id="dCanvas">
            <canvas id="cSketchPad" style="position:absolute;left:360px;top:0px;border:2px solid gray;"></canvas>
            <img id="bClear1" alt="清除簽名" src="images/mail/write/clear.gif">
            <img id="saveclose01" alt="儲存離開" src="images/mail/write/save.gif">
          </div>
        </div>
        <div name="write02" id="write02" style="display: none; position: absolute; left: 0px; top: 0px;">
          <div id="dCanvas2">
            <canvas id="cSketchPad2" style="position:absolute;left:360px;top:0px;border:2px solid gray;"></canvas>
            <img id="bClear2" alt="清除簽名" src="images/mail/write/clear.gif">
            <img id="saveclose02" alt="儲存離開" src="images/mail/write/save.gif">
          </div>
        </div>

        <div id="dCanvas" style="float: right; text-align: center;">
          收件者簽名：<br />
          <div width="450" height="450" id="show_pic01" style="border: 2px solid gray; width: 450px; height: 450px;">
            <img width="450" height="450" id="pic01" style="width: 450px; height: 450px;" src="" />
          </div>
        </div>

        <div id="dCanvas2" style="float: right; text-align: center;">
        <br /> 管理員簽名：<br />
          <div width="450" height="450" id="show_pic02" style="border: 2px solid gray; width: 450px; height: 450px;">
            <img width="450" height="450" id="pic02" style="width: 450px; height: 450px;" src="" />
          </div>
        </div>
      </div>

    </form>
  </div>
</div>
