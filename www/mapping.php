<?
$mapping = array( 
	"id([0-9]+)" 	=> "users/profile/\\1",
	"boyko" 		=> "users/profile/17",
	'contacts'		=> "pages/error",
	/*
	"lectures" 		=> "pages/dontexist",
	"tips" 			=> "pages/dontexist",
	"groups" 		=> "pages/dontexist",
	"analytics" 	=> "pages/dontexist",
	"careers" 		=> "pages/dontexist",
	"about" 		=> "pages/dontexist",
	"privacy" 		=> "pages/dontexist",
	*/
	"users/pages" 	=> "users/lectures",
	"feed" 			=> "users/alerts" ,
	"messages"		=> "mail",
	"settings" 		=> "users/settings" ,
	"contactinfo" 	=> "users/editcontacts" ,
	"recover" 		=> "users/recover" ,
	"login" 		=>"users/login",
	"register" 		=>"users/register",
	"mysummaries"	=>"users/mysummaries",
	"mylectures" 	=> "users/mylectures",
	"myseminars" 	=> "users/seminars",
	"adm"			=> "users/admlogin",
	"followers"		=> "users/followers",
	"following"		=> "users/following",
	
	//"terms" => "pages/dontexist",
);

if(isset($_GET['q'])) {
	foreach ($mapping as $k => $v){
		$_GET['q'] = ereg_replace($k,$v,$_GET['q']);
		//echo $_GET['q'];	die();
	}
}

$cases = array(
	'tasks' => array(
		'ua' => array( 
			'def' => 'завдань',
			'1' => 'завдання',
			'2' => 'завдання',
			'3' => 'завдання',
			'4' => 'завдання',
			),
		'ru' => array( 
			'def' => 'заданий',
			'1' => 'задание',
			'2' => 'задания',
			'3' => 'задания',
			'4' => 'задания',
			),
		'en' => array(
			'def' => 'tasks',
			'1' => 'task',	
			),
	),
	
	'contacts' => array(
		'ua' => array( 
			'def' => 'контактiв',
			'1' => 'контакт',
			'2' => 'контакти',
			'3' => 'контакти',
			'4' => 'контакти',
			),
		'ru' => array( 
			'def' => 'контактов',
			'1' => 'контакт',
			'2' => 'контакта',
			'3' => 'контакта',
			'4' => 'контакта',
			),
		'en' => array(
			'def' => 'contacts',
			'1' => 'contact',	
			),
	),
	
	'lectures' => array(
		'ua' => array( 
			'def' => 'лекцій',
			'1' => 'лекція',
			'2' => 'лекції',
			'3' => 'лекції',
			'4' => 'лекції',
			),
		'ru' => array( 
			'def' => 'лекций',
			'1' => 'лекция',
			'2' => 'лекции',
			'3' => 'лекции',
			'4' => 'лекции',
			),
		'en' => array(
			'def' => 'lectures',
			'1' => 'lecture',	
			),
	),
	
	'summaries' => array(
		'ua' => array( 
			'def' => 'рефератiв',
			'1' => 'реферат',
			'2' => 'реферати',
			'3' => 'реферати',
			'4' => 'реферати',
			),
		'ru' => array( 
			'def' => 'рефератов',
			'1' => 'реферат',
			'2' => 'реферата',
			'3' => 'реферата',
			'4' => 'реферата',
			),
		'en' => array(
			'def' => 'summaries',
			'1' => 'summary',	
			),
	),
	
	'dialogs' => array(
		'ua' => array( 
			'def' => 'діалогів',
			'1' => 'діалог',
			'2' => 'діалоги',
			'3' => 'діалоги',
			'4' => 'діалоги',
			),
		'ru' => array( 
			'def' => 'диалогов',
			'1' => 'диалог',
			'2' => 'диалога',
			'3' => 'диалога',
			'4' => 'диалога',
			),
		'en' => array(
			'def' => 'dialogues',
			'1' => 'dialogue',	
			),
	),	
	
	'messages' => array(
		'ua' => array( 
			'def' => 'повідомлень',
			'1' => 'повідомлення',
			'2' => 'повідомлення',
			'3' => 'повідомлення',
			'4' => 'повідомлення',
			),
		'ru' => array( 
			'def' => 'сообщений',
			'1' => 'сообщение',
			'2' => 'сообщения',
			'3' => 'сообщения',
			'4' => 'сообщения',
			),
		'en' => array(
			'def' => 'messages',
			'1' => 'message',	
			),
	),	
		
	'seconds' => array(
		'ua' => array( 
			'def' => 'секунд',
			'1' => 'секунду',
			'2' => 'секунди',
			'3' => 'секунди',
			'4' => 'секунди',
			),
		'ru' => array( 
			'def' => 'секунд',
			'1' => 'секунду',
			'2' => 'секунды',
			'3' => 'секунды',
			'4' => 'секунды',
			),
		'en' => array(
			'def' => 'seconds',
			'1' => 'second',	
			),
	),
		
	'minutes' => array(
		'ua' => array( 
			'def' => 'хвилин',
			'1' => 'хвилину',
			'2' => 'хвилини',
			'3' => 'хвилини',
			'4' => 'хвилини',
			),
		'ru' => array( 
			'def' => 'минут',
			'1' => 'минуту',
			'2' => 'минуты',
			'3' => 'минуты',
			'4' => 'минуты',
			),
		'en' => array(
			'def' => 'minute',
			'1' => 'minutes',	
			),
	),
	
	'hours' => array(
		'ua' => array( 
			'def' => 'годин',
			'1' => 'годину',
			'2' => 'години',
			'3' => 'години',
			'4' => 'години',
			),
		'ru' => array( 
			'def' => 'часов',
			'1' => 'час',
			'2' => 'часа',
			'3' => 'часа',
			'4' => 'часа',
			),
		'en' => array(
			'def' => 'hours',
			'1' => 'hour',	
			),	
	),
	
	'disciples' => array(
		'ua' => array( 
			'def' => 'дисциплін',
			'1' => 'дисципліна',
			'2' => 'дисципліни',
			'3' => 'дисципліни',
			'4' => 'дисципліни',
			),
		'ru' => array( 
			'def' => 'дисциплин',
			'1' => 'дисциплина',
			'2' => 'дисциплини',
			'3' => 'дисциплини',
			'4' => 'дисциплини',
			),
		'en' => array(
			'def' => 'subjects',
			'1' => 'subject',	
			),
	),
	
	'courses' => array(
		'ua' => array( 
			'def' => 'курсових',
			'1' => 'курсова',
			'2' => 'курсові',
			),
		'ru' => array( 
			'def' => 'курсовых',
			'1' => 'курсовая',
			'2' => 'курсовые',
			),
		'en' => array(
			'def' => 'courseworks',
			'1' => 'coursework',	
			),		
	
	),
);

function C($label,$num=0){
	global $cases; //return true;
	if($num>20) $num = $num % 10;
	if(isset($cases[$label][getVar('lang')][$num]))
		return $cases[$label][getVar('lang')][$num];
			else return @$cases[$label][getVar('lang')]['def'];
}


?>