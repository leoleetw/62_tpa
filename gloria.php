<!doctype html>
<?
include_once("include/dbinclude.php");
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
  <link href="css/tpa_pic.css" rel="stylesheet">
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
                    <a href="#" style="text-decoration:none;"><li class="nav_hover">光彩與榮耀</li></a>
                    <a href="#" class="nav" onclick="location.href='vote.php';"><li>票選活動</li></a>
                </ul>
    		</div>
            <div class="leftNav_bottom"></div>
        </div> 
				<div id="main_content">
					<form id='form1' action='gloria.php'>
						<div class="select_div">
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
						<div class="pic_table_div">
							<table class="pic_table">
								<tr>
								<?
									$sys_date=date("Y-m-d h:i:s");
									$pageSize = 16;
									$sql = "select * from albumtype where album_kind='光彩與榮耀' and year(album_date)='".$data_year."' Order by Album_Date";
									$result = mysqli_query($sqli,$sql);
									for($i = 0 ; ($i < $row = mysqli_fetch_array($result)) && $i < $pageSize ; ++$i){
										echo "<td>";
											
								?>
									<div class="img_bg">
										<a href="gloria_show.php?album_type=<? echo $row["Album_type"]; ?>">
											<div class="pic_img" style="background-image:url('upload/<? echo $row["Album_img"];?>');">
												<div class="pic_info">
													<? echo mysqldate($row["Album_Date"]); ?><br><? echo $row["Album_Name"]; ?>
												</div>
											
											</div>
										</a>
									</div>
	              <?
	              	echo "</td>";
              		if(($i+1)%2==0)
											echo "</tr><tr>";
								}
								?>
								</tr>
							</table>
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
			Dd('form1').submit();
		}
</script>
</body>