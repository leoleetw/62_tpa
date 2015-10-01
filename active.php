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
  <link href="css/tpa_active.css" rel="stylesheet">
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
					<form id='form1' action='active.php'>
						<div id="news_title">
							<div id="active_content_select">
								<select id='data_year' name='data_year' onchange="change_year();">
							<?
								for($i = intval(date("Y")); $i >= 2000 ; --$i){									
									echo "<option value='".$i."' ";
									if($i == $data_year)
										echo "selected";
									echo "> ".$i."</option>";
								}
							?>
								</select>
							</div>
						</div>
					
						<div id="active_content_text">
							<?
								$sys_date=date("Y-m-d h:i:s");
								$pageSize = 16;
								$sql = "select * from activity where Act_type='活動看板' and '".$sys_date."' between Act_BeginDate and Act_EndDate
      									and year(act_RegDate)='".$data_year."' order by Act_RegDate desc,act_id desc";
								$result = mysqli_query($sqli,$sql." limit ".((intval($nowPage)-1)*$pageSize).",".$pageSize." ");
								$rs_temp = mysqli_query($sqli,$sql);
								$rs_cn = mysqli_num_rows($rs_temp);
								$pagecount = ceil($rs_cn/$pageSize);
								for($i = 0 ; ($i < $row = mysqli_fetch_array($result)) && $i < $pageSize ; ++$i){
							?>
								<div>
									<table>
										<tr class="tr_bottom">
											<td>
												<a href="active_content.php?act_id=<? echo $row["Act_id"];?>";><? echo $row["Act_Subject"]; ?></a>
											</td>
											<td align="right" width="20%">
												<? echo mysqldate($row["Act_RegDate"]); ?>
											</td>
										</tr>
									</table>
								</div>
							<?
								}
								if($nowPage < $pagecount){
									echo "<input type='button' id='btn_down' onclick=page_change('down') value='下一頁'>";
								}
								if($nowPage !=1 && $nowPage != $pagecount){
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
	<script>
		function change_year(){
			Dd("nowPage").value="";
			Dd('form1').submit();
		}
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