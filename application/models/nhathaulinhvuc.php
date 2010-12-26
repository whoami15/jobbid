<?php

class nhathaulinhvuc extends VanillaModel {
	var $hasOne = array('nhathau' => 'nhathau','linhvuc' => 'linhvuc');
}