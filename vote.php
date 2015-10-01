<!doctype html>
<?
include_once("include/dbinclude.php");
@$nowPage = isset($_POST["nowPage"]) ? $_POST['nowPage'] : $_GET['nowPage'] ;
if($nowPage == "")
	$nowPage = '1';
@$data_year = isset($_POST["data_year"]) ? $_POST['data_year'] : $_GET['data_year'] ;
if($data_year == "")
	$data_year = date("Y");
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
  <link href="css/tpa_vote.css" rel="stylesheet">
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
                <a href="#" class="nav" onclick="location.href='active.php';"><li>活動看板</li></a>
        		<a href="#" class="nav" onclick="location.href='pic.php';"><li>活動剪影</li></a>
        		<a href="#" class="nav" onclick="location.href='gloria.php';"><li>光彩與榮耀</li></a>
                <a href="#" style="text-decoration:none;" onclick="location.href='vote.php';"><li class="nav_hover">票選活動</li></a>
      		</ul>
    		</div>
                <div class="leftNav_bottom"></div>            	
    		</div>   
				<div id="main_content">
					<form id='form1' action='vote.php'>
						<div id="vote_title"></div>
						<div>
                        	<table>
                                <tr>
                                    <th>
                                        投票主題
                                    </th>
                                    <th>
                                        投票期限
                                    </th>
                                    <th>
                                        我要投票
                                    </th>
                                </tr>
							<?
								$sys_date=date("Y-m-d h:i:s");
								$pageSize = 10;
								$sql = "Select * From qa Where Qa_Active='Y' And Qa_BeginDate<='".date("Y-m-d h:i:s")."' Order By Qa_SerNo Desc";
								$result = mysqli_query($sqli,$sql." limit ".((intval($nowPage)-1)*$pageSize).",".$pageSize." ");
								$rs_temp = mysqli_query($sqli,$sql);
								$rs_cn = mysqli_num_rows($rs_temp);
								$pagecount = ceil($rs_cn/$pageSize);
								for($i = 0 ; ($i < $row = mysqli_fetch_array($result)) && $i < $pageSize ; ++$i){
							?>
									
										<tr>
											<td>
												<? echo $row["Qa_Subject"]; ?>
											</td>
											<td>
												<? echo mysqldate($row["Qa_BeginDate"]); ?>~<? echo mysqldate($row["Qa_EndDate"]);?>
											</td>
                                            <td>
                                            <?
														if(dateDiff(date("Y-m-d h:i:s"),mysqldate($row["Qa_EndDate"])) > -1){
												//If DateDiff("d",date(),RS("Qa_EndDate"))>-1 Then
											  ?>
													  <a href="vote_voting.php?qa_serno=<? echo $row["Qa_SerNo"]; ?>"><img border="0" src="images/vote_voting.png"></a>
											  <?
													}
													else{
											  //Else
											  ?>
											  <a href="vote_result.php?qa_serno=<? echo $row["Qa_SerNo"]; ?>"><img border="0" src="images/vote_result.png"></a>
												<?
															}
												//End If
											  ?>
                                            </td>
										</tr>
									
							<?
								}
							?>
								</table>
              <?
                if($nowPage < $pagecount){
									echo "<input type='button' id='btn_down' onclick=page_change('down') value='下一頁'>";
								}
								if($nowPage !=1){
									echo "<input type='button' id='btn_up' onclick=page_change('up') value='上一頁'>";
								}
								
							?>
							<input type="hidden" id="nowPage" name="nowPage" value="<? echo $nowPage;?>">
						</div>
					</form>
				</div>
                <div id="clear"></div>
		</div>
	<div class="banner">
		<div class="banner_bg">
	        <div class="middle_section">
	        	<div id="active_banner_img"></div>	   	  	  	
	        </div>
	  	</div>
    </div>
    <footer>
		<? include_once("footer.php"); ?>
	</footer>
	<?
		Message();
	?>
	<script>
		function page_change(this_action){
			if(this_action =="up"){
				Dd("nowPage").value=parseInt(Dd("nowPage").value)-1;
				Dd('form1').submit();
			}
			else{
				Dd("nowPage").value=parseInt(Dd("nowPage").value)+1;
				Dd('form1').submit();
			}
		}
</script>
</body>