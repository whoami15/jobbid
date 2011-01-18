<html>
<body>
<form name="themsanpham" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	Input File: <input type="file" name="input" />
	<br/>
	<input type="submit" name="Submit" value="OK"/>
</form>
<?php
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
	if (isset($_POST['Submit'])) {
		$fName=$_FILES['input']['name'];
		$fSize= $_FILES['input']['size'];
		echo "File uploaded : <b>$fName</b> ($fSize bytes)<br/>";
		echo "Output :<br/>";
		//Begin read file input
		$fp = fopen($_FILES['input']['tmp_name'], 'r');
		$arrValue = readValues(readLine($fp, 1));
		$nEngineer = $arrValue[0];
		$nDrink = $arrValue[1];
		for($i=1;$i<=$nDrink;$i++)
			readValues(readLine($fp, 1));
		$matrixValue = array();
		for($i=0;$i<$nEngineer;$i++) {
			$arrValue = readValues(readLine($fp,1));
			array_shift($arrValue);
			array_push($matrixValue,$arrValue);
		}
		fclose($fp);
		//End read file input
		
		//Begin create matrix preference score	
		$matrixPreferenceScore = array();
		$nMean = $nEngineer/2; // nEngineer alway be even
		for($i=0;$i<$nMean;$i++) {
			$arrTotalScore = array();
			for($j=$nMean;$j<$nEngineer;$j++) {
				$totalScore = calculatePreferenceScore($matrixValue[$i],$matrixValue[$j]);
				array_push($arrTotalScore,$totalScore);
			}
			array_push($matrixPreferenceScore,$arrTotalScore);
		}
		//Print
		for($i=0;$i<$nMean;$i++) {
			for($j=0;$j<$nMean;$j++) {
				echo $matrixPreferenceScore[$i][$j];echo '	';
			}
			echo '<br>';
		}
		//End create matrix preference score	
	}
?>
</body>
</html>