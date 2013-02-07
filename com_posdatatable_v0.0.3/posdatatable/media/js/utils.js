function f_scrollTop() {
	return f_filterResults (
		window.pageYOffset ? window.pageYOffset : 0,
		document.documentElement ? document.documentElement.scrollTop : 0,
		document.body ? document.body.scrollTop : 0
	);
}

function f_filterResults(n_win, n_docel, n_body) {
	var n_result = n_win ? n_win : 0;
	if (n_docel && (!n_result || (n_result > n_docel)))
		n_result = n_docel;
	return n_body && (!n_result || (n_result > n_body)) ? n_body : n_result;
}

function invertChildrenVisibility(parentName, tableNumber) {
	var rows = document.getElementById("table" + tableNumber).getElementsByTagName("tr");
	for (i = 0; i < rows.length; i++)	{
		if (rows[i].attributes.getNamedItem("name")) {
			var elementName = rows[i].attributes.getNamedItem("name").value;
			if (elementName == ("c" + parentName)) {
				var text = rows[i].getElementsByTagName("td")[0].firstChild.nodeValue;
				var controlChars = text.substr(0, 2);
				if (controlChars == "#d") {
					document.getElementById("td" + tableNumber).style.marginTop = f_scrollTop() + "px";
					document.getElementById("d" + tableNumber).firstChild.nodeValue = text.substr(2);
				} else {
					if (rows[i].style.display == '') {
						rows[i].style.display = 'none';
					} else {
						rows[i].style.display = '';
					}
				}
			} else if (elementName == ("p" + parentName)) {
				var text = rows[i].getElementsByTagName("td")[0].firstChild.nodeValue;
				var sign = text.substr(0, 1);
				if (sign == "+") {
					sign = "-";
				} else {
					sign = "+";
				}
				rows[i].getElementsByTagName("td")[0].firstChild.nodeValue = sign + text.substr(1);
			}
		}
	}
}

function verifyCalcForm(form, currency) {

	var isEur = currency == "Eur";
	var tyzdnovVMesiaci = 365 / 7 / 12;
	var cenaPiva = isEur ? 1 : 30.126;
	var cenaPalenky = isEur ? (50 / 30.126) : 50;
	var cenaCigariet = isEur ? (75 / 30.126) : 75;
	var hrubaMzda = isEur ? 307.7 : (295.5 * 30.126);

	if ((form.hrubaMzda.value == "") || (form.hrubaMzda.value < hrubaMzda)) {
	    alert( "Zadajte vašu hrubú mzdu. Musí by najmenej " + hrubaMzda + " " + currency + " (taká je od 1.1.2010 zákonom stanovená minimálna mzda na Slovensku)" );
	    form.hrubaMzda.focus();
	    return false;
	}
	
	var benzin = 0;
	var pivo = 0;
	var palenka = 0;
	var cigarety = 0;
	var televizor = 0;
	var mesacneVydaje = 0;
	var mesacneNajomne = 0;

	if (form.mesacneNajomne.value != "") {
		mesacneNajomne = form.mesacneNajomne.value;
	}
		
	if (form.benzinMesacne.value != "") {
		benzin = form.benzinMesacne.value;
	}
	
	if (form.pivoTyzdenne.value != "") {
		pivo = form.pivoTyzdenne.value;
	}
	
	if (form.palenkaTyzdenne.value != "") {
		palenka = form.palenkaTyzdenne.value;
	}
	
	if (form.cigaretyTyzdenne.value != "") {
		cigarety = form.cigaretyTyzdenne.value;
	}
	
	if (form.maTelevizor.checked) {
		televizor = isEur ? 4.64 : (4.64 * 30.126);
	}
	
	if (form.mesacneVydaje.value != "") {
		mesacneVydaje = form.mesacneVydaje.value;
	}
	
	var vydaje = 0;
	
	vydaje = parseFloat(benzin) + parseFloat(pivo * tyzdnovVMesiaci * cenaPiva)
	+ parseFloat(palenka * tyzdnovVMesiaci * cenaPalenky)
	+ parseFloat(cigarety * tyzdnovVMesiaci * cenaCigariet + televizor)
	+ parseFloat(mesacneNajomne);
	
	if (mesacneVydaje < vydaje) {
	    alert("Celkové mesaèné výdavky " + mesacneVydaje + " " + currency + " musia byt vaèšie ako " + Math.round(vydaje)
	     + " " + currency + " - súèet jednotlivých výdavkov!" );
	    form.mesacneVydaje.focus();
	    return false;
	}
	return true;
} 
