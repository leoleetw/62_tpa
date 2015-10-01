<?
	include("include/dbinclude.php");
	@$ser_no = isset($_POST["ser_no"]) ? $_POST['ser_no'] : $_GET['ser_no'] ;
	$sql = "Select * From DOWNLOAD Where ser_no = '".$ser_no."';";
	//echo $sql ;
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result) ;
	$Download_Time=$row["Download_Time"];
	
	$sql = "update DOWNLOAD set Download_Time = '".(intval($Download_Time)+1)."' where ser_no = '".$ser_no."';";
	//echo $sql ;
	mysqli_query($sqli,$sql);
	mysqli_close($sqli);
	echo "<Script>javascript:window.close();</Script>";
	/*
  Set RS = Server.CreateObject("ADODB.RecordSet")
  RS.Open "Select * From DOWNLOAD Where ser_no = '"&Request("ser_no")&"'", Conn, 1, 3
  If Not RS.EOF Then  
    Download_Time=RS("Download_Time")
    RS("Download_Time") = CDbl(Download_Time)+1
    RS.Update
  End If
  RS.Close
  Set RS = Nothing
  echo "<Script>javascript:window.close();</Script>"
  */
?>