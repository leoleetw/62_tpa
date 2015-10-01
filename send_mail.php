<?
	if(@$_POST["action"] == "send"){
		require("js/mailer/class.phpmailer.php");
		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->CharSet = "utf-8"; 
		//這幾行是必須的
		
		
		$mail->Username = 'papcada1.clayart@gmail.com'; //
		$mail->Password = 'Q92001532'; //
		//這邊是你的gmail帳號和密碼
		
		$mail->FromName = "麵包花協會(".@$_POST["name"].")";
		// 寄件者名稱(你自己要顯示的名稱)
		$webmaster_email = @$_POST["email"]; 
		//回覆信件至此信箱
		
		
		$email="papcada1.clayart@gmail.com"; //papcada.clayart@yahoo.com.tw
		// 收件者信箱
		$name="clayart";
		// 收件者的名稱or暱稱
		$mail->From = $webmaster_email;
		
		
		$mail->AddAddress($email,$name);
		$mail->AddReplyTo($webmaster_email,"Squall.f");
		//這不用改
		
		$mail->WordWrap = 50;
		//每50行斷一次行
		
		//$mail->AddAttachment("/XXX.rar");
		// 附加檔案可以用這種語法(記得把上一行的//去掉)
		
		$mail->IsHTML(true); // send as HTML
		
		$content = "姓名：".@$_POST["name"]." ";
		if(@$_POST["sex"]=="0")
			$content .= "先生<br/><br/>";
		else
			$content .= "小姐<br/><br/>";
		$content .= "電話：".@$_POST["phone"]."<br/><br/>";
		$content .= "留言：".@$_POST["contant"]."";
		$mail->Subject = "台灣麵包花與紙黏土藝品推展協會-問題發送"; 
		// 信件標題
		$mail->Body = $content;
		//信件內容(html版，就是可以有html標籤的如粗體、斜體之類)
		$mail->AltBody = $content; 
		//信件內容(純文字版)
		
		if(!$mail->Send()){
		echo "寄信發生錯誤：" . $mail->ErrorInfo;
		//如果有錯誤會印出原因
		}
		else{ 
			echo "寄信成功 ";
			echo "<script>window.close();</script>";
		}
	}
?>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>台灣麵包花與紙黏土藝品推展協會</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/send_mail.css" rel="stylesheet">
<!-- jQuery Version 1.11.0 -->
<script src="js/jquery-1.11.0.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="include/ajax.js"></script>
</head>
<body>
	<div id="send_mail">
		<form id="form1" action="send_mail.php" method="post">
        <div id="mail_background" style="width:540px;height=620;text-align:center;">
        <div id="mail_title_image"></div>
		<table width="96%" class="mail_table">
			<tr>
				<td class="dark_green01" width="30%">
					姓名：
				</td>
				<td width="70%" class="light_green">
					<input type="text" id="name" name="name" value="">
                    <input type="radio" id="sex0" name="sex" value="0">先生
					<input type="radio" id="sex1" name="sex" value="1">小姐
				</td>
			</tr>
			<tr>
				<td class="dark_green01">
					電話：
				</td>
				<td class="light_green">
					<input type="text" id="phone" name="phone" value="">
				</td>
			</tr>
			<tr>
				<td class="dark_green01">
					E-mail：
				</td>
				<td class="light_green">
					<input type="text" id="email" name="email" value="">
				</td>
			</tr>
			<tr>
				<td class="dark_green02">
					留言：
				</td>
				<td class="light_green">
					<textarea id="contant" name="contant" rows="5" cols="50"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="hidden" id="action" name="action" value="send">
					<div><input type="button" value="寄出" onclick="send_mail();"></div>
				</td>
			</tr>
		</table>
        </div>
		</form>
	</div>
	<script>
		function send_mail(){
			if(Dd("name").value=="" || Dd("email").value==""|| Dd("contant").value==""){
				alert("尚有必要欄位未填寫!");
				return;
			}
			else{
				Dd('form1').submit();
			}
		}
	</script>
</body>

