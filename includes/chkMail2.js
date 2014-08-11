var xmlHttp; 
var proc; 
var id;
var lno;
var picid;//哪個圖形元件
//20121130 增加讀取base64 圖形
var myTimer;


function createXMLHttpRequest() { 
  if (window.ActiveXObject) { // IE 
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); 
  } 
  else if (window.XMLHttpRequest) { // Other browser 
    xmlHttp = new XMLHttpRequest();                
  } 
} 
function RunPicture(which)
{
  picid=which;
  //alert(which);
  myTimer=setInterval(function(){GoBase64()},500);//c# 1sec寫入所以 一秒內最少有一次可以存取base64碼
}
function StopRunPicture()
{
  clearInterval(myTimer);
}
function GoBase64() 
{
   // alert("Timer is run");
    createXMLHttpRequest(); 
		var url = "writeboard.php"; //背景執行緒程式 //Http://127.0.0.1/writeboard.php
		var postData="ts=" + new Date().getTime(); 
		xmlHttp.onreadystatechange = callbackbase64;  
		xmlHttp.open("POST", url, true); 
		xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded'); 
		xmlHttp.send(postData);
		//alert(postData);
}
 
// 資料回傳之後，使用 callback 這個函數處理後續動作  
//AJAX的Debug:就是在  callback 使用alert方式;在背景處理的程式 加標籤;才可給alert使用
function callbackbase64() 
{ 
 // alert(xmlHttp.readyState +"======="+ xmlHttp.status);
   
  if ((xmlHttp.readyState == 4) && (xmlHttp.status == 200 || xmlHttp.status == 0)) 
  {
    //alert("CALLBACK");
      base64=xmlHttp.responseText;
       //alert(base64);
      if(base64=="STOP")
      {
        //alert("STOP");
        StopRunPicture();//close timer
        if(picid=="1")
        {
          //document.getElementById("showtext1").style.backgroundColor="#FFFFFF";
           document.getElementById("show_pic01").style.border= "0px solid gray";
        }
        else if(picid=="2")
        {
         // document.getElementById("showtext2").style.backgroundColor="#FFFFFF";
           document.getElementById("show_pic02").style.border= "0px solid gray";
        }
        document.getElementById("blockPicid").value="UnLock";
      }
      else if(base64!="")
      {
        //alert("GO");
       if(picid=="1")
        {
           document.getElementById("pic01").src=xmlHttp.responseText;
           document.getElementById("sign_code").value=xmlHttp.responseText;
        }
        else if(picid=="2")
        {
          document.getElementById("pic02").src=xmlHttp.responseText;
          document.getElementById("admin_sign_code").value=xmlHttp.responseText;
        }
       
      }
		/*
     var xmldoc = xmlHttp.responseXML; //回覆的XML丟給變數xmldoc
    if(xmldoc.getElementsByTagName("base64data")[0])//表示有撈到資料;沒撈到資料就沒這個標籤
    {
     
			//sql = xmldoc.getElementsByTagName("sql")[0].firstChild.data;
      //alert(sql);
       base64data = xmldoc.getElementsByTagName("base64data")[0].firstChild.data;
       base64mode = xmldoc.getElementsByTagName("base64mode")[0].firstChild.data;
       base64lock = xmldoc.getElementsByTagName("base64lock")[0].firstChild.data;
       
			 //alert(base64data);
		  //alert(check_reservation1);
			//sc_reservation1 = document.getElementById('show_check_reservation1');  
		 
				//sc_reservation1.innerHTML = "";正確;SHOW顯示預約時間
				if(base64mode=="1")//手寫板寫字中
				{
				  //document.getElementById("pic01").src="";
				  document.getElementById("pic01").src=base64data;
				}
				else if(base64mode=="0")
				{
          StopRunPicture();//close timer
          //alert("timer is stop");
        }
		}
		else
		{
        alert("LOCK住!!");
    
    }
    */
  }
} 

function chkMail(myno) { 
  createXMLHttpRequest(); 
  //getAttribute('tb1')
  //var id = myno.getAttribute(myno); 
  //var letters_number = document.getElementById("letters_number").value; 
  id = myno.getAttribute("myid");
  lno = myno.getAttribute("myno");
  var letters_number = myno.value;
  var url = "mailCheck2.php"; 

  xmlHttp.onreadystatechange = callback;  
  xmlHttp.open("POST", url, true); 
  xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded'); 
  var postData= "letters_number=" + letters_number + "&id=" + id ; 
  xmlHttp.send(postData);
  
}

// 資料回傳之後，使用 callback 這個函數處理後續動作    
function callback() { 
  if ((xmlHttp.readyState == 4) && (xmlHttp.status == 200)) { 
    var xmldoc = xmlHttp.responseXML; 
    var mes = xmldoc.getElementsByTagName("message")[0].firstChild.data; 
    var chk = xmldoc.getElementsByTagName("lettercheck")[0].firstChild.data; 
    setMessage(mes, 1); 
    setCheck(chk); 
  } 
} 

/* xmlHttp.readyState 所有可能的值： 
     0 (還沒開始), 
     1 (讀取中), 
     2 (已讀取), 
     3 (資訊交換中), 
     4 (一切完成) 

   xmlHttp.status 常見的值： 
     200 (一切正常), 
     404 (查無此頁), 
     500 (內部錯誤)    
*/      
  
function setMessage(message, isValid) {          
  var messageArea = document.getElementById("arr["+lno+"][check]"); 
  var fontColor = "red"; 
  if (isValid == "true" || isValid == "True") { 
    fontColor = "green";                
  } 
  messageArea.innerHTML = "<font color=" + fontColor + ">" + message + " </font>";
}

function setCheck(lettercheck) {            
  //document.getElementById("lettercheck").value=lettercheck; 
}
