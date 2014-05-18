<?php //initialization

session_name("bookster_dev");
session_start(); 
date_default_timezone_set('Europe/Kiev');
header ('Content-type: text/html; charset=utf-8');
include('sqlconf.php');
include("functions.php");
//if(!(IsAdmin() || HasRights('view development') )) $_GET['q']='users/login';

include("myfunctions.php");
include('masterclass.php');
DBconnect();
getGlobals(); 
//processing URL
include('mapping.php'); // die();
$_PATH = split('/',@$_GET['q']); 
saveStat();
$first  = !CheckLogged() && ($_PATH[0] == ''); //(!CheckLogged() && (in_array($_PATH[0], array('index','','id'))));
if(@$_PATH[0]=='' && G('defclass')!='') $_PATH[0] = G('defclass');
$cl = $_PATH[0]; 
//inspect($_PATH);
//checking for filter
if($cl=='filter'){ 
 setVar(@$_PATH[1],@$_PATH[2]); goBack(); die(); }

//getting language variables
getLang(); 

//loading class
if(!file_exists(FILE_PATH."classes/$cl.php")){
	$cl = G('defmodule');
}

include("classes/$cl.php"); 
$class = new $cl(); 

//$logged = CheckLogged();
unsetVar('meta_keywords');
$content = $class->parse();

if($class->ajax) {
	echo $content; die();
} else {	

	if($first) {
		echo tpl('first', 
			array(
				'path' 		=> BASE_PATH,
				'content' 	=> $content,
			)
		);	
	} else { 
		echo tpl($class->maintpl, 
			array(
				'path' 		=> BASE_PATH,
				'content' 	=> $content,
				'class' 	=> $cl,
				'keywords'	=> getVar('meta_keywords',T('meta_keywords')), 
				'path'		=> $_PATH,
				'title' 	=> $class->title,
				'ad'		=> @$class->params['ad'],
			)
		);
	}

	/*
	if($logged){ 
		//displaying content for logged user
		echo tpl('index', array(
			'path' => BASE_PATH,
			'content' =>$class->parse(),
			'class' => $cl,
			'path' => $_PATH,
			'title' => $class->title,
			)
		);
	}else{ 
	//inspect($class);
		//displaying first page for not logged user
		if($_PATH[0] == 'index'){
			echo tpl('first', array(
			'path' => BASE_PATH,
			'content' =>$class->parse(),
			)
		);
		}else{
			$class->parse(); //die();
			echo tpl('login');
		}
	} 	*/
}
	
		
?>