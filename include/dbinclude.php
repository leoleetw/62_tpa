<?php
session_start();
$db_host = 'localhost';
$db_user = 'root';
$db_pwd = 'paisql';
$db_name = 'art';

date_default_timezone_set('Asia/Taipei');
$sqli=mysqli_connect($db_host,$db_user,$db_pwd,$db_name);
/*
if(!$sqli=mysqli_connect($db_host,$db_user,$db_pwd,$db_name)){
	echo "mysql connect error!";
}*/
function getip(){
    $ipaddress = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(!empty($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(!empty($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(!empty($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
/*
function getip(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
	 return $_SERVER['HTTP_CLIENT_IP'];
	}
	else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	  return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else{
	  return $_SERVER['REMOTE_ADDR'];
	}
}
*/
function mysqldate($mytext){
	$arr=Array();
	$arr=explode(" ",$mytext);
	$arr[0] = str_replace("-", "/" ,$arr[0]);
	//echo $arr[0];
	return $arr[0];
}
function mysqldatetime($mytext){
	$arr=Array();
	$arr=explode(".",$mytext);
	//echo $arr[0];
	return $arr[0];
}
function mysqltime($mytext){
	$arr=Array();
	$str=Array();
	$arr=explode(".",$mytext);
	$str=explode(" ",$arr[0]);
	//echo $str[1];
	return $str[1];
}
function dateDiff($startDate, $endDate) {
  $startArry = getdate(strtotime($startDate));
  $endArry = getdate(strtotime($endDate));
  $start_date = gregoriantojd($startArry["mon"], $startArry["mday"], $startArry["year"]);
  $end_date = gregoriantojd($endArry["mon"], $endArry["mday"], $endArry["year"]);

  return round(($end_date - $start_date), 0);
}
function minDiff($startTime, $endTime) {
    $start = strtotime($startTime);
    $end = strtotime($endTime);
    $timeDiff = $end - $start;
    return floor($timeDiff / 60);
}
function QuerySQL ($sql){
	global $sqli;
	$array = Array();
	$result = mysqli_query($sqli,$sql);
	for($i = 0 ; $i < $row = mysqli_fetch_array($result) ; ++$i){
		$array[$i] = $row;
	}
	return $array;
}

function instr($Str_Sourec,$Str_Target){ 
  if($Str_Sourec == "" || $Str_Target == ""){ 
      return -1; 
  }else{ 
      $StrTo = strpos($Str_Sourec,$Str_Target); 
      if($StrTo >= 0){ 
          return $StrTo; 
      }else{ 
          return -1; 
      } 
  } 
}
/*
function instr($Str_Sourec,$Str_Target){ 
	$StrTo = strpos($Str_Sourec,$Str_Target); 	    
	if($StrTo > 0){ 
		return $StrTo; 
	}else{ 
		return 0; 
	} 
}
*/
function checkFun($data,$data1){
	if(instr($data1,$data) > 0){ 
		return "checked";
	}
}
function CheckSubmitJ ($SubmitType){
	echo "document.form.action.value='".$SubmitType."';" . Chr(13) . Chr(10);
  echo "document.form.submit();" . Chr(13) . Chr(10);
}
function CheckEmailJ ($FName){
  echo "if(document.form." . $FName . ".value.indexOf('@')==-1||document.form." . $FName . ".value.indexOf('.')==-1){" . Chr(13) . Chr(10);
  echo "  alert('您輸入的電子郵件不合法！');" . Chr(13) . Chr(10);
  echo "  document.form." . $FName . ".focus();" . Chr(13) . Chr(10);
  echo "  return;" . Chr(13) . Chr(10);
  echo "}" . Chr(13) . Chr(10);
}
Function Checklen($FName,$CLength,$ListField){              //'檢測中英文夾雜字串實際長度
    echo "x = form." . $FName . ".value;" . Chr(13) . Chr(10);
    echo "if (x.length > " . $CLength . "){" . Chr(13) . Chr(10);
    echo "   alert( ". Chr(34) . $ListField . " 欄位長度超過限制 !".Chr(34) .");". Chr(13) . Chr(10);
    echo "   form." . $FName .".focus(); " . Chr(13) . Chr(10);
    echo "   return; " . Chr(13) . Chr(10);
    echo "} " . Chr(13) . Chr(10);
}
function ChecklenJ($FName,$CLength,$ListField){//檢測中英文夾雜字串實際長度
  echo "var cnt=0;" . Chr(13) . Chr(10) ;
  echo "var sName=document.form." . $FName . ".value" . Chr(13) . Chr(10);
  echo "for(var i=0;i<sName.length;i++ ){" . Chr(13) . Chr(10);
  echo "  if (escape(sName.charAt(i)).length >= 4) cnt+=2;" . Chr(13) . Chr(10)   ;
  echo "  else cnt++;" . Chr(13) . Chr(10);
  echo "}" . Chr(13) . Chr(10);
  echo "if(cnt>" . $CLength . "){" . Chr(13) . Chr(10);
  echo "  alert('". $ListField . "  欄位長度超過限制！');" . Chr(13) . Chr(10);
  echo "  return;" . Chr(13) . Chr(10);
  echo "}" . Chr(13) . Chr(10);
}

Function CheckSubmit($SubmitType){
  echo "document.form.action.value='".$SubmitType."';" . Chr(13) . Chr(10);
  echo "document.form.submit();" . Chr(13) . Chr(10);
}
Function CheckString ($FName,$ListField){
    echo "if(form." . $FName . ".value==".Chr(34).Chr(34)."){ " . Chr(13) . Chr(10);
    echo "   alert( ". Chr(34) . $ListField . " 欄位不可為空白 !" . Chr(34) .");" . Chr(13) . Chr(10);
    echo "   form." . $FName .".focus(); " . Chr(13) . Chr(10);
    echo "return;}   " . Chr(13) . Chr(10);
}
Function CheckNumber ($FName,$ListField){
    echo "if (isNaN(form." . $FName . ".value)) { " . Chr(13) . Chr(10);
    echo "   alert( ". Chr(34) . $ListField . " 欄位必須為數字 !".Chr(34) .");". Chr(13) . Chr(10);
    echo "   form." . $FName .".focus " . Chr(13) . Chr(10);
    echo "   return; " . Chr(13) . Chr(10);
    echo "} " . Chr(13) . Chr(10);
}
Function CheckContentJ ($FName,$ListField){
  echo "var content=document.form." . $FName . ".value.toLowerCase();" . Chr(13) . Chr(10);
  echo "var AryKey = new Array('script','Iframe','a href','url','drop','create','delete','table','','1=1','--',';');" . Chr(13) . Chr(10) ; 
  echo "for(var i=0;i<=AryKey.length-1;i++){" . Chr(13) . Chr(10);
  echo "  if(content.indexOf(AryKey[i])!=-1){" . Chr(13) . Chr(10);
  echo "    alert('". $ListField . "  欄位請勿輸入 '+AryKey[i]+'  保留字元！');" . Chr(13) . Chr(10);
  echo "    return;" . Chr(13) . Chr(10);
  echo "  }" . Chr(13) . Chr(10);
  echo "}" . Chr(13) . Chr(10);
}
Function CheckDate1 ($FName,$ListField){
    echo "if(form." . $FName . ".value!=".Chr(34).Chr(34)."){ " . Chr(13) . Chr(10);
    echo "	var newdate = new date(form." . $FName . ".value);". Chr(10);
    echo "	if(!IsNaN(newdate) || (form." . $FName . ".value.substr(0,1)!=".Chr(34)."2".Chr(34)." && form." . $FName . ".value.substr(0,1)!=".Chr(34)."1".Chr(34).")){ " . Chr(13) . Chr(10);
    echo "		alert( ". Chr(34) . $ListField . " 欄位必須為西元日期格式 ! yyyy-mm-dd".Chr(34) .");" .Chr(13) . Chr(10);
    echo "		form." . $FName .".focus(); " . Chr(13) . Chr(10);
    echo "		return; " . Chr(13) . Chr(10);
    echo "	} " . Chr(13) . Chr(10);
    echo "} " . Chr(13) . Chr(10);
}
Function OptionList ($SQL,$FName,$Listfield,$BoundColumn,$menusize){
		global $sqli;
		$result = mysqli_query($sqli,$SQL);
		$rs_cn = mysqli_num_rows($result);
    echo "<SELECT Name='" . $FName . "' size='" . $menusize . "' style='font-size: 9pt; font-family: 新細明體' onchange='".$FName."_OnChange();'>";
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
Function syslog_php ($log_type,$log_desc){
    $sys_date=date("Y-m-d h:i:s");
    $client_IP=getip();
    $sql="insert into sys_log values (now(),'".$sys_date."','".$_SESSION["user_id"]."','".$_SESSION["user_name"]."','".$_SESSION["dept_id"]."','".$log_type."','".$log_desc."','".$client_IP."');";
    global $sqli;
    mysqli_query($sqli,$sql);
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
/*
Function PageList ($SQL,$PageSize,$nowPage,$ProgID,$HLink,$LinkParam,$LinkTarget,$AddLink){
	global $sqli;
	$result = mysqli_query($sqli,$SQL);
	$FieldsCount = mysqli_num_fields($result);
	echo "<table border=0 cellspacing='0' cellpadding='1' style='border-collapse: collapse' width='100%'>";
  if($AddLink != "")
    	echo "<td align='right'><span style='font-size: 9pt; font-family: 新細明體'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" . $AddLink . "' >新增資料</a></span></td>";  
  echo "</tr></table>";
  echo "<table id='table_context' border=1 cellspacing='0' cellpadding='2' style=' border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>";
  echo "<thead><tr>";
  while($field = mysqli_fetch_field($result))
  	echo "<th bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>".$field->name."</span></font></th>";

  echo "</tr></thead><tbody>";
  $i = 1;
  $arr = Array();
  for($rs1_i = 0 ;$rs1_i < $row = mysqli_fetch_array($result);++$rs1_i){
  	$showhand = "";
    if( $HLink != "" ){
         //echo "<a href='" . $HLink . $arr[$rs1_i][$LinkParam]. "' target='" . $LinkTarget ."'>";
         echo "<a href='" . $HLink . $row[$LinkParam]. "'>";
         $showhand="style='cursor:hand'";
    }
    echo "<tr onclick=document.location='" . $HLink . $row[$LinkParam]. "' ".$showhand." bgcolor='#FFFFFF' onmouseover=this.bgColor='#E2F1FF' onmouseout=this.bgColor='#FFFFFF'>";
    for($j=0;$j < $FieldsCount;++$j){
    	echo "<td><span style='font-size: 9pt; font-family: 新細明體'> ".$row[$j]." </span></td>";
    	//echo "<td><span style='font-size: 9pt; font-family: 新細明體'>" & RS1(j) & "</span></td>";
    }
    $i++;
    echo "</tr>";
	  echo "</a>";
  }
  echo "</tbody></table>";
}
*/

Function PageList ($SQL,$PageSize,$nowPage,$ProgID,$HLink,$LinkParam,$LinkTarget,$AddLink){
	global $sqli;
	$nowPage1 = intval($nowPage)-1;
	if($nowPage1 < 0)
		$nowPage1 = 0;
	//echo $SQL." limit ".$nowPage1*$PageSize.",".$PageSize;
	$result = mysqli_query($sqli,$SQL." limit ".$nowPage1*$PageSize.",".$PageSize);
	$result_temp = mysqli_query($sqli,$SQL);
	$rs1_cn = mysqli_num_rows($result_temp);
	if($rs1_cn != 0){
		$FieldsCount = mysqli_num_fields($result);
    $totRec=$rs1_cn;         //'總筆數
    if($totRec > 0){
      $PageCount = ceil($totRec/$PageSize);
      if ($nowPage=="" || $nowPage==0){
         $nowPage=1;
       }
  	  else if (intval($nowPage) > $PageCount){
     	 $nowPage=$PageCount;
     	}
     	$_SESSION["nowPage"]=$nowPage;
      $totPage=$PageCount;       //'總頁數
    }
    echo "<Form action='' id=form1 name=form1>" ;
    echo "<table border=0 cellspacing='0' cellpadding='1' style='border-collapse: collapse' width='100%'>";
    echo "<tr><td width='30%'></td>";
    echo "<td width='55%'><span style='font-size: 9pt; font-family: 新細明體'>第" . $nowPage . "/" . $totPage . "頁&nbsp;&nbsp;</span>";
    echo "<span style='font-size: 9pt; font-family: 新細明體'>共" . $totRec . "筆&nbsp;&nbsp;</span>";
    if($nowPage != 1){
       echo " | <a href=".$ProgID.".php?nowPage=".($nowPage-1)."&SQL=".urlencode($SQL).">上一頁</a>";
     }
    if(intval($nowPage) != $PageCount && intval($nowPage) < $PageCount){
       echo " | <a href=".$ProgID.".php?nowPage=".($nowPage+1)."&SQL=".urlencode($SQL).">下一頁</a>"; 
     }
    echo " |&nbsp;<span style='font-size: 9pt; font-family: 新細明體'> 跳至第<select name=GoPage size='1' style='font-size: 9pt; font-family: 新細明體'>";
    for($iPage = 1 ; $iPage <= $totPage ;++$iPage){
    	if($iPage == intval($nowPage))
    		$strSelected = "selected";
    	else
    		$strSelected = "";
    	echo "<option value='".$iPage."'" . $strSelected . ">" . $iPage . "</option>";
    }
    echo "</select>頁</span></td>";
    if($AddLink != "")
    	echo "<td align='right'><span style='font-size: 9pt; font-family: 新細明體'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" . $AddLink . "' >新增資料</a></span></td>";  
    echo "</tr></table>";
    
    echo "<table border=1 cellspacing='0' cellpadding='2' style='border-collapse: collapse;BACKGROUND-COLOR: #ffffff' bordercolor='#C0C0C0' width='100%' align='center'>";
    echo "<tr>";
    $i = 0;
    $f_name =Array();
    while($field = mysqli_fetch_field($result)){
    	$f_name[$i] = $field->name;
    	$i++;
    }
    for($i = 1 ; $i< count($f_name) ; ++$i)
    	echo "<td bgcolor='#FFE1AF' nowrap><font color='#111111'><span style='font-size: 9pt; font-family: 新細明體'>".$f_name[$i]."</span></font></td>";

    echo "</tr>";
    $i = 1;
    for($rs1_i = 0 ; $rs1_i < $row = mysqli_fetch_array($result); ++$rs1_i){
    	$showhand = "";
	    if($HLink != ""){
	    	if($LinkTarget == "main")
	    		echo "<tr style='cursor:hand' onclick=window.parent.location.href='" . $HLink . $row[$LinkParam]. "' ".$showhand." bgcolor='#FFFFFF' onmouseover=this.bgColor='#E2F1FF' onmouseout=this.bgColor='#FFFFFF'>";
	    	else
	         echo "<tr style='cursor:hand' target='" . $LinkTarget ."' onclick=document.location='" . $HLink . $row[$LinkParam]. "' ".$showhand." bgcolor='#FFFFFF' onmouseover=this.bgColor='#E2F1FF' onmouseout=this.bgColor='#FFFFFF'>";
	    }
	    else
	    	echo "<tr bgcolor='#FFFFFF' onmouseover=this.bgColor='#E2F1FF' onmouseout=this.bgColor='#FFFFFF'>";
	    //echo "<tr ".$showhand." bgcolor='#FFFFFF' onmouseover=this.bgColor='#E2F1FF' onmouseout=this.bgColor='#FFFFFF'>";
	    for($j=1;$j < $FieldsCount;++$j){
	    	echo "<td><span style='font-size: 9pt; font-family: 新細明體'> ".$row[$j]." </span></td>";
	    }
	    $i++;
	    echo "</tr>";
		  	echo "</a>";
	  }
    echo "</table>";
    echo "</form>";
  }
  else{
      echo "<table border=0 cellspacing='0' cellpadding='2' style='border-collapse: collapse' width='100%'>";
      echo "<tr><td width='85%' align='center' style='color:#ff0000'>** 沒有符合條件的資料 **</td>";
      if($AddLink != "")
         echo "<td align='right'><span style='font-size: 9pt; font-family: 新細明體'><img border='0' src='../images/DIR_tri.gif' align='absmiddle'> <a href='" . $AddLink . "' target='main'>新增資料</a></span></td>";  
      echo "</table>";
 	}
}
function FileUpLoad($FilePath,$FName,$file){
	if(is_uploaded_file($file['tmp_name'])){
		$File_Extension = explode(".", $file['name']);
		$File_Extension = $File_Extension[count($File_Extension)-1];
		move_uploaded_file($file["tmp_name"],$FilePath.$FName.".".$File_Extension);
		return $FName.".".$File_Extension;
	}
}
/*
function FileUpLoad($FilePath,$FName,$Fsize,$objUpload){
	
  set objUpload = Server.CreateObject("Dundas.Upload")
	objUpload.MaxUploadSize = 10485760
	objUpload.UseUniqueNames = True
	objUpload.UseVirtualDir = True
	Set objNextFile = objUpload.GetNextFile()
    objNextFile.Save(FilePath)
    FName = objNextFile.Filename
    For Each objUploadedFile in objUpload.Files  
	   FSize = objUploadedFile.Size 
    Next
}
*/
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
function radioFun($data,$data1){
	if($data == $data1)
		return "checked";
}
function SaveButton(){
    echo "<input type='button' id='save' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg' onclick='save_OnClick();' value='存檔'>";
    echo "<input type='button' id='cancel' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg' onclick='cancel_OnClick();' value='上一頁'>";
}
function EditButton(){
    echo "<input type='button' id='update' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg' onclick='update_OnClick();' value='修改'>";
    echo "<input type='button' id='delete' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg' onclick='delete_OnClick();' value='刪除'>";
    echo "<input type='button' id='query' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg' onclick='query_OnClick();' value='查詢'>";
    echo "<input type='button' id='cancel' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg' onclick='cancel_OnClick();' value='上一頁'>";

}

function Edit2Button(){
    echo "<input type='button' id='update' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg' value='修改' onclick='report_OnClick();'>";
    echo "<input type='button' id='query' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg' value='查詢' onclick='report_OnClick();'>";
    echo "<input type='button' id='cancel' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg' value='上一頁' onclick='report_OnClick();'>";
}

function QueryButton(){
    echo "<input type='button' id='query' style='position:relative;left:20;width:45;height:40;font-size:9pt' value='查詢' onclick='report_OnClick();'>";
    echo "<input type='button' id='cancel' style='position:relative;left:30;width:45;height:40;font-size:9pt' value='上一頁' onclick='report_OnClick();'>";
}

function ReportButton(){
    echo "<input type='button' id='report' style='position:relative;left:0;width:75;height:25;font-size:9pt' class='button3-bg' value='報表' onclick='report_OnClick();'>";
    echo "<input type='button' id='export' style='position:relative;left:0;width:90;height:25;font-size:9pt' class='button3-bg' value='匯出資料' onclick='report_OnClick();'>";
}

function Report2Button(){
    echo "<input type='button' id='report' style='position:relative;left:20;width:45;height:40;font-size:9pt' class='font9' value='報表' onclick='report_OnClick();'>";
    echo "<input type='button' id='help' style='position:relative;left:30;width:45;height:40;font-size:9pt' class='font9' value='說明' onclick='help_OnClick();'>";
}
function Message(){
    if($_SESSION["errnumber"]==0)
       echo "<center>".$_SESSION["msg"]."</center>";
    else{
       echo "<script> alert('" .$_SESSION["msg"]."')";
       echo "</script>";
    }
    $_SESSION["msg"]="";
    $_SESSION["errnumber"]=0;
}
?>

<SCRIPT language JavaScript>
document.oncontextmenu = function(){
window.event.returnValue=false; //將滑鼠右鍵事件取消
}
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

//-->
</SCRIPT>