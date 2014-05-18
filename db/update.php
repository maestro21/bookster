<?php //initialization

session_name("bookster_dev");
session_start(); 
date_default_timezone_set('Europe/Kiev');
header ('Content-type: text/html; charset=utf-8');
include('../sqlconf.php');
include("../functions.php");
include("../www/myfunctions.php");
DBconnect();
getGlobals(); 

$rundeltas = array(1);

function delta_1() {
	return array(
	"ALTER TABLE `users` CHANGE  `contacts`  `following` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;",
	"ALTER TABLE `users` ADD  `followers` TEXT;");
}

foreach ($rundeltas as $delta){
	$function = "delta_$delta";
	if(function_exists($function)) {
		$queries = $function();
		foreach ($queries as $query)
			DBquery($query);		
	}
}