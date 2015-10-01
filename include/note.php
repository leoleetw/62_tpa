<?php
Function OptionList ($SQL,$FName,$Listfield,$BoundColumn,$menusize){
		global $sqli;
		$result = mysqli_query($sqli,$SQL);
		$rs_cn = mysqli_num_rows($result);
    echo "<SELECT Name='" . $FName . "' size='" . $menusize . "' style='font-size: 9pt; font-family: 新細明體'>";
    if($rs_cn==0){
			echo "<OPTION>" . " " . "</OPTION>";
		}
    echo "<OPTION selected value=''>" . " " . "</OPTION>";
    while($row = mysqli_fetch_array($result)){
    	if($row[$FName] == $BoundColumn)
    		$strSelected = "selected";
    	else
    		$strSelected = "";
    	echo "<OPTION " . $strSelected . " value='" . $row[$FName] . "'>" . $row[$Listfield] . "</OPTION>";
		}
		echo "</SELECT>";
}
Function OptionLists ($SQL,$FName,$Listfield,$BoundColumn,$menusize){
		global $sqli;
		$result = mysqli_query($sqli,$SQL);
		$rs_cn = mysqli_num_rows($result);
    echo "<SELECT Name='" . $FName . "' size='" . $menusize . "' style='font-size: 9pt; font-family: 新細明體'>";
    if($rs_cn==0)
			echo "<OPTION>" . " " . "</OPTION>";
		if($BoundColumn=="")
			echo "<OPTION selected value=''>" . "縣市" . "</OPTION>";
    while($row = mysqli_fetch_array($result)){
    	if($row[$FName] == $BoundColumn)
    		$strSelected = "selected";
    	else
    		$strSelected = "";
    	echo "<OPTION " . $strSelected . " value='" . $row[$FName] . "'>" . $row[$Listfield] . "</OPTION>";
		}
		echo "</SELECT>";
}
Function OptionList3 ($SQL,$FName,$Listfield,$BoundColumn,$menusize){
		global $sqli;
		$result = mysqli_query($sqli,$SQL);
		$rs_cn = mysqli_num_rows($result);
    echo "<SELECT Name='" . $FName . "' size='" . $menusize . "' style='font-size: 9pt; font-family: 新細明體'>";
    if($rs_cn==0){
			echo "<OPTION>" . " " . "</OPTION>";
		}
    echo "<OPTION selected value=''>" . " " . "</OPTION>";
    while($row = mysqli_fetch_array($result)){
    	$TempName = $row[$FName]; 
      $AA = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      For($i = 0 ; $i < 26 ; ++$i)
        $TempName = str_replace(substr($AA,$i,1),"",$TempName);
    	if($TempName == $BoundColumn)
    		$strSelected = "selected";
    	else
    		$strSelected = "";
    	echo "<OPTION " . $strSelected . " value='" . $TempName . "'>" . $TempName . "</OPTION>";
		}
		echo "</SELECT>";
}
function CheckBoxList ($SQL,$FName,$Listfield,$BoundColumn){
		global $sqli;
		$result = mysqli_query($sqli,$SQL);
		$rs_cn = mysqli_num_rows($result);
    $_SESSION["FieldsetCount"]=$rs_cn;
    $i = 1;
    while($row = mysqli_fetch_array($result)){
    	if( instr($row[$FName],$BoundColumn) >= 0)
    		$StrChecked="checked";
    	else
    		$StrChecked="";
    	echo "<Input Type='checkbox' " . $StrChecked . " Name='" . $FName ."[]' ID='" . $FName . $i . "' value='" . $row[$FName] . "'>" . $row[$Listfield] . "&nbsp;";
    	$i++;
    }
}
function CheckBoxLists ($SQL,$FName,$Listfield,$BoundColumn){
		global $sqli;
		$result = mysqli_query($sqli,$SQL);
		$rs_cn = mysqli_num_rows($result);
    $_SESSION["FieldsetCount"]=$rs_cn;
    $i = 1;
    while($row = mysqli_fetch_array($result)){
    	if( instr($row[$FName],$BoundColumn) >= 0)
    		$StrChecked="checked";
    	else
    		$StrChecked="";
    	echo "<Input Type='checkbox' " . $StrChecked . " Name='" . $FName .$i ."' ID='" . $FName . $i . "' value='" . $row[$FName] . "'>" . $row[$Listfield] . "&nbsp;";
    	if($i % 5 == 0)
    		echo "<br>";
    	$i++;
    }
}
Function DataLinkGrid ($SQL,$HLink,$LinkParam,$LinkTarget,$DataLink,$DataParam,$DataTarget){
	global $sqli;
	$result = mysqli_query($sqli,$SQL);
	$rs_cn = mysqli_num_rows($result);
	$FieldsCount = mysqli_num_fields($result);
  echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>";
  echo "<tr>";
  $arr = Array();
  $i=0;
  while($field = mysqli_fetch_field($result)){
  	$arr[$i] = $field -> name;
  	$i++;
  }
  for($i = 2 ; $i < count($arr); ++$i)
	echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" . $arr[$i] . "</span></font></td>";
  echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>處理</span></font></td>";
  echo "</tr>";
  while($row = mysqli_fetch_array($result)){
		echo "<tr bgcolor='#FFFFFF' onmouseover=this.bgColor='#E2F1FF' onmouseout=this.bgColor='#FFFFFF'>";
		for($i = 2 ; $i < $FieldsCount ; ++$i)
			if($i == 2)
				echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" . "<a href='" . $HLink .$row[$LinkParam]. "' target='" . $LinkTarget ."'>" . $row[$i] . "</a></span></td>";
			else
				echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" . $row[$i] . "</span></td>";
		 echo "<td><a href=JavaScript:if(confirm('是否確定要刪除 ?')){window.location.href='" . $DataLink . $row[$DataParam] . "';} target='" . $DataTarget ."'><img src='../images/x5.gif' border=0 width='16' height='14' alt='刪除'></a></td>";
		echo "</tr>";
	}
	echo "</table>";

}
Function GetGrid ($SQL,$LinkField){
	global $sqli;
	$result = mysqli_query($sqli,$SQL);
	$rs_cn = mysqli_num_rows($result);
	$FieldsCount = mysqli_num_fields($result);
	echo "<table id=grid border='1' cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>";
	echo "<tr>";
	while($field = mysqli_fetch_field($result))
		echo "<td bgcolor='#FFE1AF'><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" . $field->name . "</span></font></td>";
	echo "</tr>";
	while($row = mysqli_fetch_array($result)){
		echo "<tr bgcolor='#FFFFFF' onmouseover=this.bgColor='#E2F1FF' onmouseout=this.bgColor='#FFFFFF'>";
		for($i = 0 ; $i < $FieldsCount ; ++$i)
			if($i == 0)
				echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" . "<a href=javascript:opener.document.form." . $LinkField . ".value='" . $row[$i] . "';self.close();>" . $row[$i] . "</a></span></td>";
			else
				echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" . $row[$i] . "</span></td>";
		echo "</tr>";
	}
	echo "</table>";
}
Function ShowGrids ($SQL){
	global $sqli;
	$result = mysqli_query($sqli,$SQL);
	$rs_cn = mysqli_num_rows($result);
	$FieldsCount = mysqli_num_fields($result);
  echo  "<center>檢定名單</center><p>";
  echo  "<table id=grid border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>";
  echo  "<tr>";
  $arr = Array();
  $i=0;
  while($field = mysqli_fetch_field($result)){
  	$arr[$i] = $field -> name;
  	$i++;
  }
  for($i = 2 ; $i < count($arr); ++$i)
		echo  "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>" . $arr[$i] . "</span></font></td>";

  echo  "</tr>";
  while($row = mysqli_fetch_array($result)){
		echo "<tr>";
		for($i = 2 ; $i < $FieldsCount ; ++$i)
				echo "<td bgcolor='#FFFFFF'><span style='font-size: 9pt; font-family: 新細明體'>" . $row[$i] . "</span></td>";
		echo "</tr>";
	}
  echo "</table>";
}
?>