var xmlHttp; 
var chk

function createXMLHttpRequest() { 
  if (window.ActiveXObject) { // IE 
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); 
  } 
  else if (window.XMLHttpRequest) { // Other browser 
    xmlHttp = new XMLHttpRequest(); 
  } 
} 

function contorlCOM() {
  createXMLHttpRequest(); 
  var key1 = document.getElementById("key1").value; 
  var key2 = document.getElementById("key2").value; 
  var url = "http://127.0.0.1/control.php"; 

  xmlHttp.onreadystatechange = callback;  
  xmlHttp.open("POST", url, true); 
  xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded'); 
  var postData="key1=" + key1 + "&key2=" + key2 ; 
  xmlHttp.send(postData);
  //alert(postData);
}

// 資料回傳之後，使用 callback 這個函數處理後續動作
function callback() { 


  if (xmlHttp.readyState == 4){
    //post_to_url('backindex_mail.php', {'action_mode':'add2'});
		if(xmlHttp.status == 200){
			var xmldoc = xmlHttp.responseXML; 
			var mes = xmldoc.getElementsByTagName("message")[0].firstChild.data; 
			setMessage(mes, 1); 
		}
		else if(xmlHttp.status == 0){
			//alert('xmlHttp.status == 0');
			//setMessage(mes, 1); 
		}
		else{
			//alert('not OK1');
		}
  }
  else{
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
  var messageArea = document.getElementById("divAccount"); 
  var fontColor = "red"; 
  if (isValid == "true" || isValid == "True") { 
    fontColor = "green";
  } 
  //messageArea.innerHTML = "<font color=" + fontColor + ">" + message + " </font>";
  post_to_url('backindex_mail.php', {'action_mode':'add2'});
}
