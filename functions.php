<?php
/** DATABASE FUNCTIONS **/
function DBconnect()
{
	$link = mysql_connect(HOST_SERVER, HOST_NAME , HOST_PASS) or die('cannot connect to server');
	define('HOST_LINK',$link);
	mysql_select_db(HOST_DB,$link) or die('cannot connect to database');
	mysql_query("SET CHARACTER SET 'UTF8'");
}

function DBsrvconnect()
{
	$link = mysql_connect(HOST_SERVER, HOST_NAME , HOST_PASS) or die('cannot connect to server');
	define('HOST_LINK',$link);
	mysql_query("SET CHARACTER SET 'UTF8'");
}

function DBquery($sql, $echo = false)
{
	if($echo) echo $sql;
	$debug = TRUE;
	$res = '';
	if($sql !='')
	$res = mysql_query($sql,HOST_LINK) or ( $debug ? die(mysql_error() . ' '.$sql) : redirect(BASE_PATH.'404.htm') );
	return $res;	
}

function striprow($bak = array()){
	if(!empty($bak))
		foreach ($bak as $k=>$v){
			$bak[$k] = stripslashes($v);
		}
		
	return $bak;
}

function DBrow($sql, $echo = false)
{
	$res = DBquery($sql, $echo); //echo $sql;
	if($res){
		$bak = mysql_fetch_assoc($res);
		striprow($bak);
		mysql_free_result($res);
		return $bak;
	}else return false;	
}

function DBcol($sql, $echo = false)
{	
	$bak = Array();
	$res = DBquery($sql, $echo);
	if($res){
		while ($row =mysql_fetch_row($res)) $bak[] = stripslashes($row[0]);	
		mysql_free_result($res);	
		return $bak;	
	}else return false;
}

function DBall($sql, $echo = false)
{
	$bak = Array();
	$res = DBquery($sql, $echo);
	//print_r($res);
	if($res){
		while ($row = @mysql_fetch_assoc($res)) $bak[] = striprow($row);
		@mysql_free_result($res);	
		//print_r($bak);
		return $bak;
	}else
		return false;
}

function DBfield($sql, $echo = false)
{
	$res = DBquery($sql, $echo);
	if($res){
		$bak = stripslashes(@mysql_result($res,0));	
		@mysql_free_result($res);	
		return $bak;
	}else	
		return false;
}

function DBcell($sql, $echo = false){
	return DBfield($sql, $echo); }

function DBnumrows($sql, $echo = false) //select
{
	$res = DBquery($sql, $echo);
	if($res){
		$bak = mysql_num_rows($res);	
		mysql_free_result($res);
		return $bak;
	}else
		return false;
}

function DBinsertId(){
	return mysql_insert_id();
}

function DBaffrows($sql, $echo = false) //insert update delete
{
	$res = DBquery($sql, $echo);
	if($res){
		$bak = mysql_affected_rows(DBquery($sql));
		mysql_free_result($res);
		return $bak;
	}else
		return false;
}

function DBfields($sql){ //returns fields
	$return = Array();
	$query = DBquery($sql, $echo);
	$field = mysql_num_fields( $query );   
	for ( $i = 0; $i < $field; $i++ ) {   
		$f = mysql_field_name( $query, $i );   
		$return[$f]=$f;
	}
	//inspect($return);
	/*$res = DBrow($sql);
	
	foreach ($res as $k=>$v){
		$return[]=$k;
	} */
	return $return;
}

/** DEBUG FUNCTIONS **/

function debug($text=''){
	$info = debug_backtrace();
	//inspect($info);
	$info = $info[0];
	//inspect($info);
	$text = "File ".$info['file'] . "->class ".$info['type']."->function ".$info['function']."->line ".$info['line']."->data => (\n "
	.print_r($text,1);
	if(file_exists(LOGFILE)){
		$f = fopen(LOGFILE,"a+");
		fwrite($f,$text . "\n)\n\r");
		fclose($f);
	}	
}

/** TEMPLATE FUNCTIONS **/

function otpl($class,$method,$vars=array()){
	global $_CLASSES;
    if($_CLASSES[$class]==null){
		if(file_exists("tpl/$class.php"))
			require_once("tpl/$class.php");

		$_CLASSES[$class] = new $class(); 
	}
	ob_start();
	call_user_func_array(array($_CLASSES['tpl_'.$class], $method), $vars);
	$tpl = ob_get_contents(); 
	ob_end_clean(); 
	return $tpl;
}

function globalize($vars){
	foreach ($vars as $k =>$v){  // ïðîõîäèìñÿ ïî âñåì ýëåìåíòàì ìàññèâà
		global $$k;
		if(!is_array($v))
			$$k=html_entity_decode(stripslashes($v)); 
		else
			$$k=$v;
	}
}


function stpl($_TPL,$vars=array()){ //simple template - include direct file

	foreach ($vars as $k =>$v){  // ïðîõîäèìñÿ ïî âñåì ýëåìåíòàì ìàññèâà
		if(!is_array($v))
			$$k=html_entity_decode(stripslashes($v)); 
		else
			$$k=$v;
	}
	ob_start(); // íà÷èíàåì âûâîä â áóôåð	
	include($_TPL); // ïîäêëþ÷àåì òåìïëåéò
	$tpl = ob_get_contents(); // áåðåì ñîäåðæèìîå
	ob_end_clean(); // î÷èùàåì áóôåð
	return $tpl;	
}

function tpl($_TPL,$vars=array(),$adminmode=false){
	//inspect($vars);
	foreach ($vars as $k =>$v){  
		if(!is_array($v))
			$$k=html_entity_decode(stripslashes($v)); 
		else
			$$k=$v;
	}

	ob_start(); 
	include("tpl/$_TPL.tpl.php"); //
	$tpl = ob_get_contents(); // 

	ob_end_clean(); // 
	return $tpl;	
}

/** FORMAT FUNCTIONS **/ 

function parseString($string){
	return addslashes(htmlspecialchars(trim($string)));
}

function inspect($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function replace($matches){
	print_r($matches);
}

function getGet($label,$defval = ''){
	global $_GET;
	return (isset($_GET[$label])?$_GET[$label]:$defval);
}

function getPost($label,$defval = ''){
	global $_POST;
	return (isset($_POST[$label])?$_POST[$label]:$defval);
}

function getAll($label,$defval = ''){
	global $_REQUEST;
	return (isset($_REQUEST[$label])?$_REQUEST[$label]:$defval);
}

function insertSQL($data=array()){
	$return = '';
	
}

function updateSQL($data,$cond){
	$return = '';
}

 /** COOKIE **/
function getVal($label,$defval = ''){
	global $_COOKIE; //inspect($_COOKIE);
	return (isset($_COOKIE[$label])?$_COOKIE[$label]:$defval);
}
 
function setVal($label,$val){
	global $_COOKIE;
	setcookie($label,$val, time() + 31449600, '/');
	//inspect($_COOKIE);
}

function unsetVal($label){
	setCookie($label, "", time() - 3600, '/');
}

function checkVal($label){
	global $_COOKIE;
	return isset($_COOKIE[$label]);
}

 
 /** SESSION **/
 
 
  
function getVar($label,$defval = ''){
	global $_SESSION;
	return (isset($_SESSION[$label])?$_SESSION[$label]:$defval);
}

function setVar($label,$val){
	global $_SESSION; //echo $val;
	if($label == 'sem_term'){ unset($_SESSION['sem_spec']); unset($_SESSION['sem_sem']);}
	if($label == 'sem_spec'){ unset($_SESSION['sem_sem']);}
	$_SESSION[$label] = $val;
}

function unsetVar($label){
	global $_SESSION;
	unset($_SESSION[$label]);
}

function checkVar($label){
	global $_SESSION;
	return isset($_SESSION[$label]);
}

function debugVar($label){
	global $_SESSION;
	debug($_SESSION[$label]);
}




/*** FILTERS **/
function setFilter(){
	setVar(getAll('filter'),getAll('value'));
	unset($_GET['filter']);	
	goBack();
} 

function getLang(){
	global $labels, $_LANG;	
	if(getVar('lang')=='') setVar('lang',G('deflang','ua'));
	$tmp = file(PUB."lang/".getVar('lang',G('deflang','ua')).".txt"); // print_r($tmp);
	foreach($tmp as $s){
		$_s = split("=",$s); $label = $_s[0]; unset($_s[0]); $text = join("=",$_s);
		$labels[trim($label)] = trim($text);
	}
	$_LANG = $labels;
	//inspect($labels);
	/*if(!file_exists("lang/".getVar('lang').".php")) setVar('lang','ru');
	include("lang/".getVar('lang').".php");*/
}

function getFilterState($class,$field){
	$f = split("_",getVar('sort_'.$class));
	if($f[0] == $field){
		switch ($f[1]){
			case 'NONE': return 'ASC'; break;
			case 'ASC': return 'DESC'; break;
			case 'DESC': return 'NONE'; break;		
		}	
	}
	return 'ASC';
}

function filterImg($class,$field){
	$f = split("_",getVar('sort_'.$class));
	if($f[0] == $field){
		switch ($f[1]){
			case 'ASC': echo "&uArr;"; break;
			case 'DESC': echo "&dArr;"; break;		
		}	
	}
}


/** URL fuctions  **/

function redirect($to,$time=0,$die=1){
	$to = str_replace('#','',$to);
	echo "<html><body><script>setTimeout(\"location.href='$to'\", {$time}000);</script></body></html>"; if($die) die();
}	

function goBack(){ // echo $_SERVER['HTTP_REFERER'];
	redirect($_SERVER['HTTP_REFERER']);
	//echo "<html><body><script>window.location='".$_SERVER['HTTP_REFERER']."'</script></body></html>";
}


/*** MISC ***/


function doLogin(){
	$sql = "SELECT * from users where login='".getPost('login')."' AND pass=md5('".getPost('pass')."')"; 
	//inspect($sql); die();
	if (DBnumrows($sql)>0){
		$user = DBrow($sql);
		$user['logged'] = 1;
		setVar('admin',$user);		
	}
	goBack();
}

function doLogout(){
	global $_SESSION;
	$_SESSION = null;
	//print_r($_SESSION); die();
	//debug(getVar('user'));
}

function T($text=''){
	global $_LANG;
	return (@$_LANG[$text]!=''?$_LANG[$text]:$text);
}



function fDate($date){
	$dat = split(" ",$date);
	$time = split(":",$dat[1]);
	$date = split("-",$dat[0]);
	
	return (int)$date[2]." ".T('mon_'.(int)$date[1]);//"<i>".$date[2]." ".T('mon_'.(int)$date[1])." " .$date[0].", ".(int)$time[0].":".$time[1]."</i>";
}

function getGlobals(){
	global $_GLOBALS;
	$res = DBAll("SELECT * FROM globals");
	$rez = DBAll("SELECT * FROM globals_values");
	foreach ($res as $row){
		$_GLOBALS[$row['name']] = $row['value'];
	}
}

function G($text,$alt=''){
	global $_GLOBALS;
	return (isset($_GLOBALS[$text])?$_GLOBALS[$text]:$alt);
}


function reglogin(){
	//print_r($_POST);
	global $_SESSION;
	if(isset($_COOKIE['mail'])){
		$sql ="SELECT * FROM users where mail='{$_COOKIE['mail']}'"; //echo $sql;
		$res = DBrow($sql); //inspect($res);
		if($res !=''){
			$_SESSION['user'] = $res; //inspect($_SESSION);
			return true;
		}
	}
	//echo "1";
	
	if(isset($_POST['data']['formMode'])){
		$data = $_POST['data'];	
		switch (@$data['formMode']){
			
			case 1: //login
					$sql = "SELECT * from users WHERE mail='{$data['mail']}' 
							AND pass=md5('".$data['pass']."')";
					if (DBnumrows($sql)==0)			
						echo 'falseLogin';
					else{
						$res = DBrow($sql);
						$_SESSION['user'] = $res;
						setCookie('mail',$res['mail'],time()+999999);
						echo 'loginOk';
					}	
			break;
			
			case 2 : //register
			//echo "2";
				$sql = "SELECT * from users WHERE mail='".$data['mail']."'";
					//echo $sql; echo DBnumrows($sql);
					if (DBnumrows($sql)>0)
						echo 'falseReg';
					else{
							//echo "3";
						$sql = "INSERT into users SET
							mail='{$data['mail']}',
							pass=md5('{$data['pass']}'),
							name='{$data['name']}',
							surname='{$data['surname']}'"; //echo $sql;
						DBquery($sql);
						$_SESSION['user'] = $data; //echo $data['mail'].' ';
						setCookie('mail',$data['mail'],time()+999999); //echo $_COOKIE['mail'];
						echo 'regOk';
					}
			break;
			
			case 3 : //recover
				$sql = "SELECT 1 from users WHERE mail='".$data['mail']."'";
				if (DBnumrows($sql)==0) echo 'falseMail';
				else{
					$pass = genPass($_POST['email']);
					mail($_POST['email'],T('new_pass'), T('pass_rec_message').$pass,'From: webmaster@example.com');
				}
			break;
		}
	}
}

function CheckLogged(){

	$uid = getVal('uid');
	if(isset($uid)){
		$sql ="SELECT * FROM users where id='$uid'";
		$res = DBrow($sql); 
		if($res !='') setVar('user',$res);
	}
	$user = getVar('user');
	
	return (@$user['id']>0);
	
}

function getUid(){
	global $_SESSION;
	return (int)(@$_SESSION['user']['id']);
}

function logout(){
	global $_SESSION;
	setcookie ("mail", "", time() - 3600);
	unset($_SESSION['user']); inspect($_SESSION); redirect(BASE_PATH);
}

function IsAdmin(){
	global $_SESSION;
	return (bool)@$_SESSION['user']['isadmin'];
}

function IsSuperAdmin(){
	global $_SESSION;
	return (bool)(@$_SESSION['user']['id']==1);
}


function drawSelectById(){
	global $_REQUEST;
	drawSelById($_REQUEST['table'],$_REQUEST['idfield'],$_REQUEST['value'],$_REQUEST['id']);
}

function drawSelById($table,$idfield,$defvalue,$id){
	$sql = "SELECT * FROM $table WHERE $idfield=$id"; // echo $sql;
	$res = DBall($sql);
	echo "<option value='0'>- ".T('Not selected')." -</option>";
	foreach ($res as $v){
		echo "<option value='".$v['id']."'".($defvalue==$v['id']?' selected=SELECTED':'').">".$v['name']."</option>";
	}	
}

function loadClass($cl,$do='',$id=''){
	if(file_exists("classes/$cl.php")){
	require_once("classes/$cl.php");
		$class = new $cl();
	}else
		$class = new masterclass($do,$id);
	return $class;
}

function createthumbsml($name,$filename,$new_w,$new_h){
	$system=explode('.',$name);
	if (preg_match('/jpg|jpeg/',$system[1])){
		$src_img=imagecreatefromjpeg($name); $type = "jpg";
	}
	if (preg_match('/png/',$system[1])){
		$src_img=imagecreatefrompng($name); $type = "png";
	}
	if(preg_match('/gif/',$system[1])){
		$src_img=imagecreatefromgif($name); $type = "gif";
	}
	//size of src image
	$orig_w = imagesx($src_img);
	$orig_h = imagesy($src_img);
	

	$w_ratio = ($new_w / $orig_w); 
    $h_ratio = ($new_h / $orig_h);

        if ($w_ratio < $h_ratio ) {//landscape  - cutting width (x ) 
        //	echo "landscape";     
 	    $crop_w = ceil( $orig_h / $new_h * $new_w );
            $crop_h = $orig_h;//$new_h;
            $src_x = ceil( ( $orig_w - $crop_w ) / 2 );
            $src_y = 0;
        } elseif ($w_ratio > $h_ratio ) {//portrait  - cunnig cutting ( y ) 
     //   	echo "portrait";
            $crop_h = ceil( $orig_w / $new_w * $new_h );
            $crop_w = $orig_w; // $new_w;
            $src_x = 0;
            $src_y = ceil( ( $orig_h - $crop_h ) / 2 );
        } else {//square
      //  	echo "square";
            $crop_w = $orig_w;
            $crop_h = $new_h;
            $src_x = 0;
            $src_y = 0;
        }
   //   echo "<br>orig : x = $orig_w | y = $orig_h <br> new : x = $new_w | y = $new_h <br>";
	//echo "src_start : x = $src_x | y = $src_y <br> src_end : x = $crop_w | y = $crop_h"; //die();
        $dest_img = imagecreatetruecolor($new_w,$new_h);
        //imagecopyresampled ( new image, source image, starting new x, starting new y, starting src x, starting src y, end new x, end new y , end src x, end src y )
        imagecopyresampled($dest_img, $src_img, 0 , 0 , $src_x, $src_y, $new_w, $new_h, $crop_w, $crop_h); 
		switch($type){
			case 'jpg': imagejpeg($dest_img,$filename);  break;
			case 'gif': imagegif($dest_img,$filename);  break;
			case 'png': imagepng($dest_img,$filename); break;
		} 

		imagedestroy($dest_img); 
		imagedestroy($src_img); 
}

function createthumb($name,$filename,$new_w,$new_h){
	$system=explode('.',$name);
	if (preg_match('/jpg|jpeg/',$system[1])){
		$src_img=imagecreatefromjpeg($name); $type = "jpg";
	}
	if (preg_match('/png/',$system[1])){
		$src_img=imagecreatefrompng($name); $type = "png";
	}
	if(preg_match('/gif/',$system[1])){
		$src_img=imagecreatefromgif($name); $type = "gif";
	}
	//size of src image
	$orig_w = imagesx($src_img);
	$orig_h = imagesy($src_img);
	
	
	$w_ratio = ($new_w / $orig_w); 
    $h_ratio = ($new_h / $orig_h);
	
        if ($w_ratio < $h_ratio ) {//landscape  - take sizes (x ) 
        	//echo "landscape";     
			$crop_orig_h = $orig_h;
            $crop_h = ceil($new_w / $orig_w * $orig_h);
			$new_y =  0;
			$src_h = 0;
			$new_h=$crop_h;
        } elseif ($w_ratio > $h_ratio ) {//portrait  - cutting height( y ) 
			//echo "portrait";
            $crop_h = $new_h; // $new_w;
            $new_y = 0;
			$crop_orig_h = ceil($orig_w / $new_w * $new_h);
			$src_h = ceil( ( $orig_h - $crop_orig_h ) / 2 );
        } else {//square
      //  	echo "square";
            $crop_h = $new_h;
			$crop_orig_h = $orig_h;
			$new_y = 0;
			$src_h = 0;
        }
     // echo "<br>orig : x = $orig_w | y = $orig_h <br> new : x = $new_w | y = $new_h <br>";
	//echo "new crop by height : start = $new_y | height= $crop_h <br> src crop by height : start = $src_h | height = $crop_orig_h"; die();
        $dest_img = imagecreatetruecolor($new_w,$new_h);
		$white = imagecolorallocate($dest_img, 255, 255, 255);
		imagefilledrectangle($dest_img, 0, 0, $new_w,$new_h, $white);
        /*imagecopyresampled ( 
			new image, source image,
			starting new x, starting new y, 
			starting src x, starting src y,
			length new x, length new y , 
			length src x, length src y 
			)
        */
		imagecopyresampled(
			$dest_img, $src_img,
			0 , $new_y ,
			0, $src_h, 
			$new_w, $crop_h,
			$orig_w, $crop_orig_h
			); 
		switch($type){
			case 'jpg': imagejpeg($dest_img,$filename);  break;
			case 'gif': imagegif($dest_img,$filename);  break;
			case 'png': imagepng($dest_img,$filename); break;
		} 

		imagedestroy($dest_img); 
		imagedestroy($src_img); 
		
		//die();
}

function sendMail($to,$title,$msg){
	$to = trim($to);
	$msg = trim($msg);
	$headers = "MIME-Version: 1.0"."\r\n".
"Content-type: text/html; charset=utf-8"."\r\n".
'From: Bookster <register@bookster.com.ua>' . "\r\n" .
    'Reply-To: Bookster <register@bookster.com.ua>' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	//echo $to . ' '. $msg;
	try {
		@mail($to, $title, $msg, $headers, '-f  register@bookster.com.ua');// die();
	} catch(Exception $e) {
		return false;
	}
	/*$from  = html_entity_decode(G('mailFrom'));
	$headers = "MIME-Version: 1.0"."\r\n".
"Content-type: text/html; charset=utf-8"."\r\n".
	"From: $from\r\n" .
    "Reply-To: $from\r\n" .
	"Return-Path: $from\r\n".
	"Envelope-from: $from\r\n".
    'X-Mailer: PHP/' . phpversion();

	mail($to,$title,$subj,$headers,"-$from"); //die();*/
}

function R($d){
	$d = (int)$d;
	$r = array('','I','II','III','IV','V','VI','VII','VIII','IX','X', 'XI','XII','XIII','XIV','XV','XVI','XVII','XVIII','XIX','XX');
	return (isset($r[$d])?$r[$d]:$d);
}


function D($time){
	
	$periods = array("seconds", "minutes", "hours");
	$lengths = array("60","60","24");
	 

	$difference = time() - strtotime($time);
	
	for($j = 0; @$difference >= @$lengths[$j] && $j < count(@$lengths); $j++) {
		
		$difference /= $lengths[$j];
	}

	$difference = round($difference);
	// echo "$periods[$j] $difference |"; 
	$ret = "$difference ".C(@$periods[$j],@$difference).' '.T('ago');
	
	if($j==3){
		//echo $difference;
		if( $difference == 1){
			$ret = T('yesterday');	
		}else
			$ret = fdate($time);
	}
 
 
	return $ret ;
	
	
	/*$dat = split(" ",$time);
	$time = split(":",$dat[1]);
	$date = split("-",$dat[0]);
	
		if($j==3){
		if($difference > 24 && $difference < 48){
			$ret = T('yesterday');	
		}else
			$ret = fdate($time);
	}
	
	$now= date("Y-m-d H:i:s");
	$nowdat = split(" ",$time);
	$nowtime = split(":",$nowdat[1]);
	$nowdate = split("-",$dat[0]);
	
	if($dat[0] == $nowdat[0]){ //if date is the same we're checking hours, minutes, seconds using "ago" logic
	
	}else{
		if($time[0] ==
	}*/
}


function drawSeminarSelect(){
	$fac  = (int) getPost('fac');
	$spec = (int) getPost('spec');
	$term = (int) getPost('term');			
	echo "<option value='0'>- ".T('Not selected')." -</option>";	
	if($fac > 0){
		$sql = "SELECT * FROM seminars WHERE faculty_id = $fac";
		if($spec > 0) $sql .= " AND specialization_id = $spec";
		if($term > 0) $sql .= " AND term_id = $term";
		$res = dbAll($sql);// echo $sql; print_r($res);
		foreach ($res as $seminar){
			echo "<option value='".$seminar['id']."'".($sem==$seminar['id']?' selected=SELECTED':'').">".$seminar['name']."</option>";
		}
	}
}

function HasRights($right = '') {	
	$rights = getVar('rights'); if(isset($rights[''])) unset($rights['']);
	if(sizeof($rights) == 0) return false;
	if($right == '') return true;
	return (isset($rights[$right]));
}

function pagination($page, $pages, $href, $onclick = '', $offset = 3) {
	if($pages < 2) return '';
	
	$page 	= (int) $page;
	$pages 	= (int) $pages;	
	$offset = (int) $offset;
	$_range = 1 + $offset * 2;
	$start 	= 0;
	$end 	= 0;
	$larr 	= FALSE;
	$rarr	= FALSE;
	if ($pages <= $_range) { // pages are less than range .i.e. range = 7, pages = 6, then  1 2 [3] 4 5 6 
		$start = 1;
		$end   = $pages;
	} elseif ($page <= $offset + 1) { // we are at start, i.e. p = 4,  offset = 3, then 1 2 3 [4] 5 6 7 ->
		$start = 1;
		$end   = $_range;
		$rarr  = TRUE;
	} elseif ($page >= ($pages - $offset - 1)) { // we are at end, i.e. pages = 10,  p = 7, offset 3, then <- 4 5 6 [7] 8 9 10
		$start = $pages - $_range;
		$end   = $pages;
		$larr  = TRUE;
	} else { // we are in the middle, i.e. pages = 10, p = 5, offset = 3, then <- 2 3 4 [5] 6 7 8 ->
		$start 	= $page - $offset;
		$end 	= $page + $offset;
		$larr 	= TRUE;
		$rarr	= TRUE;
	}
	
	// generating url
	if($href == '') $href = 'javascript:void(0)';
	$url = "href=\"$href\"" . ($onclick != ''?" onclick=\"$onclick\"":"");
	
	$params = array(
		'range' 	=> range($start, $end),
		'page'		=> $page,
		'pages'		=> $pages,
		'url'		=> $url,
		'larr'		=> $larr,
		'rarr'		=> $rarr,
	);
	$html = tpl('pagination', $params);
	return $html;
} 

function saveStat() {
	global $_SERVER, $_PATH, $_SESSION;
	$vars = array(
		'time' => date('Y-m-d H:i:s',time()),
		'url'  => implode('/',$_PATH),
		'ip'   => getUserIP(),
		'uid'  => (int) @$_SESSION['user']['id'],
	);
	saveFile('analytics/'.date('Y-m').'.txt', implode(';',$vars));
	
	$moduleClass = @$_PATH[0] . '/'. @$_PATH[1];
	$params = array(
		'id'  => @$_PATH[2],
		'uid' => ($vars['uid'] == 0 ? $vars['ip'] : $vars['uid']),
	);
	switch($moduleClass) {
		case 'seminars/question':	saveConnection('seminars',  $params); break;
		case 'summaries/view':		saveConnection('summaries', $params); break;
	}
}

function saveFile($file, $data) {
	file_put_contents($file, $data . "\r\n", FILE_APPEND);
}

function saveConnection($module, $vars){
	saveFile('analytics/' . $module . '.txt', implode(';',$vars));
}

function recommend($what, $id){


}

function getUserIP()
{
	global $_SERVER;
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

?>