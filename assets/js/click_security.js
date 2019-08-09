document.onkeypress = function (event) {
        event = (event || window.event);
		var F12 = event.keyCode === 123;
		var Enter = event.keyCode === 13;
		var Backspace = event.keyCode === 8;
		var cmdleft = event.keyCode === 91;
		var cmdright = event.keyCode === 93;
        if (F12||Enter||Backspace||cmdleft||cmdright) {
           //alert('1Requested command disabled');
            return false;
        }
    };
  //-------------------  
    var message = "Sorry, right-click has been disabled";

function clickIE() {
    if (document.all) {
        (message);
        return false;
    }
}

function clickNS(e) {
    if (document.layers || (document.getElementById && !document.all)) {
        if (e.which === 2 || e.which === 3) {
           // alert(message);
            return false;
        }
    }
}
if (document.layers) {
    document.captureEvents(Event.MOUSEDOWN);
    document.onmousedown = clickNS;
} else {
    document.onmouseup = clickNS;
    document.oncontextmenu = clickIE;
}
document.oncontextmenu = new Function("return false"); 

//---------------End-Right-click-disabled---------------------
document.body.addEventListener('keydown', event => {
    if (event.ctrlKey && 'cvxspwuazgtodfhjn'.indexOf(event.key) !== -1) {
      event.preventDefault()
    }
  })
 

  window.addEventListener("contextmenu", function(e) { e.preventDefault(); })  
