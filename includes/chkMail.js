var xmlHttp; 
var proc; 

function createXMLHttpRequest() { 
  if (window.ActiveXObject) { // IE 
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); 
  } 
  else if (window.XMLHttpRequest) { // Other browser 
    xmlHttp = new XMLHttpRequest();                
  } 
} 

function chkMail() { 
  createXMLHttpRequest(); 
  var letters_number = document.getElementById("letters_number").value; 
  var url = "mailCheck.php"; 

  xmlHttp.onreadystatechange = callback;  
  xmlHttp.open("POST", url, true); 
  xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded'); 
  var postData="letters_number=" + letters_number ; 
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
  var messageArea = document.getElementById("divAccount"); 
  var fontColor = "red"; 
  if (isValid == "true" || isValid == "True") { 
    fontColor = "green";                
  } 
  messageArea.innerHTML = "<font color=" + fontColor + ">" + message + " </font>";
}

function setCheck(lettercheck) {            
  document.getElementById("lettercheck").value=lettercheck; 
}