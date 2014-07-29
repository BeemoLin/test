<script language="javascript" type="text/javascript" src="jquery-1.6.4.js"></script>
<script type="text/javascript" src="../includes/chkMail2.js"></script>
<script>
/*jQuery(function(){ 
}); 
全写为 
jQuery(document).ready(function(){ 
      
}); 

意义为在DOM加载完毕后执行了ready()方法。*/

  $(function () {
    
    //取得canvas context
    //alert('init');
    var ctxfirstopen = 0;
    var ctx2firstopen = 0;
   
    var $canvas = $("#cSketchPad");//取得元件
    var $canvas2 = $("#cSketchPad2");
   
    var ctx = $canvas[0].getContext("2d");//才可以繪圖
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
      
  
    //-------產生一塊畫布(白色的)-->可使用物件導向麼
    /*由PIC CLICK 在設定屬性
    ctx.lineCap = "round";//Sets or returns the style of the end caps for a line
    ctx2.lineCap = "round";
    ctx.fillStyle = "white"; //整個canvas塗上白色背景避免PNG的透明底色效果 Sets or returns the color, gradient, or pattern used to fill the drawing
    ctx2.fillStyle = "white"; //整個canvas塗上白色背景避免PNG的透明底色效果
    ctx.fillRect(0, 0, $canvas.width(), $canvas.height());//Draws a "filled" rectangle
    ctx2.fillRect(0, 0, $canvas2.width(), $canvas2.height());
    */
    //-------產生一塊畫布(白色的)
    //alert('產生畫布');
    
    var drawMode = false;
    
    //-----------------------------------畫圖的週期-----可使用javascript+ajax+timer繪圖------------------------------------
    //canvas點選、移動、放開按鍵事件時進行繪圖動作 座標系統與winform的座標系統一樣左上角(0,0)到右下角(screen.width,screen.height)
    $canvas.mousedown(function (e) {
      ctx.beginPath();
      ctx.strokeStyle = "black"; //Sets or returns the color, gradient, or pattern used for strokes
      ctx.lineWidth = "6";
      ctx.moveTo(e.pageX - $canvas.position().left, e.pageY - $canvas.position().top);//起點
      //alert(e.pageX);
      //alert(e.pageY);
      drawMode = true;//開始繪圖,當沒有按下,mousemove不畫圖
    })
    .mousemove(function (e) {
      if (drawMode) {
        ctx.lineTo(e.pageX - $canvas.position().left, e.pageY - $canvas.position().top);
        //alert(e.pageX);
        //alert($canvas.position().left);
        //alert(e.pageY);
        //alert($canvas.position().top);
        ctx.stroke();//Actually draws the path you have defined 
      }
    })
    .mouseup(function (e) {
      drawMode = false;//mousemove就不用畫圖
    });
    //-----------------------------------畫圖的週期------------------------------------------
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
    $("#bGenImage").click(function () 
    {
      var error_no=0;
      //var no_pic='data:image/png;base64,';
      var no_pic='';
      var no_picbase64="data:image/Png;base64,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";
      
      //alert("");
      //alert(document.getElementById("sign_code").value);
      //alert(document.getElementById("admin_sign_code").value);
      //20121204 mark
      //$("#sign_code")[0].value=$canvas[0].toDataURL();
      //$("#admin_sign_code")[0].value=$canvas2[0].toDataURL();
      
      
//----------------------------兩著都簽名才能信件發放-------------------------------------------------------------------------------------------
      if($("#sign_code")[0].value==no_pic || $("#sign_code")[0].value==no_picbase64) //javascript OR 查閱 
      {
        error_no++;
        alert("請收件者簽名");
      }
      else if($("#admin_sign_code")[0].value==no_pic || $("#admin_sign_code")[0].value==no_picbase64)
      {
        error_no++;
        alert("請管理員簽名");
      }
      else if(error_no==0)
      {
        $('#form').submit();
      }
      return false;
    });
    
    
    //清空頁面
    $("#bClearAll").click(function () 
    {
      ctx.fillRect(0, 0, $canvas.width(), $canvas.height());
      ctx2.fillRect(0, 0, $canvas2.width(), $canvas2.height());
    });
    $("#bClear1").click(function () 
    {
      ctx.fillStyle = "white"; 
      ctx.fillRect(0, 0, $canvas.width(), $canvas.height());
    });
    $("#bClear2").click(function () 
    {
      ctx.fillStyle = "white"; 
      ctx2.fillRect(0, 0, $canvas2.width(), $canvas2.height());
    });

///////////////////////////////////////////////////////////////////////
    
    $('#show_pic01').click(function()
    {//產生圖形元件
      
      /*
      ScreenWidth = document.documentElement.clientWidth;
      ScreenHeight = document.documentElement.clientHeight;
      locationX = document.documentElement.clientWidth/2;
      locationY = document.documentElement.clientHeight/2;
      
    
      $('#show_pic01').css({
        "position":"fixed",
        "top":+locationY+"px",
        "left":+locationX+"px",
        //"width":+ScreenWidth+"px",
        //"height":+ScreenHeight+"px"
      });
      document.bgColor="black";
        $('#show_pic01').css({
         "background-color":"#E7CDFF";
      });*/
      //$('#show_pic02').hide();
      if(document.getElementById("blockPicid").value=="UnLock")
      {
        //document.getElementById("showtext1").style.backgroundColor="#FF0000";
         document.getElementById("show_pic01").style.border= "8px solid red";
        document.getElementById("blockPicid").value="LOCK";
        //document.getElementById("show_pic01").style.backgroundColor="#C8C8C8 ";
        //  document.getElementById("show_pic02").hide();
        RunPicture("1");//藥袋參數 是住戶還是管理著
      }
      else
      {
          alert("使用中");
      }
      return;//即可不用把原本的程式註解
      

      window.document.documentElement.scrollTop = 0;
      $('#write01').show();
      $('#write01').css({
        "position":"fixed",
        "top":"1px",
        "left":"1px"
      });
      if(ctxfirstopen==0)
      {//一開始才有作用;並用全域變數記錄;並將元件的位置初始畫一次;因為javascript在Client端所以不會有refresh的問題
        //畫布的大小與銀幕同樣
        testsetwidth = document.documentElement.clientWidth;
        testsetheight = document.documentElement.clientHeight;
        //畫布的大小與銀幕同樣
        //alert(testsetwidth);
        //alert(testsetheight);
        
        testleft=(testsetwidth>=testsetheight)?testsetheight:testsetwidth;//取最小
        /*
        if(testsetwidth>=testsetheight)
        {
          testleft = testsetheight;
        }
        else
        {
          testleft = testsetwidth;
        }
        */
        //-----按鈕的位置--left,top--------
        closetop=testsetheight-60;
        closeleft=testsetwidth-107;
        
        cleartop=10;
        clearleft=testsetwidth-107;
        
        $('#saveclose01').attr("style","position:absolute;left:"+closeleft+"px;top:"+closetop+"px;");
        $('#bClear1').attr("style","position:absolute;left:"+clearleft+"px;top:"+cleartop+"px;");
        //-----按鈕的位置-----------
        
        //----畫布的位置起始點(0,0),寬與高=browser-------
        $canvas.attr("height",testsetheight+"px");
        $canvas.attr("width",testsetwidth+"px");
        $canvas.attr("style","position:absolute;left:0px;top:0px;width:"+testsetwidth+"px;height:"+testsetheight+"px;border:2px solid gray;");
        //----畫布的位置起始點(0,0),寬與高=browser-------
        
        ctxfirstopen++;
        //-----應該可以不用因為初始話就設定
        
        ctx.fillStyle = "white"; 
        ctx.fillRect(0, 0, $canvas.width(), $canvas.height());
        $("#space1_code")[0].value=$canvas[0].toDataURL();//存入全空白的圖片編碼; base64存圖檔的編碼用
        //alert( $("#space1_code")[0].value);
        //-----應該可以不用因為初始話就設定
      }
      
    });
    
    
    $('#show_pic02').click(function()
    {
      if(document.getElementById("blockPicid").value=="UnLock")
      {
        //document.getElementById("showtext2").style.backgroundColor="#FF0000";
          document.getElementById("show_pic02").style.border= "8px solid red";
        document.getElementById("blockPicid").value="LOCK";
        //document.getElementById("show_pic02").style.backgroundColor="#C8C8C8 ";
        RunPicture("2");//藥袋參數 是住戶還是管理著
       }
       else
       {
          alert("使用中");
       }
       return;//即可不用把原本的程式註解
       
      window.document.documentElement.scrollTop = 0;
      $('#write02').show();
      $('#write02').css({
        "position":"fixed",
        "top":"1px",
        "left":"1px"
      });
      if(ctx2firstopen==0)
      {
        testsetwidth = document.documentElement.clientWidth;
        testsetheight = document.documentElement.clientHeight;
        
        testleft=(testsetwidth>=testsetheight)?testsetheight:testsetwidth;
       /*
        if(testsetwidth>=testsetheight){
          testleft = testsetheight;
        }
        else{
          testleft = testsetwidth;
        }
        */
        closetop=testsetheight-60;
        closeleft=testsetwidth-107;
        cleartop=10;
        clearleft=testsetwidth-107;
        
        $('#saveclose02').attr("style","position:absolute;left:"+closeleft+"px;top:"+closetop+"px;");
        
        $('#bClear2').attr("style","position:absolute;left:"+clearleft+"px;top:"+cleartop+"px;");
        
        $canvas2.attr("height",testsetheight+"px");
        $canvas2.attr("width",testsetwidth+"px");
        $canvas2.attr("style","position:absolute;left:0px;top:0px;width:"+testsetwidth+"px;height:"+testsetheight+"px;border:2px solid gray;");
        
        ctx2.fillStyle = "white"; 
        ctx2.fillRect(0, 0, $canvas2.width(), $canvas2.height());
        $("#space2_code")[0].value=$canvas2[0].toDataURL();
        
        ctx2firstopen++;//之後再點入無作用
      }
      RunPicture();
    });
    
    $('#saveclose01').mousedown(function () 
    {//存檔mousedown的程式處理
      $("#sign_code")[0].value=$canvas[0].toDataURL();//存編碼;但還未存入資料庫
      $("#pic01")[0].src=$canvas[0].toDataURL();//使用 img src屬性顯示圖形
      ctx.save();//Saves the state of the current context
      $('#write01').hide();
      StopRunPicture();
      
    });
    
    $('#saveclose02').mousedown(function () 
    {
      $("#admin_sign_code")[0].value=$canvas2[0].toDataURL();
      $("#pic02")[0].src=$canvas2[0].toDataURL();
      ctx2.save();//Saves the state of the current context
      $('#write02').hide();
      StopRunPicture();
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
      <input type="hidden" name="blockPicid" id="blockPicid" value="UnLock"><!--20121203圖形用怕USER亂點--->
      <input type="hidden" name="action_mode" value="fix"><!--control-->
      <input type="hidden" name='sign_code' id="sign_code" />
      <input type="hidden" name='admin_sign_code' id="admin_sign_code" />
      <input type="hidden" name='space1_code' id="space1_code" /><!--存圖檔的編碼用-->
      <input type="hidden" name='space2_code' id="space2_code" />
      
      
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
          <!--<input type="hidden" name='sign_code' id="sign_code" />
          <input type="hidden" name='admin_sign_code' id="admin_sign_code" />
          <input type="hidden" name='space1_code' id="space1_code" />存圖檔的編碼用
          <input type="hidden" name='space2_code' id="space2_code" />-->
          <input type="button" id="bGenImage" value="確定送出"><!--檢查winform送入後端的攔位內容條件-->
          <input type="reset" value="清除重填">
          <input type="button" id="back" value="回上一頁" onClick="post_to_url('backindex_mail.php', {'action_mode':'give_list'})" />

        </div>
      </div>
      <div style="float: right; width: 450px; height: 950px;">

<!----------------------------------------畫圖的元件--現在不顯示------------------------------------------------------------------------------->
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
<!-----------------------------------------畫圖的元件--現在不顯示------------------------------------------------------------------------------->
       
<!-----------------------------------------使用CLICK放大canvas元件-----450*450---------------------------------------------------------------->
       
        <div id="dCanvas" style="float: right; text-align: center;">
           <!--<div id="showtext1" style="border: 2px solid gray; width: 10px; height: 10px;"></div>--> 收件者簽名：<br />
         <div  width="320" height="240" id="show_pic01" style="border: 2px solid gray; width: 320px; height: 240px;">
            <img width="320" height="240" id="pic01" style="width: 320px; height: 240px;" src="" /><!-- 使用src顯示picture-->
          </div>
        </div>

        <div id="dCanvas2" style="float: right; text-align: center;">
        <br /><!--<div id="showtext2" style="border: 2px solid gray; width: 10px; height: 10px;"></div>--> 管理員簽名：<br />
          <div width="320" height="240" id="show_pic02" style="border: 2px solid gray; width: 320px; height: 240px;">
            <img width="320" height="240" id="pic02" style="width: 320px; height: 240px;" src="" /><!-- 使用src顯示picture-->
          </div>
        </div>
      </div>
<!-----------------------------------------使用CLICK放大canvas元件--------------------------------------------------------------------->
    </form>
  </div>
</div>
