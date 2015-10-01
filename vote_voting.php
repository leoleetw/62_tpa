<!doctype html>
<?
include_once("include/dbinclude.php");
@$qa_serno = isset($_POST["qa_serno"]) ? $_POST['qa_serno'] : $_GET['qa_serno'] ;
@$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
if($_SESSION["User_id"]==""){
	$_SESSION['errnumber']=1;
	$_SESSION['msg']="請先登入會員，在進行投票 !";
	header("Location:index.php");
}
else{
	$sql="Select * From QA_Temp Where QA_Temp_IDNO = '".$_SESSION["User_id"]."' And Qa_SerNo = '".$qa_serno."';";
	$result = mysqli_query($sqli,$sql);
	$rs_cn = mysqli_num_rows($result);
	if($rs_cn > 0){
		$_SESSION['errnumber']=1;
		$_SESSION['msg']="您已經投過票了,請勿重覆投票 !";
		header("Location:vote.php");
	}
}

if($action=="save"){
	@$select_item = isset($_POST["select_item"]) ? $_POST['select_item'] : $_GET['select_item'] ;
	$sql = "Select * From QA Where Qa_SerNo = '".$qa_serno."' And Qa_Active='Y' And ('".date("Y-m-d h:i:s")."' Between Qa_BeginDate And Qa_EndDate);";
	$rs = QuerySQL($sql);
	if(count($rs)!=0){
		$_SESSION["errnumber"]=1;
	  $_SESSION["msg"]="投票尚未開始或已結束";
	  header("Location: index.php");
	}
	$ip = getip();
	$sql="Select * From QA_Temp Where QA_Temp_IDNO = '".$_SESSION["User_id"]."' And Qa_SerNo = '".$qa_serno."' And Year(QA_Temp_RegDate) = '".date("Y")."';";
	$rs = QuerySQL($sql);
	if(count($rs)!=0){
		$_SESSION["errnumber"]=1;
    $_SESSION["msg"]="您已經投過票了,請勿重覆投票 !";
	}
	else{ //寫入投票資訊, 之後可以判斷是否重覆投票
		if($qa_serno!="")
			$sql = "insert into qa_temp( QA_SerNo, QA_Temp_IDNO, QA_Temp_RegDate, QA_Temp_IP, QA_Item) values('".$qa_serno."','".$_SESSION["User_id"]."','".date("Y-m-d h:i:s")."','".$ip."',NULL);";
		else{
			$_SESSION["errnumber"]=1;
	    $_SESSION["msg"]="投票資訊有誤，請重新投票!";
			header("vote.php");
		}
		mysqli_query($sqli,$sql);
		$Ser_no = mysqli_insert_id($sqli);
		$Survey_id = $Ser_no;
		@$qa_id = isset($_POST["qa_id"]) ? $_POST["qa_id"] : $_GET["qa_id"] ;
		@$qa_item = isset($_POST["qa_item"]) ? $_POST["qa_item"] : $_GET["qa_item"] ;
		@$qa_name = isset($_POST["qa_name"]) ? $_POST["qa_name"] : $_GET["qa_name"] ;
		$sql_rs3 = "insert into survey_option( Survey_id, Qa_SerNo, Qa_id, Qa_name, Qa_Item, Qa_Answer) VALUES ('".$Survey_id."' , '".$qa_serno."', '".$qa_id."', '".$qa_name."', '".$qa_item."', NULL);"; //沒跑
		mysqli_query($sqli,$sql_rs3);
		

		$sql4 = "Select * From qafileitem Where Qa_item='".$qa_item."' and qa_serno='".$qa_serno."';";
		$result4 = mysqli_query($sqli,$sql4);
		$row4 = mysqli_fetch_array($result4);
		$sql5 = "Insert Into SURVEY_STAT( Qa_SerNo, Survey_id, Qa_id, Qa_item, Qa_author, Seq) Values (".$qa_serno.",".$Survey_id.",".$qa_id.",'".$qa_item."','".$row4["Qa_author"]."','".$row4["Seq"]."');"; //沒跑
		mysqli_query($sqli,$sql5);
		$sql5 = "Update qafileitem set Vote_count = ".(intval($row4["Vote_count"])+1)." where Qa_item='".$qa_item."' and qa_serno='".$qa_serno."';"; //有跑
		mysqli_query($sqli,$sql5);
		$_SESSION["errnumber"]=1;
    $_SESSION["msg"]="完成投票 ! 感謝您的參與";
		header("vote.php");
	}
}
/*
@$nowPage = isset($_POST["nowPage"]) ? $_POST['nowPage'] : $_GET['nowPage'] ;
if($nowPage == "")
	$nowPage = '1';
@$data_year = isset($_POST["data_year"]) ? $_POST['data_year'] : $_GET['data_year'] ;
if($data_year == "")
	$data_year = date("Y");
	*/
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
  <link href="css/tpa_vote_voting.css" rel="stylesheet">
	<!-- jQuery Version 1.11.0 -->
	<script src="js/jquery-1.11.0.js"></script>
	
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="include/ajax.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
</head>
<body onload="img_resize();">
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
					<form id='form1' action='vote_voting.php'  method="POST">
						<input type="hidden" id="qa_serno" name="qa_serno" value="<? echo $qa_serno; ?>">
						<div>
							<?
								$sys_date=date("Y-m-d h:i:s");
                $sql = "Select * From QA Where Qa_SerNo=".$qa_serno." And Qa_Active='Y' And ('".$sys_date."' Between Qa_BeginDate And Qa_EndDate);";
                $result = mysqli_query($sqli,$sql);
                $row = mysqli_fetch_array($result);
              	$Qa_Subject=$row["Qa_Subject"];
                $Qa_BeginDate=$row["Qa_BeginDate"];
                $Qa_EndDate=$row["Qa_EndDate"];
                if($row["Qa_Comment"]!=""){
                	$Qa_Comment=$row["Qa_Comment"];
                }
                else
                	$Qa_Comment="";
							?>
								<div>
									<table id="voting_table01">
										<tr>
										  <td id="voting_name"><? echo $Qa_Subject; ?></td>
                                          <!--投票日期-->
                                          <td id="voting_date"><? echo mysqldate($Qa_BeginDate); ?>~<? echo mysqldate($Qa_EndDate); ?></td>
									  	</tr>
									  <? 
									  	if($Qa_Comment!=""){
									 	?>
									 	<tr>
                                        	<!--辦法說明-->
										  <td colspan="2" id="voting_explain"><? echo $Qa_Comment; ?></td>
									  </tr>
									  <?
									  }
									  ?>                                     
								  </table>
								</div>
								<div>
									<?
										/*
										$sql1 = "Select * From QAFILE Where Qa_SerNo=".$qa_serno." Order By Qa_seq limit 0,1 ";
										$result = mysqli_query($sqli,$sql);
                		for($i = 0 ; $i < $row = mysqli_fetch_array($result); ++$i){
											echo "<input type=hidden name='qa_id".$i."' value=".$row["qa_id"].">";
				      				echo "<input type=hidden name=qa_name".$i." value=".$row["qa_name"].">";
				      			}
				      			*/
				      			$sql = "Select * From QAFILE Where Qa_SerNo=".$qa_serno." ";
				      			$result = mysqli_query($sqli,$sql);
				      			$row = mysqli_fetch_array($result);
				      			echo "<input type=hidden name='qa_id' value=".$row["Qa_id"].">";
				      			echo "<input type=hidden name='qa_name' value=".$row["Qa_name"].">";
				      			$sql2 = "Select * From QAFILEITEM Where Qa_SerNo=".$qa_serno." And Qa_id=".$row["Qa_id"]." Order By Seq;";
				      			$result = mysqli_query($sqli,$sql2);
                		for($i = 0 ; $i < $row = mysqli_fetch_array($result); ++$i){
                	?>
                		<div class="<? if(($i+1)%3==0){echo "vote_item02";}else{echo "vote_item01";}?>">
                			<table class="voting_table02">
                				<tr>
                					<td class="under_line">編號：<? echo $row["Seq"];?></td>
                				</tr>
                				<tr>
                					<td class="under_line"><? echo $row["Qa_author"]; ?> - <font id="qa_item<? echo ($i+1) ?>"><? echo $row["Qa_item"]; ?></font></td>
                				</tr>
                				<tr>
                					<td>
                						<?
									          if($row["Qa_Wight"]!="Y"){
									          ?>
									          <img id="img<? echo ($i+1); ?>" name="img<? echo ($i+1); ?>" border="0" src="upload/vote/<? echo $row["Qa_FileURL"]; ?>">
									          <?
										        }
										        else{
									          ?>	
									          <img id="img<? echo ($i+1); ?>" name="img<? echo ($i+1); ?>" border="0" src="upload/vote/<? echo $row["Qa_FileURL"]; ?>">
									          <?
									        	}
									          ?>	
                					</td>
                				</tr>
                				<tr>
                					<td>
														<input type="button" id="" name="" onclick=vote_item("<? echo $row["Seq"]; ?>"); value="投我一票">
                					</td>
                				</tr>
                				<tr>
                					<td>
														<font class="voting_total_nb"><? echo $row["Vote_count"]; ?></font><font class="voting_total_unit">票</font>
                					</td>
                				</tr>	
                			</table>
                		</div>
                	<?
				      			}
									?>
									<input type="hidden" id="img_count" value="<? echo ($i+1); ?>">
									
									<div>
										
									</div>
								</div>
								<input type="hidden" id="action" name="action">
								<input type="hidden" id="select_item" name="select_item">
								<input type="hidden" id="qa_item" name="qa_item">
								<input type="hidden" id="qa_answer" name="qa_answer">
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
	<script>
		function vote_item(seq){
			Dd("action").value="save";
			Dd("qa_item").value=Dd("qa_item"+parseInt(seq)).innerHTML;
			Dd("form1").submit();
		}
		function img_resize(){
			var maxW = 200;
			var maxH = 135;
			var width = 0;
			var herght = 0;
			for(var i = 1 ; i < parseInt(Dd("img_count").value) ; ++i){
				//alert("img"+i);
				if (Dd("img"+i).width > 0 && Dd("img"+i).height > 0) {
			    //如果寬度大於高
			    if (Dd("img"+i).width/Dd("img"+i).height >= maxW/maxH) {
			    	
			      if (Dd("img"+i).width >= maxW){
			        width = maxW;
			        height = maxW * Dd("img"+i).height / Dd("img"+i).width; //高=高*比率； 比率=最大寬度/寬度
			      }
			      else {
			        //不變
			        width = Dd("img"+i).width;
			        height = Dd("img"+i).height;
			      }
			     
			      
			    }
			    else{
			      //寬度小于高度
			      if(Dd("img"+i).height > maxH){  
			        width = Dd("img"+i).width * maxH / Dd("img"+i).height;     
			        height = maxH;
			      }
			      else{
			        width = Dd("img"+i).width;  
			        height = Dd("img"+i).height;
			      }
			    }
			    Dd("img"+i).width=width;
			    Dd("img"+i).height=height;
			 	}
		}
	}
</script>
</body>