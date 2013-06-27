var ie = false;
var ns = false;
var mx;
var my;
	
if (document.all) {
	ie = true;
} else {
	ns = true;
}



function getHTTPObject() {
  var xmlhttp;
  /*@cc_on
  @if (@_jscript_version >= 5)
    try {
      xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (E) {
        xmlhttp = false;
      }
    }
  @else
  xmlhttp = false;
  @end @*/
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
    try {
      xmlhttp = new XMLHttpRequest();
    } catch (e) {
      xmlhttp = false;
    }
  }
  return xmlhttp;
}

function getMouse(evt) {

	if (ie) {
		mx = window.event.clientX;
		my = window.event.clientY;
	} else {
		mx = evt.pageX;
		my = evt.pageY;
	}	

}