<?php
class Validate {
	function Validate() {
	}
	function check_submit($type=1,$arr) {
		if($type==1) { //Post
			foreach($arr as $e)
				if(isset($_POST[$e])==false)
					return false;
		} else {  //get
			foreach($arr as $e)
				if(isset($_GET[$e])==false)
					return false;
		}
		return true;
	}
	function check_null($arr) {
		foreach($arr as $e)
			if($e==null)
				return false;
		return true;
	}
	function check_length($val=null,$len=0) {
		if($val == null)
			return false;
		if(isset($val[$len]))
			return true;
		return false;
	}
	function check_date($date) {
		//die($date);
		if(empty($date))
			return false;
		list($d, $m, $y) = explode('/', $date);
		if(is_numeric($d) == false)
			return false;
		if(is_numeric($m) == false)
			return false;
		if(is_numeric($y) == false)
			return false;
		if(checkdate($m, $d, $y)) {    //Validate Gregorian date
			return true;
		} 
		return false;
	}
	function check_email($email){
		if($email == null)
			return false;
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
	function check_number($num){
		if($num == null)
			return false;
		if(is_numeric($num))
			return true;
		return false;
	}
}