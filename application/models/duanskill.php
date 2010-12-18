<?php

class duanskill extends VanillaModel {
	var $hasOne = array('duan' => 'duan','skill' => 'skill');
}