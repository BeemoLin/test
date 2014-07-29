<script type="text/javascript" src="../includes/chkMail.js"></script>
<script>

function checkFill(){


  var txt1 = document.getElementById('receives_name').value;
  var txt2 = document.getElementById('m_username').value;
  var txt3 = document.getElementById('letters_number').value;
  var txt4 = document.getElementById('letter_category').value;
  var txt5 = document.getElementById('letter_alt').value;
  var txt6 = document.getElementById('lettercheck').value;
  var txt7 = document.getElementById('sends_name').value;
  var txt8 = document.getElementById('addCname').value;
  txt8 = txt8.replace(/(^[\s]*)|([\s]*$)/g, "");
  
   
   
  if(txt4=="住戶代轉"){
    if (txt1==""){
      alert("請輸入收件者姓名");
    }
    else
    if(txt7==""){
      alert('請輸入寄件者姓名');
    }
    else{
      var Today = new Date();
      //document.getElementById('letters_number').value = Today.getFullYear()+'-'+Today.getMonth()+'-'+Today.getDate()+' '+Today.getHours()+':'+Today.getMinutes()+':'+Today.getSeconds();
      document.getElementById('letters_number').value = 'NOW( )';
      txt3 = 'NOW( )';
      txt5 = '管理室';
      //txt6 // 函件編號 AJAX 回報
      document.getElementById('add_mode').value = '住戶代轉';
      document.myForm.submit();
    }
  }
  else if(txt4==""){
    alert("請輸入信件類別");
  }
  else{
    //alert(document.getElementById('letter_alt').value);
    //alert('txt4!="住戶代轉" && txt4!=""');
    //alert('txt5='+txt5)
    if(txt5 == ""){
      //alert(1+'txt5'+1);
      alert("請選擇貨運公司");
    }
    else 
    if(txt5 == "其他" && txt8==""){
      alert("請輸入公司名稱");
    }
    else 
    if (txt1==""){
      alert("請輸入收件者姓名");
    }
    else 
    if(txt2==""){
      alert("請輸入收件者住址");
    }
    else
    if(txt3==""){
      alert("請輸入函件編號");
    }  
    else
    if(txt6=="0"){
      alert("函件編號不能重覆");
    }
    else{
     // alert("TEST");
      var myWindow =  window.open("../backstage/smsview.php?member="+txt2,"_blank","toolbar=no, scrollbars=no,titlebar=no, resizable=yes, top=0, left=500, width=700, height=700");
      
      document.getElementById('add_mode').value = '一般類別'; 
      document.myForm.submit();
    }
  }
}

function categoryChange(s){
  if (s == '住戶代轉'){
    document.getElementById("letter_alt_table").style.display = "none";
    document.getElementById("alt_option").disabled = "";
    document.getElementById("letter_alt").value = "管理室";
    //document.getElementById('letters_number_table').disabled = true;
    document.getElementById('letters_number_table').style.display = "none";
  }
  else{
    document.getElementById("letter_alt_table").style.display = "";
    document.getElementById("alt_option").disabled = "disabled";
    //document.getElementById("letter_alt").value = "";
    //document.getElementById('letters_number_table').disabled = false;
    document.getElementById('letters_number_table').style.display = "";
  }
}

function altChange(s){
  if (s == '其他'){
    //alert('其他');
    document.getElementById("disCname").style.display = "";
    document.getElementById("addCname").disabled = false;
  }
  else{
    document.getElementById("disCname").style.display = "none";
    document.getElementById("addCname").disabled = true;
  }
}

function CheckMaxlength(oInObj){
  var iMaxLen = parseInt(oInObj.getAttribute('maxlength'));
  var iCurLen = oInObj.value.length;
  if ( oInObj.getAttribute && iCurLen > iMaxLen ){
    oInObj.value = oInObj.value.substring(0, iMaxLen);
  }
}

function showUser(str) {
  if (str=="") {
      document.getElementById("txtHint").innerHTML="";
      return;
  }
  var xmlhttp;
  
  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
      add_option();
    }
  }
  
  xmlhttp.open("POST","backindex_mail.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("action_mode=getuser&user_name="+str);
}

function add_option(){
  json_data = document.getElementById("txtHint").innerHTML;

  if(json_data != null)
  {
    user_data = eval ("(" + json_data + ")")[1];
    
    var opt = document.createElement('OPTION');
    opt.text = user_data.m_name;// + " - " + user_data.m_phone;
    opt.value = user_data.m_name;// + " </br> " + user_data.m_phone;
        
    var opt1 = document.createElement('OPTION');
    opt1.text = user_data.m_car1;// + " - " + user_data.m_carmum1;
    opt1.value = user_data.m_car1;// + " </br> " + user_data.m_carmum1;
        
    var opt2 = document.createElement('OPTION');
    opt2.text = user_data.m_car2;// + " - " + user_data.m_carmum2;
    opt2.value = user_data.m_car2;// + " </br> " + user_data.m_carmum2;
        
    var opt3 = document.createElement('OPTION');
    opt3.text = user_data.m_car3;// + " - " + user_data.m_carmum3;
    opt3.value = user_data.m_car3;// + " </br> " + user_data.m_carmum3;
        
    var opt4 = document.createElement('OPTION');
    opt4.text = user_data.m_car4;// + " - " + user_data.m_carmum4;
    opt4.value = user_data.m_car4;// + " </br> " + user_data.m_carmum4;
        
    var opt5 = document.createElement('OPTION');
    opt5.text = user_data.m_car5;// + " - " + user_data.m_carmum5;
    opt5.value = user_data.m_car5;// + " </br> " + user_data.m_carmum5;
        
    document.getElementById('receives_name').options.length = 0;
    document.getElementById('receives_name').options.add(opt);
    
    if(opt1.text!=""){
      document.getElementById('receives_name').options.add(opt1);
    }
    
    if(opt2.text!=""){
      document.getElementById('receives_name').options.add(opt2);
    }
    
    if(opt3.text!=""){
      document.getElementById('receives_name').options.add(opt3);
    }
    
    if(opt4.text!=""){
      document.getElementById('receives_name').options.add(opt4);
    }
    
    if(opt5.text!=""){
      document.getElementById('receives_name').options.add(opt5);
    }
  }
}

function val() {
  user_id = "";
  json_data = "";
  user_data = "";

  json_data = document.getElementById("txtHint").innerHTML;

  if(json_data != "")
  {  
    user_data = eval ("(" + json_data + ")"); 
    user_id = user_data[1].m_id;
    post_to_url('backindexhouseholder.php', {'action_mode':'set_contact_view','m_id':user_id});
  }
  else
  {
    alert("請先選擇住戶地址");
  }
}

</script>

<div style="height:100px;"><!--排版用空白區塊--></div>
<div id="main">
  <div id="main_add">
    <form id="myForm" name="myForm" method="post" action="backindex_mail.php">
      <input type="hidden" name="action_mode" value="add">
      <input type="hidden" id="add_mode" name="add_mode" value="">
      <div>
        <div style="float:left;margin-bottom:20px;">
          <div style="float:left">
            <font style="color:red">*</font>信件類別　：
            <select id="letter_category" name="letter_category" style="width:155px" onchange="categoryChange(this.value)">
              <option selected="selected" value=''>請選擇信件種類</option>
              <?php foreach($data1 as $v) { ?>
              <option value="<?php echo $v['type'];?>"><?php echo $v['type'];?></option>
              <?php }?>
            </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          </div>
          <div id="letter_alt_table" style="float:left">
            <font style="color:red">*</font>貨運公司：<select id="letter_alt" name="letter_alt" style="width:155px" onchange="altChange(this.value)">
              <option selected="selected" value=''>請選擇公司名稱</option>
              <?php foreach($data3 as $v) { ?>
              <option value="<?php echo $v['Logistics_Company_Name'];?>"><?php echo $v['Logistics_Company_Name'];?></option>
              <?php }?>
              <option id="alt_option" value="管理室" disabled="disabled" style="display:none">管理室</option>
              <option value="其他">其他</option>
            </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          </div>
          <div id="disCname" style="float:left;display:none;" >
            公司名稱：<input id="addCname" name="addCname" disabled="disabled" />
          </div>
        </div>
        <div style="clear:both;margin-bottom:20px;"><font style="color:red">*</font>收件者住址：
          <select id="m_username" name="m_username" onchange="showUser(this.value);" style="width:155px">
            <option selected="selected" value=''>請選擇收件者地址</option>
            <?php foreach ($data2 as $row){ ?>
            <option value="<?php echo $row['m_username']; ?>"><?php echo $row['m_address'].' - '.$row['m_username'];?></option>
            <?php }?>
          </select>
        </div>
    <div style="clear:both;margin-bottom:20px;">
      <div id="txtHint" style="display:none"></div>
      <font style="color:red">*</font>收件者姓名： 
      <select id="receives_name" name="receives_name">
        <option selected="selected" value=''>請選擇收件地址</option>
      </select>
      <a href="#" class="btn btn-primary" onclick="val();">修改</a> 
    </div>
        <div id="letters_number_table" style="clear:both;" >
          <div style="float:left;">
            <font style="color:red">*</font>函件編號　：
            <input id="letters_number" name="letters_number"  onkeyup="chkMail()" AutoComplete="Off" />
            <input id="lettercheck" name="lettercheck" type="hidden" value="0" />
          </div>
          <div id="divAccount" style="float:left;margin-left:23px;"></div>
        </div>
        
        <div id="letters_number_table" style="clear:both;margin-bottom:20px;" >
          <font color="red">*函件編號請輸入數字或英文，如果輸入中文或符號會導致信件收件查詢異常。</font><br />
          <font color="red">&nbsp;如果沒有編號，請打年月日時分秒，只要號碼不重複(如20120701120033)就可以新增信件。</font>
        </div>
        
        <div style="clear:both;margin-bottom:20px;" >
          <font style="color:red">*</font>寄件者姓名： <input type="text" id="sends_name" name="sends_name" maxlength="10" onkeyup="CheckMaxlength(this);"/>
        </div>
        <div style="margin-bottom:20px;">&nbsp;&nbsp;寄件者地址： <input type="text" id="sends_add" name="sends_add" /></div>
        <div style="margin-bottom:20px;">&nbsp;&nbsp;收件時間　： <input type="text" id="receives_time" name="receives_time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" /></div>
        <div style="margin-bottom:20px;"><font style="color:red">*</font>是否通知住戶： <input id="show" name="show" type="radio" value="1" checked="checked" />是&nbsp;<input id="show" name="show" type="radio" value="0" />否&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <div style="margin-bottom:20px;">
          <input type="button" class="btn btn-success" value="確定送出" onClick="checkFill()">&nbsp;
          <input type="reset" class="btn btn-warning" value="清除重填">&nbsp;
          <input type="button" class="btn btn-danger" value="返回" onclick="post_to_url('backindex_mail.php', {'action_mode':'view_all_data'})" ></div>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  document.getElementById('m_username').selectedIndex = 0;
</script>
