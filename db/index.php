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

$do = $_GET['do'];
if(function_exists($do)) $do();

function subs() {
	$sql = "SELECT * from users";
	$users = DBall($sql);
	$followers = array();
	
	foreach ($users as $user) {
		$id = $user['id'];
		if($user['following'] != '') {
			$following = explode(',',$user['following']);
			//inspect($following);
			foreach ($following as $follower){
				$followers[$follower][] = $id;
			}
		}
	}
	
	//inspect($followers);
	foreach($followers as $id => $follows) {			
		$sql  = "UPDATE users SET followers = '". implode(',', $follows) . "' WHERE id=$id";
		DBquery($sql);
	}
}