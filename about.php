<!doctype html>
<?
include_once("include/dbinclude.php");
@$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
if($action == "")
	$action = "about";
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
  <link href="css/tpa_about.css" rel="stylesheet">
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
            <div id="about_banner_nav"></div>
            <div class="leftNav_top"><img src="images/about_nav_img" width="210px" height="66px"></div>
            <div class="leftNav_mid">
	            <ul>
	                <? if($action=='about'){ ?>
	                <a href="#" style="text-decoration:none;" onclick="go_to('about');"><li class="about_nav_hover">協會簡介</li></a>
	                <? }else{ ?>
	                <a href="#" class="about_nav" onclick="go_to('about');"><li>協會簡介</li></a>
	                <? }
	                        if($action=='organize'){
	                ?>
	                <a href="#" style="text-decoration:none;" onclick="go_to('organize');"><li class="about_nav_hover">協會組織</li></a>
	                <? }else{ ?>
	                <a href="#" class="about_nav" onclick="go_to('organize');"><li>協會組織</li></a>
	                <? }
	                        if($action=='member'){
	                ?>
	                <a href="#" style="text-decoration:none;" onclick="go_to('member');"><li class="about_nav_hover">會員權益</li></a>
	                <? }else{ ?>
	                <a href="#" class="about_nav" onclick="go_to('member');"><li>會員權益</li></a>
	                <? }
	                        if($action=='list'){
	                ?>
	                <a href="#" style="text-decoration:none;" onclick="go_to('list');"><li class="about_nav_hover">協會章程 </li></a>
	                <? }else{ ?>
	                <a href="#" class="about_nav" onclick="go_to('list');"><li>協會章程</li></a>
	                <? }
	                ?>
	            </ul>
            </div>
            <div class="leftNav_bottom"></div>
		</div>
		<div id="main_content">
			<?
				if($action != "organize"){
					if($action == "about")
						$sql="select * from content where ContentSubType='協會簡介'";
					else if($action == "member")
						$sql="select * from content where ContentSubType='會員權益'";
					else if($action == "list")
						$sql="select * from content where ContentSubType='協會章程'";
					$res = QuerySQL($sql);
					if(count($res)!=0){
						$ImgPosition=$res[0]["ImgPosition"];
					  $object_id=$res[0]["Ser_no"];
					  $content_desc=$res[0]["Content_Desc"];
					}
					echo "<font color='#333333' class:'about_page_position'>".$content_desc."</font>";
				}
				else{
			?>
          	<div id="organize_img"><img src="images/about_function_img.png" width="520" height="546" usemap="#Map">
                <map name="Map">
                  <area shape="circle" coords="97,140,80" onclick="get_info(1);">
                  <area shape="circle" coords="249,81,67" onclick="get_info(2);">
                  <area shape="circle" coords="385,131,61" onclick="get_info(3);">
                  <area shape="circle" coords="447,247,56" onclick="get_info(4);">
                  <area shape="circle" coords="439,363,51" onclick="get_info(5);">
                  <area shape="circle" coords="372,446,45" onclick="get_info(6);">
                </map>
          	</div>
	            <div id="organize_info" style="display:none">
	            	<table id="organize">
	            		<tr><td id="organize_title"></td><td id="organize_count"></td></tr>
	            		<tr><td colspan="2"><table id="organize_pic"></table></td></tr>
	            		<tr><td colspan="2" id="return"><a onclick="return_top();">▲TOP</a></td></tr>
	            	</table>
	            </div>
	            
					<?
						}
					?>
		</div>
        <div id="clear"></div>
	</div>
    <div class="banner">
		<div class="banner_bg">
	        <div class="middle_section">
	        	<div id="about_banner_img"></div>	   	  	  	
	        </div>
	  	</div>
    </div>    
	<div>
		<footer>
			<? include_once("footer.php"); ?>
		</footer>
	</div>
<script>
		function go_to(this_action){
			location.href="about.php?action="+this_action;
		}
		function change_organize_info(mytext){
			var str = "";
			var arr = new Array();
			arr=JSON.parse(mytext);
			Dd("organize_count").innerHTML = "/　"+arr.length+"名";
			str += "<tr>";
			for(var i = 0 ; i < arr.length ; ++i){
				str += "<td><table><tr><td><img src='upload/"+arr[i].album_url+"' ></td></tr><tr><td>"+arr[i].album_desc+"</td></tr></table></td>";
				if((i+1)%4==0)
					str += "</tr><tr>";
			}
			str += "</tr>";
			Dd("organize_pic").innerHTML = str;
			block("organize_info");
			$('html,body').animate({scrollTop:$('#organize_info').offset().top},800);
		}
		function return_top(){

			$('html,body').animate({scrollTop:$('#organize_img').offset().top},800);
			//none("organize_info");
		}
		function get_info(this_type){
			var str = "";
			if(this_type == "1")
				str = "▼　理事長";
			else if(this_type == "2")
				str = "▼　常務理事";
			else if(this_type == "3")
				str = "▼　秘書長";
			else if(this_type == "4")
				str = "▼　秘書處";
			else if(this_type == "5")
				str = "▼　常務監事";
			else if(this_type == "6")
				str = "▼　理監事";

			Dd("organize_title").innerHTML = str;
			CallServer("include/organize_info.php","type="+this_type, "GET", true, "mytext", change_organize_info);
		}
</script>
</body>
</html>