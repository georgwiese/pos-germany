<?php
	require_once(JPATH_COMPONENT_SITE . '/models/results/CartDao.php');

	$constants = $this->getCartDao()->getConstants();
	$workingPersonCount = $constants[CartDao::WORKING_COUNT]->value;
	$residentCount = $constants[CartDao::RESIDENT_COUNT]->value;
	$currentStateInEur = $constants[CartDao::TOTAL_EXPEDITURES]->value;
	$currentPerCaptivaTax = number_format($constants[CartDao::PER_CAPTIVA_TAX]->value, 0, ',', ' ');;
	$yourState = $this->getSum()/1000;
	$yourStateRounded = round($this->getSum()/1000, 2);
	$perCaptivaTax = number_format(round(($yourState * 1000000000) / $residentCount, 0), 0, ',', ' ');
	$cheaperThan = round(($currentStateInEur - ($yourState * 1000000000)) / 1000000000, 2);
	$cheaperThanRounded = abs(round($currentStateInEur - ($yourState * 1000000000), 0));
	$savePerResident = number_format(round(($cheaperThanRounded / $residentCount) - 0.5, 0), 0, ',', ' ');
	$savePerWorking = number_format(round(($cheaperThanRounded / $workingPersonCount) - 0.8, 0), 0, ',', ' ');
	$currentState = round(($currentStateInEur / 1000000), 2);
?>