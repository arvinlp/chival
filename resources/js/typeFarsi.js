
var FarsiType = {
	// Farsi keyboard map based on Iran Popular Keyboard Layout
	farsiKey: {
		"۱":"1",
		"۲":"2",
		"۳":"3",
		"۴":"4",
		"۵":"5",
		"۶":"6",
		"۷":"7",
		"۸":"8",
		"۹":"9",
		"۰":"0",
		"-":"-",
		"=":"=",
	},
	Type: true,
	counter: 0,
	ShowChangeLangButton: 0,	// 0: Hidden / 1: Visible
	KeyBoardError: 1,			// 0: Disable FarsiType / 1: Show Error
	ChangeDir: 0,			// 0: No Action / 1: Do Rtl-Ltr / 2: Rtl-Ltr button
	UnSupportedAction: 1		//0: Disable FarsiType / 1: Low Support
}
FarsiType.init = function() {

	var Inputs = document.getElementsByTagName('INPUT');
	for (var i=0; i<Inputs.length; i++) {
		if (Inputs[i].type.toLowerCase() == 'text' && (Inputs[i].lang.toLowerCase() == 'fa' || Inputs[i].lang.toLowerCase() == 'fa-ir')) {
			FarsiType.counter++;
			new FarsiType.KeyObject(Inputs[i], FarsiType.counter);
		}
	}

	var Areas = document.getElementsByTagName('TEXTAREA');
	for (var i=0; i<Areas.length; i++) {
		if (Areas[i].lang.toLowerCase() == 'fa' || Areas[i].lang.toLowerCase() == 'fa-ir') {
			FarsiType.counter++;
			new FarsiType.KeyObject(Areas[i], FarsiType.counter);
		}
	}
	
}

FarsiType.KeyObject = function(z,x) {
	Convert = function(e) {

		if (e == null)
			e = window.event;

		var key = e.which || e.charCode || e.keyCode;
		var eElement = e.target || e.originalTarget || e.srcElement;

		if (e.ctrlKey && key == 32) {
			ChangeLang(e, z);
		}

		if (FarsiType.Type) {
			console.error("hooooy")
			// If Farsi
			if (FarsiType.Type && z.farsi) {
				eElement.value = eElement.value.replace(/[۰۱۲۳۴۵۶۷۸۹]/g, function(match){
					return map[match]
				})
			}
		}
		return true;
	}
}

if (window.attachEvent) {
	window.attachEvent('onload', FarsiType.init)
} else if (window.addEventListener) {
	window.addEventListener('load', FarsiType.init, false)
}