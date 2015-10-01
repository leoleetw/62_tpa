<?php
response.buffer =true
response.expires=-1
If session("user_id")="" Then
  session.abandon
  response.redirect("../sysmgr/timeout.php")
End If
session.Timeout=600
Server.ScriptTimeout=600
set conn=server.createobject("ADODB.Connection")
conn.connectiontimeout=600
conn.commandtimeout=600
conn.Provider="sqloledb"
conn.open "server="&session("server")&";uid="&session("uid")&";pwd="&session("pwd")&";database="&session("database")

Sub Warning (msg)
  echo "<script Language='JavaScript'> alert('" & msg & "')"
  echo "</script>"
End Sub 

Sub Message()
  If session("errnumber")=0 then
    echo "<center>"&session("msg")&"</center>"
  Else
    echo "<script Language='JavaScript'> alert('" & session("msg")&"')</script>"
  End If
  session("msg")=""
  session("errnumber")=0
End Sub

Function QuerySQL (SQL,RS)
  Set RS=Server.CreateObject("ADODB.Recordset")
  RS.Open SQL,Conn,1,1
End Function

Function AddSQL (SQL)
  On Error Resume Next
  Set RS=Server.CreateObject("ADODB.Recordset")
  RS.Open SQL,Conn,1,3
  Conn.Close
  Select case err.number
    case 0 session("msg")="訊息 : 新增資料成功 !"
    case -2147217900 session("msg")="錯誤訊息 : 資料已經存在, 無法新增 !"
    case -2147217873 session("msg")="錯誤訊息 : 資料已經存在, 無法新增 !"
    case else
      session("msg")="錯誤 : " & err.number & "  " & err.description
  End Select
  session("errnumber")=err.number
End Function

Function UpdateSQL (SQL)
  On Error Resume Next
  Set RS=Server.CreateObject("ADODB.Recordset")
  RS.Open SQL,conn,1,3
  Conn.Close
  Select case err.number
    case 0 session("msg")="訊息 : 異動資料成功 !"
    case -2147217873 session("msg")="錯誤訊息 : 資料已經存在, 無法新增 !"
    case else
      session("msg")="錯誤 : " & err.number & "  " & err.description
  End Select
  session("errnumber")=err.number
End Function

Function ExecSQL (SQL)
  On Error Resume Next
  Set RS=Conn.Execute(SQL)
  Select case err.number
    case 0 session("msg")="訊息 : 異動資料成功 !"
    case -2147217900 session("msg")="錯誤訊息 : 資料已經存在, 無法新增 !"
    case -2147217873 session("msg")="錯誤訊息 : 資料已經存在, 無法新增 !"
    case else
      session("msg")="錯誤 : " & err.number & "  " & err.description
  End Select
  session("errnumber")=err.number
End Function

Function CheckStringJ (FName,ListField)
  echo "if(document.form." & FName & ".value==''){" & Chr(13) & Chr(10)
  echo "  alert('"& ListField & "  欄位不可為空白！');" & Chr(13) & Chr(10)
  echo "  document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
End Function

Function ChecklenJ(FName,CLength,ListField)'檢測中英文夾雜字串實際長度
  echo "var cnt=0;" & Chr(13) & Chr(10) 
  echo "var sName=document.form." & FName & ".value;" & Chr(13) & Chr(10)
  echo "for(var i=0;i<sName.length;i++ ){" & Chr(13) & Chr(10)
  echo "  if(escape(sName.charAt(i)).length >= 4) cnt+=2;" & Chr(13) & Chr(10)   
  echo "  else cnt++;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
  echo "if(cnt>" & CLength & "){" & Chr(13) & Chr(10)
  echo "  alert('"& ListField & "  欄位長度超過限制！');" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
End function

Function CheckNumberJ (FName,ListField)
  echo "if(isNaN(Number(document.form." & FName & ".value))==true){" & Chr(13) & Chr(10)
  echo "  alert('"& ListField & "  欄位必須為數字！');" & Chr(13) & Chr(10)
  echo "  document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
End Function

Function CheckIntJ (FName,ListField)
  echo "if(document.form." & FName & ".value.indexOf(""-"")!=-1&&document.form." & FName & ".value.indexOf(""."")!=-1){" & Chr(13) & Chr(10)
  echo "  alert('"& ListField & "  欄位必須為大於0的整數！');" & Chr(13) & Chr(10)
  echo "  document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
End Function

Function CheckMinNumberJ (FName,ListField,MinNum)  
  echo "if(Number(document.form." & FName & ".value)<" & MinNum & "){" & Chr(13) & Chr(10)
  echo "  alert('"& ListField & "  必須大於" & MinNum & "元！');" & Chr(13) & Chr(10)
  echo "  document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
End Function

Function CheckMaxNumberJ (FName,ListField,MaxNum)  
  echo "if(Number(document.form." & FName & ".value)>" & MaxNum & "){" & Chr(13) & Chr(10)
  echo "  alert('"& ListField & "  必須小於" & MaxNum & "元！');" & Chr(13) & Chr(10)
  echo "  document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
End Function

Function CheckEmailJ (FName,ListField)
  echo "if(document.form." & FName & ".value.indexOf(""@"")==-1||document.form." & FName & ".value.indexOf(""."")==-1){" & Chr(13) & Chr(10)
  echo "  alert('您輸入的"& ListField & "格式錯誤！');" & Chr(13) & Chr(10)
  echo "  document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
  echo "if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.form." & FName & ".value))){" & Chr(13) & Chr(10)
  echo "  alert('您輸入的"& ListField & "格式錯誤！');" & Chr(13) & Chr(10)
  echo "  document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
  echo "var keyword=document.form." & FName & ".value.toLowerCase();" & Chr(13) & Chr(10)
  echo "var AryKey = new Array('`','~','!','#','$','%','^','&','*','(',')','+','=','[',']','{','}','\\','|',';',':','\'','""','<','>',',','?','/');" & Chr(13) & Chr(10)
  echo "for(var i=0;i<=AryKey.length-1;i++){" & Chr(13) & Chr(10)
  echo "  if(keyword.indexOf(AryKey[i])!=-1){" & Chr(13) & Chr(10)
  echo "    alert('您輸入的"& ListField & "請勿使用特殊字元！');" & Chr(13) & Chr(10)
  echo "    document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "    return;" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)    
  echo "var keyword=document.form." & FName & ".value.toLowerCase();" & Chr(13) & Chr(10)
  echo "var AryKey = new Array('1=1','--','./','.php','.css','.inc','.ini','/*','*/','.@','@.','@@','@C','@T','@P','acunetix','alert','and','begin','cast','char','chr','count','create','css','cursor','deallocate','declare','delete','dir','drop','end','exec','execute','fetch','from','iframe','insert','into','js','kill','left','master','mid','nchar','ntext','nvarchar','open','right','script','set','select','src','sys','sysobjects','syscolumns','table','text','truncate','url','update','varchar','while','xtype','%2527','address.tst');" & Chr(13) & Chr(10)
  echo "for(var i=0;i<=AryKey.length-1;i++){" & Chr(13) & Chr(10)
  echo "  if(keyword.indexOf(AryKey[i])!=-1){" & Chr(13) & Chr(10)
  echo "    alert('您輸入的"& ListField & "請勿使用保留字元！');" & Chr(13) & Chr(10)
  echo "    document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "    return;" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
End Function

Function CheckKeyWordJ (FName,ListField)
  echo "var content=document.form." & FName & ".value.toLowerCase();" & Chr(13) & Chr(10)
  echo "var AryKey = new Array('script','iframe','a href','url','drop','create','delete','table','""','1=1','--',';');" & Chr(13) & Chr(10)  
  echo "for(var i=0;i<=AryKey.length-1;i++){" & Chr(13) & Chr(10)
  echo "  if(content.indexOf(AryKey[i])!=-1){" & Chr(13) & Chr(10)
  echo "    alert('"& ListField & "  欄位請勿輸入 '+AryKey[i]+'  保留字元！');" & Chr(13) & Chr(10)
  echo "    return;" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
End Function

Function CheckExtJ (FName,Ext,ListField)
  echo "if(document.form." & FName & ".value!==''){" & Chr(13) & Chr(10)
  echo "  if(document.form." & FName & ".value.length>4){" & Chr(13) & Chr(10)
  echo "    if(document.form." & FName & ".value.indexOf('.')>-1){" & Chr(13) & Chr(10)
  echo "      var ext_check=false;" & Chr(13) & Chr(10) 
  echo "      var filename=document.form." & FName & ".value.toLowerCase();" & Chr(13) & Chr(10)
  echo "      var ext=filename.substr(filename.lastIndexOf('.')+1,filename.length);" & Chr(13) & Chr(10)
  If Ext="img" Then
    echo "      var StrExt = 'jpg,gif,bmp';" & Chr(13) & Chr(10)
  ElseIf Ext="flash" Then
    echo "      var StrExt = 'swf';" & Chr(13) & Chr(10)  
  ElseIf Ext="doc" Then
    echo "      var StrExt = 'doc,pdf,xls';" & Chr(13) & Chr(10)
  ElseIf Ext="wmv" Then
    echo "      var StrExt = 'wmv,asf,avi,mpg';" & Chr(13) & Chr(10)
  ElseIf Ext="flv" Then
    echo "      var StrExt = 'flv';" & Chr(13) & Chr(10)    
  End If
  echo "      var AryExt = StrExt.split(',');" & Chr(13) & Chr(10)
  echo "      var AllExt = '';" & Chr(13) & Chr(10) 
  echo "      for(var i=0;i<=AryExt.length-1;i++){" & Chr(13) & Chr(10)
  echo "        if(AllExt==''){" & Chr(13) & Chr(10)
  echo "          AllExt='.'+AryExt[i]+' ';" & Chr(13) & Chr(10)
  echo "        }else{" & Chr(13) & Chr(10)
  echo "          AllExt=AllExt+' 或 .'+AryExt[i]+' ';" & Chr(13) & Chr(10)
  echo "        }" & Chr(13) & Chr(10)
  echo "        if(AryExt[i]==ext){" & Chr(13) & Chr(10)
  echo "          ext_check=true;" & Chr(13) & Chr(10)
  echo "        }" & Chr(13) & Chr(10)        
  echo "      }" & Chr(13) & Chr(10)
  echo "      if(ext_check==false){" & Chr(13) & Chr(10)
  echo "        alert('"& ListField & "  檔案名稱錯誤，副檔名必須為\n'+AllExt);" & Chr(13) & Chr(10)
  echo "        return;" & Chr(13) & Chr(10)
  echo "      }" & Chr(13) & Chr(10)
  echo "    }else{" & Chr(13) & Chr(10)
  echo "      alert('"& ListField & "  檔案名稱錯誤！');" & Chr(13) & Chr(10)
  echo "      return;" & Chr(13) & Chr(10)
  echo "    } " & Chr(13) & Chr(10)
  echo "  }else{" & Chr(13) & Chr(10)
  echo "    alert('"& ListField & "  檔案名稱錯誤！');" & Chr(13) & Chr(10)
  echo "    return;" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10) 
  echo "}" & Chr(13) & Chr(10)
End Function

Function DiffDateJ (FName1,FName2)
  echo "var begindate=new Date(document.form." & FName1 & ".value)" & Chr(13) & Chr(10)
  echo "var enddate=new Date(document.form." & FName2 & ".value)" & Chr(13) & Chr(10)
  echo "var diffdate=(Date.parse(begindate.toString())-Date.parse(enddate.toString()))/(1000*60*60*24)" & Chr(13) & Chr(10)
  echo "if(parseInt(diffdate)>0){" & Chr(13) & Chr(10)
  echo "  alert('刊登起日不可大於迄日！');" & Chr(13) & Chr(10)
  echo "  document.form." & FName1 & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)  
  echo "}" & Chr(13) & Chr(10)
End Function 

Function CheckVerifyCodeJ (FName,CLength,ListField)
  echo "if(document.form." & FName & ".value==''){" & Chr(13) & Chr(10)
  echo "  alert('"& ListField & "  欄位不可為空白！');" & Chr(13) & Chr(10)
  echo "  document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
  echo "if(isNaN(Number(document.form." & FName & ".value))==true){" & Chr(13) & Chr(10)
  echo "  alert('"& ListField & "  欄位必須為數字！');" & Chr(13) & Chr(10)
  echo "  document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
  echo "if(document.form." & FName & ".value.indexOf(""-"")!=-1&&document.form." & FName & ".value.indexOf(""."")!=-1){" & Chr(13) & Chr(10)
  echo "  alert('"& ListField & "  欄位必須為大於0的整數！');" & Chr(13) & Chr(10)
  echo "  document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
  echo "if(document.form." & FName & ".value.length!=" & CLength & "){" & Chr(13) & Chr(10)
  echo "  alert('"& ListField & "  欄位必須為" & CLength & "個數字！');" & Chr(13) & Chr(10)
  echo "  document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)      
End Function

Function CheckImage_Width_HeightJ (FName,image_width,image_height)
  echo "if(document.form." & FName & ".value!=''){" & Chr(13) & Chr(10)
  echo "  var image = new Image();" & Chr(13) & Chr(10)
  echo "  image.src = document.form."&FName&".value;" & Chr(13) & Chr(10)
  echo "  var iwidth=image.width;" & Chr(13) & Chr(10)
  echo "  var iheight=image.height;" & Chr(13) & Chr(10)
  echo "  document.form." & image_width & ".value=iwidth;" & Chr(13) & Chr(10)
  echo "  document.form." & image_height & ".value=iheight; " & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10) 
End Function

Function Calendar (FName,Val)
  echo "<input type=text name="&FName&" size=10 class=font9 value="&Val&">" & Chr(13) & Chr(10)
  echo "<a href onclick=cal19.select(document.form."&FName&",'"&FName&"','yyyy/MM/dd');>" & Chr(13) & Chr(10)
  echo "<img border=0 src=../images/date.gif width=16 height=14></a>" & Chr(13) & Chr(10)
End Function

Function SubmitJ (SubmitType)
  if SubmitType="delete" then echo "if(confirm('您是否確定要刪除？')){" & Chr(13) & Chr(10)
  if SubmitType="update" then echo "if(confirm('您是否確定要修改？')){" & Chr(13) & Chr(10)
  if SubmitType="export" then echo "if(confirm('您是否確定要將查詢結果匯出？')){" & Chr(13) & Chr(10)
  echo "document.form.action.value='"&SubmitType&"';" & Chr(13) & Chr(10)
  echo "document.form.submit();" & Chr(13) & Chr(10)
  if SubmitType="delete" or SubmitType="update" or SubmitType="export" then echo "}" & Chr(13) & Chr(10)
End Function

Function CheckRedirectJ (URLName)
  echo "window.location.href='" & URLName & "';"
End Function

Function Sel_CodeType(SQL,File_TypeName,File_TypeData,File_SubName)
  Row1 = 0
  Sel_TypeCode="<option value=''> </option>"
  Set RS1 = Server.CreateObject("ADODB.RecordSet")
  RS1.Open SQL,Conn,1,1
  While Not RS1.EOF
    If Cstr(RS1(File_TypeName))=Cstr(File_TypeData) Then
      Sel_TypeCode = Sel_TypeCode & "<option value='" & RS1(File_TypeName) & "' selected >" & RS1(File_TypeName) & "</option>"
    Else   
      Sel_TypeCode = Sel_TypeCode & "<option value='" & RS1(File_TypeName) & "'>" & RS1(File_TypeName) & "</option>"
    End If
    If Row1 = 0 Then
      Sub_Code = Sub_Code & "'" & RS1(File_TypeName) & "'" & ","
    Else 
      Sub_Code = Sub_Code & "," & "'" & RS1(File_TypeName) & "'" & ","
    End If    
    Row2=1
    Sub_Code = Sub_Code & "["
    SQL2="Select CodeDesc From CaseCode Where CodeName='"&RS1(File_TypeName)&"' Order By Seq"
    Set RS2 = Server.CreateObject("ADODB.RecordSet")
    RS2.Open SQL2,Conn,1,1
    Do While Not RS2.EOF    
      If Row2 = 1 Then
        Sub_Code = Sub_Code & "'" & RS2("CodeDesc") & "'"
      Else 
        Sub_Code = Sub_Code & "," & "'" & RS2("CodeDesc") & "'" 
      End If
      Row2=Row2+1      
      RS2.MoveNext
    Loop
    RS2.Close
    Set RS2 = Nothing
    Sub_Code=Sub_Code&"]"    
    Row1=Row1+1
    RS1.MoveNext
  Wend
  RS1.Close
  Set RS1=Nothing
  echo "<Select name='"&File_TypeName&"' Size='1' style='font-size: 9pt; font-family: 新細明體' onchange='Chg_Type(this.value)'>"&Sel_TypeCode&"</Select>"  
  echo "<script language=""JavaScript""><!--" & Chr(13) & Chr(10)
  echo "  function Chg_Type(TypeCode){" & Chr(13) & Chr(10)
  echo "    ClearOption(document.form."&File_SubName&");" & Chr(13) & Chr(10)
  echo "    document.form."&File_SubName&".options[0] = new Option('','');" & Chr(13) & Chr(10)
  echo "    var ArySubCode = new Array("&Sub_Code&")" & Chr(13) & Chr(10)
  echo "    for(var i=0;i<=ArySubCode.length-1;i=i+2){" & Chr(13) & Chr(10)
  echo "      if(ArySubCode[i]==TypeCode){" & Chr(13) & Chr(10)
  echo "        var theSub = ArySubCode[i+1];" & Chr(13) & Chr(10)
  echo "        var k=1;" & Chr(13) & Chr(10)
  echo "        for(var j=0;j<=theSub.length-1;j++){" & Chr(13) & Chr(10)
  echo "          document.form."&File_SubName&".options[k] = new Option(theSub[j],theSub[j]);" & Chr(13) & Chr(10)
  echo "          k++;" & Chr(13) & Chr(10)
  echo "        }" & Chr(13) & Chr(10)
  echo "      }" & Chr(13) & Chr(10)
  echo "    }" & Chr(13) & Chr(10)
  echo "    Chg_SubType();" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10) 
  echo "  function ClearOption(SelObj){" & Chr(13) & Chr(10)
  echo "    var i;" & Chr(13) & Chr(10)
  echo "    for(i=SelObj.length-1;i>=0;i--){" & Chr(13) & Chr(10)
  echo "      SelObj.options[i] = null;" & Chr(13) & Chr(10)
  echo "    }" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10)
  echo "--></script>" & Chr(13) & Chr(10)
End Function

Function Sel_SubType(File_TypeDate,File_SubName,File_SubDate)
  Sel_SubCode="<option value=''> </option>"
  If File_TypeDate<>"" Then
    SQL="Select CodeDesc From CaseCode Where CodeName='"&File_TypeDate&"' Order By Seq"
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    Do While Not RS1.EOF
      If Cstr(RS1("CodeDesc"))=Cstr(File_SubDate) Then
        Sel_SubCode = Sel_SubCode & "<option value='" & RS1("CodeDesc") & "' selected >" & RS1("CodeDesc") & "</option>"
      Else
        Sel_SubCode = Sel_SubCode & "<option value='" & RS1("CodeDesc") & "'>" & RS1("CodeDesc") & "</option>"
      End If
      RS1.MoveNext
    Loop
    RS1.Close
    Set RS1 = Nothing       
  End If
  echo "<Select name='"&File_SubName&"' Size='1' style='font-size: 9pt; font-family: 新細明體' onchange='Chg_SubType()'>"&Sel_SubCode&"</Select>"  
End Function

Function OptionList (SQL,FName,Listfield,BoundColumn,menusize)
  Set RS1 = Server.CreateObject("ADODB.RecordSet")
  RS1.Open SQL,Conn,1,1
  echo "<SELECT Name='" & FName & "' size='" & menusize & "' style='font-size: 9pt; font-family: 新細明體'>"
  If RS1.EOF Then
    echo "<OPTION>" & " " & "</OPTION>"
  End If
  If BoundColumn="" or IsNull(BoundColumn) Then
    echo "<OPTION selected value=''>" & " " & "</OPTION>"
  End If    
  While Not RS1.EOF
    If RS1(FName)=BoundColumn Then
      stRS1elected = "selected"
    Else
      stRS1elected = ""
    End If      
    echo "<OPTION " & stRS1elected & " value='" & RS1(FName) & "'>" & RS1(Listfield) & "</OPTION>"
    RS1.MoveNext
  Wend
  echo "</SELECT>"
  RS1.Close
  Set RS1=Nothing
End Function

Function RadioBoxList (SQL,FName,Listfield,BoundColumn,NoChecked)
  Set RS1 = Server.CreateObject("ADODB.RecordSet")
  RS1.Open SQL,Conn,1,1
  session("FieldsetCount")=RS1.RecordCount
  Dim i
  I = 1
  While Not RS1.EOF
    If BoundColumn="" Then
      If I = NoChecked Then
        StrChecked="checked"
      Else
        StrChecked=""   
      End If  
    Else
      If RS1(FName)=BoundColumn Then
        StrChecked="checked"
      Else
        StrChecked=""   
      End If
    End If   	
    echo "<Input Type='radio' " & StrChecked & " Name='" & FName &"' ID='" & FName & I & "' value='" & RS1(FName) & "'>" & RS1(Listfield)
    I = I + 1
    RS1.MoveNext
  WEnd
  RS1.Close
  Set RS1=Nothing
End Function

Function CheckBoxList (SQL,FName,Listfield,BoundColumn)
  Set RS1 = Server.CreateObject("ADODB.RecordSet")
  RS1.Open SQL,Conn,1,1
  session("FieldsetCount")=RS1.RecordCount
  Dim i
  I = 1
  While Not RS1.EOF
    If Instr(BoundColumn,RS1(FName)) > 0 Then
      StrChecked="checked"
    Else
      StrChecked=""   
    End If   
    echo "<Input Type='checkbox' " & StrChecked & " Name='" & FName &"' ID='" & FName & I & "' value='" & RS1(FName) & "'>" & RS1(Listfield) & "&nbsp;"
    I = I + 1
    RS1.MoveNext
  WEnd
  RS1.Close
  Set RS1=Nothing
End Function

Sub SaveButton()
  echo "<button id='save' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg' onClick='Save_OnClick()'> <img src='../images/save.gIf' width='19' height='20' align='absmiddle'> 存檔</button>&nbsp;"
  echo "<button id='cancel' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg' onClick='Cancel_OnClick()'> <img src='../images/icon6.gIf' width='20' height='15' align='absmiddle'> 離開</button>&nbsp;"
End Sub

Sub EditButton()
  echo "<button id='update' style='position:relative;left:0;width:75;height:25;font-size:9pt;cursor:hand' class='button3-bg' onClick='Update_OnClick()'> <img src='../images/update.gIf' width='20' height='20' align='absmiddle'> 修改</button>&nbsp;"
  echo "<button id='delete' style='position:relative;left:0;width:75;height:25;font-size:9pt;cursor:hand' class='button3-bg' onClick='Delete_OnClick()'> <img src='../images/delete.gIf' width='20' height='20' align='absmiddle'> 刪除</button>&nbsp;"
  echo "<button id='cancel' style='position:relative;left:0;width:75;height:25;font-size:9pt;cursor:hand' class='button3-bg' onClick='Cancel_OnClick()'> <img src='../images/icon6.gIf' width='20' height='15' align='absmiddle'> 離開</button>&nbsp;"
End Sub

Function GridListHit (SQL,PageSize,nowPage,ProgID,HLink,LinkParam,LinkTarget,AddLink,Hit_Nemu)
  Set RS1 = Server.CreateObject("ADODB.RecordSet")
  RS1.Open SQL,Conn,1,1
  If Not RS1.EOF Then 
    FieldsCount = RS1.Fields.Count-1
    totRec=RS1.Recordcount
    If totRec>0 Then 
      RS1.PageSize=PageSize
      If nowPage="" or nowPage=0 Then 
        nowPage=1
      ElseIf cint(nowPage) > RS1.PageCount Then 
        nowPage=RS1.PageCount 
      End If
      session("nowPage")=nowPage
      RS1.AbsolutePage=nowPage
      totPage=RS1.PageCount
      SQL=server.URLEncode(SQL)
    End If
    echo "<Form action='' id=form1 name=form1>" 
    echo "<table border=0 cellspacing='0' cellpadding='1' style='border-collapse: collapse' width='100%'>"
    echo "<tr><td width='30%'></td>"
    echo "<td width='55%'><span style='font-size: 9pt; font-family: 新細明體'>第" & nowPage & "/" & totPage & "頁&nbsp;&nbsp;</span>"
    echo "<span style='font-size: 9pt; font-family: 新細明體'>共" & totRec & "筆&nbsp;&nbsp;</span>"
    If cint(nowPage) <>1 Then             
      echo " | <a href='"&ProgID&".php?nowPage="&(nowPage-1)&"&SQL="&SQL&"'>上一頁</a>" 
    End If      
    If cint(nowPage)<>RS1.PageCount and cint(nowPage)<RS1.PageCount Then 
      echo " | <a href='"&ProgID&".php?nowPage="&(nowPage+1)&"&SQL="&SQL&"'>下一頁</a>" 
    End If
    echo " |&nbsp;<span style='font-size: 9pt; font-family: 新細明體'> 跳至第<select name=GoPage size='1' style='font-size: 9pt; font-family: 新細明體' onchange='GoPage_OnChange(this.value)'>"
    For iPage=1 to totPage
      If iPage=cint(nowPage) Then
        strSelected = "selected"
      Else
	      strSelected = "" 
      End If   
      echo "<option value='"&iPage&"'" & strSelected & ">" & iPage & "</option>"          
    Next   
    echo "</select>頁</span></td>" 
    If AddLink <> "" Then
      echo "<td align='right'><span style='font-size: 9pt; font-family: 新細明體'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" & AddLink & "' target='main'>新增資料</a></span></td>"
    End If   
    echo "</tr></table>"
    Dim I
    Dim J
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For J = 1 To FieldsCount
      echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(J).Name & "</span></font></td>"
    Next
    If Hit_Nemu<>"" Then 
      echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>累計點閱次數</span></font></td>"
      If Hit_Nemu="activity" Then echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>報名明細</span></font></td>"
    End If
    echo "</tr>"
    I = 1
    While Not RS1.EOF And I <= RS1.PageSize
      If Hlink<>"" Then
        echo "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>"
        showhand="style='cursor:hand'"
      End If
      echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
      For J = 1 To FieldsCount
        echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(J) & "</span></td>"
      Next
      If Hit_Nemu<>"" Then 
        Total=0
        SQL2="Select Total=isnull(Sum(Hit_Count),0) From HIT Where Hit_Nemu='"&Hit_Nemu&"' And Hit_Object_ID='"&RS1(0)&"'"
        Set RS2 = Server.CreateObject("ADODB.RecordSet")
        RS2.Open SQL2,Conn,1,1
        If Not RS2.EOF Then Total=RS2("Total")
        RS2.Close
        Set RS2=Nothing 
        echo "<td><span style='font-size: 9pt; font-family: 新細明體'>"&FormatNumber(Total,0)&"</span></td>"
        If Hit_Nemu="activity" Then 
          Total=0
          SQL2="Select Total=Count(*) From ACTIVITY_SIGNUP Where Activity_Id='"&RS1(0)&"'"
          Set RS2 = Server.CreateObject("ADODB.RecordSet")
          RS2.Open SQL2,Conn,1,1
          If Not RS2.EOF Then Total=RS2("Total")
          RS2.Close
          Set RS2=Nothing 
          echo "</a><td><span style='font-size: 9pt; font-family: 新細明體'><a href='activity_signup.php?activity_id="&RS1(0)&"' target='main'>&nbsp;報名明細(&nbsp;"&FormatNumber(Total,0)&"&nbsp;)</a></span></td>"       
        End If
      End If
      I = I + 1
      RS1.MoveNext
      echo "</tr>"
      If Hit_Nemu<>"activity" Then echo "</a>"
    Wend
    echo "</table>"
    echo "</form>"
  Else
    echo "<table border=0 cellspacing='0' cellpadding='2' style='border-collapse: collapse' width='100%'>"
    echo "<tr><td width='85%' align='center' style='color:#ff0000'>** 沒有符合條件的資料 **</td>"
    If AddLink <> "" Then
      echo "<td align='right'><span style='font-size: 9pt; font-family: 新細明體'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" & AddLink & "' target='main'>新增資料</a></span></td>"
    End If  
    echo "</table>"
  End If 
  RS1.Close
  Set RS1=Nothing
End Function

Function GridList (SQL,PageSize,nowPage,ProgID,HLink,LinkParam,LinkTarget,AddLink)
  Set RS1 = Server.CreateObject("ADODB.RecordSet")
  RS1.Open SQL,Conn,1,1
  If Not RS1.EOF Then 
    FieldsCount = RS1.Fields.Count-1
    totRec=RS1.Recordcount
    If totRec>0 Then 
      RS1.PageSize=PageSize
      If nowPage="" or nowPage=0 Then 
        nowPage=1
      ElseIf cint(nowPage) > RS1.PageCount Then 
        nowPage=RS1.PageCount 
      End If
      session("nowPage")=nowPage
      RS1.AbsolutePage=nowPage
      totPage=RS1.PageCount
      SQL=server.URLEncode(SQL)
    End If
    echo "<Form action='' id=form1 name=form1>" 
    echo "<table border=0 cellspacing='0' cellpadding='1' style='border-collapse: collapse' width='100%'>"
    echo "<tr><td width='30%'></td>"
    echo "<td width='55%'><span style='font-size: 9pt; font-family: 新細明體'>第" & nowPage & "/" & totPage & "頁&nbsp;&nbsp;</span>"
    echo "<span style='font-size: 9pt; font-family: 新細明體'>共" & totRec & "筆&nbsp;&nbsp;</span>"
    If cint(nowPage) <>1 Then             
      echo " | <a href='"&ProgID&".php?nowPage="&(nowPage-1)&"&SQL="&SQL&"'>上一頁</a>" 
    End If      
    If cint(nowPage)<>RS1.PageCount and cint(nowPage)<RS1.PageCount Then 
      echo " | <a href='"&ProgID&".php?nowPage="&(nowPage+1)&"&SQL="&SQL&"'>下一頁</a>" 
    End If
    echo " |&nbsp;<span style='font-size: 9pt; font-family: 新細明體'> 跳至第<select name=GoPage size='1' style='font-size: 9pt; font-family: 新細明體' onchange='GoPage_OnChange(this.value)'>"
    For iPage=1 to totPage
      If iPage=cint(nowPage) Then
        strSelected = "selected"
      Else
	      strSelected = "" 
      End If   
      echo "<option value='"&iPage&"'" & strSelected & ">" & iPage & "</option>"          
    Next   
    echo "</select>頁</span></td>" 
    If AddLink <> "" Then
      echo "<td align='right'><span style='font-size: 9pt; font-family: 新細明體'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" & AddLink & "' target='main'>新增資料</a></span></td>"
    End If   
    echo "</tr></table>"
    Dim I
    Dim J
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For J = 1 To FieldsCount
      echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(J).Name & "</span></font></td>"
    Next
    echo "</tr>"
    I = 1
    While Not RS1.EOF And I <= RS1.PageSize
      If Hlink<>"" Then
        echo "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>"
        showhand="style='cursor:hand'"
      End If
      echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
      For J = 1 To FieldsCount
        echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(J) & "</span></td>"
      Next
      I = I + 1
      RS1.MoveNext
      echo "</tr>"
      echo "</a>"
    Wend
    echo "</table>"
    echo "</form>"
  Else
    echo "<table border=0 cellspacing='0' cellpadding='2' style='border-collapse: collapse' width='100%'>"
    echo "<tr><td width='85%' align='center' style='color:#ff0000'>** 沒有符合條件的資料 **</td>"
    If AddLink <> "" Then
      echo "<td align='right'><span style='font-size: 9pt; font-family: 新細明體'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" & AddLink & "' target='main'>新增資料</a></span></td>"
    End If  
    echo "</table>"
  End If 
  RS1.Close
  Set RS1=Nothing
End Function

Function SubjectList (SQL,HLink,LinkParam,LinkTarget,LinkType)
  Set RS1 = Server.CreateObject("ADODB.RecordSet")
  RS1.Open SQL,Conn,1,1
  FieldsCount = RS1.Fields.Count-1
  Dim I
  echo "<table id=grid border='1' cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
  echo "<tr>"
  For I = 1 To FieldsCount
    echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i).Name & "</span></font></td>"
  Next
  echo "</tr>"
  While Not RS1.EOF
    If Hlink<>"" Then
      If LinkType="window" Then
        echo "<a href onclick=""window.open('" & Hlink & RS1(LinkParam)&"','','scrollbars=no,top=100,left=120,width=470,height=320')"">"
      Else
        echo "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>"
      End If   
      showhand="style='cursor:hand'"
    End If
    echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
    For I = 1 To FieldsCount
      echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i) & "</span></td>"
    Next    
    RS1.MoveNext
    echo "</tr>"
    echo "</a>"
  Wend
  echo "</table>"
  RS1.Close
  Set RS1=Nothing
End Function

Function ImageList (SQL,HLink,LinkParam,LinkTarget)
  Set RS1 = Server.CreateObject("ADODB.RecordSet")
  RS1.Open SQL,Conn,1,1
  FieldsCount = RS1.Fields.Count-1
  Dim I
  echo "<table id=grid border=0 cellspacing='0' cellpadding='3' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
  echo "<tr>"
  For I = 1 To FieldsCount
    echo "<td bgcolor='#FFE1AF'><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(i).Name & "</span></font></td>"
  Next
  echo "<td bgcolor='#FFE1AF'><span style='font-size: 9pt; font-family: 新細明體'></span></td>"
  echo "</tr>"
  While Not RS1.EOF
    echo "<tr>"
    For I = 1 To FieldsCount
      echo "<td bgcolor='#FFFFFF' align='center'><a onClick=""window.open('image_left_show.php?imgfile="&RS1(i)&"','','scrollbars=yes,resizable=yes,top=20,left=40,width=280,height=180')""><img src='../upload/"&RS1(i)&"' border=0 width='90' height='67'></a></td>"
    Next
    echo "<td valign='bottom'><a href='JavaScript:if(confirm(""是否確定要刪除圖片 ?"")){window.location.href=""" & HLink & RS1(LinkParam) & """;}' target='" & LinkTarget &"'><img src='../images/x5.gif' border=0 width='16' height='14' alt='刪除'></a></td>"
    RS1.MoveNext
    echo "</tr>"
  Wend
  echo "</table>"
  RS1.Close
  Set RS1=Nothing
End Function

function DundasUpLoad(FilePath,UploadName,UploadSize,objUpload,MaxFileSize)
  set objUpload = Server.CreateObject("Dundas.Upload")
  on error resume next
  objUpload.MaxFileCount = 1
  objUpload.MaxFileSize = MaxFileSize*1048576
  objUpload.MaxUploadSize = MaxFileSize*1048576
  objUpload.UseUniqueNames = True
  objUpload.UseVirtualDir = True
  objUpload.Save FilePath
  
  For Each objUploadedFile in objUpload.Files
    If objUploadedFile.Size>0 Then
      SourcePath = objUploadedFile.Originalpath
      SourceName = objUpload.GetFileName(objUploadedFile.Originalpath)
      UploadName = objUpload.GetFileName(objUploadedFile.path)
      UploadSize = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
      ExtName = objUpload.GetFileExt(objUploadedFile.Originalpath)
    End If
  Next
End function

function DundasUpLoad5(FilePath,UploadName1,UploadSize1,ExtName1,UploadName2,UploadSize2,ExtName2,UploadName3,UploadSize3,ExtName3,UploadName4,UploadSize4,ExtName4,UploadName5,UploadSize5,ExtName5,objUpload,MaxFileSize)
  set objUpload = Server.CreateObject("Dundas.Upload")
  on error resume next
  objUpload.MaxFileCount = 5
  objUpload.MaxFileSize = MaxFileSize*1048576
  objUpload.MaxUploadSize = 5*MaxFileSize*1048576
  objUpload.UseUniqueNames = True
  objUpload.UseVirtualDir = True
  objUpload.Save FilePath
  
  I=0
  For Each objUploadedFile in objUpload.Files
    I = I + 1
    If objUploadedFile.Size>0 Then
      If I=1 Then
        SourcePath1 = objUploadedFile.Originalpath
        SourceName1 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName1 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize1 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName1 = objUpload.GetFileExt(objUploadedFile.Originalpath)
      ElseIf I=2 Then
        SourcePath2 = objUploadedFile.Originalpath
        SourceName2 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName2 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize2 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName2 = objUpload.GetFileExt(objUploadedFile.Originalpath)      
      ElseIf I=3 Then
        SourcePath3 = objUploadedFile.Originalpath
        SourceName3 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName3 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize3 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName3 = objUpload.GetFileExt(objUploadedFile.Originalpath)      
      ElseIf I=4 Then
        SourcePath4 = objUploadedFile.Originalpath
        SourceName4 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName4 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize4 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName4 = objUpload.GetFileExt(objUploadedFile.Originalpath)      
      ElseIf I=5 Then
        SourcePath5 = objUploadedFile.Originalpath
        SourceName5 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName5 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize5 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName5 = objUpload.GetFileExt(objUploadedFile.Originalpath)      
      End If
    End If
  Next
End function

function DundasUpLoad10(FilePath,UploadName1,UploadSize1,ExtName1,UploadName2,UploadSize2,ExtName2,UploadName3,UploadSize3,ExtName3,UploadName4,UploadSize4,ExtName4,UploadName5,UploadSize5,ExtName5,UploadName6,UploadSize6,ExtName6,UploadName7,UploadSize7,ExtName7,UploadName8,UploadSize8,ExtName8,UploadName9,UploadSize9,ExtName9,UploadName10,UploadSize10,ExtName10,objUpload,MaxFileSize)
  set objUpload = Server.CreateObject("Dundas.Upload")
  on error resume next
  objUpload.MaxFileCount = 10
  objUpload.MaxFileSize = MaxFileSize*1048576
  objUpload.MaxUploadSize = 10*MaxFileSize*1048576
  objUpload.UseUniqueNames = True
  objUpload.UseVirtualDir = True
  objUpload.Save FilePath
  
  I=0
  For Each objUploadedFile in objUpload.Files
    I = I + 1
    If objUploadedFile.Size>0 Then
      If I=1 Then
        SourcePath1 = objUploadedFile.Originalpath
        SourceName1 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName1 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize1 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName1 = objUpload.GetFileExt(objUploadedFile.Originalpath)
      ElseIf I=2 Then
        SourcePath2 = objUploadedFile.Originalpath
        SourceName2 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName2 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize2 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName2 = objUpload.GetFileExt(objUploadedFile.Originalpath)
      ElseIf I=3 Then
        SourcePath3 = objUploadedFile.Originalpath
        SourceName3 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName3 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize3 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName3 = objUpload.GetFileExt(objUploadedFile.Originalpath)
      ElseIf I=4 Then
        SourcePath4 = objUploadedFile.Originalpath
        SourceName4 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName4 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize4 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName4 = objUpload.GetFileExt(objUploadedFile.Originalpath)
      ElseIf I=5 Then
        SourcePath5 = objUploadedFile.Originalpath
        SourceName5 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName5 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize5 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName5 = objUpload.GetFileExt(objUploadedFile.Originalpath)
      ElseIf I=6 Then
        SourcePath6 = objUploadedFile.Originalpath
        SourceName6 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName6 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize6 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName6 = objUpload.GetFileExt(objUploadedFile.Originalpath)
      ElseIf I=7 Then
        SourcePath7 = objUploadedFile.Originalpath
        SourceName7 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName7 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize7 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName7 = objUpload.GetFileExt(objUploadedFile.Originalpath)
      ElseIf I=8 Then
        SourcePath8 = objUploadedFile.Originalpath
        SourceName8 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName8 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize8 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName8 = objUpload.GetFileExt(objUploadedFile.Originalpath)
      ElseIf I=9 Then
        SourcePath9 = objUploadedFile.Originalpath
        SourceName9 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName9 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize9 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName9 = objUpload.GetFileExt(objUploadedFile.Originalpath)
      ElseIf I=10 Then
        SourcePath10 = objUploadedFile.Originalpath
        SourceName10 = objUpload.GetFileName(objUploadedFile.Originalpath)
        UploadName10 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize10 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
        ExtName10 = objUpload.GetFileExt(objUploadedFile.Originalpath)
      End If
    End If
  Next
End function

Function ShowFlv(FileName,FileType,xWidth,xHeight)
  If xHeight<>"" Then xHeight="height="&xHeight
  If Filetype="flash" Then
    echo "<object classid='clsid:D27CDB6E-AE6D-11CF-96B8-444553540000' id='obj1' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0' border='0' width='"&xWidth&"'>"
    echo "<param name='movie' value='"&FileName&"'>"
    echo "<param name='quality' value='High'>"
    echo "<embed src='"&FileName&"' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' name='obj1' width='"&xWidth&"' quality='High'></object>"
  Elseif FileType="wmv" Then
    echo "<EMBED src='"&FileName&"' autostart=true controls=console width='"&xWidth&"' "&xHeight&" type=video/x-ms-wmv></EMBED>" 
  Elseif FileType="flv" Then
    echo "<embed src='../include/vcastr.swf?vcastr_file="&FileName&"' allowfullscreen='true' showMovieInfo=0 pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' wmode='transparent' quality='high' width='"&xWidth&"' "&xHeight&"></embed>" 
  End If
End Function

Function ShowMedia(FileName,FileType,xWidth,xHeight)
  If xHeight<>"" Then xHeight="height="&xHeight
  If Filetype="flash" Then
    echo "<object classid='clsid:D27CDB6E-AE6D-11CF-96B8-444553540000' id='obj1' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0' border='0' width='"&xWidth&"'>"
    echo "<param name='movie' value='"&FileName&"'>"
    echo "<param name='quality' value='High'>"
    echo "<embed src='"&FileName&"' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' name='obj1' width='"&xWidth&"' quality='High'></object>"
  Elseif FileType="wmv" Then
    echo "<EMBED src='"&FileName&"' autostart=true controls=console width='"&xWidth&"' "&xHeight&" type=video/x-ms-wmv></EMBED>" 
  Elseif FileType="flv" Then
    echo "<embed src='../include/vcastr.swf?vcastr_file="&FileName&"' allowfullscreen='true' showMovieInfo=0 pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' wmode='transparent' quality='high' width='"&xWidth&"' "&xHeight&"></embed>" 
  End If
End Function

Function CodeCity_Add (ZipCode,CityCode,AreaCode,Address,AddressSize)
  '縣市選單
  RS1Row = 0
  SelCity="<option value=''>縣&nbsp;&nbsp;&nbsp;&nbsp;市</option>"
  SQL1 = "Select mCode,mValue From CODECITY Where codeMetaID = 'Addr0' Order By mSortValue"
  Set RS1 = Server.CreateObject("ADODB.RecordSet")
  RS1.Open SQL1,Conn,1,1
  Do While Not RS1.EOF
    SelCity = SelCity & "<option value='" & RS1("mCode") & "'>" & RS1("mValue") & "</option>"
    
    If RS1Row = 0 Then
      Aera_Code = Aera_Code & "'" & RS1("mCode") & "'" & ","
    Else 
      Aera_Code = Aera_Code & "," & "'" & RS1("mCode") & "'" & ","
    End If
    RS2Row=1
    Aera_Code = Aera_Code & "["
    SQL2 = "Select mCode,mValue From CODECITY Where codeMetaID = 'Addr0R"&RS1("mCode")&"' Order By mSortValue"
    Set RS2 = Server.CreateObject("ADODB.RecordSet")
    RS2.Open SQL2,Conn,1,1
    Do While Not RS2.EOF
      If RS2Row = 1 Then
        Aera_Code = Aera_Code & "'" & RS2("mCode") & "'" & "," & "'" & RS2("mValue") & "'" 
      Else 
        Aera_Code = Aera_Code & "," & "'" & RS2("mCode") & "'" & "," & "'" & RS2("mValue") & "'" 
      End If
      RS2Row=RS2Row+1
      RS2.MoveNext
    Loop
    RS2.Close
    Set RS2 = Nothing
    Aera_Code=Aera_Code&"]"
    RS1Row=RS1Row+1
    RS1.MoveNext
  Loop
  RS1.Close
  Set RS1 = Nothing  
  '鄉鎮市區選單
  SelArea="<option value=''>鄉鎮市區</option>"  
  echo "<input type='text' name='"&ZipCode&"' size='3' class='font9' readonly maxlength='5'>&nbsp;"
  echo "<Select name='"&CityCode&"' Size='1' style='font-size: 9pt; font-family: 新細明體' onchange='JavaScript:ChgCity(this.value);'>"&SelCity&"</Select>&nbsp;"
  echo "<Select name='"&AreaCode&"' Size='1' style='font-size: 9pt; font-family: 新細明體' onchange='JavaScript:ChgArea(this.value);'>"&SelArea&"</Select>&nbsp;"
  echo "<input type='text' class='font9' name='"&Address&"' size='"&AddressSize&"' maxlength='80' value='請輸入路段號' onClick='JavaScript:ChgAddress();'>" & Chr(13) & Chr(10) 
  '縣市/鄉鎮市區選單連動
  echo "<script language=""JavaScript""><!--" & Chr(13) & Chr(10)
  echo "  function ChgCity(CityCode){" & Chr(13) & Chr(10)
  echo "    document.form."&ZipCode&".value='';" & Chr(13) & Chr(10)
  echo "    ClearOption(document.form."&AreaCode&");" & Chr(13) & Chr(10)
  echo "    document.form."&AreaCode&".options[0] = new Option('鄉鎮市區','');" & Chr(13) & Chr(10)
  echo "    var AryAreaCode = new Array("&Aera_Code&")" & Chr(13) & Chr(10)
  echo "    for(var i=0;i<=AryAreaCode.length-1;i=i+2){" & Chr(13) & Chr(10)
  echo "      if(AryAreaCode[i]==CityCode){" & Chr(13) & Chr(10)
  echo "        var theArea = AryAreaCode[i+1];" & Chr(13) & Chr(10)
  echo "        var k=1;" & Chr(13) & Chr(10)
  echo "        for(var j=0;j<=theArea.length-1;j=j+2){" & Chr(13) & Chr(10)
  echo "          document.form."&AreaCode&".options[k] = new Option(theArea[j+1],theArea[j]);" & Chr(13) & Chr(10)
  echo "          k++;" & Chr(13) & Chr(10)
  echo "        }" & Chr(13) & Chr(10)
  echo "      }" & Chr(13) & Chr(10)
  echo "    }" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10) 
  echo "  function ClearOption(SelObj){" & Chr(13) & Chr(10)
  echo "    var i;" & Chr(13) & Chr(10)
  echo "    for(i=SelObj.length-1;i>=0;i--){" & Chr(13) & Chr(10)
  echo "      SelObj.options[i] = null;" & Chr(13) & Chr(10)
  echo "    }" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10)
  echo "  function ChgArea(AreaCode){" & Chr(13) & Chr(10)
  echo "    document.form."&ZipCode&".value=AreaCode;" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10)
  echo "  function ChgAddress(){" & Chr(13) & Chr(10)
  echo "    if(document.form."&Address&".value=='請輸入路段號'){" & Chr(13) & Chr(10)
  echo "      document.form."&Address&".value='';" & Chr(13) & Chr(10)
  echo "    }" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10)
  echo "--></script>" & Chr(13) & Chr(10)
End Function

Function CodeCity_Edit (ZipCode,ZipValue,CityCode,CityValue,AreaCode,AreaValue,Address,AddressValue,AddressSize)
  '縣市選單
  RS1Row = 0
  SelCity="<option value=''>縣&nbsp;&nbsp;&nbsp;&nbsp;市</option>"
  SQL1 = "Select mCode,mValue From CODECITY Where codeMetaID = 'Addr0' Order By mSortValue"
  Set RS1 = Server.CreateObject("ADODB.RecordSet")
  RS1.Open SQL1,Conn,1,1
  Do While Not RS1.EOF
    If RS1("mCode")=CityValue Then
      SelCity = SelCity & "<option value='" & RS1("mCode") & "' Selected>" & RS1("mValue") & "</option>"
    Else
      SelCity = SelCity & "<option value='" & RS1("mCode") & "'>" & RS1("mValue") & "</option>"
    End If
    
    If RS1Row = 0 Then
      Aera_Code = Aera_Code & "'" & RS1("mCode") & "'" & ","
    Else 
      Aera_Code = Aera_Code & "," & "'" & RS1("mCode") & "'" & ","
    End If
    RS2Row=1
    Aera_Code = Aera_Code & "["
    SQL2 = "Select mCode,mValue From CODECITY Where codeMetaID = 'Addr0R"&RS1("mCode")&"' Order By mSortValue"
    Set RS2 = Server.CreateObject("ADODB.RecordSet")
    RS2.Open SQL2,Conn,1,1
    Do While Not RS2.EOF
      If RS2Row = 1 Then
        Aera_Code = Aera_Code & "'" & RS2("mCode") & "'" & "," & "'" & RS2("mValue") & "'" 
      Else 
        Aera_Code = Aera_Code & "," & "'" & RS2("mCode") & "'" & "," & "'" & RS2("mValue") & "'" 
      End If
      RS2Row=RS2Row+1
      RS2.MoveNext
    Loop
    RS2.Close
    Set RS2 = Nothing
    Aera_Code=Aera_Code&"]"
    RS1Row=RS1Row+1
    RS1.MoveNext
  Loop
  RS1.Close
  Set RS1 = Nothing  
  '鄉鎮市區選單
  SelArea="<option value=''>鄉鎮市區</option>"
  If CityValue<>"" And AreaValue<>"" Then
    SQL1 = "Select mCode,mValue From CodeCity Where codeMetaID = 'Addr0R"&CityValue&"' Order By mSortValue"
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL1,Conn,1,1
    Do While Not RS1.EOF
      If RS1("mCode")=AreaValue Then
        SelArea = SelArea & "<option value='" & RS1("mCode") & "' Selected>" & RS1("mValue") & "</option>"
      Else
        SelArea = SelArea & "<option value='" & RS1("mCode") & "'>" & RS1("mValue") & "</option>"
      End If  
      RS1.MoveNext
    Loop 
    RS1.Close
    Set RS1 = Nothing  
  End If
      
  echo "<input type='text' name='"&ZipCode&"' size='3' class='font9' readonly maxlength='5' value='"&ZipValue&"'>&nbsp;"
  echo "<Select name='"&CityCode&"' Size='1' style='font-size: 9pt; font-family: 新細明體' onchange='JavaScript:ChgCity(this.value);'>"&SelCity&"</Select>&nbsp;"
  echo "<Select name='"&AreaCode&"' Size='1' style='font-size: 9pt; font-family: 新細明體' onchange='JavaScript:ChgArea(this.value);'>"&SelArea&"</Select>&nbsp;"
  echo "<input type='text' class='font9' name='"&Address&"' size='"&AddressSize&"' maxlength='80' value='"&AddressValue&"' onClick='JavaScript:ChgAddress();'>" & Chr(13) & Chr(10) 
  '縣市/鄉鎮市區選單連動
  echo "<script language=""JavaScript""><!--" & Chr(13) & Chr(10)
  echo "  function ChgCity(CityCode){" & Chr(13) & Chr(10)
  echo "    document.form."&ZipCode&".value='';" & Chr(13) & Chr(10)
  echo "    ClearOption(document.form."&AreaCode&");" & Chr(13) & Chr(10)
  echo "    document.form."&AreaCode&".options[0] = new Option('鄉鎮市區','');" & Chr(13) & Chr(10)
  echo "    var AryAreaCode = new Array("&Aera_Code&")" & Chr(13) & Chr(10)
  echo "    for(var i=0;i<=AryAreaCode.length-1;i=i+2){" & Chr(13) & Chr(10)
  echo "      if(AryAreaCode[i]==CityCode){" & Chr(13) & Chr(10)
  echo "        var theArea = AryAreaCode[i+1];" & Chr(13) & Chr(10)
  echo "        var k=1;" & Chr(13) & Chr(10)
  echo "        for(var j=0;j<=theArea.length-1;j=j+2){" & Chr(13) & Chr(10)
  echo "          document.form."&AreaCode&".options[k] = new Option(theArea[j+1],theArea[j]);" & Chr(13) & Chr(10)
  echo "          k++;" & Chr(13) & Chr(10)
  echo "        }" & Chr(13) & Chr(10)
  echo "      }" & Chr(13) & Chr(10)
  echo "    }" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10) 
  echo "  function ClearOption(SelObj){" & Chr(13) & Chr(10)
  echo "    var i;" & Chr(13) & Chr(10)
  echo "    for(i=SelObj.length-1;i>=0;i--){" & Chr(13) & Chr(10)
  echo "      SelObj.options[i] = null;" & Chr(13) & Chr(10)
  echo "    }" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10)
  echo "  function ChgArea(AreaCode){" & Chr(13) & Chr(10)
  echo "    document.form."&ZipCode&".value=AreaCode;" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10)
  echo "  function ChgAddress(){" & Chr(13) & Chr(10)
  echo "    if(document.form."&Address&".value=='請輸入路段號'){" & Chr(13) & Chr(10)
  echo "      document.form."&Address&".value='';" & Chr(13) & Chr(10)
  echo "    }" & Chr(13) & Chr(10)
  echo "  }" & Chr(13) & Chr(10)
  echo "--></script>" & Chr(13) & Chr(10)
End Function	
?>
<SCRIPT language JavaScript><!--
function MM_openBrWindow(theURL,winName,features) {
  window.open(theURL,winName,features);
}
--></SCRIPT>