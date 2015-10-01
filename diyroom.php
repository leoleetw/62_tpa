<!doctype html>
<?
include_once("include/dbinclude.php");
@$tp = isset($_POST["tp"]) ? $_POST['tp'] : $_GET['tp'] ;

if($tp==""){
	$sql="Select DISTINCT Diy_type from diy where '".date("Y-m-d h:i:s")."' between diy_BeginDate and diy_EndDate  order by diy_RegDate desc,ser_no desc limit 0,1;";
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result);
	$tp = $row["Diy_type"];
	$sql="Select * from diy where '".date("Y-m-d h:i:s")."' between diy_BeginDate and diy_EndDate AND diy_type = '".$tp."'  order by diy_RegDate desc,ser_no desc";
}
else{
	$sql="Select * from diy where '".date("Y-m-d h:i:s")."' between diy_BeginDate and diy_EndDate AND diy_type = '".$tp."'  order by diy_RegDate desc,ser_no desc";
}
$result = mysqli_query($sqli,$sql);
/*$res = mysqli_fetch_array($result);*/
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
  <link href="css/tpa_course.css" rel="stylesheet">
	<!-- jQuery Version 1.11.0 -->
	<script src="js/jquery-1.11.0.js"></script>
	
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="include/ajax.js"></script>
    <link rel="stylesheet" href="js/magnific-popup/dist/magnific-popup.css"> 
	<script src="js/magnific-popup/dist/jquery.magnific-popup.js"></script>
	<style>
		.image-source-link {
			color: #98C3D1;
		}
		
		.mfp-with-zoom .mfp-container,
		.mfp-with-zoom.mfp-bg {
			opacity: 0;
			-webkit-backface-visibility: hidden;
			/* ideally, transition speed should match zoom duration */
			-webkit-transition: all 0.3s ease-out; 
			-moz-transition: all 0.3s ease-out; 
			-o-transition: all 0.3s ease-out; 
			transition: all 0.3s ease-out;
		}
		
		.mfp-with-zoom.mfp-ready .mfp-container {
				opacity: 1;
		}
		.mfp-with-zoom.mfp-ready.mfp-bg {
				opacity: 0.8;
		}
		
		.mfp-with-zoom.mfp-removing .mfp-container, 
		.mfp-with-zoom.mfp-removing.mfp-bg {
			opacity: 0;
		}
	</style>
</head>
<body>
	<header>
		<? include_once("header.php"); ?>
	</header>
	  <div class="middle_section">
      <form id="form1" action="diyroom.php">
      	<input type="hidden" id="tp" name="tp">
      	<div id="about_main_nav">
	   	  	 <div id="diyroom_banner_nav"></div>
	      	<div class="leftNav_top"><img src="images/about_nav_img" width="210px" height="66px"></div>
					<div class="leftNav_mid">
	          <ul>
	              <?
	                  $sql_nav = "Select DISTINCT Diy_type from diy where '".date("Y-m-d h:i:s")."' between diy_BeginDate and diy_EndDate  order by diy_RegDate desc,ser_no desc;";
	                  $result_nav = mysqli_query($sqli,$sql_nav);
	                  for($i = 0 ; ($i < $row = mysqli_fetch_array($result_nav)); ++$i){
	                      if($tp==$row["Diy_type"]){
	              ?>
	                          <a href="#" style="text-decoration:none;" onclick=go_to('tp',"<? echo $row["Diy_type"]; ?>");>
	                          <li class="nav_hover"><? echo $row["Diy_type"];; ?></li></a>
	              <?
	                      }else{
	              ?>
	                          <a href="#" class="nav" onclick=go_to('tp',"<? echo $row["Diy_type"]; ?>");><li><? echo $row["Diy_type"]; ?></li></a>
	              <?
	                      }
	                  }
	              ?>
	          </ul>
	        </div>
	        <div class="leftNav_bottom"></div>
        </div> 
        <!--<div id="course_level"></div>   -->
				<div id="diy_main_content">
					<div>
						<table width="100%">
							<tr><th>發布日期</th><th>主    題</th><th>示範講師</th></tr>
							<? for($i = 0 ; ($i < $row = mysqli_fetch_array($result)); ++$i){ ?>
							<tr onclick="">
								
								<td width="20%">
									<? echo mysqldate($row["Diy_BeginDate"]); ?>
								</td>
								<td>
									<a href="diy_show.php?Ser_no=<? echo $row["Ser_no"];?>";><? echo $row["Diy_Subject"]; ?></a>
								</td>
								<td width="20%">
									<? echo $row["Diy_Author"]; ?>
								</td>
							</tr>
						<? } ?>
						</table>
					</div>
				</div>
    	</form>
        <div id="clear"></div>
	</div>
	<div class="banner">
		<div class="banner_bg">
	        <div class="middle_section">
	        	<div id="diyroom_banner_img"></div>
	        </div>
	  	</div>
    </div>
    <footer>
		<? include_once("footer.php"); ?>
	</footer>
	<script>
		$(document).ready(function() {
			$('.zoom-gallery').magnificPopup({
				delegate: 'a',
				type: 'image',
				closeOnContentClick: false,
				closeBtnInside: false,
				mainClass: 'mfp-with-zoom mfp-img-mobile',
				image: {
					verticalFit: true,
					titleSrc: function(item) {
						return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank">image source</a>';
					}
				},
				gallery: {
					enabled: true
				},
				zoom: {
					enabled: true,
					duration: 300, // don't foget to change the duration also in CSS
					opener: function(element) {
						return element.find('img');
					}
				}
				
			});
		});
		function go_to(this_type,this_action){
			if(this_type=="tp"){
				Dd("form1").tp.value=this_action;
				Dd("form1").submit();
			}
			else if(this_type=="ser_no"){
				Dd("form1").ser_no.value=this_action;
				Dd("form1").submit();
			}
			//alert(this_action);
		}
</script>
</body>
