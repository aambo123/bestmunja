function getCookieVal(offset) {
    var endstr = document.cookie.indexOf(";", offset);
    if (endstr == -1) {
        endstr = document.cookie.length;
    }
    return decodeURIComponent(document.cookie.substring(offset, endstr));
}

function GetCookie(name) {
    var arg = name + "=";
    var alen = arg.length;
    var clen = document.cookie.length;
    var i = 0;

    while (i < clen) {
        var j = i + alen;

        if (document.cookie.substring(i, j) == arg) {
            return getCookieVal(j);
        }

        i = document.cookie.indexOf(" ", i) + 1;

        if (i == 0) {
            break;
        }
    }
    return null;
}

function getDateByjQueryDateFormat(value, baseDate) {
	var today = new Date();
	if(baseDate != null && typeof(baseDate) === 'object')
		today = new Date(baseDate.getFullYear(), baseDate.getMonth(), baseDate.getDate());
	//alert("today : " + today);
	var elements = value.toString().split(' ');
	for(var x in elements) {
		var num = eval(elements[x].substr(0, elements[x].length - 1).toString());
		var flag = elements[x].substr(elements[x].length -1).toString().toLowerCase();
		if(flag == 'd')
			today.setDate(today.getDate() + num);
		else if(flag == 'm')
			today.setMonth(today.getMonth() + num);
		else if(flag == 'y')
			today.setFullYear(today.getFullYear() + num);
	}
	return today;
}
function SetCookie(name, value, domain, path, expires, secure) {
	try {
		var argv = SetCookie.arguments;
		var argc = SetCookie.arguments.length;
		document.cookie = name + "=" + encodeURIComponent(value) 
			+ ((expires == null) ? "" : ("; expires=" + expires.toGMTString())) 
			+ ((path == null) ? "; path=/" : ("; path=" + path)) 
			+ ((domain == null) ? "" : ("; domain=" + domain)) 
			+ ((secure == true) ? "; secure" : "");
	}
	catch (e) {
		alert(e.message);
		console.log(e)
	}
}