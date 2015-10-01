<!doctype html>
<?
include_once("include/dbinclude.php");
@$tp = isset($_POST["tp"]) ? $_POST['tp'] : $_GET['tp'] ;
@$ser_no = isset($_POST["ser_no"]) ? $_POST['ser_no'] : $_GET['ser_no'] ;
if($ser_no=="" && $tp=="")
	$sql = "select * from content where ContentType = '課程介紹' limit 0,1";
else if($ser_no=="")
	$sql = "select * from content where ContentType = '課程介紹' AND ContentSubType = '".$tp."' limit 0,1";
else
	$sql = "select * from content where Ser_no = '".$ser_no."'";
$result = mysqli_query($sqli,$sql);
$res = mysqli_fetch_array($result);
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
      <form id="form1" action="course.php">
      	<input type="hidden" id="tp" name="tp">
      	<input type="hidden" id="ser_no" name="ser_no">
				<div id="about_main_nav">
	   	  	  	<div id="course_banner_nav"></div>
	      	<div class="leftNav_top"><img src="images/about_nav_img" width="210px" height="66px"></div>
					<div class="leftNav_mid">
          <ul>
              <?
                  $sql = "select distinct ContentSubType  from content where ContentType = '課程介紹';";
                  $result = mysqli_query($sqli,$sql);
                  for($i = 0 ; ($i < $row = mysqli_fetch_array($result)); ++$i){
                      if($res["ContentSubType"]==$row["ContentSubType"]){
              ?>
                          <a href="#" style="text-decoration:none;" onclick=go_to('tp',"<? echo $row["ContentSubType"]; ?>");>
                          <li class="nav_hover"><? echo $row["ContentSubType"];; ?></li></a>
              <?
                      }else{
              ?>
                          <a href="#" class="nav" onclick=go_to('tp',"<? echo $row["ContentSubType"]; ?>");><li><? echo $row["ContentSubType"]; ?></li></a>
              <?
                      }
                  }
              ?>
          </ul>
        </div>
	        <div class="leftNav_bottom"></div>
        </div> 
    		<div class="dropdown">
				  <div id="dLabel" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				    <? echo $res["ContentSubType"]; ?>課程選擇
				    <span class="caret"></span>
				  </div>
					<ul class="dropdown-menu" aria-labelledby="dLabel">
	      	<?
						$sql = "select ser_no , title from content where ContentType = '課程介紹' AND ContentSubType = '".$res["ContentSubType"]."';";
						$result = mysqli_query($sqli,$sql);
						for($i = 0 ; ($i < $row = mysqli_fetch_array($result)); ++$i){
					?>
						<li>
	               <a href="#" onclick=go_to('ser_no',<? echo $row["ser_no"];?>)><? echo $row["title"];?></a>
	          </li>
	        <?
						}
					?>
					</ul>
				</div>
				<div id="main_content">
                <div>
        		<!--<div class="dropdown">
						  <a id="dLabel" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						    <? echo $res["ContentSubType"]; ?>課程選擇
						    <span class="caret"></span>
						  </a>
						  
						<ul class="dropdown-menu" aria-labelledby="dLabel">
          	<?
							$sql = "select ser_no , title from content where ContentType = '課程介紹' AND ContentSubType = '".$res["ContentSubType"]."';";
							$result = mysqli_query($sqli,$sql);
							for($i = 0 ; ($i < $row = mysqli_fetch_array($result)); ++$i){
						?>
							<li>
                   <a href="#" onclick=go_to('ser_no',<? echo $row["ser_no"];?>)><? echo $row["title"];?></a>
              </li>
            <?
							}
						?>
						</ul>
						</div>-->
          </div>
	        <?
						$sql = "select * from content where ser_no = '".$res["Ser_no"]."';";
						$result = mysqli_query($sqli,$sql);
						 $row = mysqli_fetch_array($result);
					?>
					<div>
	          <? echo $row["Content_Desc"]; ?>
	        </div><hr/>
	        <div class="zoom-gallery">
						<table class="picture_table">
							<tr>
								<?
									$sql="Select * from upload where Ap_Name='content' and attach_type in ('img','image') and object_id='".$res["Ser_no"]."'";
									$result = mysqli_query($sqli,$sql);
									for($i = 0 ; ($i < $row = mysqli_fetch_array($result)); ++$i){
										if($row["Upload_FileName"]!=""){
								  			if(strlen($row["Upload_FileName"]) > 12)
								  				$ImgDesc = substr($row["Upload_FileName"],1,12);
								  			else
								  				$ImgDesc = $row["Upload_FileName"];
								  		}
								  		if(!is_null($row["Upload_FileURL_S"])||$row["Upload_FileURL_S"]!="")
								  			$ImgSrc = $row["Upload_FileURL_S"];
								  		else
								  			$ImgSrc = $row["Upload_FileURL"];
								?>
									<td>
										<div class="img_bg">
		                  <a class="test-popup-link" href="upload/<? echo urlencode($row["Upload_FileURL"]);?>"><img src="upload/<? echo  urlencode($ImgSrc);?>" ></a>
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
    	</form>
		<div id="clear"></div>
	</div>
	<div class="banner">
		<div class="banner_bg">
	        <div class="middle_section">
	        	<div id="course_banner_img"></div>
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
