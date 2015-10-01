<!doctype html>
<?
include_once("include/dbinclude.php");
@$tp = isset($_POST["tp"]) ? $_POST['tp'] : $_GET['tp'] ;
if($tp == "" )
	$tp = "麵包花作品欣賞";
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
  <link href="css/tpa_creat.css" rel="stylesheet">
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
	   	  	  	<div id="create_banner_nav"></div>
	      	<div class="leftNav_top"><img src="images/about_nav_img" width="210px" height="66px"></div>
					<div class="leftNav_mid">
	      		<ul>
	            	<?
						/*$sql = "select distinct name from table";*/
						$sql = "select distinct Album_kind  from albumtype where Album_kind like '%作品欣賞';";
						$result = mysqli_query($sqli,$sql);
						for($i = 0 ; ($i < $row = mysqli_fetch_array($result)); ++$i){
							if($tp==$row["Album_kind"]){
					?>
	                			<a href="#" style="text-decoration:none;" onclick=go_to("<? echo $row["Album_kind"]; ?>");>
	                            <li class="nav_hover"><? echo mb_substr($row["Album_kind"],0,-4,"UTF-8"); ?></li></a>
	                <?
							}else{
					?>
	                			<a href="#" class="nav" onclick=go_to("<? echo $row["Album_kind"]; ?>");><li><? echo mb_substr($row["Album_kind"],0,-4,"UTF-8"); ?></li></a>
	                <?
							}
						}
					?>
	      		</ul>
	    		</div>
	        <div class="leftNav_bottom"></div>
        </div>   
				<div id="main_content">
					<div class="pic_table_div">
						<table class="pic_table">
							<tr>
							<?
								$sql = "select * from albumtype where album_kind='".$tp."' order by album_type";
								$result = mysqli_query($sqli,$sql);
								for($i = 0 ; ($i < $row = mysqli_fetch_array($result)); ++$i){
									echo "<td>";
										
							?>
								<div class="img_bg">
									<a href="create_show.php?tp=<? echo $row["Album_kind"];?>&album_type=<? echo $row["Album_type"];?>">
										<div class="pic_img" style="background-image:url('upload/<? echo $row["Album_img"]; ?>');">
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
					
				</div>		
        <div id="clear"></div>
	</div>
	<div class="banner">
		<div class="banner_bg">
	        <div class="middle_section">
	        	<div id="create_banner_img"></div>
	        </div>
	  	</div>
    </div>
    <footer>
		<? include_once("footer.php"); ?>
	</footer>
	<script>
		function go_to(this_action){
			location.href="create.php?tp="+this_action;
		}
</script>
</body>