<?php
	/* ***Begin process*** */
	$inputfile = $argv[1];
	$outputfile = $argv[2];
	//Begin read file input
	$fp = fopen($inputfile, 'r');
	$arrValue = readValues(readLine($fp, 1));
	$nEngineer = $arrValue[0];
	$nDrink = $arrValue[1];
	for($i=1;$i<=$nDrink;$i++)
		readValues(readLine($fp, 1));
	$matrixValue = array();
	for($i=0;$i<$nEngineer;$i++) {
		$arrValue = readValues(readLine($fp,1));
		array_push($matrixValue,$arrValue);
	}
	fclose($fp);
	//Begin create array couple preference score	
	$arrCouple = array();
	$nMean = $nEngineer/2; // nEngineer alway be even
	for($i=0;$i<$nMean;$i++) {
		for($j=$nMean;$j<$nEngineer;$j++) {
			$couple = new couple();
			$couple->engineerA = $matrixValue[$i][0];
			$couple->engineerB = $matrixValue[$j][0];
			$totalScoreAB = calculatePreferenceScore($matrixValue[$i],$matrixValue[$j]);
			$totalScoreBA = calculatePreferenceScore($matrixValue[$j],$matrixValue[$i]);
			$couple->preferenceScoreAB = $totalScoreAB;
			$couple->preferenceScoreBA = $totalScoreBA;
			array_push($arrCouple,$couple);
		}
	}
	//Sort this array
	$arrCouple = insertionSort($arrCouple);
	/* $str = '';
	for($i=0;$i<count($arrCouple);$i++)
		$str .= '['.$arrCouple[$i]->engineerA.','.$arrCouple[$i]->engineerB.'] = '.$arrCouple[$i]->preferenceScore."\n";
	echo $str; */ 
	//Push in arrCoupleOutput the couples have hight preferenceScore
	$arrCoupleOutput = array();
	$arrTmp = array(); //contain engineers's id in arrCoupleOutput
	$i = 1;
	while($i<=$nMean) {
		$couple = array_shift($arrCouple);
		if(in_array($couple->engineerA,$arrTmp) == false && in_array($couple->engineerB,$arrTmp)==false) {
			$arrCoupleOutput[$couple->engineerA] = $couple;
			array_push($arrTmp,$couple->engineerA);
			array_push($arrTmp,$couple->engineerB);
			$i++;
		}
	}
	//Print result
	$i = 0;
	$strResult = '';
	while(isset($arrCoupleOutput[$i])) {
		$couple = $arrCoupleOutput[$i];
		$strResult.=$couple->engineerA.' '.$couple->engineerB."\n";
		$i++;
		/* if(isset($arrCoupleOutput[$i]))
			$strResult.="\n"; */
	}
	if(isset($outputfile)) {
		//Write file
		$fh = fopen($outputfile, 'w');
		fwrite($fh, $strResult);
		fclose($fh);
	} else
		echo $strResult;
	//***End process***
	class couple {
		var $engineerA;
		var $engineerB;
		var $preferenceScoreAB;
		var $preferenceScoreBA;
		function couple() {
		}
	}
	function readLine($fp, $line_num, $delimiter="\n")
	{
		/*** set the counter to one ***/
		$i = 1;
		/*** loop over the file pointer ***/
		while ( !feof ( $fp) )
		{
			/*** read the line into a buffer ***/
			$buffer = stream_get_line( $fp, 1024, $delimiter );
			/*** if we are at the right line number ***/
			if( $i == $line_num )
			{
				/*** return the line that is currently in the buffer ***/
				return $buffer;
			}
			/*** increment the line counter ***/
			$i++;
			/*** clear the buffer ***/
			$buffer = '';
		}
		return false;
	}
	function readValues($str) {
		$arrValue = array();
		$i = 0;
		$str = trim($str);
		$value = '';
		$bNewValue = true;
		while(isset($str[$i])) {
			$c = $str[$i];
			if($c != ' ' && $c != ',' && $c != '	') {
				if($bNewValue == false)
					$bNewValue = true;
				$value.=$c;
			} else {
				if($bNewValue == true) {
					array_push($arrValue,$value);
					$value = '';
					$bNewValue = false;
				}
			}
			$i++;
		}
		array_push($arrValue,$value);
		return $arrValue;
	}
	function findIndex($arr,$value) {
		$i = 0;
		while(isset($arr[$i])) {
			if($arr[$i] == $value)
				return $i;
			$i++;
		}
		return -1;
	}
	function calculatePreferenceScore($Alist, $Blist) {
		array_shift($Alist);
		array_shift($Blist);
		$totalScore = 0;
		$nBaseValue = count($Alist);
		$i = 0;
		while(isset($Alist[$i])) {
			$value = $Alist[$i];
			$index = findIndex($Blist,$value);
			if($index == -1 || $index > $i) { //A like this drink more
				$totalScore += $nBaseValue;
			} else if ($index == $i) { // A and B have so much more in common
				$totalScore += ($nBaseValue*$nBaseValue);
			}
			$i++;
			$nBaseValue--;
		}
		return $totalScore;
	}
	//Insertion Sort
	function insertionSort($arr) { // sort desc
		$N = count($arr);
		for($i=0; $i < $N; $i++){ 
			$ai = $arr[$i];
			$j = $i-1;
			while(true) { 
				$aj = $arr[$j];
				if($aj->preferenceScoreAB > $ai->preferenceScoreAB || $j<0) {
					break;
				}
				if($aj->preferenceScoreAB == $ai->preferenceScoreAB) {
					if($aj->preferenceScoreBA<$ai->preferenceScoreBA)
						break;
				}
				$arr[$j+1] = $aj;
				$j--;
			}
			$arr[$j+1] = $ai;
		}
		return $arr;
	}
?>