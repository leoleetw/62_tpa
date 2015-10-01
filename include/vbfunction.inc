<script><!--

function ConfirmUpdate(){
	if(confirm ( "您是否確定要修改 ?")){
		form.action.value="update";
    form.submit();
	}
}

function delete_OnClick(){
	if(confirm ( "您是否確定要刪除 ?")){
		form.action.value="delete";
    form.submit();
	}
}

function Add_OnClick(){
    var Addbtn=form.AddButton.value;
    location.href=Addbtn;
}

function cancel_OnClick(){
    history.go(-1);
}

function help_OnClick(){
    var thelp=form.helpdesk.value;
    window.open("../include/helpdesk.php?help_id="+thelp,"flag","scrollbars=yes,status=no,toolbar=no,top=100,left=120,width=500,height=400");
}

function blen(xs){              //'檢測中英文夾雜字串實際長度
	var xl = xs.length;
	for( var i = 0 ; i < xs.length ; ++i)
		if(string.charCodeAt(i) < 0)
			xl++;
	return xl;
  //blen = xl
}

function GoPage_OnChange(){
    var newPage=form1.GoPage.value ;    
    document.location.href="<?php echo @$ProgID; ?>.php?nowPage=" + newPage + "&SQL=<?php echo urlencode(@$SQL);?>";
}
</script>