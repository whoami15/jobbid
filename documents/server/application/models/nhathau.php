<?php

class nhathau extends VanillaModel {
	var $hasOne = array('file' => 'file','account' => 'account');
}