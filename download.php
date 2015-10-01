<!doctype html>
<?
include_once("include/dbinclude.php");
@$nowPage = isset($_POST["nowPage"]) ? $_POST['nowPage'] : $_GET['nowPage'] ;
if($nowPage == "")
	$nowPage = '1';
@$ktype = isset($_POST["ktype"]) ? $_POST['ktype'] : $_GET['ktype'] ;
if($ktype == "")
	$ktype = '1';
@$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
if($action == "login"){
	@$User_id = isset($_POST["User_id"]) ? $_POST['User_id'] : $_GET['User_id'] ;
	@$Password = isset($_POST["Password"]) ? $_POST['Password'] : $_GET['Password'] ;
	$sql="Select * From MEMBERDATA Where Member_No='".$User_id."'";
	$result = mysqli_query($sqli,$sql);
	$rs_cn = mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
  	if($rs_cn!=0){
  		if($row ["Status"] == "停權"){
  			$log_desc="登入帳號已停權";
	      memberlog ($log_desc);
	      $_SESSION["errnumber"]=1;
	      $_SESSION["msg"]="您的帳號已停權，詳情請與協會聯絡！";
	      header("Location: index.php");
  		}
  		else{
  			if($row ["IDNo"] == $Password){
  				$log_desc = "會員登入成功 ";
		      //memberlog ($log_desc);
		      //memberlogin ();
		      $_SESSION["errnumber"]=1;
		      $_SESSION["msg"]="會員登入成功 ";
		      $_SESSION["errntime"]="";
			  $_SESSION["User_id"]=$User_id;
			  $_SESSION["Member_Name"]=$row ["Member_Name"];
			  $_SESSION["Member_Category"]=$row ["Category"];
			  if($row ["Category"]=='講師'){
					$AA = "";
					$sql2 =  "Select Test_type From Test Where Member_id = '".$row["Member_id"]."' And Test_type Like '%講師%'";
					$res2 = QuerySQL($sql2);
					for($i=0 ; $i < count($res2) ; ++$i){
						if($AA=="")
							$AA = $res2[$i]["Test_type"];
						else
							$AA = "@".$res2[$i]["Test_type"];
					}
					$AA = str_replace("兒童捏塑講師","兒童捏塑講師@黏土捏塑設計講師",$AA);
					$AA = str_replace("兒童彩繪講師","兒童彩繪講師@鄉村風藝術彩繪師範科",$AA);
					$AA = str_replace("傢飾班講師證","傢飾班講師證@麵包花傢飾藝術講師",$AA);
					$AA = str_replace("麵包花藝術講師證","花藝術講師證@麵包花藝術講師",$AA);
					$AA = str_replace("紙粘土講師","紙粘土講師@紙黏土裝飾藝術講師",$AA);
					$AA = str_replace("麵包花講師","麵包花講師@麵包花藝術講師",$AA);
					$AA = str_replace("彩繪講師","彩繪講師@生活藝術彩繪師範科",$AA);
				}
			  $nowPage=1;
			  $ktype='t';
  			}
		    else{
		    	$log_desc="登入密碼錯誤";
          memberlog ($log_desc);
          if($_SESSION["errntime"]=="")
            $_SESSION["errntime"]=1;
          else
            $_SESSION["errntime"]=$_SESSION["errntime"]+1;
          
          
          if($_SESSION["errntime"] >= 6 ){
            memberlock();
            $_SESSION["errnumber"]=1;
            $_SESSION["msg"]="您的帳號已封鎖，詳情請與協會聯絡！";
            header("Location: index.php");
          }     
          else{
            $_SESSION["errnumber"]=1;
            $_SESSION["msg"]="密碼錯誤！";
            header("Location: index.php");
          }   
		    } 
  		}
  	}
  	else{
  		$log_desc="登入帳號不存在";
	    memberlog ($log_desc);
	    $_SESSION["errnumber"]=1;
	    $_SESSION["msg"]="帳號 / 密碼錯誤！";
	    header("Location: index.php");
  	}
}
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
  <link href="css/tpa_download.css" rel="stylesheet">
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
	   	<div id="download_banner_nav"></div>
  		<div id="link_main_nav"></div>
        </div-->
	  		<form id='form1' action='download.php' method="post">
					
					<div class="download_div">
						<div class="j4right">
							<?
								if($_SESSION["User_id"]==""){
							?>
								<input type="button" value="講師專區"  onclick="$('#myModal').modal('show');">
							<?
								}else if($_SESSION["Member_Category"]=="講師"){
							?>
								<input type="button" value="講師專區" onclick="teacher_download();">
							<?
								}
							?>
							<select id='ktype1' name='ktype1' onchange="change_ktype();">
								<?
									if($ktype == 't')
										echo "<option value='' selected>講師專區</option>";
								?>
							<?
								$sql = "select CodeDesc AS download_type,Seq from casecode where codetype='DownloadType' order by seq";
								$result = mysqli_query($sqli,$sql);
								for($i = 0 ; $i < $row = mysqli_fetch_array($result); ++$i){
									echo "<option value='".$row["Seq"]."' ";
									if($row["Seq"]==$ktype)
										echo "selected";
									echo "> ".$row["download_type"]."</option>";
								}
							?>
							</select>
							<input type='hidden' id='ktype' name='ktype' value="<? echo $ktype ?>">
						</div>
						<table class="download_table">
						<?
						$pageSize = 20;
						if($ktype != 't'){
							$sql = "Select * From DOWNLOAD Where Download_Url<>'' And ('".date("Y-m-d h:i:s")."' Between Download_BeginDate And Download_EndDate) And Download_Type2 = '無'";
		        	$sql .=" And download_type=(Select CodeDesc from casecode where Codetype='DownloadType' And Seq = '".intval($ktype)."' order by seq limit 0,1) ";
		          $sql .="Order By Download_Seq desc, ser_no desc ";
		        }
		        else{
		        	
		        	$sql = "Select * From DOWNLOAD Where Download_Url<>'' And Download_Type2='講師' And ('".date("Y-m-d h:i:s")."' Between Download_BeginDate And Download_EndDate) ";
              if(instr($AA,"@") > 0){
              	$Desc = "";
              	$BB = explode("@" , $AA);
              	for($i=0;$i < count($BB);++$i){
              		if($Desc=="")
              			$Desc = "download_LicenseDesc Like '%".$BB($i)."%' ";
              		else
              			$Desc .= " Or download_LicenseDesc Like '%".$BB($i)."%' ";
              	}
              	$sql .= "And (IFNULL(download_LicenseDesc,'') = '' Or ".$Desc.")";
              }
              else
              	$sql .= "And (IFNULL(download_LicenseDesc,'') = '' Or download_LicenseDesc Like '%".$AA."%' )";
              $sql .= "Order By Download_Seq desc, ser_no desc ";
              
		        }
	          $result = mysqli_query($sqli,$sql." limit ".((intval($nowPage)-1)*$pageSize).",".$pageSize." ");
						$rs_temp = mysqli_query($sqli,$sql);
						$rs_cn = mysqli_num_rows($rs_temp);
						$pagecount = ceil($rs_cn/$pageSize);
							for($i = 0 ; $i < $row = mysqli_fetch_array($result); ++$i){
						?>
							<tr>
								<td width="30px"><? echo ($i+1); ?></td>
								<td width="600px"><? echo $row["Download_Name"]; ?></td>
								<td width="60"><a href="#" onclick="javascript:window.open('download_count.php?ser_no=<? echo $row["ser_no"]; ?>','download','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,top=0,left=0,width=0,height=0');javascript:window.location.href ='upload/download/<? echo $row["Download_Url"]?>';"><img class="download_img" src="images/download_button.png"></a></td>
							</tr>
						<? } ?>
						</table>
						<?
						if($nowPage < $pagecount){
							echo "<input type='button' id='btn_down' onclick=page_change('down') value='下一頁'>";
						}
						if($nowPage != 1){
							echo "<input type='button' id='btn_up' onclick=page_change('up') value='上一頁'>";
						}
						
					?>
					<input type="hidden" id="nowPage" name="nowPage" value="<? echo $nowPage;?>">
					</div>
					
						
				</form>
			</div>
	<form id='form2' action='download.php' method="post">
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">講師登入</h4>
		      </div>
		      <div class="modal-body">
		        <table width="100%">
		        	<tr>
		        		<td width="20%">帳號：</td>
		        		<td width="80%"><input type="text" id="User_id" name="User_id" value="" class="form-control"></td>
		        	</tr>
		        	<tr>
		        		<td>密碼：</td>
		        		<td><input type="password" id="Password" name="Password" value="" class="form-control"></td>
		        	</tr>
		        </table>
		        <input type="hidden" id="action" name="action" value="login" >
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="button" class="btn btn-primary" onclick="login();">登入</button>
		      </div>
		    </div>
		  </div>
		</div>
	</form>
	<div id="clear"></div>
    </div>
	<div class="banner">
		<div class="banner_bg">
	        <div class="middle_section">
	        	<div id="download_banner_img"></div>
	        </div>
	  	</div>
    </div>
    <footer>
		<? include_once("footer.php"); ?>
	</footer>
	<script>
		function change_ktype(){
			Dd("nowPage").value="";
			Dd("ktype").value=Dd("ktype1").value;
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
		function login(){
			$('#myModal').modal('hide');
			
			if(Dd("User_id").value=="" || Dd("Password").value==""){
				alert("帳密尚未填寫完全!");
				Dd("form2").reset();
			}
			else{
				Dd("form2").submit();
			}
		}
		
		function teacher_download(){
			Dd("ktype").value='t';
			Dd("form1").submit();
		}
	</script>
</body>
</html>