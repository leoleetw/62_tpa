<?php
Sub SendMessage (FromName,FromEmail,ToName,ToEmail,cc,Subject,MailType,Content,AttachFile)
    Set Mail=CreateObject("CDO.Message")
    Mail.Subject=Subject
    Mail.From=FromName & "<" & FromEmail & ">"
    Mail.To=ToName & "<" & ToEmail & ">"
    if cc <> "" then
       Mail.cc = cc
    end if
    if MailType="html" then
       Mail.HTMLBody=Content
    elseif MailType="WebPage" then
       Mail.CreateMHTMLBody Content
    else
       Mail.TextBody=Content
    end if
    if AttachFile <> "" then
       Mail.AddAttachment Server.MapPath(AttachFile)
    end if
    Mail.Send
    set Mail=nothing
end sub

Sub SendJMail (FromName,FromEmail,ToName,ToEmail,cc,Subject,MailType,Content,AttachFile,server_url)
    Set JMail = Server.CreateObject("JMail.Message")
    JMail.Charset = "Big5"
    JMail.From = FromEmail
    JMail.FromName = FromName
    JMail.MailServerUserName = "Webmaster@give.org.tw"
    JMail.MailServerPassWord = "TpicGIVE1679"
    JMail.Subject = Subject
    JMail.AddRecipient ToEmail,ToName
    if cc <> "" then
       JMail.AddRecipientCC cc
    end if
    if MailType="html" then
       JMail.HTMLBody= Content
    else 
       JMail.Body = Content
    end if
    if AttachFile<>"" then
       contentId = JMail.AddAttachment(Server.MapPath(AttachFile))
    end if   
    JMail.Priority = 3
    JMail.Send(server_url)
    Set JMail = Nothing
End sub

Sub SendEmailtoRaw (FromEmail,ToEmail,Subject,mc,Content)
    Set FS = Server.CreateObject("Scripting.FileSystemObject")
    Set F = FS.OpenTextFile("D:\Inetpub\Mailroot\pickup\"&mc&".RAW",2,True)
    F.WriteLine("x-sender: "&FromEmail )
    F.WriteLine("x-receiver: "&ToEmail )
    F.WriteLine("From: "&FromEmail)
    F.WriteLine("To: "&ToEmail )
    F.WriteLine("Subject: "&Subject )
    F.WriteLine("Content-Type: multipart/related; boundary=""==PageRelatedBoundary"";type=""text/html""")
    F.WriteLine("")
    F.WriteLine("This is a multi-part message in MIME format.")
    F.WriteLine("")
    F.WriteLine("--==PageRelatedBoundary")
    F.WriteLine("Content-Type: text/html; charset=""big5""")
    F.WriteLine("")
    F.Write(Content)
    F.WriteLine("")
    F.Close
    Set F = Nothing
End Sub

Sub SendEmailtoMDaemon (FromName,FromEmail,ToName,ToEmail,Subject,mc,Content)
    Set FS = Server.CreateObject("Scripting.FileSystemObject")
    Set F = FS.OpenTextFile("D:\MDaemon\Queues\Raw\"&mc&".RAW",2,True)
    F.WriteLine("From <"&FromName&" <"&FromEmail&">>")
    F.WriteLine("To <"&ToName&" <"&ToEmail&">>")
    F.WriteLine("Subject < "&Subject&" >")
    F.WriteLine("Header <Content-Type: multipart/related; boundary=""==PageRelatedBoundary""; type=""text/html"">")
    F.WriteLine("")
    F.WriteLine("This is a multi-part message in MIME format.")
    F.WriteLine("")
    F.WriteLine("--==PageRelatedBoundary")
    F.WriteLine("Content-Type: text/html; charset=""big5""")
    F.WriteLine("")
    F.Write(Content)
    F.WriteLine("")
    F.Close
    Set F = Nothing
End Sub

Function WinHttp (MailLink)
    Dim whttp
    Set wHttp=Server.CreateObject("WinHttp.WinHttpRequest.5.1")
    wHttp.Open "POST", MailLink
    wHttp.SetRequestHeader "Content-Type", "application/x-www-form-urlencoded"
    wHttp.Send
    WinHttp=wHttp.ResponseText
End Function
?>