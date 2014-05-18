<?php 
header("Content-type: text/html; charset=utf-8");
session_name("bookster");
session_start();
include('sqlconf.php');
include('functions.php');
getLang();
 if(function_exists(@$_REQUEST['do'])){	$f = $_REQUEST['do'];	DBconnect();	$f();}else{	echo "false";}?>