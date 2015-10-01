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
	<div id="about_main">
		<div id="about_main_top01">
	        <div class="middle_section">
	        	<div id="about_main_top02"></div>
	   	  	  	<div id="about_main_top03"></div>
	        </div>
	  	</div>
	  	<div class="middle_section">				
				<div id="about_main_nav">
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
        		<a href="#" class="about_nav" onclick="go_to('member');"><li>協會組織</li></a>
        		<? } 
        				if($action=='list'){
        		?>
        		<a href="#" style="text-decoration:none;" onclick="go_to('list');"><li class="about_nav_hover">協會章程 </li></a>
        		<? }else{ ?>
        		<a href="#" class="about_nav" onclick="go_to('list');"><li>協會組織</li></a>
        		<? }
        		?>
      		</ul>
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
							echo "<font color='#333333'>".$content_desc."</font>";
						}
						else{
						}
					?>
				</div>
		</div>
	</div>
	<footer>
		<? include_once("footer.php"); ?>
	</footer>
<script>
		function go_to(this_action){
			location.href="about.php?action="+this_action;
		}
</script>
</body>
</html>