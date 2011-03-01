<?php

class comment extends VanillaModel {
	var $hasOne = array('article' => 'article','nhathau' => 'nhathau');
}