<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	include(JPATH_COMPONENT . "/models/constants_ge.php");

	$gross_salary = $_POST["grossSalary"];
	$monthly_expenses = $_POST["monthlyExpenses"];
	$petrol_monthly = $_POST["petrolMonthly"];
	$cigarettes_weekly = $_POST["cigarettesWeekly"];
	$beer_weekly = $_POST["beerWeekly"];
	$wine_weekly = $_POST["wineWeekly"];
	$alcohol_weekly = $_POST["alcoholWeekly"];
	$monthly_rent = $_POST["monthlyRent"];

	function formatTime($time) {
		$hours = floor($time);
                $minutes = round(60 * ($time - $hours));
		return $hours." h ".$minutes." min" ;
	}

	function formatNumber($number) {
		return number_format($number, 0, ",", ' ');
	}

	function roundup($value, $precision = 0) {
    		return ceil($value * pow(10, $precision)) / pow(10, $precision);
	}

	function rounddown($value, $precision = 0) {
    		return floor($value * pow(10, $precision)) / pow(10, $precision);
	}

	$tax_base = $gross_salary;
	$income_tax = rounddown($tax_base*0.2 , 2);
	$excise_tax = $petrol_monthly / $average_petrol_price * $excise_tax_petrol + $cigarettes_weekly * $excise_tax_cigarettes * (365/7/12) +
		$beer_weekly * $excise_tax_beer * (365/7/12) +
		$alcohol_weekly * $excise_tax_alcohol * (365/7/12) +
		$wine_weekly * $excise_tax_wine * (365/7/12);
	$VAT = $monthly_expenses - $monthly_rent - ( $monthly_expenses - $monthly_rent) / 1.18;
	$total_taxes = $VAT + $excise_tax + $income_tax;
	$tax_wage = $total_taxes / $gross_salary;
	$net_salary = $gross_salary - $income_tax;
?>
