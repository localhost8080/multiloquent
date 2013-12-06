
function ieVersion() {
  var rv = -1;
  if (navigator.appName == 'Microsoft Internet Explorer') {
    var ua = navigator.userAgent;
    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
    if (re.exec(ua) != null)
      rv = parseFloat( RegExp.$1 );
  }
  return rv;
}
var version = ieVersion();

if ((navigator.appName=="Microsoft Internet Explorer") && (version < 7) && readCookie('end6Off') != '1') {
	makeWindow(); 
}


function closeLayer(theobject,makeCook) {
	var makeCook = makeCook;
	document.getElementById(theobject).style.display="none";
	if (makeCook > '0') {
		createCookie('end6Off',1,14400);
	}
}


function createCookie(name,value,minutes) {
	var minutes = minutes;
	if (minutes) {
		var date = new Date();
		date.setTime(date.getTime()+(minutes*60*1000));
		var expires = "; expires="+date.toGMTString();
	} else {
		var expires = "";
	}
	document.cookie = name+"="+value+expires+"; path=/";
}


function readCookie(the_name) {
	var nameEQ = the_name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}



function makeWindow() {

	bit = '<div id="bigWindow" style="position:absolute;height:1000px;width:100%;background-color:#000000;opacity:0.95;filter:alpha(opacity=95);z-index:990;top:0px;left:0px;"></div>';
	bit += '<div id="iWindow" style="position:relative;width:900px;margin:0px auto;z-index:1000;color:#000000;">';
	bit += '<div style="position:absolute;top:100px;left:250px;width:400px;height:320px;padding:10px;background-color:#ffffff;border:5px solid #cccccc;font-size:14px;">';
	bit += '<div style="text-align:center;">';
	//bit += '<b>ACK!!!</b><br />It appears that you are using<br /><b>Internet Explorer 6</b>!!!';
	//bit += '<br />&nbsp;<br />This browser is full of security problems and is very unsafe to use.<br />&nbsp;<br />';
	//bit += 'It is highly recommended that you upgrade to:<br /><a href="http://www.mozilla.com" title="Firefox" target="_blank">Firefox</a>, ';
	//bit += '<a href="http://www.opera.com" title="Opera" target="_blank">Opera</a>, <a href="http://www.apple.com/safari/" title="Safari" target="_blank">Safari</a>, ';
	//bit += '<a href="http://www.google.com/chrome" title="Chome" target="_blank">Chrome</a>, or ';
	//bit += '<a href="http://www.microsoft.com/windows/internet-explorer/default.aspx" title="Internet Explorer 8" target="_blank">Explorer 8</a>';
	//bit += '.<br />&nbsp;<br />These are all free, much better browsers, and take only a couple of minutes to install.<br />&nbsp;<br />';
	//bit += 'Learn more at <a href="http://www.end6.org/" title="End6!" target="_blank">End6!</a>.<br />&nbsp;<br />&nbsp;<br />';
	//bit += '<a href="#" onclick="closeLayer(\'iWindow\',\'1\');closeLayer(\'bigWindow\',\'1\');return false;" style="font-size:10px;">Close this annoying window</a>';
	bit += '<img src="/wp-content/themes/jonathansblog/images/ie6.jpg" width="400" height="320" alt=""/>';
	bit += '</div>'
	bit += '</div>';
	bit += '</div>';
	
	
	document.write(bit);
	
}