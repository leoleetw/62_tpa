<?
include_once("database.ini.php");

$list = Array();
$respone = "";
$type=isset($_POST["type"]) ? $_POST['type'] : $_GET['type'] ;
if($type=="1")
	$sql="select album.album_desc,album_url from albumtype join album on albumtype.album_type=album.album_type where album_kind='協會組織' and album_name='理事長'";
if($type=="3")
	$sql="select album.album_desc,album_url from albumtype join album on albumtype.album_type=album.album_type where album_kind='協會組織' and album_name='秘書長'";
if($type=="4")
	$sql="select album.album_desc,album_url from albumtype join album on albumtype.album_type=album.album_type where album_kind='協會組織' and album_name='秘書處'";
if($type=="2")
	$sql="select album.album_desc,album_url from albumtype join album on albumtype.album_type=album.album_type where album_kind='協會組織' and album_name='常務理事'";
if($type=="5")
	$sql="select album.album_desc,album_url from albumtype join album on albumtype.album_type=album.album_type where album_kind='協會組織' and album_name='常務監事'";
if($type=="6")
	$sql="select album.album_desc,album_url from albumtype join album on albumtype.album_type=album.album_type where album_kind='協會組織' and album_name='理監事'";
	
$result = mysqli_query($sqli, $sql);
for($i = 0 ;$row = mysqli_fetch_array($result);++$i){
	$list[$i] = $row;
}

$respone .= json_encode($list);
echo $respone;
$sqli->close();

?>