<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	$hruba_mzda = $_POST["hrubaMzda"];
	$mesacne_vydaje = $_POST["mesacneVydaje"];
	$benzin_mesacne = $_POST["benzinMesacne"];
	$cigarety_tyzdenne = $_POST["cigaretyTyzdenne"];
	$pivo_tyzdenne = $_POST["pivoTyzdenne"];
	$palenka_tyzdenne = $_POST["palenkaTyzdenne"];
	$mesacne_najomne = $_POST["mesacneNajomne"];
	$televizor = isset($_POST["maTelevizor"]) ? $_POST["maTelevizor"] : 0;
	$druhyPilier = isset($_POST["maDruhyPilier"]) ? $_POST["maDruhyPilier"] : 0;

	function vypocitaj_odvody($mzda, $max_zaklad, $p_odvod, $round = 2) {
		if (($mzda < $max_zaklad) || ($max_zaklad == 0)) {
			return rounddown($mzda * $p_odvod / 100, $round);
		} else {
			return rounddown($max_zaklad * $p_odvod / 100, $round);
		}
	}

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
	// -- KONSTANTY --
	
	$priemerna_mzda = 769;         //priemerna mzda za rok 2010, doplnene 2012 02 20
	$zivotne_minimum = 189.83;	//zmena vykonana 2012 02 20
	
	// odvody [%] zamestnanec
	$starobne_poistenie_p = 4;
	$nemocenske_poistenie_p = 1.4;
	$poistenie_v_nezamestnanosti_p = 1;
	$invalidne_poistenie_p = 3;
	$urazove_poistenie_p = 0;
	$garancne_poistenie_p = 0;
	$fond_solidarity_p = 0;
	$zdravotne_poistenie_p = 4;
	$odvody_spolu_p = 13.4;
	
	// odvody [%] zamestnavatel
	$z_starobne_poistenie_p = 14;
	$z_nemocenske_poistenie_p = 1.4;
	$z_poistenie_v_nezamestnanosti_p = 1;
	$z_invalidne_poistenie_p = 3;
	$z_urazove_poistenie_p = 0.8;
	$z_garancne_poistenie_p = 0.25;
	$z_fond_solidarity_p = 4.75;
	$z_zdravotne_poistenie_p = 10;
	$z_odvody_spolu_p = 35.2;
	
	// Maximalny vymeriavaci zaklad pre jednotlive odvody 
	$mvz_starobne_poistenie = 3076; //roundup(4 * $priemerna_mzda, 2);
	$mvz_nemocenske_poistenie = 1153.50; //roundup(1.5 * $priemerna_mzda, 2);
	$mvz_poistenie_v_nezamestnanosti = 3076; //roundup(4 * $priemerna_mzda, 2);
	$mvz_invalidne_poistenie = 3076; //roundup(4 * $priemerna_mzda, 2);
	$mvz_urazove_poistenie = 0;
	$mvz_garancne_poistenie = 1153.50; //roundup(1.5 * $priemerna_mzda, 2);
	$mvz_fond_solidarity = 3076; //roundup(4 * $priemerna_mzda, 2);
	$mvz_zdravotne_poistenie = 2307; //rounddown(3 * $priemerna_mzda, 2);
	// -- VYPOCET ODVODOV --
	// zamestnanec
	$starobne_poistenie = vypocitaj_odvody($hruba_mzda, $mvz_starobne_poistenie, $starobne_poistenie_p);
	$nemocenske_poistenie = vypocitaj_odvody($hruba_mzda, $mvz_nemocenske_poistenie, $nemocenske_poistenie_p); 
	$poistenie_v_nezamestnanosti = vypocitaj_odvody($hruba_mzda, $mvz_poistenie_v_nezamestnanosti, $poistenie_v_nezamestnanosti_p);
	$invalidne_poistenie = vypocitaj_odvody($hruba_mzda, $mvz_invalidne_poistenie, $invalidne_poistenie_p);
	$urazove_poistenie = vypocitaj_odvody($hruba_mzda, $mvz_urazove_poistenie, $urazove_poistenie_p);
	$garancne_poistenie = vypocitaj_odvody($hruba_mzda, $mvz_garancne_poistenie, $garancne_poistenie_p); 
	$fond_solidarity = vypocitaj_odvody($hruba_mzda, $mvz_fond_solidarity, $fond_solidarity_p);
	$zdravotne_poistenie = vypocitaj_odvody($hruba_mzda, $mvz_zdravotne_poistenie, $zdravotne_poistenie_p, 2); 
	$odvody_spolu = $starobne_poistenie + $nemocenske_poistenie + $poistenie_v_nezamestnanosti + $invalidne_poistenie
		 + $urazove_poistenie + $garancne_poistenie + $fond_solidarity + $zdravotne_poistenie; 
	
	
	// zamestnavatel
	$z_starobne_poistenie = vypocitaj_odvody($hruba_mzda, $mvz_starobne_poistenie, $z_starobne_poistenie_p);
	$z_nemocenske_poistenie = vypocitaj_odvody($hruba_mzda, $mvz_nemocenske_poistenie, $z_nemocenske_poistenie_p); 
	$z_poistenie_v_nezamestnanosti = vypocitaj_odvody($hruba_mzda, $mvz_poistenie_v_nezamestnanosti, $z_poistenie_v_nezamestnanosti_p);
	$z_invalidne_poistenie = vypocitaj_odvody($hruba_mzda, $mvz_invalidne_poistenie, $z_invalidne_poistenie_p);
	$z_urazove_poistenie = vypocitaj_odvody($hruba_mzda, $mvz_urazove_poistenie, $z_urazove_poistenie_p);
	$z_garancne_poistenie = vypocitaj_odvody($hruba_mzda, $mvz_garancne_poistenie, $z_garancne_poistenie_p); 
	$z_fond_solidarity = vypocitaj_odvody($hruba_mzda, $mvz_fond_solidarity, $z_fond_solidarity_p);
	$z_zdravotne_poistenie = vypocitaj_odvody($hruba_mzda, $mvz_zdravotne_poistenie, $z_zdravotne_poistenie_p, 2); 
	$z_odvody_spolu = $z_starobne_poistenie + $z_nemocenske_poistenie + $z_poistenie_v_nezamestnanosti + $z_invalidne_poistenie
		 + $z_urazove_poistenie + $z_garancne_poistenie + $z_fond_solidarity + $z_zdravotne_poistenie; 
	
	$zaklad_dane = $hruba_mzda - $odvody_spolu;
	$odpocitatelna_polozka = ($zaklad_dane * 12  > $zivotne_minimum * 100) ? $zivotne_minimum * 44.2 - $zaklad_dane * 12 * 0.25
		: $zivotne_minimum * 19.2;
	$odpocitatelna_polozka = ($odpocitatelna_polozka > 0) ? $odpocitatelna_polozka : 0 ;
	$dan_z_prijmu = rounddown(($zaklad_dane - ($odpocitatelna_polozka / 12)) * 0.19 , 2);
	$dan_z_prijmu_pozitivna = ($dan_z_prijmu > 0 ) ? $dan_z_prijmu : 2;
	
	$priemer_cena_benzinu = 1.4092; // // zmena 2012 02 20
	
	$dph_benzin = $priemer_cena_benzinu - $priemer_cena_benzinu * 1.20;
	$spot_dan_benzin = 0.5145*0.4 + 0.368*0.6;
	$dane_benzin = $dph_benzin + $spot_dan_benzin;  // zda sa, ze toto nikde dalej do vypoctu nevstupuje
	
	$cena_krabicky_cigariet = 3.2; // zmena 2012 02 20
	$dph_cigarety = $cena_krabicky_cigariet - $cena_krabicky_cigariet / 1.20;
	$spot_dan_cigarety = 1.896; //+ ($cena_krabicky_cigariet * 0.23) - toto bolo za 1.896, dali sme prec 2012 02 23
	$dane_cigarety = $dph_cigarety + $spot_dan_cigarety;
	
	$spotrebna_dan = $benzin_mesacne / $priemer_cena_benzinu *$spot_dan_benzin +
		$cigarety_tyzdenne * $spot_dan_cigarety * (365/7/12) +
		$pivo_tyzdenne * 0.0896 * (365/7/12) +
		$palenka_tyzdenne * 0.216 * (365/7/12) +
		$televizor;
	$cena_prace = $hruba_mzda + $z_odvody_spolu;
	$odvody_celkovo = $odvody_spolu + $z_odvody_spolu;
	$dane_spolu = ($mesacne_vydaje - $mesacne_najomne - ($mesacne_vydaje - $mesacne_najomne) / 1.20) + $spotrebna_dan + $dan_z_prijmu_pozitivna;
        $dane_spolu_pozitivne = ($dane_spolu < 0) ? 0 : $dane_spolu;

	$dph = $mesacne_vydaje - $mesacne_najomne - ( $mesacne_vydaje - $mesacne_najomne) / 1.20;
	$zdravotne_odvody = $zdravotne_poistenie + $z_zdravotne_poistenie;
	$dochodkove_poistenie = $z_starobne_poistenie + $starobne_poistenie + $z_fond_solidarity + $fond_solidarity;
	$dsporenie = $druhyPilier * ($z_starobne_poistenie + $starobne_poistenie) / 2; // toto som pridal - s tymto sa bude ratat ak II. pilier ano, potom treba presunut tie ostatne vypocty, v ktorych sa bude ratat s $dsporenie, pod tento riadok
	$dochodkove_poistenie = $dochodkove_poistenie - $dsporenie; // important!!!!!!
	$odvody_celkovo = $odvody_celkovo - $dsporenie; // important
	$dane_a_odvody_spolu = $dane_spolu + $odvody_celkovo; // + $televizor;
	$podiel = ($odvody_celkovo + $dane_spolu) / ($hruba_mzda + $z_odvody_spolu);
	$ostatne_odvody = $z_nemocenske_poistenie + $z_poistenie_v_nezamestnanosti + $z_invalidne_poistenie + $z_urazove_poistenie + $z_garancne_poistenie
				+ $nemocenske_poistenie + $poistenie_v_nezamestnanosti + $invalidne_poistenie + $urazove_poistenie + $garancne_poistenie; 
	$cista_mzda = $hruba_mzda - $dan_z_prijmu_pozitivna - $odvody_spolu;
?>
