<?php

class violation extends VanillaModel {
	var $hasOne = array('account' => 'account');
}