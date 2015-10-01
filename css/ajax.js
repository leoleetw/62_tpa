var xmlhttp;
function CallServer(url, para, method, asyn, dest, fun)
{
	//alert("CallServer"+url);
	if(!(asyn == true || asyn == false))
		return false;

	xmlhttp = false;
	if(window.XMLHttpRequest) { // Mozilla, Safari,...
		xmlhttp = new XMLHttpRequest();
		if(xmlhttp.overrideMimeType)
			xmlhttp.overrideMimeType('text/html');
	}
	else if(window.ActiveXObject) { // IE
		try {
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch(e) {
			try {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch(e) {}
		}
	}

	if(!xmlhttp) {
		alert('Cannot create XMLHTTP instance');
		return false;
	}

	try {
		xmlhttp.onreadystatechange = function()
		{
			if(xmlhttp.readyState == 4)
				if(xmlhttp.status == 200) {
					if(fun != null)
						fun(xmlhttp.responseText,dest);
					else if(dest != null && dest != "") {
							//alert(xmlhttp.responseText);
							document.getElementById(dest).innerHTML = xmlhttp.responseText;
					}
					else alert(xmlhttp.responseText);
				}
				//else alert(xmlhttp.status + ": " + xmlhttp.statusText);
		}

		if(method.toUpperCase() == "POST") { // POST
			xmlhttp.open("POST", url, asyn);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    	xmlhttp.setRequestHeader("Content-length", para.length);
	    	xmlhttp.setRequestHeader("Charset", "utf-8");
	    	xmlhttp.setRequestHeader("Connection", "close");
	    	xmlhttp.send(para);
	    }
	    else if(method.toUpperCase() == "GET") { // GET
	    	if(para == "")
	    		xmlhttp.open("GET", url, asyn);
	    	else {
	    		//alert(url + "?" + para);
	    		xmlhttp.open("GET", url + "?" + para, asyn);
	    	}
	    	xmlhttp.send(null);
	    }
	    else
	    	return false;

	    return true;
    } catch(e) {
    	alert("In File: remove.php\n"
    		+ "Error Code: " + e.number + "\n"
    		+ "Error Description: " + e.description);
    	return false;
    }
}

function Dd(did){
	return document.getElementById(did);
}

function re_state(mun){
	if(mun==1){
		return "處理中";
	}
	else if(mun==2){
		return "待維修";
	}
	else if(mun==3){
		return "待遠端";
	}
	else if(mun==4){
		return "轉其他部門";
	}
	else{
		return "已結案";
	}
}

function get_source(mun){
	if(mun==0){
		return "來信";
	}
	else if(mun==1){
		return "來電";
	}
	else if(mun==2){
		return "e-mail";
	}
	else if(mun==3){
		return "簡訊";
	}
	else if(mun==4){
		return "傳真";
	}
	else if(mun==5){
		return "售服工程師";
	}
	else{
		return "外部門";
	}
}

function get_edu(mun){
	if(mun==0){
		return "小學未畢業";
	}
	else if(mun==1){
		return "國小畢業";
	}
	else if(mun==2){
		return "國中畢業";
	}
	else if(mun==3){
		return "高中/職畢業";
	}
	else if(mun==4){
		return "大學/專畢業";
	}
	else if(mun==5){
		return "碩士畢業";
	}
	else if(mun==6){
		return "博士畢業";
	}
	else{
		return "";
	}
}

function block(divid){
	Dd(divid).style.display = "block";
}

function none(divid){
	Dd(divid).style.display = "none";
}
function getrstate(str1){
	var list = new Array();
	var str = "";
	/*
	var str_index = -1;
	str_index = str.search("str");
	*/
	if(str1!=null){		
		list = str1.split("|");
		str = "<table border='1'><tr>";
		for(var i=0;i<list.length;++i){
			str += "<td>"+list[i]+"</td>";
		}
		str += "</tr></table>";
		
		//return str1;
		return str;
	}
	else{
		return "";
	}
}

function DIVAlert(str,msgw,msgh){ //創建DIVAlert
      var msgw,msgh,bordercolor;
      //msgw=400;//提示窗口的宽度
      //msgh=100;//提示窗口的高度
      titleheight=25 //提示窗口标题高度
      bordercolor="#336699";//提示窗口的边框颜色
      titlecolor="#99CCFF";//提示窗口的标题颜色
   
      var sWidth,sHeight;
      sWidth=document.body.offsetWidth;
      sHeight=screen.height;
      var bgObj=document.createElement("div");
      bgObj.setAttribute('id','bgDiv');
      bgObj.style.position="absolute";
      bgObj.style.top="0";
      bgObj.style.background="#777";
      bgObj.style.filter="progid:DXImageTransform.Microsoft.Alpha(style=3,opacity=25,finishOpacity=75";
      bgObj.style.opacity="0.6";
      bgObj.style.left="0";
      bgObj.style.width=sWidth + "px";
      bgObj.style.height=sHeight + "px";
      bgObj.style.zIndex = "10000";
      document.body.appendChild(bgObj);
   
      var msgObj=document.createElement("div")
      msgObj.setAttribute("id","msgDiv");
      msgObj.setAttribute("align","center");
      msgObj.style.background="white";
      msgObj.style.border="1px solid " + bordercolor;
         msgObj.style.position = "absolute";
               msgObj.style.left = "40%";
               msgObj.style.top = "25%";
               msgObj.style.font="12px/1.6em Verdana, Geneva, Arial, Helvetica, sans-serif";
               msgObj.style.marginLeft = "-225px" ;
               msgObj.style.marginTop = -75+document.documentElement.scrollTop+"px";
               //msgObj.style.width = msgw ;
               //msgObj.style.height =msgh ;
               msgObj.style.width = msgw + "px";
               msgObj.style.height =msgh + "px";
               msgObj.style.textAlign = "center";
               msgObj.style.lineHeight ="25px";
               msgObj.style.zIndex = "10001";
   
        var title=document.createElement("h4");
        title.setAttribute("id","msgTitle");
        title.setAttribute("align","right");
        title.style.margin="0";
        title.style.padding="3px";
        title.style.background=bordercolor;
        title.style.filter="progid:DXImageTransform.Microsoft.Alpha(startX=20, startY=20, finishX=100, finishY=100,style=1,opacity=75,finishOpacity=100);";
        title.style.opacity="0.75";
        title.style.border="1px solid " + bordercolor;
        title.style.height="18px";
        title.style.font="12px Verdana, Geneva, Arial, Helvetica, sans-serif";
        title.style.color="white";
        title.style.cursor="pointer";
        title.innerHTML="關閉";
        title.onclick=function(){
             document.body.removeChild(bgObj);
                   document.getElementById("msgDiv").removeChild(title);
                   document.body.removeChild(msgObj);
                   }
        document.body.appendChild(msgObj);
        document.getElementById("msgDiv").appendChild(title);
        var txt=document.createElement("p");
        txt.style.margin="1em 0"
        txt.setAttribute("id","msgTxt");
        txt.innerHTML=str;
              document.getElementById("msgDiv").appendChild(txt);
 }
 
 function cancelalert(){		//DIVAlert 取消
	document.body.removeChild(Dd("bgDiv"));
	Dd("msgDiv").removeChild(Dd("msgTitle"));
	document.body.removeChild(Dd("msgDiv"));    
}

function getchecked(obj){ //獲得勾選的欄位 RADIO
	var res="";
	for (var i=0; i< obj.length; i++){
				   if ( obj[i].checked){
				      res=obj[i].value;
				      break;
				   }
			}
	return res;
}

function padLeft(str, len) {  //左邊補0
    str = '' + str;
    return str.length >= len ? str : new Array(len - str.length + 1).join("0") + str;
}

function mssqldate(mytext){
	var arr=new Array();
	arr=mytext.split(" ");
	return arr[0];
}
function mssqldatetime(mytext){
	var arr=new Array();
	arr=mytext.split(".");
	return arr[0];
}
function mssqltime(mytext){
	var arr=new Array();
	var str=new Array();
	arr=mytext.split(".");
	str=arr[0].split(" ");
	return str[1];
}

function DB(mytext){ //顯示 資料庫來源
	switch(mytext)
	{
   case 'latent':
      return "潛在客戶";
   case 'ez':
      return "東森公司";
   case 'sam':
      return "三貝德公司";
   case 'old':
      return "大中華公司";  
   default:
      return "未知來源";
	}
}
function return_item(mytext){ //未用!!!!!!!
	var arr=new Array();
	arr=JSON.parse(mytext);
	var str="";
	for(var i=0;i < arr.length;++i)
		if(i==0)
			str+=arr[i].name;
		else
			str+="/"+arr[i].name;
	return str ;
}
function get_item(soid){
	CallServer("ajax/getitem.php",'soid='+soid, "POST", true, "mytext", return_item);
}


function isnull(exam){ //innerHTML 時 將NULL轉為空值
	if ((!exam && typeof exam == "undefined" && exam != 0 )|| exam==null || exam==""){ //undefined != > ==
    return "";
	}
	else
		return exam;
}

function checkerror(mytext){ //確認回傳的值為JSON或SPILT
	var arr=new Array();
	arr=mytext.split("&&");
	if(arr.length > 1){
		return true;
	}
	else{
		return false;
	}
}

/*
function checkerror(mytext){ //確認回傳的值為JSON或SPILT 2版
  try {
    JSON.parse(mytext);
  } 
  catch (e) {
    return false;
  }
  return true;
}
*/
/*
function checkerror(mytext){ //確認回傳的值為JSON或SPILT 2版
		return false;

}
*/
function creat_date(){
	
 //$(document).ready(function(){ 
  var opt={dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
           dayNamesMin:["日","一","二","三","四","五","六"],
           monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
           monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
           prevText:"上月",
           nextText:"下月",
           weekHeader:"週",
           showMonthAfterYear:true,
           dateFormat:"yy-mm-dd"
           };
  return opt; //p@$$w0rd64
  //$("#"+Ddstr).datepicker(opt);
  //$("#datepicker_1").datepicker(opt);

 // });
}

function str2sql(str){
	if(str==""||str==null){
		return "";
	}
	else{
		var str2="";
		str2 = str.replace(/  /g, "&nbsp;&nbsp;");
		str2 = str2.replace(/\n/g,"<br>");
		return str2;
	}
}

function sql2str(str){
	if(str==""||str==null){
		return "";
	}
	else{
		var str2="";
		str2 = str.replace(/&nbsp;&nbsp;/g, "  ");
		str2 = str2.replace(/<br>/g,"\n");
		//str2 = str2.replace("'", "''", str2);
		return str2;
	}
}

function isemail(str){
	var emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;  
	if(str.search(emailRule)!= -1)
		return true;
	else
		return false;  
}

function submitenter(myfield,e){ //ENTER 自動發送
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13)
	   {
	   login_check();
	   return false;
	   }
	else
	   return true;
}

function onlyNum(){
	if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105)))//考慮小鍵盤上的數字鍵
		event.returnvalue=false;
}

function imgResize(xObj,maxW,maxH , view){
  Dd(view).style .width =maxW +'px';
  Dd(view).style .height =maxH+'px';
  if (xObj.width > 0 && xObj.height > 0) {
    //如果寬度大於高
    if (xObj.width/xObj.height >= maxW/maxH) {
      if (xObj.width >= maxW){
        width = maxW;
        height = maxW * xObj.height / xObj.width; //高=高*比率； 比率=最大寬度/寬度
      }
      else {
        //不變
        width = xObj.width;
        height = xObj.height;
      }
    }
    else{
      //寬度小于高度
      if(xObj.height>maxH){  
        width = xObj.width * maxH / xObj.height;     
        height = maxH;
      }
      else{
        width = xObj.width;  
        height = xObj.height;
      }
    }
    xObj.width=width;
    xObj.height=height;
  }
}


function tableToExcel(table, name, filename) {
	var n = new Date();
	var y = n.getFullYear();//.substr(2,2);
	var m = (n.getMonth()+1< 10)?("0" + (n.getMonth() + 1)):(n.getMonth() + 1);
	var d = (n.getDate()< 10)?("0" + (n.getDate())):(n.getDate());
	var h = (n.getHours()< 10)?("0" + (n.getHours())):(n.getHours());
	var mi = (n.getMinutes()< 10)?("0" + (n.getMinutes())):(n.getMinutes());
	var s = (n.getSeconds()< 10)?("0" + (n.getSeconds())):(n.getSeconds());
	filename = filename+y+m+d+h+mi+s+".xls";
	//alert(filename);
  var uri = 'data:application/vnd.ms-excel;base64,';
  //定義格式及編碼方式

  var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office"'
               + '      xmlns:x="urn:schemas-microsoft-com:office:excel"'
               + '      xmlns="http://www.w3.org/TR/REC-html40">'
               + '<head>'
               + '<!--[if gte mso 9]>'
               + '<xml>'
               + '  <x:ExcelWorkbook>'
               + '    <x:ExcelWorksheets>'
               + '      <x:ExcelWorksheet>'
               + '        <x:Name>{worksheet}</x:Name>'
               + '        <x:WorksheetOptions>'
               + '          <x:DisplayGridlines/>'
               + '        </x:WorksheetOptions>'
               + '      </x:ExcelWorksheet>'
               + '    </x:ExcelWorksheets>'
               + '  </x:ExcelWorkbook>'
               + '</xml>'
               + '<![endif]-->'
               + '</head>'
               + '<body>'
               + '  <table>{table}</table>'
               + '</body>'
               + '</html>';
  //Excel的基本框架

  if (!table.nodeType)
    table = document.getElementById(table)

  var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

  document.getElementById("dlink").href = uri + base64(format(template, ctx));
  //將超連結指向Excel內容
  document.getElementById("dlink").download = filename;
  //定義超連結下載的檔名
  document.getElementById("dlink").click();
  //執行點擊超連結的動作來下載檔案
  
}

function base64(s) {
  return window.btoa(unescape(encodeURIComponent(s)))
}
//將文字編譯成Base64格式

function format(s, c) {
  return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; })
}

function ord_payment_type(type){
	if(type=='D')
		return '專案分期';
	else if(type=='5')
		return '匯款';
	else if(type=='2')
		return '刷卡';	
}

function ord_send_way(type){
	if(type=='1')
		return '宅配';
	else if(type=='2')
		return '自取';
}

function ord_state(type){
	if(type=='1')
		return '待確認';
	else if(type=='2')
		return '變更中';
	else if(type=='3')
		return '已確定(暫不出貨)';
	else if(type=='4')
		return '退件';
	else if(type=='5')
		return '已確定(待出貨)';
	else if(type=='6')
		return '部分出貨';
	else if(type=='7')
		return '已出貨';
	else if(type=='9')
		return '已退貨';
	else if(type=='10')
		return '已退訂';
	else if(type=='11')
		return '已作廢';
}

function ord_invoice_type(type){
	if(type=='4')
		return '三聯式';
	else if(type=='5')
		return '二聯式';
}