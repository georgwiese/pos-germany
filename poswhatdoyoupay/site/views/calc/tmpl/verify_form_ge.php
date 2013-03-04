<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	include(JPATH_COMPONENT . "/models/constants_ge.php");

	JFactory::getDocument()->addScriptDeclaration('

	function verifyCalcFormGe(form) {

		var cigarettes_pack_price  =  ' . $cigarettes_pack_price . ';
		var beer_bottle_price = ' . $beer_bottle_price . ';
		var wine_bottle_price = ' . $wine_bottle_price . ';
		var alcohol_bottle_price = ' . $alcohol_bottle_price . ' ;
		var petrol_monthly = (form.petrolMonthly.value != "") ? parseFloat(form.petrolMonthly.value) : 0;
		var cigarettes_weekly = (form.cigarettesWeekly.value != "") ? parseFloat(form.cigarettesWeekly.value) : 0;
		var alcohol_weekly = (form.alcoholWeekly.value != "") ? parseFloat(form.alcoholWeekly.value) : 0;
		var beer_weekly = (form.beerWeekly.value != "") ? parseFloat(form.beerWeekly.value) : 0;
		var wine_weekly = (form.wineWeekly.value != "") ? parseFloat(form.wineWeekly.value) : 0;
		var monthly_rent = (form.monthlyRent.value != "") ? parseFloat(form.monthlyRent.value) : 0;
		var monthly_expenses = (form.monthlyExpenses.value != "") ? parseFloat(form.monthlyExpenses.value) : 0;
		var gross_salary = (form.grossSalary.value != "") ? parseFloat(form.grossSalary.value) : 0;

		var monthly_sum_of_expenses = 0 + petrol_monthly + cigarettes_weekly * cigarettes_pack_price * (365/7/12) +
			beer_weekly * beer_bottle_price * (365/7/12) +
			alcohol_weekly * alcohol_bottle_price* (365/7/12) +
			wine_weekly * wine_bottle_price* (365/7/12) +
			monthly_rent;

		if (gross_salary <= 0) {
		 	alert("' . JText::_('COM_POSWHATDOYOUPAY_NON_ZERO_SALARY'). '");
		 	form.grossSalary.focus();
	 	    return false;
		}

		if (monthly_sum_of_expenses > monthly_expenses) {
		 	alert("' . JText::_('COM_POSWHATDOYOUPAY_SUM_OF_EXPENSES1') . ' " + Math.round(monthly_sum_of_expenses) + " ' . JText::_('COM_POSWHATDOYOUPAY_SUM_OF_EXPENSES2') . '");
		 	form.monthlyExpenses.focus();
	 	    return false;
		}
		return true;

    }
');

?>
