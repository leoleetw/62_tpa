<script>

function ChkID(idno){
	if(idno.trim().length==0)
	{
		return;
	}
	var d = new Array();
	var acc = 0;
	d = idno.split("");
	switch(d[0]){
		case "A" : 
			acc=1;
			break;
    case "B" : 
    	acc=10
			break;
    case "C" :
    	acc=19
			break;
    case "D" : 
    	acc=28
			break;
    case "E" :  
    	acc=37
			break;
    case "F" :  
    	acc=46
			break;
    case "G" :  
    	acc=55
			break;
    case "H" :  
    	acc=64
			break;
    case "I" :  
    	acc=39
			break;
    case "J" :  
    	acc=73
			break;
    case "K" :  
    	acc=82
			break;
    case "L" :  
    	acc=2
			break;
    case "M" :  
    	acc=11
			break;
    case "N" :  
    	acc=20
			break;
    case "O" :  
    	acc=48
			break;
    case "P" :  
    	acc=29
			break;
    case "Q" :  
    	acc=38
			break;
    case "R" :  
    	acc=47
			break;
    case "S" :  
    	acc=56
			break;
    case "T" :  
    	acc=65
			break;
    case "U" :  
    	acc=74
			break;
    case "V" :  
    	acc=83
			break;
    case "W" :  
    	acc=21
			break;
    case "X" :  
    	acc=3
			break;
    case "Y" :  
    	acc=12
			break;
    case "Z" :  
    	acc=30
			break;
	}
	var checksum = acc+8*d[1]+7*d[2]+6*d[3]+5*d[4]+4*d[5]+3*d[6]+2*d[7]+1*d[8]+1*d[9];
  var check1 = intparse(checksum/10);
  var check2 = checksum/10;
  var check3 = (check2-check1)*10;
  if (idno.length > 10 )
    return false
  else if(err.number != 0 )
    return false
  else if(checksum==check1*10)
    return true
  else if (d[9]==(10-check3))
    return true
  else
    return false
}
/*
function ChkID(idno)	'-----身份證字號檢驗(新)
  if len(trim(idno))=0 then exit function

  alpha=UCase(left(idno,1))
  d1=mid(idno,2,1)
  d2=mid(idno,3,1)
  d3=mid(idno,4,1)
  d4=mid(idno,5,1)
  d5=mid(idno,6,1)
  d6=mid(idno,7,1)
  d7=mid(idno,8,1)
  d8=mid(idno,9,1)
  d9=mid(idno,10,1)
  select case alpha
    case "A" : acc=1
    case "B" : acc=10
    case "C" : acc=19
    case "D" : acc=28
    case "E" : acc=37
    case "F" : acc=46
    case "G" : acc=55
    case "H" : acc=64
    case "I" : acc=39
    case "J" : acc=73
    case "K" : acc=82
    case "L" : acc=2
    case "M" : acc=11
    case "N" : acc=20
    case "O" : acc=48
    case "P" : acc=29
    case "Q" : acc=38
    case "R" : acc=47
    case "S" : acc=56
    case "T" : acc=65
    case "U" : acc=74
    case "V" : acc=83
    case "W" : acc=21
    case "X" : acc=3
    case "Y" : acc=12
    case "Z" : acc=30
  end select
  on error resume next
  checksum = acc+8*d1+7*d2+6*d3+5*d4+4*d5+3*d6+2*d7+1*d8+1*d9
  check1 = Int(checksum/10)
  check2 = checksum/10
  check3 = (check2-check1)*10
  if len(idno)>10 then
    ChkID=false
  elseif err.number<>0 then
    ChkID=false
  elseif checksum=check1*10 then
    ChkID=true
  elseif d9=(10-check3) then
    ChkID=true
  else
    ChkID=false
  end if
end function
*/
</Script>