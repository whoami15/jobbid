<?php

class hosothau extends VanillaModel {
	var $hasOne = array('nhathau' => 'nhathau','duan' => 'duan');
}