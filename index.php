<!doctype html>
<?
include_once("include/dbinclude.php");
@$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
if($action == "cancel"){
	$log_desc="會員登出";
/*	memberlog ($log_desc);*/
	$_SESSION["errnumber"]=0;
	$_SESSION["msg"]="會員登出";
	$_SESSION["errntime"]="";
	unset($_SESSION["User_id"]);
	unset($_SESSION["Member_Name"]);
	unset($_SESSION["Member_Category"]);
}
$sys_date=date("Y-m-d h:i:s");
$sql="select * from activity where '".$sys_date."' between Act_BeginDate and Act_EndDate order by Act_RegDate desc,act_id desc";
$array = QuerySQL($sql);
//print_r($array);
$i = 0;
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

<!-- jQuery Version 1.11.0 -->
<script src="js/jquery-1.11.0.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="include/ajax.js"></script>
<script src="http://www.google.com/jsapi"></script>
<script>google.load("jquery", "1");</script>
<!-- jQuery Image Scale Carousel CSS & JS -->
<!--link rel="stylesheet" href="js/Image-Scale/lib.css" type="text/css" media="screen" charset="utf-8"-->
<link rel="stylesheet" href="js/Image-Scale/jQuery.isc/jQuery.isc.css" type="text/css" media="screen" charset="utf-8">
<script src="js/Image-Scale/jQuery.isc/jquery-image-scale-carousel.js" type="text/javascript" charset="utf-8"></script>
<link href="css/tpa.css" rel="stylesheet">
<link href="css/tpa_index.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="js/Slicebox/css/slicebox.css" />
<link rel="stylesheet" type="text/css" href="js/Slicebox/css/custom.css" />
<script type="text/javascript" src="js/Slicebox/js/modernizr.custom.46884.js"></script>
<script type="text/javascript" src="js/Slicebox/js/jquery.slicebox.js"></script>
</head>
<body>
<header>
  <? include_once("header.php"); ?>
</header>
<div id="main">
	<div id="index_middle_section">
  		<div id="bottom">
    <div id="bottom_title"></div>
    <div id="index_bottom_01">
    	<div id="news">
      	<table>
    <?
			While($i != count($array) && $i < 7){
				if($array[$i]["Act_Redirect"]=="Y" && $array[$i]["Act_Redirect_URL"]!="")
					echo "<tr><td><li><div style='display:inline;'>".mysqldate($array[$i]["Act_RegDate"])."</div> &nbsp;<div style='display:inline;'><a href='".$array[$i]["Act_Redirect_URL"]."' style='text-decoration:none;color:white;'>".$array[$i]["Act_Subject"]."</a></div>";
				else
				  if($array[$i]["Act_type"]=="活動看板")
						echo "<tr><td><li><div style='display:inline;'>".mysqldate($array[$i]["Act_RegDate"])."</div> &nbsp;<div style='display:inline;'><a href='active_content.php?act_id=".$array[$i]["Act_id"]."' style='text-decoration:none;color:white;'>".$array[$i]["Act_Subject"]."</a></div>";
				  else
						echo "<tr><td><li><div style='display:inline;'>".mysqldate($array[$i]["Act_RegDate"])."</div>&nbsp; <div style='display:inline;'>".$array[$i]["Act_Subject"]."</div>";
				$i = $i + 1;
				echo "</td></tr>";
			}
		?>
         </table>
      </div>
    </div>
    <div id="index_bottom_02">
    	<div id="login_box">
      <? if($_SESSION["User_id"]==""){ ?>
        <form id="form01" name="form01" method="post" action="member.php">
            	<font class="login_text"> Account | 帳號</font>
                <p></p>
              <input type="text" id="User_id" name="User_id" value="" class="form-control" style="background-color:#D16A8F; color:#313441;">
            	<p></p>
                <font class="login_text"> PassWord | 密碼</font>
                <p></p>
              <input type="password" id="Password" name="Password" value="" class="form-control" style="background-color:#D16A8F; color:#313441;">
            	<div>
              <input type="button" value="確 認" class="btn" onclick="form.submit();">
              </div>
							<!--div id="fb"><fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
							</fb:login-button></div>
							
							<div id="status">
							</div-->
        </form>
       <? }else{?>
       	<form id="form02" name="form02" method="post" action="index.php">
       		<div style="text-align:center">
            	<input type="hidden" id="action" name="action">
              <div class="login_text"><? echo $_SESSION["Member_Category"]."&nbsp; ".$_SESSION["Member_Name"];?>&nbsp; 您好！</div>
              <hr/>
              <div><img src="images/index_member_button.png" onclick="location.href='member.php'" style="cursor:pointer;"></div>
              <div style="text-align:center">
            	<input type="button" value="登出" class="btn" onclick="onclick_cancel();"></div>
          </div>
         </form>
       <? } ?>
       </div>
    </div>
               	
   	</div>
    	<div id="index_img_action">
  		<div id="main_img">
  			<ul id="sb-slider" class="sb-slider">
					<li>
						<img src="images/1.jpg" alt="image1"/>
					</li>
					<li>
						<img src="images/2.jpg" alt="image1"/>
					</li>
					<li>
						<img src="images/3.jpg" alt="image1"/>
					</li>
					<li>
						<img src="images/4.jpg" alt="image1"/>
					</li>
					<li>
						<img src="images/5.jpg" alt="image1"/>
					</li>
					<li>
						<img src="images/6.jpg" alt="image1"/>
					</li>
				</ul>
				<div id="nav-arrows" class="nav-arrows">
					<a href="#">Next</a>
					<a href="#">Previous</a>
				</div>
  		</div>
        </div>
        <div id="contact_box">
            <div class="contact">
                <section>
                    <p><img src="images/phone.png"></p>
                    <font class="font02" align='center'>TEL ： 04-2241-1234<br/>FAX ： 04-2241-0077</font>
                </section>
            </div>
            <div class="contact">
                <section style="cursor:pointer;" onclick="window.open('https://www.google.com.tw/maps/place/406%E5%8F%B0%E4%B8%AD%E5%B8%82%E5%8C%97%E5%B1%AF%E5%8D%80%E6%96%87%E5%BF%83%E8%B7%AF%E5%9B%9B%E6%AE%B5669%E8%99%9F/@24.172197,120.687506,17z/data=!3m1!4b1!4m2!3m1!1s0x346917dd3590c297:0x23eb96f56c72bed7?hl=zh-TW');">
                    <p><img src="images/address.png"></p>
                    <font class="font02" align='center'>406 台中市文心路四段669號3F-2</font>
                </section>
            </div>
            <div class="contact">
                <section style="cursor:pointer;" onclick="window.open('send_mail.php','flag','scrollbars=yes,status=no,toolbar=no,top=100,left=120,width=540,height=620');">
                    <p><img src="images/mail.png"></p>
                    <font class="font02" align='center'>連絡信箱</font>
                </section>
            </div>
            <div class="contact" style="cursor:pointer;" onclick="window.open('https://www.facebook.com/pages/%E5%8F%B0%E7%81%A3%E9%BA%B5%E5%8C%85%E8%8A%B1%E8%88%87%E7%B4%99%E9%BB%8F%E5%9C%9F%E6%8E%A8%E5%B1%95%E5%8D%94%E6%9C%83/240688636059350');">
                <p><img src="images/facebook.png"></p>
                <font class="font02" align='center'>facebook粉絲團</font>
            </div>
        </div>
   </div>
  </div>
<footer>
  <? include_once("footer.php"); ?>
</footer>
<? Message(); ?>
<script>
		$(function() {
				
				var Page = (function() {

					var $navArrows = $( '#nav-arrows' ).hide(),
						slicebox = $( '#sb-slider' ).slicebox( {
							onReady : function() {

								$navArrows.show();
								/*$shadow.show();*/

							},
							orientation : 'r',
							cuboidsRandom : true
						} ),
						
						init = function() {

							initEvents();
							
						},
						initEvents = function() {

							// add navigation events
							$navArrows.children( ':first' ).on( 'click', function() {

								slicebox.next();
								return false;

							} );

							$navArrows.children( ':last' ).on( 'click', function() {
								
								slicebox.previous();
								return false;

							} );

						};

						return { init : init };

				})();

				Page.init();

			});
			/*
		var carousel_images = [
			"images/1.jpg",
			"images/2.jpg",
			"images/3.jpg",
			"images/4.jpg",
			"images/5.jpg",
			"images/6.jpg"
		];

		
		 $(window).load(function() {

		    $("#main_img").isc({
		        imgArray: carousel_images,
		        autoplay: true,
		        autoplayTimer: 5000
		    });
	
	   });
	   		*/
  function onclick_cancel(){
	  Dd("action").value="cancel";
	  Dd("form02").submit();
  }
  /*
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '511656458982766',
      xfbml      : true,
      version    : 'v2.3'
    });
  };
  */
   function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
	  FB.init({
	    appId      : '511656458982766',
	    cookie     : true,  // enable cookies to allow the server to access 
	                        // the session
	    xfbml      : true,  // parse social plugins on this page
	    version    : 'v2.3' // use version 2.2
	  });
	
	  // Now that we've initialized the JavaScript SDK, we call 
	  // FB.getLoginStatus().  This function gets the state of the
	  // person visiting this page and can return one of three states to
	  // the callback you provide.  They can be:
	  //
	  // 1. Logged into your app ('connected')
	  // 2. Logged into Facebook, but not your app ('not_authorized')
	  // 3. Not logged into Facebook and can't tell if they are logged into
	  //    your app or not.
	  //
	  // These three cases are handled in the callback function.
	
	  FB.getLoginStatus(function(response) {
	    statusChangeCallback(response);
	  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
  /*
	function fb_login(){
	 FB.login(function (response) {
	        FB.getLoginStatus(function (response) {
					    if (response.status === 'connected') {  // 程式有連結到 Facebook 帳號
					        var uid = response.authResponse.userID; // 取得 UID
					        var accessToken = response.authResponse.accessToken; // 取得 accessToken
					        $("#uid").html("UID：" + uid);
					        $("#accessToken").html("accessToken：" + accessToken);
					    } else if (response.status === 'not_authorized') {  // 帳號沒有連結到 Facebook 程式
					        alert("請允許授權！");
					    } else {    // 帳號沒有登入
					        // 在本例子中，此段永遠不會進入...XD
					    }
					});
	    }, { scope: "email" });
	}
	*/
	

	</script>
</body>
