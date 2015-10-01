<?
	include_once("database.ini.php");
	@$value = isset($_POST["value"]) ? $_POST['value'] : $_GET['value'] ;
	$list = Array();
	$sql = "select mCode ,mValue from CodeCity where codeMetaID='Addr0R".$value."' order by mSortValue";
	$result = mysqli_query($sqli,$sql);
	for($i = 0 ; $i < $row = mysqli_fetch_array($result) ; ++$i){
		$list[$i] = $row;
	}
	echo json_encode($list);
	$sqli->close();
?>