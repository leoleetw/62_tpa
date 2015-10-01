<!doctype html>
<?
include_once("include/dbinclude.php");
if($_SESSION["User_id"]!=""){
	@$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "update"){
		@$updatetime = date("Y-m-d h:i:s") ;
		$sql = "update MEMBERDATA set Tel_Home='".$_POST["Tel_Home"]."' , Tel_Office='".$_POST["Tel_Office"]."', Cellular_Phone='".$_POST["Cellular_Phone"]."', Fax='".$_POST["Fax"]."'
		, Email='".$_POST["Email"]."', ZipCode='".$_POST["ZipCode"]."', City='".$_POST["City"]."', Area='".$_POST["Area"]."', Address='".$_POST["Address"]."', Last_Update='".$updatetime."'
		where Member_id='".$_POST["Member_id"]."';";
		mysqli_query($sqli,$sql);
		$_SESSION["errnumber"]=1;
   	$_SESSION["msg"]="資料修改成功 !";
	}
	else if($action == "cancel" ){
		$log_desc="會員登出";
	  memberlog ($log_desc);
	  $_SESSION["errnumber"]=0;
	  $_SESSION["msg"]="會員登出";
	  $_SESSION["errntime"]="";
	  unset($_SESSION["User_id"]);
	  unset($_SESSION["Member_Name"]);
	  unset($_SESSION["Member_Category"]);
	  header("Location: index.php");
	}
	$sql="Select * From MEMBERDATA Where Member_No='".$_SESSION["User_id"]."'";
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result);
}
else{
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
		      memberlog ($log_desc);
		      memberlogin ();
		      $_SESSION["errnumber"]=1;
		      $_SESSION["msg"]="會員登入成功 ";
		      $_SESSION["errntime"]="";
			  $_SESSION["User_id"]=$User_id;
			  $_SESSION["Member_Name"]=$row ["Member_Name"];
			  $_SESSION["Member_Category"]=$row ["Category"];
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

function memberlog ($log_desc){
	@$User_id = isset($_POST["User_id"]) ? $_POST['User_id'] : $_GET['User_id'] ;
	@$Password = isset($_POST["Password"]) ? $_POST['Password'] : $_GET['Password'] ;
	$update = date("Y-m-d h:i:s");
	$client_IP=getip();
	$sql="Insert Into member_log values ('".$update."','".$User_id."','".$Password."','".$log_desc."','".$client_IP."');";
	global $sqli;
	mysqli_query($sqli,$sql);
}

function memberlock (){
	@$User_id = isset($_POST["User_id"]) ? $_POST['User_id'] : $_GET['User_id'] ;
	$sql="update MEMBERDATA set Member_lock='Y' Where Member_No='".$User_id."';";
	global $sqli;
	mysqli_query($sqli,$sql);
}

function memberlogin (){
	@$User_id = isset($_POST["User_id"]) ? $_POST['User_id'] : $_GET['User_id'] ;
	$update = date("Y-m-d h:i:s");
	$client_IP=getip();
	$sql="update MEMBERDATA set Last_Login='".$update."',Last_IP='".$client_IP."' Where Member_No='".$User_id."';";
	global $sqli;
	mysqli_query($sqli,$sql);
}

function OptionLists ($sql,$FName,$Listfield,$BoundColumn,$menusize){
	global $sqli;
	$result = mysqli_query($sqli,$sql);
	$row_cnt = mysqli_num_rows($result);
	echo "<SELECT Name='" . $FName . "' size='" . $menusize . "' style='font-family: 新細明體; font-size: 9pt'>";
	if($row_cnt == 0)
		echo "<OPTION>  </OPTION>";
	if($BoundColumn == "")
		echo "<OPTION selected value=''>" . "縣市" . "</OPTION>";

	for($i = 0 ; $i < $row = mysqli_fetch_array($result) ; ++$i){
		if($row[$FName]==$BoundColumn)
			$strSelected = "selected";
		else
			$strSelected = "";
		echo "<OPTION " . $strSelected . " value='" . $row[$FName] . "'>" . $row[$Listfield] . "</OPTION>";
	}
	echo "</SELECT>";
}
function OptionLists2 ($sql,$FName,$Listfield,$BoundColumn,$menusize){
	global $sqli;
	$result = mysqli_query($sqli,$sql);
	$row_cnt = mysqli_num_rows($result);
	echo "<SELECT Name='" . $FName . "' size='" . $menusize . "' style='font-family: 新細明體; font-size: 9pt'>";
	if($row_cnt == 0)
		echo "<OPTION>  </OPTION>";
	if($BoundColumn == "")
		echo "<OPTION selected value=''>" . "區域" . "</OPTION>";

	for($i = 0 ; $i < $row = mysqli_fetch_array($result) ; ++$i){
		if($row[$FName]==$BoundColumn)
			$strSelected = "selected";
		else
			$strSelected = "";
		echo "<OPTION " . $strSelected . " value='" . $row[$FName] . "'>" . $row[$Listfield] . "</OPTION>";
	}
	echo "</SELECT>";
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
<link href="css/send_mail.css" rel="stylesheet">
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
<!--<div id="main">
	<div id="main_top01">
        <div class="middle_section">
            <div id="main_top02"></div>
            <div id="main_top03"></div>
        </div>
  	</div>-->
  	<div class="middle_section">
    	<div id="member_title"></div>
    	<div id="main_content">
            <form id='form1' name="form1" method="post" action='member.php'>
                    <div>
                    	<input type="hidden" id="action" name="action">
                    	<input type="hidden" id="Member_id" name="Member_id" value="<? echo $row["Member_id"];?>">
						<table id="member_profile">
                        	<tr>
                            	<td class="dark_green01">編號：</td><td colspan="3" class="light_green"><input type="text" id="Member_No" name="Member_No" value="<? echo $row["Member_No"];?>" readonly></td>
                            </tr>
                            <tr>
                            	<td class="dark_green01">姓名：</td><td colspan="3" class="light_green"><input type="text" id="Member_Name" name="Member_Name" value="<? echo $row["Member_Name"];?>" readonly></td>
                            </tr>
                            <tr>
                            	<td class="dark_green01">電話（H）：</td><td class="light_green"><input type="text" id="Tel_Home" name="Tel_Home" value="<? echo $row["Tel_Home"];?>" ></td>
                                <td class="dark_green01">電話（O）：</td><td class="light_green"><input type="text" id="Tel_Office" name="Tel_Office" value="<? echo $row["Tel_Office"];?>" ></td>
                            </tr>
                            <tr>
                            	<td class="dark_green01">手機：</td><td class="light_green"><input type="text" id="Cellular_Phone" name="Cellular_Phone" value="<? echo $row["Cellular_Phone"];?>" ></td>
                                <td class="dark_green01">傳真：</td><td class="light_green"><input type="text" id="Fax" name="Fax" value="<? echo $row["Fax"];?>" ></td>
                            </tr>
                            <tr>
                            	<td class="dark_green01">E-Mail：</td><td colspan="3" class="light_green"><input type="text" id="Email" name="Email" value="<? echo $row["Email"];?>" ></td>
                            </tr>
                            <tr>
                            	<td class="dark_green01">通訊地址：</td>
                                <td colspan="3" class="light_green">
                                	<input type="text" id="ZipCode" name="ZipCode" value="<? echo $row["ZipCode"];?>" readonly>
                                    <select id="City" name="City" onchange="change_zipcode('city',this.value);">
                                    <?
										$sql = "select mCode , mValue from codecity where codeMetaID = 'Addr0' order by mSortValue";
										$result1 = mysqli_query($sqli,$sql);
										while($row1 = mysqli_fetch_array($result1)){
											echo "<option value='".$row1["mCode"]."' ";
											if($row1["mCode"]==$row["City"])
												echo "selected";
											echo " >".$row1["mValue"]."</option>";
										}
									?>
                                    </select>
                                    <select id="Area" name="Area" onchange="change_zipcode('area',this.value);">
                                    <?
										$sql = "select mCode , mValue from codecity where codeMetaID = 'Addr0R".$row["City"]."' order by mSortValue";
										$result1 = mysqli_query($sqli,$sql);
										while($row1 = mysqli_fetch_array($result1)){
											echo "<option value='".$row1["mCode"]."' ";
											if($row1["mCode"]==$row["Area"])
												echo "selected";
											echo " >".$row1["mValue"]."</option>";
										}
									?>
                                    </select>
                                	<input type="text" id="Address" name="Address" value="<? echo $row["Address"];?>" >
                                </td>
                            </tr>
                            <tr>
                            <td colspan="4">
                            	<input type="button" id="cancel" name="cancel" value="登出" onclick="onclick_cancel();">
                            	<input type="button" id="update" name="update" value="修改" onclick="onclick_update();">
                            </td>
                            </tr>
                        </table>
                    </div>
                    
                </form>
            </div>
  	</div>
</body>
<footer>
  <? include_once("footer.php"); ?>
</footer>
<? Message(); ?>
<script>
	function onclick_cancel(){
		Dd("action").value="cancel";
		document.form1.submit();
	}
	function onclick_update(){
		Dd("action").value="update";
		document.form1.submit();
	}
	function change_zipcode_info(mytext){
		var str = "";
		var arr = new Array();
		arr=JSON.parse(mytext);
		for(var i=0; i< arr.length ; ++i){
			if(i == 0)
				Dd("ZipCode").value=arr[i].mCode;
			str += "<option value='"+arr[i].mCode+"'>"+arr[i].mValue+"</option>";
		}
		Dd("Area").innerHTML = str;
	}
	function change_zipcode(this_type , this_value){
		if(this_type == "city")
			CallServer("include/city.php","value="+this_value, "GET", true, "mytext", change_zipcode_info);
		else
			Dd("ZipCode").value=this_value;
	}
</script>
</body>
