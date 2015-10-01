<!doctype html>
<?
include_once("include/dbinclude.php");
@$act_id = isset($_POST["act_id"]) ? $_POST['act_id'] : $_GET['act_id'] ;
$sql="select * from activity where act_id='".$act_id."'";
	$res = QuerySQL($sql);
	if(count($res)!=0){
		$ImgPosition=$res[0]["Act_ImgPosition"];
		$object_id=$res[0]["Act_id"];
		$content_desc=$res[0]["Act_Content"];
	}

	$sql="select * from upload where Ap_Name='activity' and attach_type not in ('doc','img') and object_id='".$object_id."'";
	$res2 = QuerySQL($sql);

	$sql="select * from upload where Ap_Name='activity' and attach_type='doc' and object_id='".$object_id."'";
	$res3 = QuerySQL($sql);
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
  <link href="css/tpa.css" rel="stylesheet">
  <link href="css/tpa_active_content.css" rel="stylesheet">
	<!-- jQuery Version 1.11.0 -->
	<script src="js/jquery-1.11.0.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="include/ajax.js"></script>
</head>
<body>
	<header>
		<? include_once("header.php"); ?>
	</header>
	<div class="middle_section">
			<div id="about_main_nav">
            	<div id="active_banner_nav"></div>
            	<div class="leftNav_top"><img src="images/about_nav_img" width="210px" height="66px"></div>
                <div class="leftNav_mid">
      		<ul>
        		<a href="#" style="text-decoration:none;"><li class="nav_hover">活動看板</li></a>
        		<a href="#" class="nav" onclick="location.href='pic.php';"><li>活動剪影</li></a>
        		<a href="#" class="nav" onclick="location.href='gloria.php';"><li>光彩與榮耀</li></a>
        		<a href="#" class="nav" onclick="location.href='vote.php';"><li>票選活動</li></a>
      		</ul>
            </div>
            <div class="leftNav_bottom"></div>
    	</div>
				<div id="main_content">
					<div><input type='button' value='回上頁' onclick="history.go(-1)"></div>
					<div>
						<table>
							<tr>
								<td>
								<table border="0" width="764" id="table21" cellspacing="0" cellpadding="0" height="340">
									<tr>
										<td valign="top" height="340" width="681">
										<table border="0" width="674" id="table22" cellspacing="0" cellpadding="0" height="26">
											<tr>
												<td width="87" valign="top">
												<font color="#333333" style="font-size: 11pt"><b>
												活動名稱：</b></font></td>
												<td width="241" valign="top">
												<? echo $res[0]["Act_Subject"]; ?></td>
												<td width="89" align="right" valign="top">
												<font color="#333333" style="font-size: 11pt"><b>
												活動講師：</b></font></td>
												<td width="257" valign="top">
												<? echo $res[0]["Act_ShortName"]; ?></td>
											</tr>
										</table>
										<table border="0" width="674" id="table23" cellspacing="0" cellpadding="0" height="30">
											<tr>
												<td width="86">
												<font color="#333333" style="font-size: 11pt"><b>
												活動日期：</b></font></td>
												<td width="243">
												<? echo mysqldate($res[0]["Act_RegDate"]); ?></td>
												<td width="89" align="right">
												<font color="#333333" style="font-size: 11pt"><b>
												報名日期：</b></font></td>
												<td width="256">
												<font color="#FF0000"><span lang="EN-US" style="font-family: 新細明體"><font style="font-size: 11pt"><? echo $res[0]["Act_Period"]; ?></font></span></font></td>
											</tr>
										</table>
										<table border="0" width="674" id="table24" cellspacing="0" cellpadding="0" height="27">
											<tr>
												<td width="86">
												<font color="#333333" style="font-size: 11pt"><b>
												活動地點：</b></font></td>
												<td width="243">
												<? echo $res[0]["Act_Place"]; ?></td>
												<td width="89" align="right">
												<font color="#333333" style="font-size: 11pt"><b>
												活動地址：</b></font></td>
												<td width="256">
												<? echo $res[0]["Act_Org"]; ?></td>
											</tr>
										</table>
										<table border="0" width="674" id="table25" cellspacing="0" cellpadding="0" height="27">
											<tr>
												<td width="86">
												<font color="#333333" style="font-size: 11pt"><b>
												活動費用：</b></font></td>
												<td width="588">
													<?
													echo $res[0]["Act_brief"];
													//echo replace( $res[0]["Act_Brief"],vbcrld,"<br>"); //不知為何
													?>
												　</td>
											</tr>
										</table>
										<table border="0" width="99%" id="table26" cellspacing="0" cellpadding="0" height="176">
											<tr>
												<td valign="top">
												<table border="0" width="100%" id="table27" cellspacing="0" cellpadding="0" height="325">
													<tr>
														<td height="41">
														<font color="#333333" style="font-size: 11pt">
														<b>詳細內容：</b></font></td>
													</tr>
													<tr>
														<td valign="top" width="680">
														<?
														if($ImgPosition=="bottom")
															echo $content_desc;
	                  						?>
	                						<TABLE cellSpacing=0 cellPadding=6 width=98 align=<? echo $ImgPosition; ?> border=0>
	                  						<?
	                  						for($res2_i=0 ; $res2_i < count($res2) ; ++$res2_i){
	                  						//While Not RS2.EOF
	                  						?>
	                    						<TR>
	                      							<TD align=middle>
	                      							<?
	                      							if($res2[$res2_i]["Attach_Type"]=="image"){
	                      							//if RS2("attach_type")="image" then
	                      							?>
	                      							<IMG src="upload/<? echo $res2[$res2_i]["Upload_FileURL"]; ?>" width="550" border=0 alt="<? echo $res2[$res2_i]["Upload_FileName"]; ?>">
	                      							<?
	                      							}
	                      							?>
	                      							</TD>
	                    						</TR><!-- 圖說 -->
	                    						<TR>
	                      							<TD><font color="#4B640B" size="2"><? echo $res2[$res2_i]["Upload_FileName"]; ?></font></TD>
	                    						</TR>
	                  						<?
	                  					}
	                   						 ?>
	                						</TABLE>
	                						<?
	                						if($ImgPosition != "bottom")
	                							echo $content_desc;
	                						/*
	                						if ImgPosition<>"bottom" then
	                    						 echo content_desc
	                  						end if
	                  						*/
	                  						?>
														</td>
													</tr>
												</table>
												<table border="0" width="674" id="table28" cellspacing="0" cellpadding="0">
													<tr>
														<td width="674" height="22" colspan="2">
														　</td>
													</tr>
													<tr>
														<td width="337">
														<p align="left">
														<?
														if(count($res3)!=0){
														//if Not RS3.EOF then
														?>
														<a href="upload/<? echo $res3[0]["Upload_fileURL"]; ?>"><img border="0" src="images/3-1-1active_25A.gif" width="120" height="25"></a>
														<?
														}
														?></td>
														<td width="337">
														<!--font style="font-size: 11pt">
														<a href style="cursor:hand" onclick="history.back();">
														<img border="0" src="images/3-1-1active_25.gif" width="76" height="28" align="right"></a></font-->
														<input type='button' value='回上頁' onclick="history.go(-1)">
														</td>
													</tr>
												</table>
												</td>
											</tr>
										</table>
										</td>
									</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
				</div>
		</div>
	<footer>
		<? include_once("footer.php"); ?>
	</footer>
	<script>
</script>
</body>