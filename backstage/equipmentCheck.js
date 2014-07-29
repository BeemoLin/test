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

function selectEquipment() {
  createXMLHttpRequest(); 
  var equipment_id = document.getElementById("equipment_id").value; 
  var m_id = document.getElementById("m_id").value;
	if(equipment_id != 0){
		var url = "equipmentCheck.php"; 
    var postData="m_id=" + m_id + "&equipment_id=" + equipment_id ;

		xmlHttp.onreadystatechange = callback;  
		xmlHttp.open("POST", url, true); 
		xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded'); 
		xmlHttp.send(postData);
		//alert(postData);
	}
}

function checkNumber() {
  createXMLHttpRequest(); 
  var m_id = document.getElementById("m_id").value; 
  var equipment_id = document.getElementById("equipment_id").value; 
  var set_list_date = document.getElementById("list_date").value; 
  var set_list_time = document.getElementById("list_time").value; 
	if(m_id !=0 && equipment_id != 0){
		var url = "equipmentCheck.php"; 
		var postData="m_id=" + m_id + "&equipment_id=" + equipment_id + "&set_list_date=" + set_list_date + "&set_list_time=" + set_list_time; 

		xmlHttp.onreadystatechange = callback2;  
		xmlHttp.open("POST", url, true); 
		xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded'); 
		xmlHttp.send(postData);
		//alert(postData);
	}
}

// 資料回傳之後，使用 callback 這個函數處理後續動作    
function callback() { 
  if ((xmlHttp.readyState == 4) && (xmlHttp.status == 200)) { 
    var xmldoc = xmlHttp.responseXML; 
    advance_start = xmldoc.getElementsByTagName("advance_start")[0].firstChild.data; 
    advance_end = xmldoc.getElementsByTagName("advance_end")[0].firstChild.data; 
    equipment_exclusive = xmldoc.getElementsByTagName("equipment_exclusive")[0].firstChild.data; 
    equipment_max_people = xmldoc.getElementsByTagName("equipment_max_people")[0].firstChild.data; 
    document.getElementById("equipment_exclusive").value = equipment_exclusive;
    setWdatePicker(advance_start, advance_end, equipment_max_people); 
  }
} 

function setWdatePicker(advance_start, advance_end, equipment_max_people) {            
	var list_time = document.getElementById('list_time');  
	list_time.setAttribute("onfocus","WdatePicker({minDate:'" + advance_start + "',maxDate:'" + advance_end + "',dateFmt:'HH:00:00'})");
	del_list_time_options();
	for (var i=0; i<equipment_max_people; i++){
		document.getElementById("equipment_max_people").options[i]=new Option(i+1+"人", i+1);
	}
	document.getElementById("list_date").value="";
	document.getElementById("list_time").value="";
}


function callback2() { 
  if ((xmlHttp.readyState == 4) && (xmlHttp.status == 200)) { 
    var xmldoc = xmlHttp.responseXML; 
    check_reservation = xmldoc.getElementsByTagName("check_reservation")[0].firstChild.data; 
    accumulative = xmldoc.getElementsByTagName("accumulative")[0].firstChild.data; 
    count_list = xmldoc.getElementsByTagName("count_list")[0].firstChild.data; 
    if(check_reservation>0){
      alert("這個時段已經預約過了!");
    }
    else if(check_reservation==0){
      equipment_exclusive = document.getElementById("equipment_exclusive").value;
      if(equipment_exclusive == "1" && accumulative > 0){
        if(count_list>0){
          document.getElementById("accumulative").innerHTML = "目前有" + count_list + "戶預約，可候補。";
        }
        else{
          document.getElementById("accumulative").innerHTML = "目前為優先預約，不用後補";
        }
      }
      else{
        if(accumulative>0){
          document.getElementById("accumulative").innerHTML = "目前有" + accumulative + "人預約，可候補。";
        }
        else{
          document.getElementById("accumulative").innerHTML = "目前為優先預約，不用後補";
        }
      }
      etime_yes();
    }
  }
} 

function setWdatePicker2(check_reservation, accumulative) {            
///////////
	document.getElementById("list_date").value="";
	document.getElementById("list_time").value="";
}