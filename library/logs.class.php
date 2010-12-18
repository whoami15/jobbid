<?php
class Logs {

	function write($log) {
		$fileName = ROOT.DS.'tmp'.DS.'logs'.DS.'logs.txt';
		$handle = fopen($fileName, 'a');
		fwrite($handle, serialize($log));
		fclose($handle);
	}

}