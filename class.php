<!doctype html>
<?
include_once("include/dbinclude.php");
@$nowPage = isset($_POST["nowPage"]) ? $_POST['nowPage'] : $_GET['nowPage'] ;
if($nowPage == "")
	$nowPage = '1';
@$city = isset($_POST["city"]) ? $_POST['city'] : $_GET['city'] ;
@$area = isset($_POST["area"]) ? $_POST['area'] : $_GET['area'] ;
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
  <link href="css/tpa_class.css" rel="stylesheet">
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
	   	  	  	<div id="class_banner_nav"></div>
				<div id="nav_img"></div>
            </div-->
					<form id='form1' action='class.php'>
						<div style="text-align:right">
							縣市：
								<select id='city' name='city' onchange="change_area();">
									<option value=''> 縣市</ option>
							<?
							$sql = "select mCode ,mValue from CodeCity where codeMetaID='Addr0' order by mSortValue";
							$result = mysqli_query($sqli,$sql);
							for($i = 0 ; $i < $row = mysqli_fetch_array($result) ; ++$i){
								if($city == $row["mCode"])
									echo "<option value='".$row["mCode"]."' selected> ".$row["mValue"]."</option>";
								else
									echo "<option value='".$row["mCode"]."'> ".$row["mValue"]."</option>";
							}
							?>
							</select>
							區域：<select id='area' name='area' onchange="change_area();">
								<option value=''> 區域</option>
								<?
									if($city != ""){
										$mycity = "Addr0R".$city;
										$sql = "SELECT mCode, mValue FROM CodeCity WHERE codeMetaID='" . $mycity . "'";
										$result = mysqli_query($sqli,$sql);
										for($i = 0 ; $i < $row = mysqli_fetch_array($result) ; ++$i){
											if($area == $row["mCode"])
												echo "<option value='".$row["mCode"]."' selected> ".$row["mValue"]."</option>";
											else
												echo "<option value='".$row["mCode"]."'> ".$row["mValue"]."</option>";
										}
									}
								?>
							</select>
						</div>
						<div>
							<?
									
									$pageSize = 8;
									$sql = "select classroom.*,concat(b.mValue,d.mValue,address) AS addr from classroom
										      left join CodeCity as b on classroom.city=b.mCode
													left join CodeCity as d on classroom.area=d.mCode
										      where ('".$city."'='' or city='".$city."') and
										      ('".$area."'='' or area='".$area."') And ClassRoom_Status<>'停止'  order by city,area";
									$result = mysqli_query($sqli,$sql." limit ".((intval($nowPage)-1)*$pageSize).",".$pageSize." ");
									$rs_temp = mysqli_query($sqli,$sql);
									$rs_cn = mysqli_num_rows($rs_temp);
									$pagecount = ceil($rs_cn/$pageSize);
									for($i = 0 ; ($i < $row = mysqli_fetch_array($result)) && $i < $pageSize ; ++$i){
							?>
								<div class="classroom">
									<table>
										<tr>
											<td rowspan="3" class="h1">
												<? echo $row["CName"]; ?>
											</td>
											<td width="5%" class="td_icon">>
											</td>
											<td class="class_contact">
												<? echo $row["Tel"]; ?><br/>
												<? echo $row["addr"]; ?>
											</td>
										</tr>
										<tr>
											<td class="td_icon">>
											</td>
											<td class="class_contact">
												<? echo $row["Summary"]; ?>
											</td>
										</tr>
										<?
											if($row["Website"]!=""){
										?>
										<tr>
											<td class="td_icon">>
											</td>
											<td>
												<a href="<? echo $row["Website"];?>" target="_blank"><? echo $row["Website"];?></a>
											</td>
										</tr>
										<?
											}
										?>
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
	        	<div id="class_banner_img"></div>
	        </div>
	  	</div>
    </div>
    <footer>
		<? include_once("footer.php"); ?>
	</footer>
	<script>
		function change_area(){
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