<!doctype html>
<?
include_once("include/dbinclude.php");
@$qa_serno = isset($_POST["qa_serno"]) ? $_POST['qa_serno'] : $_GET['qa_serno'] ;
$sql="Select * From qa Where qa_serno='".$qa_serno."'";
$result = mysqli_query($sqli,$sql);
$row = mysqli_fetch_array($result);
$Qa_WinNumber1 = intval($row["Qa_WinNumber1"]);
$Qa_WinNumber2 = intval($row["Qa_WinNumber2"]);
$Qa_EndDate = $row["Qa_EndDate"];
if(dateDiff($Qa_EndDate,date("Y-m-d h:i:s")) <= 0){
	$_SESSION["errnumber"]=1;
	$_SESSION["msg"]="投票尚在進行, 無法查看投票結果!!";
	header("Location: index.php");
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
				<div>
				<?
					$sql = "Select * From qa Where Qa_SerNo=".$qa_serno." And Qa_Active='Y'";
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
         	<div id="vote_result_title"><? echo $Qa_Subject; ?></div>
         	<div><img src="images/vote_result_bar.png"></div>
         	<div id="award_page">
         	<?
         	$sql = "Select * From qafile Where Qa_SerNo=".$qa_serno."  Order By Qa_seq limit 0,1";
         	$result = mysqli_query($sqli,$sql);
         	$row1 = mysqli_fetch_array($result);
         	$arr_temp = Array();
         	/*$sql = "Select Qa_item,Qa_author,Qa_FileURL,(Select count(*) From SURVEY_STAT Where Qa_SerNo=".$qa_serno." And Qa_id=".$row1["Qa_id"]." And Qa_author=QAFILEITEM.Qa_author) as total
                  From QAFILEITEM Where Qa_id=".$row1["Qa_id"]." Order By total Desc";*/
          $sql = "Select Qa_item,Qa_author,Qa_FileURL
                  From qafileitem Where Qa_id=".$row1["Qa_id"]." ";
          $result = mysqli_query($sqli,$sql);
         	for($i = 0 ; $i < $row = mysqli_fetch_array($result);++$i){
         		$row["total"] = 0; //close total
         		$arr_temp[$i] = $row;
         	}
         	for($i = 0 ; $i < 3 ; ++$i){
				?><!--
         --><div class="awards">
            	<table>
              	<tr>
                	<td colspan="2" class="awards_img">
                		<img border="0" src="upload/vote/<? echo $arr_temp[$i]["Qa_FileURL"]; ?>" height="150">
                	</td>
                </tr>
                <tr>
                	<td rowspan="3" width="40px">
                		<?
                			if($i==0)
                				$rank = "vote_result_prize01";
                			else if($i == 1)
                				$rank ="vote_result_prize02";
                			else
                				$rank ="vote_result_prize03";
                		?>
                		<img src="images/<? echo $rank; ?>.png" >
               		</td>
                  <td class="winners_name">
                  	<? echo $arr_temp[$i]["Qa_author"]; ?>
                  </td>
                </tr>
                <tr>
                    <td class="winners_list">
                    	<? echo $arr_temp[$i]["Qa_item"]; ?>
                    </td>
                </tr>
                <tr>
                    <td class="winners_list">
                    	<? echo $arr_temp[$i]["total"]; ?>
                    </td>
                </tr>
              </table>
            </div><!--
      --><?
            }
					?>
		        <div id="master_title">佳作</div>
		        <div class="master">
		        	<table>
		        		<tr class="title"><th>姓名</th>
		        				<th>作品名稱</th>
		        				<th>票數</th></tr>
				      <?
				      	for($i = 3 ; $i < ($Qa_WinNumber1+3) && $i < count($arr_temp) ; ++$i){
				      ?>
				      		<tr><td width="20%"><? echo $arr_temp[$i]["Qa_author"]; ?></td><td width="60%"><? echo $arr_temp[$i]["Qa_item"]; ?></td><td><? echo $arr_temp[$i]["total"]; ?></td></tr>
				      <?
				      	}
				      ?>     
				      </table>   
						</div>
						<div id="merit_title">優選</div>
		        <div class="merit">
				      <table>
				      	<tr class="title"><th style="width:100px">姓名</th>
		        				<th>作品名稱</th>
		        				<th>票數</th></tr>
				      <?
				      	for( $i = ($Qa_WinNumber1+3) ; $i < ($Qa_WinNumber1+$Qa_WinNumber2+3) && $i < count($arr_temp) ; ++$i){
				      ?>
				      		<tr><td width="20%"><? echo $arr_temp[$i]["Qa_author"]; ?></td><td width="60%"><? echo $arr_temp[$i]["Qa_item"]; ?></td><td><? echo $arr_temp[$i]["total"]; ?></td></tr>
				      <?
				      	}
				      ?>
		      		</table>
						</div>
					</div>
				</div>
                <div><input type='button' value='回上頁' onclick="history.go(-1)"></div>
			</div>
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
</script>
</body>