<?php

class duan extends VanillaModel {
	var $hasOne = array('linhvuc' => 'linhvuc','account' => 'account','tinh' => 'tinh','file' => 'file','nhathau' => 'nhathau','hosothau' => 'hosothau');
}