<!doctype html>
<?
include_once("include/dbinclude.php");
@$nowPage = isset($_POST["nowPage"]) ? $_POST['nowPage'] : $_GET['nowPage'] ;
if($nowPage == "")
	$nowPage = '1';
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
  <link href="css/tpa_link.css" rel="stylesheet">
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
    	<div id="main_content">
    	<!--div class="nav_wrapper">
	   	<div id="link_banner_nav"></div>
  		<div id="link_main_nav"></div>
        </div-->
        <div id="link_bg">
            <form id='form1' action='link.php'>
                    <div class="link_div">
                    		<div class="link_table_div">
	                        <table class="link_table">
	                            <tr>
	                            	<td width="50%"></td><td width="50%"></td>
	                            </tr><tr>
	                        <?
	                            $pageSize = 20 ;
	                            $sql = "select * from links order by Link_seq";
	                            $result = mysqli_query($sqli,$sql." limit ".((intval($nowPage)-1)*$pageSize).",".$pageSize." ");
															$rs_temp = mysqli_query($sqli,$sql);
															$rs_cn = mysqli_num_rows($rs_temp);
															$pagecount = ceil($rs_cn/$pageSize);
	                            for($i = 1 ; ($i <= $row = mysqli_fetch_array($result)) && $i <= $pageSize ; ++$i){
	                                echo "<td><img src='images/active_icon.png' style='width:12px;'> <a href='".$row["Link_URL"]."' target='_black'>".$row["Link_Name"]."</a></td>";
	                                if(($i % 2) ==0)
	                                    echo "</tr><tr>";
	                            }
	                        ?>
	                        		
	                            </tr>
	                        </table>
                        </div>
                        <div class="page_btn_div">
		                    <?
					                if($nowPage < $pagecount){
														echo "<input type='button' id='btn_down' onclick=page_change('down') value='下一頁'>";
													}
													if($nowPage !=1){
														echo "<input type='button' id='btn_up' onclick=page_change('up') value='上一頁'>";
													}
													
												?>
												<input type="hidden" id="nowPage" name="nowPage" value="<? echo $nowPage;?>">
												</div>
                    </div>
                    
                </form>
            </div>
            </div>
            <div id="clear"></div>
  	</div>
	<div class="banner">
		<div class="banner_bg">
	        <div class="middle_section">
	        	<div id="link_banner_img"></div>
	        </div>
	  	</div>
    </div>
    <footer>
		<? include_once("footer.php"); ?>
	</footer>
	<script>
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