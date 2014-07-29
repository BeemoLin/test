//20121119不顯示候補人數或戶數


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
		var postData="equipment_id=" + equipment_id + "&list_date=" + list_date + "&m_id=" + m_id+ "&ts=" + new Date().getTime(); 
    
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
		
		//把資訊丟給AJAX背景處理;要再夾帶是否專屬預約
    var postData="equipment_id=" + equipment_id + "&list_date=" + list_date+ "&list_time=" + list_time + "&m_id=" + m_id+ "&ts=" + new Date().getTime(); 

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
    var xmldoc = xmlHttp.responseXML; //回覆的XML丟給變數xmldoc
    
		if(xmldoc.getElementsByTagName("check_reservation1")[0])
    {
    //1.先檢查日期
			//sql = xmldoc.getElementsByTagName("sql")[0].firstChild.data;
      //alert(sql);
			check_reservation1 = xmldoc.getElementsByTagName("check_reservation1")[0].firstChild.data;
		  //alert(check_reservation1);
			//sc_reservation1 = document.getElementById('show_check_reservation1');  
			if(check_reservation1>0)
      {
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
      //alert("");
    /*2.檢查時間
    	sql = xmldoc.getElementsByTagName("sqla")[0].firstChild.data;
      
    
    	sql =sql+'==='+ xmldoc.getElementsByTagName("sqlb")[0].firstChild.data;
      
      
      sql = sql+'==='+xmldoc.getElementsByTagName("sqlc")[0].firstChild.data;
      alert(sql);
    */
      /*
      for(i=0;i<7;i++)
      {
        blocktime = xmldoc.getElementsByTagName("blocktime")[i].firstChild.data;
        alert(blocktime);
      }
      */
     //	return;
    
			check_reservation2 = xmldoc.getElementsByTagName("check_reservation2")[0].firstChild.data;
		//	alert(check_reservation2);
		  //sc_reservation2.innerHTML = check_reservation2;
			accumulative = xmldoc.getElementsByTagName("accumulative")[0].firstChild.data;
	//	 	alert(accumulative);
	 //sc_reservation2.innerHTML = check_reservation2;
			sc_reservation2 = document.getElementById('show_check_reservation2'); 
	  //	alert(sc_reservation2);
	   //sc_reservation2.innerHTML = check_reservation2;
			e_exclusive = document.getElementById('equipment_exclusive').value; 
   //   alert(e_exclusive);
    //sc_reservation2.innerHTML = check_reservation2;
   
     
     //可以寫成一個含數,然後輸出到DIV元件上;不使用ALERT()//輸出到畫面上 使用DIV元件的innerHTML或innerTEXT屬性
     //sql = xmldoc.getElementsByTagName("sqlc")[0].firstChild.data;
     //alert(sql);
     //sc_reservation2.innerHTML = sql;
      //endtime = xmldoc.getElementsByTagName("equipment_endtime")[0].firstChild.data;//設備時間
      //alert(endtime);
     //sc_reservation2.innerHTML =sc_reservation2.innerHTML+endtime;
      ordereddetail= xmldoc.getElementsByTagName("ordered")[0].firstChild.data;
      usecount= xmldoc.getElementsByTagName("usecount")[0].firstChild.data;//20140716 by akai
      //equipmentid=xmldoc.getElementsByTagName("equipmentid")[0].firstChild.data;
      //alert(ordereddetail);
      //sc_reservation2.innerHTML = ordereddetail;
      //count_list = xmldoc.getElementsByTagName("count_list")[0].firstChild.data;
      //alert(count_list);
      
      if(ordereddetail=="NO")//ordereddetail傳回預約時段;如果都不行傳回NO
      {
        sc_reservation2.innerHTML ="此時段無法預約";  //!!!!!list_endtime有問題 重疊時間;list_endtime沒有直
      }
      else
      {
         if(usecount!="N"){
              if(usecount!="nouse"){
                  sc_reservation2.innerHTML =ordereddetail+" 可預約";
                  sc_reservation2.innerHTML =sc_reservation2.innerHTML+";剩餘人數:"+usecount;//20140716 by akai
                     //2014/07 By akai for 跑步機人數統計
                      document.getElementById("max_people_hidden").style.display="";
                      document.getElementById("equipment_max_people").style.display="";
                      document.getElementById("equipment_max_people").disabled=false;
                      
                      document.getElementById("equipment_max_people").options.length = 0; //清除;否則會一直往下加
                      
                      orderpeople=(parseInt(usecount,10)<3)?parseInt(usecount,10):3;
                      //parseInt(usecount,10) => orderpeople
                      for(i=1;i<=orderpeople;i++){
                        var varItem = new Option(i.toString()+"人", i);   //文字,值   
                        document.getElementById("equipment_max_people").options.add(varItem);   
                      }
                      
                      document.getElementById("equipment_max_people").value="1";
                      document.getElementById("submit01").style.display="";
              }else{
                  sc_reservation2.innerHTML =ordereddetail+" 無法預約";
                  sc_reservation2.innerHTML =sc_reservation2.innerHTML+"(已預約完)";//20140716 by akai
              }
         }else{
              sc_reservation2.innerHTML =ordereddetail+" 可預約";
              document.getElementById("submit01").style.display="";
         }
      
         //sc_reservation2.innerHTML =";使用人數:"+usecount;
         //20121120 因為非同步,所以要放入這邊alert(document.getElementById("list_time").value);
      		if(document.getElementById("list_time").value != "")
          {
            if(document.getElementById("equipment_exclusive").value == "1" | document.getElementById("equipment_exclusive").value == "0")
            {
              document.getElementById("list_time_yes").disabled=true;
              document.getElementById("list_date").disabled=true;
              document.getElementById("set_list_time").value = document.getElementById("list_time").value;
              document.getElementById("list_time").disabled=true;
              
              //20121109不顯示用戶人數
              //document.getElementById("equipment_max_people").disabled=false;
              //document.getElementById("equipment_max_people").value="1";
              
              document.getElementById("list_date_hidden").style.display="";
              document.getElementById("list_time_hidden").style.display="";
              //document.getElementById("submit01").style.display="";
              document.getElementById("equipment_exclusive").value="1";//20121110  0 或1都設成1 動javascript不動php怕影響其他的程式
              //alert('TEST');
            }
             
      		}
         
         
         
      }
      //-----------統計今天這個時間區域有幾個人 -----------------------
      //20121119不顯示人數與戶數;改成可以使用的時段區間
      /*
      if(count_list>0)
      {
        
        if(e_exclusive == 1)
        {
          sc_reservation2.innerHTML = "目前有" + count_list + "戶預約，可候補。";
        }
        else if(e_exclusive == 0)
        {
          sc_reservation2.innerHTML = "目前有" + accumulative + "人預約，可候補。";
        }
        
      }
      else
      {
       
        sc_reservation2.innerHTML = "目前可以直接預約";
      }
      20121119不顯示人數與戶數;改成可以使用的時段區間*/
			//document.getElementById('reservation2_number').value = check_reservation2 ;
		}
		else if(xmldoc.getElementsByTagName("check_reservation3")[0])//後續若要在檢查機制再往下擴充
    {
			//alert("check_reservation3");
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
