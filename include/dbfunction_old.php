<?php
response.buffer =true;
response.expires=-1
if(session("user_id")=""){
   session.abandon;
   response.redirect("../sysmgr/timeout.php");
}
session.Timeout=600;
Server.ScriptTimeout=600;
set conn=server.createobject("ADODB.Connection");
conn.connectiontimeout=600;
conn.commandtimeout=600;
conn.Provider="sqloledb";
conn.open "server="&session("server")&";uid="&session("uid")&";pwd="&session("pwd")&";database="&session("database");

Function ShowGrid (SQL){
    Set RS1 = Server.CreateObject("ADODB.RecordSet");
    RS1.Open SQL,Conn,1,1;
    FieldsCount = RS1.Fields.Count-1;
    Dim i	;
    echo "<table id=grid border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>";
    echo "<tr>";
    For(i = 0; i < FieldsCount ; ++i){
			echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i).Name & "</span></font></td>";
		}
    echo "</tr>";
    While(!RS1.EOF){
			echo "<tr>"
			For( i = 0 ; i < FieldsCount ; ++i)
		    echo "<td bgcolor='#FFFFFF'><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i) & "</span></td>";
		  RS1.MoveNext
			echo "</tr>";
		}
    echo "</table>";
    RS1.Close;
}

Function DataGrid (SQL,HLink,LinkParam,LinkTarget){
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    FieldsCount = RS1.Fields.Count-1
    Dim i
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For i = 1 To FieldsCount
	echo "<td bgcolor='#FFE1AF' nowrap><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i).Name & "</span></td>"
    Next
    echo "<td bgcolor='#FFE1AF' nowrap><span style='font-size: 9pt; font-family: �s�ө���'>�B�z</span></td>"
    echo "</tr>"
    While Not RS1.EOF
	echo "<tr bgcolor='FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	For i = 1 To FieldsCount
          echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i) & "</span></td>"
	Next
        echo "<td><a href='JavaScript:if(confirm(""�O�_�T�w�n�R�� ?"")){window.location.href=""" & HLink & RS1(LinkParam) & """;}' target='" & LinkTarget &"'><img src='../images/x5.gif' border=0 width='16' height='14' alt='�R��'></a></td>"    
	RS1.MoveNext
	echo "</tr>"
    Wend
    echo "</table>"
    RS1.Close
}

Function DataGrid2 (SQL,HLink,LinkParam,LinkTarget,LinkCol,DataLink,DataParam){
  Set RS1 = Server.CreateObject("ADODB.RecordSet")
  RS1.Open SQL,Conn,1,1
  FieldsCount = RS1.Fields.Count-1
  Dim i
  echo "<table id=grid border='1' cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
  echo "<tr>"
  For i = 1 To FieldsCount
    echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i).Name & "</span></font></td>"
  Next
  echo "</tr>"
  While Not RS1.EOF
    if Hlink<>"" then
      echo "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>"   
      showhand="style='cursor:hand'"
    end if
    echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
    For i = 1 To FieldsCount
      if i = LinkCol then
        echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & "<a href='#' onclick=""window.open('" & DataLink & RS1(DataParam) & "','','top=100,left=120,width=450,height=260')"">" & RS1(i) & "</a></span></td>"
      else
        echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i) & "</span></td>"
      end if
    Next    
    RS1.MoveNext
    echo "</tr>"
    echo "</a>"
  Wend
  echo "</table>"
  RS1.Close
}

Function DataGrid3 (SQL,HLink,LinkParam,LinkTarget,LinkCol,DataLink,DataParam,DataTarget){
  Set RS1 = Server.CreateObject("ADODB.RecordSet")
  RS1.Open SQL,Conn,1,1
  FieldsCount = RS1.Fields.Count-1
  Dim i
  echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
  echo "<tr>"
  For i = 1 To FieldsCount
    echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i).Name & "</span></font></td>"
  Next
  echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>�B�z</span></font></td>"
  echo "</tr>"
  While Not RS1.EOF
  /*
    'if DataLink<>"" then
    '  echo "<a href='" & DataLink & RS1(DataParam) & "' target='" & DataTarget &"'>"  
    '  showhand="style='cursor:hand'"
    'end if
  */
    echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
    For i = 1 To FieldsCount
      if i = LinkCol then
        echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & "<a href='#' onclick=""window.open('" & HLink & RS1(LinkParam) & "','','top=100,left=120,width=450,height=260')"">" & RS1(i) & "</a></span></td>"
      else
        echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i) & "</span></td>"
      end if
    Next
    echo "<td><a href='JavaScript:if(confirm(""�O�_�T�w�n�R�� ?"")){window.location.href=""" & DataLink & RS1(DataParam) & """;}' target='" & DataTarget &"'><img src='../images/x5.gif' border=0 width='16' height='14' alt='�R��'></a></td>"    
    RS1.MoveNext
    echo "</tr>"
    //echo "</a>"
  Wend
  echo "</table>"
  RS1.Close
}

Function DataGrid4 (SQL,HLink,LinkParam,LinkTarget,LinkCol,PHLink,PLinkParam,PotoCol,DataLink,DataParam,DataTarget){
  Set RS1 = Server.CreateObject("ADODB.RecordSet")
  RS1.Open SQL,Conn,1,1
  FieldsCount = RS1.Fields.Count-1
  Dim i
  echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
  echo "<tr>"
  For i = 1 To FieldsCount
    echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i).Name & "</span></font></td>"
  Next
  echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>�B�z</span></font></td>"
  echo "</tr>"
  While Not RS1.EOF
  /*
    'if DataLink<>"" then
    '  echo "<a href='" & DataLink & RS1(DataParam) & "' target='" & DataTarget &"'>"  
    '  showhand="style='cursor:hand'"
    'end if
  */
    echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
    For i = 1 To FieldsCount
      if i = LinkCol then
        echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & "<a href='#' onclick=""window.open('" & HLink & RS1(LinkParam) & "','','top=100,left=120,width=450,height=260')"">" & RS1(i) & "</a></span></td>"
      elseif i = PotoCol then
        echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & "<a onClick=""MM_openBrWindow('" & PHLink & RS1(PLinkParam) & "','','top=20,left=40,width=600,height=515')""><img src='../upload/vote/"&RS1(i)&"' width='50' border='1' style='border: 1px ridge #C0C0C0'/></a></td>"
      else
        echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i) & "</span></td>"
      end if
    Next
    echo "<td><a href='JavaScript:if(confirm(""�O�_�T�w�n�R�� ?"")){window.location.href=""" & DataLink & RS1(DataParam) & """;}' target='" & DataTarget &"'><img src='../images/x5.gif' border=0 width='16' height='14' alt='�R��'></a></td>"    
    RS1.MoveNext
    echo "</tr>"
    //echo "</a>"
  Wend
  echo "</table>"
  RS1.Close
}

Function DataLinkGrid (SQL,HLink,LinkParam,LinkTarget,DataLink,DataParam,DataTarget){
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    FieldsCount = RS1.Fields.Count-1
    Dim i
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For i = 2 To FieldsCount
	echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i).Name & "</span></font></td>"
    Next
    echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>�B�z</span></font></td>"
    echo "</tr>"
    While Not RS1.EOF
	echo "<tr bgcolor='FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	For i = 2 To FieldsCount
        if i = 2 then
	       echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>" & RS1(i) & "</a></span></td>"
        else
           echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i) & "</span></td>"
        end if
	Next
    echo "<td><a href='JavaScript:if(confirm(""�O�_�T�w�n�R�� ?"")){window.location.href=""" & DataLink & RS1(DataParam) & """;}' target='" & DataTarget &"'><img src='../images/x5.gif' border=0 width='16' height='14' alt='�R��'></a></td>"    
	RS1.MoveNext
	echo "</tr>"
    Wend
    echo "</table>"
    RS1.Close
}

Function GetGrid (SQL,LinkField){
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    FieldsCount = RS1.Fields.Count-1
    Dim i
    echo "<table id=grid border='1' cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For i = 0 To FieldsCount
	echo "<td bgcolor='#FFE1AF'><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i).Name & "</span></font></td>"
    Next
    echo "</tr>"
    While Not RS1.EOF
	echo "<tr bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	For i = 0 To FieldsCount
	    if i = 0 then
		   echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & "<a href='javascript:opener.document.form." & LinkField & ".value=""" & RS1(i) & """;self.close()'>" & RS1(i) & "</a></span></td>"
	    else
           echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i) & "</span></td>"
	    end if   
        Next    
        RS1.MoveNext
        echo "</tr>"
    Wend
    echo "</table>"
    RS1.Close
}

Function LinkGrid (SQL,HLink,LinkParam,LinkTarget,LinkType){
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    FieldsCount = RS1.Fields.Count-1
    Dim i
    echo "<table id=grid border='1' cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For i = 1 To FieldsCount
	  echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i).Name & "</span></font></td>"
    Next
    echo "</tr>"
    While Not RS1.EOF
      if Hlink<>"" then
         if LinkType="window" then
            echo "<a href onclick=""window.open('" & Hlink & RS1(LinkParam)&"','','scrollbars=no,top=100,left=120,width=470,height=320')"">"
         else
            echo "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>"
         end if   
         showhand="style='cursor:hand'"
      end if
	  echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	  For i = 1 To FieldsCount
           echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i) & "</span></td>"
      Next    
      RS1.MoveNext
      echo "</tr>"
      echo "</a>"
    Wend
    echo "</table>"
    RS1.Close
}

Function LinkGrid2 (SQL,HLink,LinkParam,LinkTarget){
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    FieldsCount = RS1.Fields.Count-1
    Dim i
    echo "<table id=grid border='1' cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For i = 1 To FieldsCount
	echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i).Name & "</span></font></td>"
    Next
    echo "</tr>"
    While Not RS1.EOF
	echo "<tr bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	For i = 1 To FieldsCount
	    if i = 1 then
	      echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>" & RS1(i) & "</a></span></td>"
	    else
          echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i) & "</span></td>"
	    end if   
       Next    
       RS1.MoveNext
       echo "</tr>"
    Wend
    echo "</table>"
    RS1.Close
}

Function PageList (SQL,PageSize,nowPage,ProgID,HLink,LinkParam,LinkTarget,AddLink){
	Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    if Not RS1.EOF then 
       FieldsCount = rs1.Fields.Count-1
       totRec=RS1.Recordcount         //�`����
       if totRec>0 then 
          RS1.PageSize=PageSize       //�C������
          if nowPage="" or nowPage=0 then 
             nowPage=1
      	  elseif cint(nowPage) > RS1.PageCount then 
         	 nowPage=RS1.PageCount 
      	  end if    
      	  session("nowPage")=nowPage        	
          RS1.AbsolutePage=nowPage
          totPage=RS1.PageCount       //�`����
          Sql=server.URLEncode(Sql)
       end if    
    echo "<Form action='' id=form1 name=form1>" 
    echo "<table border=0 cellspacing='0' cellpadding='1' style='border-collapse: collapse' width='100%'>"
    echo "<tr><td width='30%'></td>"
    echo "<td width='55%'><span style='font-size: 9pt; font-family: �s�ө���'>��" & nowPage & "/" & totPage & "��&nbsp;&nbsp;</span>"
    echo "<span style='font-size: 9pt; font-family: �s�ө���'>�@" & totRec & "��&nbsp;&nbsp;</span>"
    if cint(nowPage) <>1 then             
       echo " | <a href='"&ProgID&".php?nowPage="&(nowPage-1)&"&SQL="&SQL&"'>�W�@��</a>" 
    end if      
    if cint(nowPage)<>RS1.PageCount and cint(nowPage)<RS1.PageCount then 
       echo " | <a href='"&ProgID&".php?nowPage="&(nowPage+1)&"&SQL="&SQL&"'>�U�@��</a>" 
    end if
    echo " |&nbsp;<span style='font-size: 9pt; font-family: �s�ө���'> ���ܲ�<select name=GoPage size='1' style='font-size: 9pt; font-family: �s�ө���'>"
    For iPage=1 to totPage
        if iPage=cint(nowPage) then
           strSelected = "selected"
	    else
	       strSelected = "" 
	    end if   
        echo "<option value='"&iPage&"'" & strSelected & ">" & iPage & "</option>"          
    Next   
    echo "</select>��</span></td>" 
    
    if AddLink <> "" then
       echo "<td align='right'><span style='font-size: 9pt; font-family: �s�ө���'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" & AddLink & "' target='main'>�s�W���</a></span></td>"
    end if   
    echo "</tr></table>"
    Dim i
    Dim j
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For j = 1 To FieldsCount
		echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & rs1(j).Name & "</span></font></td>"
    Next
    echo "</tr>"
    i = 1
    While Not rs1.EOF And i <= rs1.PageSize
      if Hlink<>"" then
         echo "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>"
         showhand="style='cursor:hand'"
      end if   
	  echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	  For j = 1 To FieldsCount
          echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(j) & "</span></td>"
	  Next
      i = i + 1
	  rs1.MoveNext
	//�Y��ƫ��Ш�FEOF�h���X�^��
	  echo "</tr>"
	  echo "</a>"
    Wend
    echo "</table>"
    echo "</form>"
    else
        echo "<table border=0 cellspacing='0' cellpadding='2' style='border-collapse: collapse' width='100%'>"
        echo "<tr><td width='85%' align='center' style='color:#ff0000'>** �S���ŦX���󪺸�� **</td>"
        if AddLink <> "" then
           echo "<td align='right'><span style='font-size: 9pt; font-family: �s�ө���'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" & AddLink & "' target='main'>�s�W���</a></span></td>"
        end if  
        echo "</table>"
    end if 
    rs1.close
}

Function PageList2 (SQL,PageSize,nowPage,ProgID,HLink,LinkParam,LinkTarget,AddLink){
	Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    if Not RS1.EOF then 
       FieldsCount = rs1.Fields.Count-1
       totRec=RS1.Recordcount         //�`����
       if totRec>0 then 
          RS1.PageSize=PageSize       //�C������
          if nowPage="" or nowPage=0 then 
             nowPage=1
      	  elseif cint(nowPage) > RS1.PageCount then 
         	 nowPage=RS1.PageCount 
      	  end if    
      	  session("nowPage")=nowPage        	
          RS1.AbsolutePage=nowPage
          totPage=RS1.PageCount       //�`����
          Sql=server.URLEncode(Sql)
       end if    
    echo "<Form action='' id=form1 name=form1>" 
    echo "<table border=0 cellspacing='0' cellpadding='1' style='border-collapse: collapse' width='100%'>"
    echo "<tr><td width='35%'></td>"
    echo "<td width='50%'><span style='font-size: 9pt; font-family: �s�ө���'>��" & nowPage & "/" & totPage & "��&nbsp;&nbsp;</span>"
    echo "<span style='font-size: 9pt; font-family: �s�ө���'>�@" & totRec & "��&nbsp;&nbsp;</span>"
    if cint(nowPage) <>1 then             
       echo " | <a href='"&ProgID&".php?nowPage="&(nowPage-1)&"&SQL="&SQL&"'>�W�@��</a>" 
    end if      
    if cint(nowPage)<>RS1.PageCount and cint(nowPage)<RS1.PageCount then 
       echo " | <a href='"&ProgID&".php?nowPage="&(nowPage+1)&"&SQL="&SQL&"'>�U�@��</a>" 
    end if
    echo " |&nbsp;<span style='font-size: 9pt; font-family: �s�ө���'> ���ܲ�<select name=GoPage size='1' style='font-size: 9pt; font-family: �s�ө���'>"
    For iPage=1 to totPage
        if iPage=cint(nowPage) then
           strSelected = "selected"
	    else
	       strSelected = "" 
	    end if   
        echo "<option value='"&iPage&"'" & strSelected & ">" & iPage & "</option>"          
    Next   
    echo "</select>��</span></td>" 
    
    if AddLink <> "" then
       echo "<td align='right'><span style='font-size: 9pt; font-family: �s�ө���'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href onclick=""window.open('" & AddLink &"','','scrollbars=no,top=100,left=120,width=470,height=320')"">�s�W���</a></span></td>"
    end if   
    echo "</tr></table>"
    Dim i
    Dim j
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For j = 1 To FieldsCount
		echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & rs1(j).Name & "</span></font></td>"
    Next
    echo "</tr>"
    i = 1
    While Not rs1.EOF And i <= rs1.PageSize
      if Hlink<>"" then
         echo "<a href onclick=""window.open('" & Hlink & RS1(LinkParam)&"','','scrollbars=no,top=100,left=120,width=470,height=320')"">"
         showhand="style='cursor:hand'"
      end if   
	  echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	  For j = 1 To FieldsCount
          echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(j) & "</span></td>"
	  Next
      i = i + 1
	  rs1.MoveNext
	//�Y��ƫ��Ш�FEOF�h���X�^��
	  echo "</tr>"
	  echo "</a>"
    Wend
    echo "</table>"
    echo "</form>"
    else
        echo "<table border=0 cellspacing='0' cellpadding='2' style='border-collapse: collapse' width='100%'>"
        echo "<tr><td width='85%' align='center' style='color:#ff0000'>** �S���ŦX���󪺸�� **</td>"
        if AddLink <> "" then
           echo "<td align='right'><span style='font-size: 9pt; font-family: �s�ө���'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href onclick=""window.open('" & AddLink &"','','scrollbars=no,top=100,left=120,width=470,height=320')"">�s�W���</a></span></td>"
        end if  
        echo "</table>"
    end if 
    rs1.close
}

Function PageList3 (SQL,PageSize,nowPage,ProgID,HLink,LinkParam,LinkTarget,AddLink,AddName){
	Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    if Not RS1.EOF then 
       FieldsCount = rs1.Fields.Count-1
       totRec=RS1.Recordcount         //�`����
       if totRec>0 then 
          RS1.PageSize=PageSize       //�C������
          if nowPage="" or nowPage=0 then 
             nowPage=1
      	  elseif cint(nowPage) > RS1.PageCount then 
         	 nowPage=RS1.PageCount 
      	  end if    
      	  session("nowPage")=nowPage        	
          RS1.AbsolutePage=nowPage
          totPage=RS1.PageCount       //�`����
          Sql=server.URLEncode(Sql)
       end if    
    echo "<Form action='' id=form1 name=form1>" 
    echo "<table border=0 cellspacing='0' cellpadding='1' style='border-collapse: collapse' width='100%'>"
    echo "<tr><td width='30%'></td>"
    echo "<td width='55%'><span style='font-size: 9pt; font-family: �s�ө���'>��" & nowPage & "/" & totPage & "��&nbsp;&nbsp;</span>"
    echo "<span style='font-size: 9pt; font-family: �s�ө���'>�@" & totRec & "��&nbsp;&nbsp;</span>"
    if cint(nowPage) <>1 then             
       echo " | <a href='"&ProgID&".php?nowPage="&(nowPage-1)&"&SQL="&SQL&"'>�W�@��</a>" 
    end if      
    if cint(nowPage)<>RS1.PageCount and cint(nowPage)<RS1.PageCount then 
       echo " | <a href='"&ProgID&".php?nowPage="&(nowPage+1)&"&SQL="&SQL&"'>�U�@��</a>" 
    end if
    echo " |&nbsp;<span style='font-size: 9pt; font-family: �s�ө���'> ���ܲ�<select name=GoPage size='1' style='font-size: 9pt; font-family: �s�ө���'>"
    For iPage=1 to totPage
        if iPage=cint(nowPage) then
           strSelected = "selected"
	    else
	       strSelected = "" 
	    end if   
        echo "<option value='"&iPage&"'" & strSelected & ">" & iPage & "</option>"          
    Next   
    echo "</select>��</span></td>" 
    
    if AddLink <> "" then
       echo "<td align='right'><span style='font-size: 9pt; font-family: �s�ө���'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" & AddLink & "' target='main'>"&AddName&"</a></span></td>"
    end if   
    echo "</tr></table>"
    Dim i
    Dim j
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For j = 1 To FieldsCount
		echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & rs1(j).Name & "</span></font></td>"
    Next
    echo "</tr>"
    i = 1
    While Not rs1.EOF And i <= rs1.PageSize
      if Hlink<>"" then
         echo "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>"
         showhand="style='cursor:hand'"
      end if   
	  echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	  For j = 1 To FieldsCount
          echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(j) & "</span></td>"
	  Next
      i = i + 1
	  rs1.MoveNext
	//�Y��ƫ��Ш�FEOF�h���X�^��
	  echo "</tr>"
	  echo "</a>"
    Wend
    echo "</table>"
    echo "</form>"
    else
        echo "<table border=0 cellspacing='0' cellpadding='2' style='border-collapse: collapse' width='100%'>"
        echo "<tr><td width='85%' align='center' style='color:#ff0000'>** �S���ŦX���󪺸�� **</td>"
        if AddLink <> "" then
           echo "<td align='right'><span style='font-size: 9pt; font-family: �s�ө���'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" & AddLink & "' target='main'>"&AddName&"</a></span></td>"
        end if  
        echo "</table>"
    end if 
    rs1.close
}

Function PageList4 (SQL,PageSize,nowPage,ProgID,HLink,LinkParam,LinkTarget,AddLink,AddName){
	Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    if Not RS1.EOF then 
       FieldsCount = rs1.Fields.Count-1
       totRec=RS1.Recordcount         //�`����
       if totRec>0 then 
          RS1.PageSize=PageSize       //�C������
          if nowPage="" or nowPage=0 then 
             nowPage=1
      	  elseif cint(nowPage) > RS1.PageCount then 
         	 nowPage=RS1.PageCount 
      	  end if    
      	  session("nowPage")=nowPage        	
          RS1.AbsolutePage=nowPage
          totPage=RS1.PageCount       //�`����
          Sql=server.URLEncode(Sql)
       end if    
    echo "<Form action='' id=form1 name=form1>" 
    echo "<table border=0 cellspacing='0' cellpadding='1' style='border-collapse: collapse' width='100%'>"
    echo "<tr><td width='30%'></td>"
    echo "<td width='55%'><span style='font-size: 9pt; font-family: �s�ө���'>��" & nowPage & "/" & totPage & "��&nbsp;&nbsp;</span>"
    echo "<span style='font-size: 9pt; font-family: �s�ө���'>�@" & totRec & "��&nbsp;&nbsp;</span>"
    if cint(nowPage) <>1 then             
       echo " | <a href='"&ProgID&".php?nowPage="&(nowPage-1)&"&SQL="&SQL&"'>�W�@��</a>" 
    end if      
    if cint(nowPage)<>RS1.PageCount and cint(nowPage)<RS1.PageCount then 
       echo " | <a href='"&ProgID&".php?nowPage="&(nowPage+1)&"&SQL="&SQL&"'>�U�@��</a>" 
    end if
    echo " |&nbsp;<span style='font-size: 9pt; font-family: �s�ө���'> ���ܲ�<select name=GoPage size='1' style='font-size: 9pt; font-family: �s�ө���'>"
    For iPage=1 to totPage
        if iPage=cint(nowPage) then
           strSelected = "selected"
	    else
	       strSelected = "" 
	    end if   
        echo "<option value='"&iPage&"'" & strSelected & ">" & iPage & "</option>"          
    Next   
    echo "</select>��</span></td>" 
    
    if AddLink <> "" And totRec=0 then
       echo "<td align='right'><span style='font-size: 9pt; font-family: �s�ө���'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" & AddLink & "' target='main'>"&AddName&"</a></span></td>"
    end if   
    echo "</tr></table>"
    Dim i
    Dim j
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For j = 1 To FieldsCount
		echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & rs1(j).Name & "</span></font></td>"
    Next
    echo "</tr>"
    i = 1
    While Not rs1.EOF And i <= rs1.PageSize
      if Hlink<>"" then
         echo "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>"
         showhand="style='cursor:hand'"
      end if   
	  echo "<tr "&showhand&" bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	  For j = 1 To FieldsCount
          echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(j) & "</span></td>"
	  Next
      i = i + 1
	  rs1.MoveNext
	//�Y��ƫ��Ш�FEOF�h���X�^��
	  echo "</tr>"
	  echo "</a>"
    Wend
    echo "</table>"
    echo "</form>"
    else
        echo "<table border=0 cellspacing='0' cellpadding='2' style='border-collapse: collapse' width='100%'>"
        echo "<tr><td width='85%' align='center' style='color:#ff0000'>** �S���ŦX���󪺸�� **</td>"
        if AddLink <> "" then
           echo "<td align='right'><span style='font-size: 9pt; font-family: �s�ө���'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" & AddLink & "' target='main'>"&AddName&"</a></span></td>"
        end if  
        echo "</table>"
    end if 
    rs1.close
}

Function LinkPageGrid (SQL,PageSize,HLink,LinkParam,LinkTarget,AddLink){
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    rs1.PageSize = PageSize
    FieldsCount = rs1.Fields.Count-1
    nowAbsolutePage = Cint(Request("PostAbsolutePage"))
    if nowAbsolutePage <> "" then
	   myAbsolutePage = nowAbsolutePage
    else
	   myAbsolutePage = 1
    end if
    arrowValue = Request("ArrowAbsolutePage")
    if arrowValue = "�W�@��" then
	   myAbsolutePage = myAbsolutePage - 1
    elseif arrowValue = "�U�@��" then
	   myAbsolutePage = myAbsolutePage + 1
    elseif arrowValue = "�Ĥ@��" then
	   myAbsolutePage = 1
    elseif arrowValue = "�̫᭶" then
	   myAbsolutePage = rs1.PageCount
    end if
    if myAbsolutePage = "" or myAbsolutePage < 1 then
	   myAbsolutePage = 1
    elseif myAbsolutePage > rs1.PageCount then
	   myAbsolutePage = rs1.PageCount
    end if
    if rs1.PageCount > 0 then 
       rs1.AbsolutePage = myAbsolutePage
    end if   
    echo "<Form action='' id=form1 name=form1><table border=0 cellspacing='0' cellpadding='2' style='border-collapse: collapse' align='center'>"
    echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>��" & myAbsolutePage & "��</span></td>"
    echo "<Input type=hidden name='PostAbsolutePage' value='" & myAbsolutePage & "'>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='�Ĥ@��' class=cbutton></td>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='�W�@��' class=cbutton></td>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='�U�@��' class=cbutton></td>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='�̫᭶' class=cbutton></td>"
    echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>�p: " & RS1.PageCount & "��/ " & RS1.RecordCount & "��</span></td>"
    if AddLink <> "" then
       echo "<td width=15></td>"
       echo "<td><span style='font-size: 9pt; font-family: �s�ө���'><a href='" & AddLink & "' target='main'>�s�W���</a></span></td>"
    end if   
    echo "</tr></table>"
    Dim i
    Dim j
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For j = 1 To FieldsCount
	echo "<td bgcolor='#FFE1AF'><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & rs1(j).Name & "</span></font></td>"
    Next
    echo "</tr>"
    i = 1
    While Not rs1.EOF And i <= rs1.PageSize
	  echo "<tr bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	  For j = 1 To FieldsCount
          if j = 1 then
	         echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & "<a href='" & HLink & RS1(LinkParam) & "' target='" & LinkTarget &"'>" & RS1(j) & "</a></span></td>"
          else
             echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(j) & "</span></td>"
          end if
	  Next
      i = i + 1
	  rs1.MoveNext
	//�Y��ƫ��Ш�FEOF�h���X�^��
	  echo "</tr>"
    Wend
    echo "</table>"
    echo "</form>"
    if RS1.RecordCount=0 then
       echo "<center>�|���إߥ�����</center>"
    end if 
    rs1.close
}

Function PageGrid (SQL,PageSize){
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    rs1.PageSize = PageSize
    FieldsCount = rs1.Fields.Count-1
    nowAbsolutePage = Cint(Request("PostAbsolutePage"))
    if nowAbsolutePage <> "" then
	   myAbsolutePage = nowAbsolutePage
    else
	   myAbsolutePage = 1
    end if
    arrowValue = Request("ArrowAbsolutePage")
    if arrowValue = "�W�@��" then
	   myAbsolutePage = myAbsolutePage - 1
    elseif arrowValue = "�U�@��" then
	   myAbsolutePage = myAbsolutePage + 1
    elseif arrowValue = "�Ĥ@��" then
	   myAbsolutePage = 1
    elseif arrowValue = "�̫᭶" then
	   myAbsolutePage = rs1.PageCount
    end if
    if myAbsolutePage = "" or myAbsolutePage < 1 then
	   myAbsolutePage = 1
    elseif myAbsolutePage > rs1.PageCount then
	   myAbsolutePage = rs1.PageCount
    end if
    if rs1.PageCount > 0 then 
       rs1.AbsolutePage = myAbsolutePage
    end if   
    echo "<Form action='' id=form1 name=form1><table border=0 cellspacing='0' cellpadding='2' style='border-collapse: collapse' align='center'>"
    echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>��" & myAbsolutePage & "��</span></td>"
    echo "<Input type=hidden name='PostAbsolutePage' value='" & myAbsolutePage & "'>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='�Ĥ@��' class=cbutton></td>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='�W�@��' class=cbutton></td>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='�U�@��' class=cbutton></td>"
    echo "<td><Input type=submit name='ArrowAbsolutePage' value='�̫᭶' class=cbutton></td>"
    echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>�p: " & RS1.PageCount & "��/ " & RS1.RecordCount & "��</span></td>"
    echo "</tr></table>"
    Dim i
    Dim j
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    For i = 0 To FieldsCount
	echo "<td bgcolor='#FFE1AF'><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & rs1(i).Name & "</span></font></td>"
    Next
    echo "</tr>"
    i = 1
    While Not rs1.EOF And i <= rs1.PageSize
	echo "<tr bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
	For j = 0 To FieldsCount
	    echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & rs1(j) & "</span></td>"
	Next
    i = i + 1
	rs1.MoveNext
	//�Y��ƫ��Ш�FEOF�h���X�^��
	echo "</tr>"
    Wend
    echo "</table>"
    echo "</form>"
    rs1.close
}

Function OptionList (SQL,FName,Listfield,BoundColumn,menusize){
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    echo "<SELECT Name='" & FName & "' size='" & menusize & "' style='font-size: 9pt; font-family: �s�ө���'>"
    If RS1.EOF then
	echo "<OPTION>" & " " & "</OPTION>"
    End If
    'if BoundColumn="" or IsNull(BoundColumn) then
       echo "<OPTION selected value=''>" & " " & "</OPTION>"
    'end if    
    While Not RS1.EOF
	If RS1(FName)=BoundColumn then
	   strSelected = "selected"
	else
	   strSelected = ""
	End if      
	echo "<OPTION " & strSelected & " value='" & RS1(FName) & "'>" & RS1(Listfield) & "</OPTION>"
	RS1.MoveNext
    Wend
    echo "</SELECT>"
    RS1.Close
}

Function OptionList2 (SQL,FName,Listfield,BoundColumn,menusize){
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    echo "<SELECT Name='" & FName & "' size='" & menusize & "' style='font-size: 9pt; font-family: �s�ө���'>"
    If RS1.EOF then
	   echo "<OPTION>" & " " & "</OPTION>"
    End If
    if BoundColumn="" or IsNull(BoundColumn) then
       echo "<OPTION selected value=''>" & " " & "</OPTION>"
    end if    
    While Not RS1.EOF
	if Instr(BoundColumn,RS1(FName)) > 0 then      
	   echo "<OPTION " & strSelected & " value='" & RS1(FName) & "'>" & RS1(Listfield) & "</OPTION>"
	end if   
	RS1.MoveNext
    Wend
    echo "</SELECT>"
    RS1.Close
}

Function CheckBoxList (SQL,FName,Listfield,BoundColumn){
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    session("FieldsetCount")=RS1.RecordCount
    Dim i
    I = 1
    While Not RS1.EOF
      	if Instr(BoundColumn,RS1(FName)) > 0 then
         	StrChecked="checked"
      	else
            StrChecked=""   
      	end if   
		echo "<Input Type='checkbox' " & StrChecked & " Name='" & FName &"' ID='" & FName & I & "' value='" & RS1(FName) & "'>" & RS1(Listfield) & "&nbsp;"
        I = I + 1
		RS1.MoveNext
    Wend
    RS1.Close
}

Function RadioBoxList (SQL,FName,Listfield,BoundColumn,NoChecked){
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    session("FieldsetCount")=RS1.RecordCount
    Dim i
    I = 1
    While Not RS1.EOF
      if BoundColumn="" then
         if I = NoChecked then
            StrChecked="checked"
         else
            StrChecked=""   
         end if  
      else
         If RS1(FName)=BoundColumn then
    		StrChecked="checked"
    	 else
            StrChecked=""   
         end if
      end if   	
	  echo "<Input Type='radio' " & StrChecked & " Name='" & FName &"' ID='" & FName & I & "' value='" & RS1(FName) & "'>" & RS1(Listfield)
      I = I + 1
	RS1.MoveNext
    Wend
    RS1.Close
}

Function CheckBoxData (SQL,FName,DataName,DataNum,StrChecked){
    Set RS1 = Server.CreateObject("ADODB.RecordSet")
    RS1.Open SQL,Conn,1,1
    session("FieldsetCount")=RS1.RecordCount
    FieldsCount = RS1.Fields.Count-1
    Dim i, j
    j = 1
    K = FieldsCount - DataNum
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>"
    echo "<tr>"
    echo "<td bgcolor='#FFE1AF'><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>���</span></font></td>"
    For i = 1 To FieldsCount
	echo "<td bgcolor='#FFE1AF'><font color='#111111'><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i).Name & "</span></font></td>"
    Next
    echo "</tr>"
    While Not RS1.EOF
	echo "<tr bgcolor='#FFFFFF' onmouseover='this.bgColor=""#E2F1FF""' onmouseout='this.bgColor=""#FFFFFF""'>"
        echo "<td><span style='font-size: 9pt; font-family: �s�ө���'><Input Type='checkbox'" & StrChecked & " Name='" & FName & j & "' value='" & RS1(FName) & "'>" & "</span></td>"
	For i = 1 To FieldsCount
            if i > k then
	           echo "<td><span style='font-size: 9pt; font-family: �s�ө���'><input type='text' name='" & DataName & i & j & "' size='4' style='font-size: 9pt; font-family: �s�ө���' value='" & RS1(i) & "'></span></td>"
            else
               echo "<td><span style='font-size: 9pt; font-family: �s�ө���'>" & RS1(i) & "</span></td>"
            end if
	Next 
        j = j + 1   
        RS1.MoveNext
	echo "</tr>"
    Wend
    echo "</table>"
    RS1.Close
}

function radioFun(data,data1){
	if data = data1 then radioFun = "checked" end if
}

function checkFun(data,data1){
	if Instr(data,data1) > 0 then checkFun = "checked" end if
}

Function AddSQL (SQL){
    On error resume next
    set RS=Server.CreateObject("ADODB.Recordset")
    RS.Open sql,conn,1,3
    conn.close
    select case err.number
      case 0 session("msg")="�T�� : �s�W��Ʀ��\ !"
      case -2147217900 session("msg")="���~�T�� : ��Ƥw�g�s�b, �L�k�s�W !"
      case -2147217873 session("msg")="���~�T�� : ��Ƥw�g�s�b, �L�k�s�W !"
      case else
        session("msg")="���~ : " & err.number & "  " & err.description
    end select
    session("errnumber")=err.number
}

Function UpdateSQL (SQL){
    On error resume next
    set RS=Server.CreateObject("ADODB.Recordset")
    RS.Open sql,conn,1,3
    conn.close
    select case err.number
      case 0 session("msg")="�T�� : ���ʸ�Ʀ��\ !"
      case -2147217873 session("msg")="���~�T�� : ��Ƥw�g�s�b, �L�k�s�W !"
      case else
        session("msg")="���~ : " & err.number & "  " & err.description
    end select
    session("errnumber")=err.number
}

Function ExecSQL (SQL){
    On error resume next
    Set RS=Conn.Execute(SQL)
    select case err.number
      case 0 session("msg")="�T�� : ���ʸ�Ʀ��\ !"
      case -2147217900 session("msg")="���~�T�� : ��Ƥw�g�s�b, �L�k�s�W !"
      case -2147217873 session("msg")="���~�T�� : ��Ƥw�g�s�b, �L�k�s�W !"
      case else
        session("msg")="���~ : " & err.number & "  " & err.description
    end select
    session("errnumber")=err.number
}

Function QuerySQL (SQL,RS){
    set RS=Server.CreateObject("ADODB.Recordset")
    
    RS.Open sql,conn,1,1
}	

Function SPSQL (SpName,RS){
    Set cmd=Server.CreateObject("ADODB.Command")
    Set cmd.ActiveConnection=conn
    cmd.CommandText=SpName
    Set RS=cmd.Execute
}

Function SpParam (SpName,Param,SpType,SpLength,SpValue,RS){
    Set cmd=Server.CreateObject("ADODB.Command")
    Set cmd.ActiveConnection=conn
    cmd.CommandText=SpName
    cmd.Parameters.Append cmd.CreateParameter(Param,SpType,1,SpLength,SpValue)
    Set RS=cmd.Execute
}

Function Warning (msg){
    echo "<script Language='JavaScript'> alert('" & msg & "')"
    echo "</script>"
}

Function Message(){
    if session("errnumber")=0 then
       echo "<center>"&session("msg")&"</center>"
    else
       echo "<script Language='JavaScript'> alert('" & session("msg")&"')"
       echo "</script>"
    end if
    session("msg")=""
    session("errnumber")=0
}

Function CheckNumber (FName,ListField){
    echo "if Not IsNumeric(form." & FName & ".value) then " & Chr(13) & Chr(10)
    echo "   msgbox "& Chr(34) & ListField & " ��쥲�����Ʀr !"&Chr(34) & Chr(13) & Chr(10)
    echo "   form." & FName &".focus " & Chr(13) & Chr(10)
    echo "   exit sub " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
}

Function CheckInt (FName,ListField){
    echo "if InStr(form." & FName & ".value,"&Chr(34)&"."&Chr(34)&")>0 or form." & FName & ".value<=0 then " & Chr(13) & Chr(10)
    echo "   msgbox "& Chr(34) & ListField & " ��쥲�����j��0����� !"&Chr(34) & Chr(13) & Chr(10)
    echo "   form." & FName &".focus " & Chr(13) & Chr(10)
    echo "   exit sub " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
}

Function CheckString (FName,ListField){
    echo "if form." & FName & ".value="&Chr(34)&Chr(34)&" then " & Chr(13) & Chr(10)
    echo "   msgbox "& Chr(34) & ListField & " ��줣�i���ť� !"&Chr(34) & Chr(13) & Chr(10)
    echo "   form." & FName &".focus " & Chr(13) & Chr(10)
    echo "   exit sub " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
}

Function CheckDate (FName,ListField){
    echo "if form." & FName & ".value<>"&Chr(34)&Chr(34)&" then " & Chr(13) & Chr(10)
    echo "if Not IsDate(form." & FName & ".value) or (left((form." & FName & ".value),1)<>"&Chr(34)&"2"&Chr(34)&" and left((form." & FName & ".value),1)<>"&Chr(34)&"1"&Chr(34)&") then " & Chr(13) & Chr(10)
    echo "   msgbox "& Chr(34) & ListField & " ��쥲�����褸����榡 ! (yyyy/mm/dd)"&Chr(34) & Chr(13) & Chr(10)
    echo "   form." & FName &".focus " & Chr(13) & Chr(10)
    echo "   exit sub " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
} 

Function CheckDateRange (FName1,FName2){
    echo "if form." & FName1 & ".value > form." & FName2 & ".value then " & Chr(13) & Chr(10)
    echo "   msgbox " & Chr(34) & "������j��, �����b�e�� !"&Chr(34) & Chr(13) & Chr(10)
    echo "   form." & FName1 &".focus " & Chr(13) & Chr(10)
    echo "   exit sub " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
}

Function Checklen(FName,CLength,ListField){              //�˴����^�姨���r���ڪ���
    echo "x = form." & FName & ".value" & Chr(13) & Chr(10)
    echo "if blen(x) > " & CLength & " then" & Chr(13) & Chr(10)
    echo "   msgbox "& Chr(34) & ListField & " �����׶W�L���� !"&Chr(34) & Chr(13) & Chr(10)
    echo "   form." & FName &".focus " & Chr(13) & Chr(10)
    echo "   exit sub " & Chr(13) & Chr(10)
    echo "end if " & Chr(13) & Chr(10)
}

Function SaveButton(){
    echo "<button id='save' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/save.gif' width='19' height='20' align='absmiddle'>�s��</button>"
    echo "<button id='cancel' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/icon6.gif' width='20' height='15' align='absmiddle'>�W�@��</button>"
}

Function Edit2Button(){
    echo "<button id='update' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/update.gif' width='19' height='20' align='absmiddle'> �ק�</button>"
    echo "<button id='query' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/search.gif' width='19' height='20' align='absmiddle'>�d��</button>"
    echo "<button id='cancel' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/icon6.gif' width='20' height='15' align='absmiddle'>�W�@��</button>"
}

Function EditButton(){
    echo "<button id='update' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/update.gif' width='19' height='20' align='absmiddle'> �ק�</button>"
    echo "<button id='delete' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/delete.gif' width='19' height='20' align='absmiddle'>�R��</button>"
    echo "<button id='query' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/search.gif' width='19' height='20' align='absmiddle'>�d��</button>"
    echo "<button id='cancel' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/document.gif' width='19' height='20' align='absmiddle'>�W�@��</button>"
}

Function QueryButton(){
    echo "<button id='query' style='position:relative;left:20;width:45;height:40;font-size:9pt'> <img src='../images/search.gif' width='19' height='20'><br>�d��</button>"
    echo "<button id='cancel' style='position:relative;left:30;width:45;height:40;font-size:9pt'> <img src='../images/document.gif' width='19' height='20'><br>�W�@��</button>"
}

Function ReportButton(){
    echo "<button id='report' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg'> <img src='../images/print.gif' width='19' height='20' align='absmiddle'> ����</button>"
    echo "<button id='export' style='position:relative;left:0;width:90;height:25;font-size:9pt' class='button3-bg'> <img src='../images/word.gif' width='19' height='19' align='absmiddle'> �ץX���</button>"
}

Function Report2Button(){
    echo "<button id='report' style='position:relative;left:20;width:45;height:40;font-size:9pt' class='font9'> <img src='../images/print.gif' width='19' height='20'><br>����</button>"
    echo "<button id='help' style='position:relative;left:30;width:45;height:40;font-size:9pt' class='font9'> <img src='../images/help.gif' width='19' height='20'><br>����</button>"
}

Function GetChkNum (GuiNo){
    Dim ChkNum
    X=Array("A0","B1","C2","D3","E4","F5","G6","H7","I8","J9","K0","L1","M2","N3","O4","P5","Q6","R7","S8","T9","U0","V1","W2","X3","Y4","Z5")
    For i=0 to 25
      if Mid(GuiNo,1,1)=Left(X(i),1) then
         A1=CSng(Right(X(i),1))
      end if
      if Mid(GuiNo,2,1)=Left(X(i),1) then
         A2=CSng(Right(X(i),1))
      end if
    Next
    ChkNum=A1+A2*9+CSng(Mid(GuiNo,3,1))*8+CSng(Mid(GuiNo,4,1))*7+CSng(Mid(GuiNo,5,1))*6+CSng(Mid(GuiNo,6,1))*5+CSng(Mid(GuiNo,7,1))*4+CSng(Mid(GuiNo,8,1))*3+CSng(Mid(GuiNo,9,1))*2+CSng(Mid(GuiNo,10,1))
    GetChkNum = 9 - CSng(Right(CStr(ChkNum),1))
}

Function syslog (log_type,log_desc){
    sys_date=date()
    client_IP=Request.ServerVariables("REMOTE_ADDR")
    sql="insert into sys_log values (getdate(),'"&sys_date&"','"&session("user_id")&"','"&session("user_name")&"','"&session("dept_id")&"','"&log_type&"','"&log_desc&"','"&client_IP&"')"
    On error resume next
    Set RS=Conn.Execute(SQL)
}

Function xdate (dt){
    if year(dt) > 99 and year(dt) < 120 then
       xdate=CStr(year(dt)+1911)&"/"&CStr(month(dt))&"/"&CStr(day(dt))
    elseif year(dt)>2000 and year(dt) < 2030 then
       xdate=CStr(year(dt)-89)&"/"&CStr(month(dt))&"/"&CStr(day(dt))
    else       
       xdate=CStr(year(dt)+11)&"/"&CStr(month(dt))&"/"&CStr(day(dt))
    end if   
}

Function sdate (dt){
    if Not IsNull(dt) then
       sdate=CStr((year(dt)-1911))&"/"&CStr(month(dt))&"/"&CStr(day(dt))
    else
       sdate=""
    end if      
}

function FileUpLoad(FilePath,FName,Fsize,objUpload){
  	set objUpload = Server.CreateObject("Dundas.Upload")
	objUpload.MaxUploadSize = 10485760
	objUpload.UseUniqueNames = True
	objUpload.UseVirtualDir = True
	Set objNextFile = objUpload.GetNextFile()
    objNextFile.Save(FilePath)
    FName = objNextFile.Filename
    For Each objUploadedFile in objUpload.Files  
	   FSize = objUploadedFile.Size 
    Next
}

function MaxFileUpLoads(FilePath,UploadName1,UploadSize1,UploadName2,UploadSize2,UploadName3,UploadSize3,UploadName4,UploadSize4,UploadName5,UploadSize5,UploadName6,UploadSize6,UploadName7,UploadSize7,UploadName8,UploadSize8,UploadName9,UploadSize9,UploadName10,UploadSize10,objUpload,MaxFileSize,MaxUploadSize){
  set objUpload = Server.CreateObject("Dundas.Upload")
  on error resume next
  objUpload.MaxFileCount = 10
  objUpload.MaxFileSize = MaxFileSize*1048576
  objUpload.MaxUploadSize = MaxUploadSize*1048576
  objUpload.UseUniqueNames = True
  objUpload.UseVirtualDir = True
  objUpload.Save FilePath  
  
  I=0
  For Each objUploadedFile in objUpload.Files
    I = I + 1
    If objUploadedFile.Size>0 Then
      If I=1 Then
        UploadName1 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize1 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
      ElseIf I=2 Then
        UploadName2 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize2 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
      ElseIf I=3 Then
        UploadName3 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize3 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
      ElseIf I=4 Then
        UploadName4 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize4 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
      ElseIf I=5 Then
        UploadName5 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize5 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
      ElseIf I=6 Then
        UploadName6 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize6 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
      ElseIf I=7 Then
        UploadName7 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize7 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","") 
      ElseIf I=8 Then
        UploadName8 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize8 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
      ElseIf I=9 Then
        UploadName9 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize9 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")
      ElseIf I=10 Then
        UploadName10 = objUpload.GetFileName(objUploadedFile.path)
        UploadSize10 = replace(FormatNumber((objUploadedFile.Size/1024),2),",","")                                                       
      End If
    End If
  Next
}

Function ChineseMoney( lmoney ){
sDallor = cstr( lMoney)
chDallor = array("", "�B", "��", "�a", "�U","�B","��", "�a","��","�B","��", "�a","��")
chB = array("", "�U","��","��")
for i= 1 to len(sDallor) step 1
        if mid(sDallor, i, 1)<>"0" then
                xx = xx & mid(sDallor, i, 1) & chDallor(len(sDallor)-i) '&"�U"
        else
                if right(xx, 1)<>"�s" then
                        If ((len(sDallor)-i) mod 4) = 0 then
                        xx = xx & chB( ( len(sDallor) - i) \ 4 )
                        else 
                        xx = xx & "�s"
                        End If
                else
                        If ((len(sDallor)-i) mod 4) = 0 then
                        'msgbox "i = " & i & " xx=" & xx
                        xx= mid(xx, 1, len(xx)-1) & chB( ( len(sDallor) - i) \ 4 )
                        End If
                end if
        end if
next

        if right(xx, 1)="�s" then xx = mid(xx,1,len(xx)-1)
        xx = replace( xx, "1", "��")
        xx = replace( xx, "2", "�L")
        xx = replace( xx, "3", "��")
        xx = replace( xx, "4", "�v")
        xx = replace( xx, "5", "��")
        xx = replace( xx, "6", "��")
        xx = replace( xx, "7", "�m")
        xx = replace( xx, "8", "��")
        xx = replace( xx, "9", "�h")

        ChineseMoney= xx & "����"
}

Function Calendar (FName,Val){
  echo "<input type=text name="&FName&" size=10 class=font9 value="&Val&">" & Chr(13) & Chr(10)
  echo "<a href onclick=cal19.select(document.forms[0]."&FName&",'"&FName&"','yyyy/MM/dd');>" & Chr(13) & Chr(10)
  echo "<img border=0 src=../images/date.gif width=16 height=14></a>" & Chr(13) & Chr(10)
}

Function CheckStringJ (FName,ListField){
  echo "if(document.form." & FName & ".value==''){" & Chr(13) & Chr(10)
  echo "  alert('"& ListField & "  ��줣�i���ťաI');" & Chr(13) & Chr(10)
  echo "  document.form." & FName & ".focus();" & Chr(13) & Chr(10)
  echo "  return;" & Chr(13) & Chr(10)
  echo "}" & Chr(13) & Chr(10)
}
?>
<SCRIPT language JavaScript>
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</SCRIPT>