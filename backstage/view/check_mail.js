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

function check_mail() {
  createXMLHttpRequest(); 
  
  var mail = new Array();
  var m = 0;
  var postData = '';
  var s_inputs = document.getElementsByTagName('input');
  for(var k=0,l=s_inputs.length;k<l;k++){
    input1 = s_inputs[k];
    k++;
    input2 = s_inputs[k];
    if((input1.type == 'hidden') && (input2.type == 'hidden')){
      mail[m] = new Array(2);
      mail[m][0] = input1.value;
      mail[m][1] = input2.value;
      //alert(mail[m][0]);
      //alert(mail[m][1]);
      m++;
    }
  }
  
  for (var a = 0, b = mail.length; a < b; a++) {
    for (var c = 0, d = mail[a].length; c < d; c++){
      if(a == (b-1) && c == (d-1)){
        postData += 'mail'+a+c+'='+mail[a][c]+'<br />';
      }
      else{
        postData += 'mail'+a+c+'='+mail[a][c]+'&';
      }
    }
  }

  var url = "http://127.0.0.1/auto_get_mail.php"; 

  xmlHttp.onreadystatechange = callback;  
  xmlHttp.open("POST", url, true); 
  xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded'); 
  //var postData="key1=" + key1 + "&key2=" + key2 ; 
  xmlHttp.send(postData);
}

// 資料回傳之後，使用 callback 這個函數處理後續動作    
function callback() { 
  if ((xmlHttp.readyState == 4) && ((xmlHttp.status == 200) || (xmlHttp.status == 0))) { 
    //post_to_url('backindex_mail.php', {'action_mode':'add2'});
  }
  else{
  }
} 
