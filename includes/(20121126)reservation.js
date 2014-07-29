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
//預約機制的日期CHECK
function checkReservation1() {
  createXMLHttpRequest(); 
  var equipment_id = document.getElementById("equipment_id").value; 
  var list_date = document.getElementById("list_date").value; 
  var m_id = document.getElementById("m_id").value; 
	if(list_date != 0){
		var url = "ReservationCheck.php"; //背景執行緒程式
		var postData="equipment_id=" + equipment_id + "&list_date=" + list_date + "&m_id=" + m_id; 

		xmlHttp.onreadystatechange = callback;  
		xmlHttp.open("POST", url, true); 
		xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded'); 
		xmlHttp.send(postData);
		//alert(postData);
	}
}
//預約機制的時間CHECK
function checkReservation2() {
  createXMLHttpRequest(); 
  var equipment_id = document.getElementById("equipment_id").value; 
  var list_date = document.getElementById("list_date").value; 
  var list_time = document.getElementById("list_time").value; 
  var m_id = document.getElementById("m_id").value; 
	if(list_date != 0){
		var url = "ReservationCheck.php"; //背景執行緒程式
		
    var postData="equipment_id=" + equipment_id + "&list_date=" + list_date+ "&list_time=" + list_time + "&m_id=" + m_id; 

		xmlHttp.onreadystatechange = callback;  
		xmlHttp.open("POST", url, true); 
		xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded'); 
		xmlHttp.send(postData);
		//alert(postData);
	}
}

// 資料回傳之後，使用 callback 這個函數處理後續動作  
//AJAX的Debug:就是在  callback 使用alert方式;在背景處理的程式 加標籤;才可給alert使用
function callback() 
{ 
  if ((xmlHttp.readyState == 4) && (xmlHttp.status == 200)) 
  {
    var xmldoc = xmlHttp.responseXML; 
		if(xmldoc.getElementsByTagName("check_reservation1")[0])
    {
			//sql = xmldoc.getElementsByTagName("sql")[0].firstChild.data;
      //alert(sql);
			check_reservation1 = xmldoc.getElementsByTagName("check_reservation1")[0].firstChild.data;
		  //alert(check_reservation1);
			//sc_reservation1 = document.getElementById('show_check_reservation1');  
			if(check_reservation1>0)
      {
        //1.先檢查日期
        
        alert("同一天如要預約兩次以上，請洽管理室!!");
				//sc_reservation1.innerHTML = "同一天如要預約兩次以上，請洽管理室!!";
			}
			else
      {
				//sc_reservation1.innerHTML = "";正確;SHOW顯示預約時間
				document.getElementById("list_date_yes").disabled=true;
				document.getElementById("set_list_date").value = document.getElementById("list_date").value;
				document.getElementById("list_date").disabled=true;
				document.getElementById("list_time").disabled=false;
				document.getElementById("equipment_max_people").disabled=true;
				document.getElementById("list_date_hidden").style.display="";
				document.getElementById("list_time_hidden").style.display="";
				document.getElementById("max_people_hidden").style.display="none";
				//sc_reservation1.innerHTML = "";正確;SHOW顯示預約時間
			}

		}
		else if(xmldoc.getElementsByTagName("check_reservation2")[0])
    {
      /*
      for(i=0;i<7;i++)
      {
        blocktime = xmldoc.getElementsByTagName("blocktime")[i].firstChild.data;
        alert(blocktime);
      }
      */
     //	return;
     
    
    /*2.檢查時間
    	sql = xmldoc.getElementsByTagName("sqla")[0].firstChild.data;
      
    
    	sql =sql+'==='+ xmldoc.getElementsByTagName("sqlb")[0].firstChild.data;
      
      
      sql = sql+'==='+xmldoc.getElementsByTagName("sqlc")[0].firstChild.data;
      alert(sql);
    */
			check_reservation2 = xmldoc.getElementsByTagName("check_reservation2")[0].firstChild.data;
		//	alert(check_reservation2);
			accumulative = xmldoc.getElementsByTagName("accumulative")[0].firstChild.data;
		//	alert(accumulative);
			sc_reservation2 = document.getElementById('show_check_reservation2'); 
	//		alert(sc_reservation2);
			e_exclusive = document.getElementById('equipment_exclusive').value; 
   //   alert(e_exclusive);
      count_list = xmldoc.getElementsByTagName("count_list")[0].firstChild.data;
   //   alert(count_list);
   
      if(count_list>0)
      {
        //-----------統計今天這個時間區域有幾個人 -----------------------
        if(e_exclusive == 1)
        {
          sc_reservation2.innerHTML = "目前有" + count_list + "戶預約，可候補。";
        }
        else if(e_exclusive == 0){
          sc_reservation2.innerHTML = "目前有" + accumulative + "人預約，可候補。";
        }
      }
      else
      {
        sc_reservation2.innerHTML = "目前可以直接預約";
      }

			//document.getElementById('reservation2_number').value = check_reservation2 ;
		}
		else if(xmldoc.getElementsByTagName("check_reservation3")[0])//後續若要在檢查機制再往下擴充
    {
			alert("check_reservation3");
		}
		
    //sql = xmldoc.getElementsByTagName("sql")[0].firstChild.data; 
		//alert(sql);

    //setWdatePicker(sql, check_reservation); 
  }
} 

function setWdatePicker(sql, check_reservation) {            
	var show_sql = document.getElementById('show_sql');  
	var sc_reservation1 = document.getElementById('show_check_reservation1');  
	show_sql.innerHTML = sql;
	if(check_reservation>0){
		sc_reservation1.innerHTML = "同一天如要預約兩次以上，請洽管理室!!";
	}
	else{
		sc_reservation1.innerHTML = "";
	}
}


function callback2() { 
  if ((xmlHttp.readyState == 4) && (xmlHttp.status == 200)) { 
    var xmldoc = xmlHttp.responseXML; 
    check_reservation = xmldoc.getElementsByTagName("check_reservation")[0].firstChild.data; 
    accumulative = xmldoc.getElementsByTagName("accumulative")[0].firstChild.data; 
    setWdatePicker2(check_reservation, accumulative); 
  }
} 

function setWdatePicker2(check_reservation, accumulative) {            
///////////
	document.getElementById("list_date").value="";
	document.getElementById("list_time").value="";
}
