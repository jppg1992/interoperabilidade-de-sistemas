<?php

	function validaCpf ( $entrada ) {
		if (strlen($entrada) != 11) {
			return false;
		}

		if (is_numeric($entrada) == false){
			return false;
		}

		$soma = 0;
		for ($i = 0;$i < 9;$i++){
			$n = $entrada[$i]; // número
			$m = 10 - $i; // multiplicador
			$soma += ($n*$m);
		}

		$resto = $soma%11;
		$dv = 11 - $resto;

		if ($dv>9){
			$dv = 0;
		}

		if ($entrada[9] != $dv){
			return false;
		}


		$soma = 0;
		for ($i = 0;$i < 10;$i++){
			$n = $entrada[$i]; // número
			$m = 
			 11- $i; // multiplicador
			$soma += ($n*$m);
		}

		$resto = $soma%11;
		$dv = 11 - $resto;

		if ($dv>9){
			$dv = 0;
		}

		if ($entrada[10] != $dv){
			return false;
		}


		return true;
	}

	function validaCnpj($entrada){

		if (strlen($entrada) != 14) {
			return false;
		}
		if (!is_numeric($entrada)){
			return false;
		}

		$verifi = "543298765432";

		$soma = 0;
		for($i = 0; $i <strlen($verifi); $i++){

			$c = $verifi[$i];
			$n = $entrada[$i];
			$m = $n * $c;
			$soma += $m;
		}

		$resto = $soma%11;

		$dv1 = 11 - $resto;

		if ($dv1 > 9){
			$dv1 = 0;
		}

		if ($entrada[12]!=$dv1){
			return false;
		}

		$verifi = "6543298765432";

		$soma = 0;
	 
		for($i = 0; $i <strlen($verifi); $i++){

			$c = $verifi[$i];
			$n = $entrada[$i];
			$m = $n * $c;
			$soma += $m;
		}

		$resto = $soma%11;

		$dv1 = 11 - $resto;

		if ($dv1 > 9){
			$dv1 = 0;
		}


		if ($entrada[13]!=$dv1){
			return false;
		}

		return true;

	}


