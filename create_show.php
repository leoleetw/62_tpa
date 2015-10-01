<!doctype html>
<?
include_once("include/dbinclude.php");
@$tp = isset($_POST["tp"]) ? $_POST['tp'] : $_GET['tp'] ;
if($tp == "" )
	$tp = "麵包花作品欣賞";
@$album_type = isset($_POST["album_type"]) ? $_POST['album_type'] : $_GET['album_type'] ;
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
  <link href="css/tpa_creat_show.css" rel="stylesheet">
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
                <div><input type='button' value='回上頁' onclick="history.go(-1)"></div>
        	<div class="zoom-gallery">
            <table class="picture_table">
							<tr>
							<?
								/*$pageSize = 15;*/
								$sql="Select * From AlbumType Left Join Album On AlbumType.Album_Type = Album.Album_Type where AlbumType.album_type='".$album_type."'";
								$result = mysqli_query($sqli,$sql);
								for($i = 0 ; ($i < $row = mysqli_fetch_array($result)); ++$i){
									if($row["Album_URL_S"] != "")
							  		$album_URL = $row["Album_URL_S"];
							  	else
							  		$album_URL = $row["Album_URL"];
							?>
								<td>
									<div class="img_bg">
										<div class="img_resize">
	                  	<a class="test-popup-link" href="upload/<? echo $row["Album_URL"];?>"><img src="upload/<? echo $album_URL;?>" ></a>
	                  </div>
									</div>
								</td>
               <?
               	if(($i+1)%3 == 0)
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
function go_to(this_action){
	location.href="create.php?tp="+this_action;
}
</script>
</body>