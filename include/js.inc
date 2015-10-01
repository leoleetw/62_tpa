<?php
function CheckFileJ($Form,$FName,$FSpace,$Ftype,$FLen,$ListField){
	if($FSpace=="Y"){
    if($Ftype=="checkbox")
      echo "if(CheckBox(document." . $Form . "." . $FName . ")==false){" . Chr(13) . Chr(10);
      echo "  alert('". $ListField . "  欄位不可為空白！');" . Chr(13) . Chr(10);
      echo "  return;" . Chr(13) . Chr(10);
      echo "}" . Chr(13) . Chr(10);
    else if( $Ftype=="radio"){
      echo "if(Radio(document." . $Form . "." . $FName . ")==false){" . Chr(13)  . Chr(10);
      echo "  alert('". $ListField  . "  欄位不可為空白！');"  . Chr(13)  . Chr(10);
      echo "  return;"  . Chr(13)  . Chr(10);
      echo "}"  . Chr(13)  . Chr(10) ;
    }     
    else{
      echo "if(document."  . $Form  . "."  . $FName  . ".value==''){"  . Chr(13)  . Chr(10);
      echo "  alert('". $ListField  . "  欄位不可為空白！');"  . Chr(13)  . Chr(10);
      echo "  document."  . $Form  . "."  . $FName  . ".focus();"  . Chr(13)  . Chr(10);
      echo "  return;"  . Chr(13)  . Chr(10);
      echo "}"  . Chr(13)  . Chr(10);
    }
  }
  if( intval($FLen) > 0){
    If($Ftype=="checkbox"){
      echo "if(CheckBoxLen(document."  . $Form  . "."  . $FName  . ",".$FLen.")==false){" . Chr(13)  . Chr(10);
      echo "  alert('" $ListField  . "  欄位長度超過限制！');" . Chr(13)  . Chr(10);
      echo "  return;" . Chr(13) . Chr(10);
      echo "}" . Chr(13) . Chr(10);
    }
    else if($Ftype=="radio"){
      echo "if(RadioLen(document."  . $Form  . "."  . $FName  . ",".$FLen.")==false){" . Chr(13) . Chr(10);
      echo "  alert('" $ListField  . "  欄位長度超過限制！');" . Chr(13) . Chr(10);
      echo "  return;"  . Chr(13)  . Chr(10);
      echo "}" . Chr(13)  . Chr(10) ;
    }
    else{
      echo "if(Len(document."  . $Form  . "."  . $FName  . ".value,".$FLen.")==false){"  . Chr(13)  . Chr(10);
      echo "  alert('". $ListField  . "  欄位長度超過限制！');"  . Chr(13)  . Chr(10);
      echo "  document."  . $Form  . "."  . $FName  . ".focus();"  . Chr(13)  . Chr(10);
      echo "  return;"  . Chr(13)  . Chr(10);
      echo "}"  . Chr(13)  . Chr(10);
    }
  }
  if($Ftype != "checkbox" && $Ftype != "radio"){
    echo "if(document."  . $Form  . "."  . $FName  . ".value!=''){"  . Chr(13)  . Chr(10);
    echo "  if(Column(document."  . $Form  . "."  . $FName  . ".value,'".$Ftype."')==false){"  . Chr(13)  . Chr(10);
    if($Ftype="date")
      echo "  alert('". $ListField  . "  欄位格式錯誤(或日期不存在)！');"  . Chr(13)  . Chr(10);
    else
      echo "  alert('". $ListField  . "  欄位格式錯誤！');"  . Chr(13)  . Chr(10);
    End If
    echo "    document."  . Form  . "."  . FName  . ".focus();"  . Chr(13)  . Chr(10);
    echo "    return;"  . Chr(13)  . Chr(10);
    echo "  }"  . Chr(13)  . Chr(10);
    echo "  if(KeyWord(document."  . $Form  . "."  . $FName  . ".value,'".$Ftype."')==false){"  . Chr(13)  . Chr(10);
    echo "    alert('". $ListField  . "  欄位請勿使用特殊字元！');"  . Chr(13)  . Chr(10);
    echo "    document."  . $Form  . "."  . $FName  . ".focus();"  . Chr(13)  . Chr(10);
    echo "    return;"  . Chr(13)  . Chr(10);
    echo "  }"  . Chr(13)  . Chr(10);
    echo "  if(KeepWord(document."  . $Form  . "."  . $FName  . ".value)==false){"  . Chr(13)  . Chr(10);
    echo "    alert('". $ListField  . "  欄位請勿使用保留字串！');"  . Chr(13)  . Chr(10);
    echo "    document."  . $Form  . "."  . $FName  . ".focus();"  . Chr(13)  . Chr(10);
    echo "    return;"  . Chr(13)  . Chr(10);
    echo "  }"  . Chr(13)  . Chr(10);  
    echo "}"  . Chr(13)  . Chr(10);
  }
}
/*
Function CheckFileJ(Form,FName,FSpace,Ftype,FLen,ListField)
  If FSpace="Y" Then
    If Ftype="checkbox" Then
      echo "if(CheckBox(document."  . Form  . "."  . FName  . ")==false){"  . Chr(13)  . Chr(10)
      echo "  alert('"& ListField  . "  欄位不可為空白！');"  . Chr(13)  . Chr(10)
      echo "  return;"  . Chr(13)  . Chr(10)
      echo "}"  . Chr(13)  . Chr(10)
    ElseIf Ftype="radio" Then
      echo "if(Radio(document."  . Form  . "."  . FName  . ")==false){"  . Chr(13)  . Chr(10)
      echo "  alert('"& ListField  . "  欄位不可為空白！');"  . Chr(13)  . Chr(10)
      echo "  return;"  . Chr(13)  . Chr(10)
      echo "}"  . Chr(13)  . Chr(10)      
    Else
      echo "if(document."  . Form  . "."  . FName  . ".value==''){"  . Chr(13)  . Chr(10)
      echo "  alert('"& ListField  . "  欄位不可為空白！');"  . Chr(13)  . Chr(10)
      echo "  document."  . Form  . "."  . FName  . ".focus();"  . Chr(13)  . Chr(10)
      echo "  return;"  . Chr(13)  . Chr(10)
      echo "}"  . Chr(13)  . Chr(10)
    End If
  End If
  If Cint(FLen)>0 Then
    If Ftype="checkbox" Then
      echo "if(CheckBoxLen(document."  . Form  . "."  . FName  . ","&FLen&")==false){"  . Chr(13)  . Chr(10)
      echo "  alert('"& ListField  . "  欄位長度超過限制！');"  . Chr(13)  . Chr(10)
      echo "  return;"  . Chr(13)  . Chr(10)
      echo "}"  . Chr(13)  . Chr(10)
    ElseIf Ftype="radio" Then
      echo "if(RadioLen(document."  . Form  . "."  . FName  . ","&FLen&")==false){"  . Chr(13)  . Chr(10)
      echo "  alert('"& ListField  . "  欄位長度超過限制！');"  . Chr(13)  . Chr(10)
      echo "  return;"  . Chr(13)  . Chr(10)
      echo "}"  . Chr(13)  . Chr(10)            
    Else
      echo "if(Len(document."  . Form  . "."  . FName  . ".value,"&FLen&")==false){"  . Chr(13)  . Chr(10)
      echo "  alert('"& ListField  . "  欄位長度超過限制！');"  . Chr(13)  . Chr(10)
      echo "  document."  . Form  . "."  . FName  . ".focus();"  . Chr(13)  . Chr(10)
      echo "  return;"  . Chr(13)  . Chr(10)
      echo "}"  . Chr(13)  . Chr(10)
    End If
  End If
  If Ftype<>"checkbox" And Ftype<>"radio" Then
    echo "if(document."  . Form  . "."  . FName  . ".value!=''){"  . Chr(13)  . Chr(10)
    echo "  if(Column(document."  . Form  . "."  . FName  . ".value,"""&Ftype&""")==false){"  . Chr(13)  . Chr(10)
    If Ftype="date" Then
      echo "  alert('"& ListField  . "  欄位格式錯誤(或日期不存在)！');"  . Chr(13)  . Chr(10)
    Else
      echo "  alert('"& ListField  . "  欄位格式錯誤！');"  . Chr(13)  . Chr(10)
    End If
    echo "    document."  . Form  . "."  . FName  . ".focus();"  . Chr(13)  . Chr(10)
    echo "    return;"  . Chr(13)  . Chr(10)
    echo "  }"  . Chr(13)  . Chr(10)
    echo "  if(KeyWord(document."  . Form  . "."  . FName  . ".value,"""&Ftype&""")==false){"  . Chr(13)  . Chr(10)
    echo "    alert('"& ListField  . "  欄位請勿使用特殊字元！');"  . Chr(13)  . Chr(10)
    echo "    document."  . Form  . "."  . FName  . ".focus();"  . Chr(13)  . Chr(10)
    echo "    return;"  . Chr(13)  . Chr(10)
    echo "  }"  . Chr(13)  . Chr(10)
    echo "  if(KeepWord(document."  . Form  . "."  . FName  . ".value)==false){"  . Chr(13)  . Chr(10)
    echo "    alert('"& ListField  . "  欄位請勿使用保留字串！');"  . Chr(13)  . Chr(10)
    echo "    document."  . Form  . "."  . FName  . ".focus();"  . Chr(13)  . Chr(10)
    echo "    return;"  . Chr(13)  . Chr(10)
    echo "  }"  . Chr(13)  . Chr(10)      
    echo "}"  . Chr(13)  . Chr(10)
  End If
End Function
*/

function CheckExtJ ($Form,$FName,$FSpace,$Ftype,$ListField){
	if($FSpace=="Y"){
    echo "if(document."  . $Form  . "."  . $FName  . ".value==''){"  . Chr(13)  . Chr(10);
    echo "  alert('". $ListField  . "  欄位不可為空白！');"  . Chr(13)  . Chr(10);
    echo "  document."  . $Form  . "."  . $FName  . ".focus();"  . Chr(13)  . Chr(10);
    echo "  return;"  . Chr(13)  . Chr(10);
    echo "}"  . Chr(13)  . Chr(10);
  }
  echo "if(document."  . $Form  . "."  . $FName  . ".value!=''){"  . Chr(13)  . Chr(10);
  if($Ftype=="img" || $Ftype=="doc" || $Ftype=="wmv" || $Ftype=="flash" || $Ftype=="flv")
    echo "if(Ext(document."  . $Form  . "."  . $FName  . ".value,'".$Ftype."')==false){"  . Chr(13)  . Chr(10);
  else
    echo "if(ExtDIY(document."  . $Form  . "."  . $FName  . ".value,'".$Ftype."')==false){"  . Chr(13)  . Chr(10);

  echo "    alert('". $ListField  . "  此檔案系統不支援！');"  . Chr(13)  . Chr(10);
  echo "    document."  . $Form  . "."  . $FName  . ".focus();"  . Chr(13)  . Chr(10);
  echo "    return;"  . Chr(13)  . Chr(10);
  echo "  }"  . Chr(13)  . Chr(10);
  echo "}"  . Chr(13)  . Chr(10);
}

/*
Function CheckExtJ (Form,FName,FSpace,Ftype,ListField)
  If FSpace="Y" Then
    echo "if(document."  . Form  . "."  . FName  . ".value==''){"  . Chr(13)  . Chr(10)
    echo "  alert('"& ListField  . "  欄位不可為空白！');"  . Chr(13)  . Chr(10)
    echo "  document."  . Form  . "."  . FName  . ".focus();"  . Chr(13)  . Chr(10)
    echo "  return;"  . Chr(13)  . Chr(10)
    echo "}"  . Chr(13)  . Chr(10)
  End If
  echo "if(document."  . Form  . "."  . FName  . ".value!=''){"  . Chr(13)  . Chr(10)
  If Ftype="img" Or Ftype="doc" Or Ftype="wmv" Or Ftype="flash" Or Ftype="flv" Then
    echo "if(Ext(document."  . Form  . "."  . FName  . ".value,"""&Ftype&""")==false){"  . Chr(13)  . Chr(10)
  Else
    echo "if(ExtDIY(document."  . Form  . "."  . FName  . ".value,"""&Ftype&""")==false){"  . Chr(13)  . Chr(10)
  End If
  echo "    alert('"& ListField  . "  此檔案系統不支援！');"  . Chr(13)  . Chr(10)
  echo "    document."  . Form  . "."  . FName  . ".focus();"  . Chr(13)  . Chr(10)
  echo "    return;"  . Chr(13)  . Chr(10)
  echo "  }"  . Chr(13)  . Chr(10)
  echo "}"  . Chr(13)  . Chr(10)
End Function
*/
function Check_Post(){
  $Check_Post = True;
  $URL1 = (string)$_SERVER['HTTP_REFERER'];
  $URL2 = (string)$_SERVER['SERVER_NAME'];
  if(substr(8,strlen($URL2),$URL1) != $URL2)
  	$Check_Post = False;
}
/*
Function Check_Post()
  Check_Post = True
  URL1 = Cstr(Request.ServerVariables("HTTP_REFERER"))
  URL2 = Cstr(Request.ServerVariables("SERVER_NAME"))
  If Mid(URL1,8,Len(URL2))<>URL2 Then Check_Post = False
End Function
*/
?>
<Script language="JavaScript"><!--
  function Len(FileNmame,MaxLen){
    var cnt=0;
    for(var i=0;i<FileNmame.length;i++ ){
      if(escape(FileNmame.charAt(i)).length >= 4) cnt+=2;
      else cnt++;
    }
    if(cnt>MaxLen) return false;
    else return true;
  }
  function CLen(FileNmame,MaxLen){
    var cnt=0;
    for(var i=0;i<FileNmame.length;i++ ){
      if(escape(FileNmame.charAt(i)).length >= 4) cnt+=2;
    }
    if(cnt>MaxLen) return true;
    else return false;
  }   
  function Column(FileNmame,ColumnType){
  	if(ColumnType=='number'){
  		if(isNaN(Number(FileNmame))==true) return false;
  	}else if(ColumnType=='verify'){
  		if(isNaN(Number(FileNmame))==true) return false;
  		if(FileNmame.length!=4) return false;
  	}else if(ColumnType=='email'){
  	  if(FileNmame.indexOf("@")==-1||FileNmame.indexOf(".")==-1||FileNmame.indexOf("@")==1||FileNmame.indexOf(".")==1||FileNmame.indexOf("@")==FileNmame.length||FileNmame.indexOf(".")==FileNmame.length) return false;
  	  if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(FileNmame))) return false;
  	}else if(ColumnType=='url'){
  	  if(FileNmame.indexOf(".")==-1||FileNmame.indexOf(".")==1||FileNmame.indexOf(".")==FileNmame.length) return false;
  	}else if(ColumnType=='date'){
  	  if(FileNmame.indexOf("/")==-1||FileNmame.indexOf("/")==1||FileNmame.indexOf("/")==FileNmame.length) return false;
  	  Ary_Date=FileNmame.split("/");
  	  if(Ary_Date.length!=3) return false;
  	  for(i=0;i<3;i++){
  	  	if(isNaN(Number(Ary_Date[i]))==true) return false;
  	  }
  	  if(Ary_Date[0].length!=4) return false;
  	  if(parseInt(Number(Ary_Date[0]))<1000) return false;
  	  if(parseInt(Number(Ary_Date[1]))<1||parseInt(Number(Ary_Date[1]))>12) return false;
  	  var YYYY=parseInt(Number(Ary_Date[0]))
  	  var MM=parseInt(Number(Ary_Date[1]))
  	  var DD=parseInt(Number(Ary_Date[2]))
  	    	  
  	  if(MM==1||MM==3||MM==5||MM==7||MM==8||MM==10||MM==12){
  	  	if(DD<1||DD>31) return false;
  	  }else if(MM==4||MM==6||MM==9||MM==11){
  	    if(DD<1||DD>30) return false;
  	  }else if(MM==2){
  	    if(LeapYear(YYYY)){
  	    	if(DD<1||DD>29) return false;
  	    }else{
  	      if(DD<1||DD>28) return false;
  	    }
  	  }else return false;
  	}else if(ColumnType=='idno'){
      if(FileNmame.length==8){
      	if(isNaN(Number(FileNmame))==true) return false;
      }else if(FileNmame.length==10){	
        if(isNaN(Number(FileNmame.substring(0,1)))==false) return false;
        if(isNaN(Number(FileNmame.substring(1,10)))==true) return false;
        var alpha = FileNmame.substring(0,1).toUpperCase();
        var d1 = FileNmame.substring(1,2);
        var d2 = FileNmame.substring(2,3);
        var d3 = FileNmame.substring(3,4);
        var d4 = FileNmame.substring(4,5);
        var d5 = FileNmame.substring(5,6);
        var d6 = FileNmame.substring(6,7);
        var d7 = FileNmame.substring(7,8);
        var d8 = FileNmame.substring(8,9);
        var d9 = FileNmame.substring(9,10);
        var acc=0;
        switch(alpha){
          case "A":
            acc=1;
            break;
          case "B":
            acc=10;
            break;
          case "C":
            acc=19;
            break;
          case "D":
            acc=28;
            break;
          case "E":
            acc=37;
            break;
          case "F":
            acc=46;
            break;
          case "G":
            acc=55;
            break;
          case "H":
            acc=64;
            break;
          case "I":
            acc=39;
            break;
          case "J":
            acc=73;
            break;
          case "K":
            acc=82;
            break;
          case "L":
            acc=2;
            break;
          case "M":
            acc=11;
            break;
          case "N":
            acc=20;
            break;
          case "O":
            acc=48;
            break;
          case "P":
            acc=29;
            break;
          case "Q":
            acc=38;
            break;
          case "R":
            acc=47;
            break;
          case "S":
            acc=56;
            break;
          case "T":
            acc=65;
            break; 
          case "U":
            acc=74;
            break;
          case "V":
            acc=83;
            break;
          case "W":
            acc=21;
            break;
          case "X":
            acc=3;
            break;
          case "Y":
            acc=12;
            break;
          case "Z":
            acc=30;
            break;
        }
        if(acc=='0') return false;
        var checksum = acc+8*d1+7*d2+6*d3+5*d4+4*d5+3*d6+2*d7+1*d8+1*d9;
        var check1 = parseInt(checksum/10);
        var check2 = checksum/10;
        var check3 = (check2-check1)*10;
        if((checksum!=check1*10)&&(d9!=(10-check3))) return false;
      }else return false;
    }
  	return true;
  }  
  function KeyWord(FileNmame,KeyWordType){
    var keyword=FileNmame.toLowerCase();
    if(KeyWordType=='content'){
    	var AryKey = new Array('1=1','a=a','--','./');
    }else if(KeyWordType=='tel'){
      var AryKey = new Array('`','~','!','$','%','^','&','*','+','=','[',']','{','}','\\','|',';',':','\'','""','<','>','//','1=1','a=a','--',';','./');
    }else if(KeyWordType=='url'){
      var AryKey = new Array('`','~','!','#','$','%','^','*','(',')','+','[',']','{','}','\\','|',';',':','\'','""','<','>','//','1=1','a=a','--',';','./');
    }else if(KeyWordType=='money'){
      var AryKey = new Array('`','~','!','#','%','^','&','*','(',')','+','=','[',']','{','}','\\','|',';',':','\'','""','<','>','//','1=1','a=a','--',';','./');
    }else{
      var AryKey = new Array('`','~','!','#','$','%','^','&','*','(',')','+','=','[',']','{','}','\\','|',';',':','\'','"','<','>','//','1=1','a=a','--',';','./');
    }
    for(var i=0;i<=AryKey.length-1;i++){
      if(keyword.indexOf(AryKey[i])!=-1) return false;
    }
    return true;
  }    
  function KeepWord(FileNmame){
    var keyword=FileNmame.toLowerCase();
    var AryKey = new Array('.php','.bak','.cfm','.css','.dos','.htm','.inc','.ini','.js','.php','.txt','/*','*/','.@','@.','@@','@C','@T','@P','a href','admin','acunetix','alert','and','application','begin','cast','cache','config','char','chr','cookie','count','create','css','cursor','deallocate','declare','delete','dir','drop','echo','end','eval','exec','exists','execute','fetch','from','hidden','iframe','insert','into','is_','join','js','kill','left','manage','master','mid','nchar','ntext','nvarchar','open','password','right','script','set','select','session','src','sys','sysobjects','syscolumns','table','text','truncate','url','user','update','varchar','where','while','xtype','%2527','address.tst');
    for(var i=0;i<=AryKey.length-1;i++){
      if(keyword.indexOf(AryKey[i])!=-1) return false;
    }
    return true;
  }
  function CheckBox(FileNmame){
    for(i=0;i<FileNmame.length;i++){
      if(FileNmame[i].checked) return true;
    }
    return false;
  }
  function CheckBoxLen(FileNmame,MaxLen){
    var cnt=0;
    for(i=0;i<FileNmame.length;i++){
    	if(FileNmame[i].checked){
    		for(var j=0;j<FileNmame[i].value.length;j++ ){
    		  if(escape(FileNmame[i].value.charAt(j)).length >= 4) cnt+=2;
          else cnt++;
    		}
    		cnt+=2;
    	}
    }
    if(cnt>MaxLen) return false;
    else return true;
  }
  function Radio(FileNmame){
    for(i=0;i<FileNmame.length;i++){
      if(FileNmame[i].checked) return true;
    }
    return false;
  }
  function RadioLen(FileNmame,MaxLen){
    var cnt=0;
    for(i=0;i<FileNmame.length;i++){
    	if(FileNmame[i].checked){
    		for(var j=0;j<FileNmame[i].value.length;j++ ){
    		  if(escape(FileNmame[i].value.charAt(j)).length >= 4) cnt+=2;
          else cnt++;
    		}
    	}
    }
    if(cnt>MaxLen) return false;
    else return true;
  }    
  function Ext(FileNmame,ExtType){
    if(FileNmame.length>4){
      if(FileNmame.indexOf(".")==-1||FileNmame.indexOf(".")==1||FileNmame.indexOf(".")==FileNmame.length) return false;
      var ExtName=FileNmame.substr(FileNmame.lastIndexOf('.')+1,FileNmame.length).toLowerCase();
      if(ExtType=='img'){
      	var AllExt='jpg,gif';
      }else	if(ExtType=='doc'){
        var AllExt='doc,pdf,xls';
      }else	if(ExtType=='wmv'){
        var AllExt='wmv,asf,avi,mpg';
      }else	if(ExtType=='flash'){
        var AllExt='swf';
      }else	if(ExtType=='flv'){
        var AllExt='flv';
      }
      var Ary_Ext=AllExt.split(',');
      for(var i=0;i<=Ary_Ext.length-1;i++){
        if(Ary_Ext[i]==ExtName) return true;
      }
      return false;
    }else return false;
  }    
  function ExtDIY(FileNmame,ExtType){
    if(FileNmame.length>4){
      if(FileNmame.indexOf(".")==-1||FileNmame.indexOf(".")==1||FileNmame.indexOf(".")==FileNmame.length) return false;
      var ExtName=FileNmame.substr(FileNmame.lastIndexOf('.')+1,FileNmame.length).toLowerCase();
      var Ary_Ext=ExtType.split(',');
      for(var i=0;i<=Ary_Ext.length-1;i++){
        if(Ary_Ext[i]==ExtName) return true;
      }
      return false;
    }else return false;
  }
  function LeapYear(Year){
    if(parseInt(Year)%4==0){
    	if(parseInt(Year)%100==0){
    		if(parseInt(Year)%400==0) return true;
    	  return false;	
      }else return true;
    }else return false;
  } 
--></Script>