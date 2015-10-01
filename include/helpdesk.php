<?php
	response.buffer =true
  response.expires=0
  On Error Resume Next
  Set FS=Server.CreateObject("Scripting.FileSystemObject")
  FileExist1=FS.FileExists(Server.MapPath(Request.QueryString("help_id")))
  if Err=0 and FileExist1 then
     Response.redirect Request.QueryString("help_id")
  end if
?>
<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
<link REL="stylesheet" type="text/css" HREF="../include/dms.css">
<title>說明</title>
</HEAD>
<BODY class=tool>

<table border="0" width="100%" cellspacing="0">
  <tr>
    <td width="100%" height="25" bgcolor="#cccc99" class="font11"><b><img border="0" src="../images/icon6.GIF" align="absmiddle">操作說明</b></td>
  </tr>
  <tr>
    <td width="100%">
    
    <table border="0" width="100%">
      <tr>
        <td width="5%" align="center" height="25"></td>
        <td width="95%" height="25"></td>
      </tr>
      <tr>
        <td width="5%" align="right"><img border="0" src="../images/error.GIF" align="absmiddle"></td>
        <td width="95%"><font size="3"><b> 說明檔案不存在 !</b></font></td> 
      </tr> 
    </table> 
    <p>&nbsp; </p>
     
    </td> 
  </tr> 
</table> 
</BODY>
</HTML>