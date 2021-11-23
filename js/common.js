	/*
	문자열 앞뒤에있는 공백없에기
	*/
	function strTrim( arg )
	{
	   var st = 0;
	   var len = arg.length;

	   //문자열앞에 공백문자가 들어 있는 Index 추출
	   while( (st < len) && (arg.charCodeAt(st) == 32) )
	   {
	      st++;
	   }
	   //문자열뒤에 공백문자가 들어 있는 Index 추출
	   while( (st < len) && (arg.charCodeAt(len-1) == 32) )
	   {
	      len--;
	   }
	   return ((st > 0) || (len < arg.length)) ? arg.substring(st, len) : arg;
	}	


function checkValue(obj, msg) {
	var objvalue = obj.value;
	if (objvalue == "") {
		alert(msg);
		obj.focus();
		return true; 
	} 
	return false;	
}

		