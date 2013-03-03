function verifyCalcForm(form) {

	var isEur = true;
	var tyzdnovVMesiaci = 365 / 7 / 12;
	var cenaPiva = 1;
	var cenaPalenky = (50 / 30.126);
	var cenaCigariet = (75 / 30.126);
	var hrubaMzda = 327.2;

	if ((form.hrubaMzda.value == "") || (form.hrubaMzda.value < hrubaMzda)) {
	    alert( "Zadajte va�u hrub� mzdu. Mus� by� najmenej " + hrubaMzda + " Eur (tak� je od 1.1.2012 z�konom stanoven� minim�lna mzda na Slovensku)" );
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
		televizor = 4.64 ;
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
	    alert("Celkov� mesa�n� v�davky " + mesacneVydaje + " Eur musia byt va�ie ako " + Math.round(vydaje)
	     + " Eur - s��et jednotliv�ch v�davkov!" );
	    form.mesacneVydaje.focus();
	    return false;
	}
	return true;
} 
