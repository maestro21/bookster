<?php

class users extends masterclass{

	function extend(){
	if(CheckLogged()){
		$this->defFunc = 'profile';
	}else
		$this->defFunc = 'register';
	
		$sql = "SELECT CONCAT(module,'_',function) FROM rightlist"; $list = DBcol($sql);
		foreach ($list as $val){ $this->options['rights'][$val] = $val; } 

		
		switch($this->do){
			case 'soclog1n':
			case 'login':
			case 'register':
			case 'recover':
					$this->ajax = true;
				break;
		}	
	}
	
	function register(){
		if(isset($this->post['form'])){
			if(DBcell("SELECT * from users WHERE mail='".$this->post['form']['mail']."'")){	
				echo "error"; die();
			}else{
				$data = $this->post['form'];
				$sql  = "INSERT INTO users SET ".
						"name='".addslashes(htmlspecialchars($data['name']))."',".
						"surname='".addslashes(htmlspecialchars($data['surname']))."',".
						"mail='".addslashes(htmlspecialchars($data['mail']))."',".
						"pass='".md5($data['pass'])."'";
				DBquery($sql);		
				
				sendMail($this->post['form']['mail'],T('welcometobookster'),
					tpl('email',array(
						'username'=>$this->post['form']['name'],
						'usermail' => $this->post['form']['mail'],
						'lang'=>getVar('lang',G('deflang','ua'))
						)
					   )
					);
				$this->login();
			}		
			
		}			
	}
	
	
	function soclog1n() { //die('111');
		$data = $this->post['form'] = $this->post;
		if(isset($this->post['form'])){ //echo"111";
			$sql = "SELECT * FROM users WHERE soc_type='" . $data['social_type'] . "' AND soc_id='" . $data['social_id'] . "'";

			$res = DBrow($sql);
			if($res) {
			} else {
				if($data['email'] != '' && DBrow("SELECT * from users WHERE mail='".$data['email']."'")){
					$sql = "UPDATE users SET ".
						"soc_type='" . $data['social_type'] . "',".
						"soc_id='" . $data['social_id'] . "'".
						" WHERE mail='".$data['email']."'";
					DBquery($sql);
				}else{
					$sql  = "INSERT INTO users SET ".
							"name='".addslashes(htmlspecialchars($data['name']))."',".
							"surname='".addslashes(htmlspecialchars($data['surname']))."',".
							($data['email']!=''?"mail='".addslashes(htmlspecialchars($data['email']))."',":'').
							"soc_type='" . addslashes(htmlspecialchars($data['social_type'])) . "',".
							"soc_id='" . addslashes(htmlspecialchars($data['social_id'])) . "'";
					DBquery($sql);		
					
					$id = DBinsertId();
					$filename = "up/photos/$id.jpg"; 
					$sml 	= "up/photossml/$id.jpg";
					if(file_put_contents(file_get_contents($data['img']), $filename)) {
						createthumb($filename,$filename,200,250);	
						createthumbsml($filename,$sml,50,50);
					}
					
					sendMail($this->post['form']['mail'],T('welcometobookster'),
						tpl('email',array(
							'username'=>$this->post['form']['name'],
							'usermail' => $this->post['form']['mail'],
							'lang'=>getVar('lang',G('deflang','ua'))
							)
						   )
						);
				}
				$res = DBrow("SELECT * FROM users WHERE soc_type='" . $data['social_type'] . "' AND soc_id='" . $data['social_id'] . "'");
			
			}
			$this->session['user'] = $res;			
			$data = $this->session['user'];	
			setVal('uid',  $data['id']);			
			setVar( 'edu_country', (int) $data['country'] );
			setVar( 'edu_city',    (int) $data['city_id'] );
			setVar( 'edu_uni',     (int) $data['country'] );
			setVar( 'edu_spec',    (int) $data['specialization_id'] );
			setVar( 'edu_fac',     (int) $data['faculty_id'] );
			setVar( 'edu_term',    (int) $data['term'] );
			setVar( 'rights',	array_flip(split(',', $data['rights'])));
			echo "ok";
			die();	
		}	
	}
	
	
	function all(){
		$sql = "SELECT * from users  ORDER BY id ASC";
		$this->do='list';
		$this->title = T('users');
		return DBall($sql);
	}
	
	function uni(){
		$sql = "SELECT * from users WHERE uni_id='{$this->id}' ORDER BY id ASC";
		$this->do='list';
		$this->title = DBcell("SELECT name from universities WHERE id={$this->id}");
		return DBall($sql);
	}
	
	
	function term(){
		$term = $this->search;
		$id = (int)$this->id;
		$sql = "SELECT * from users WHERE faculty_id='$id' AND term='$term'  ORDER BY id ASC";
		$this->do='list';
		$this->title = $term . ' ' . T('term');
		return DBall($sql);
	
	}
	
	function faculty(){
		$id = (int)$this->id;
		$sql = "SELECT * from users WHERE faculty_id='$id'  ORDER BY id ASC";
		$this->do='list';
		$this->title = DBcell("SELECT name from faculties WHERE id=$id");
		return DBall($sql);
	}
	
	function specialization(){
		$id = (int)$this->id;
		$sql = "SELECT * from users WHERE specialization_id='$id'  ORDER BY id ASC";
		$this->title = DBcell("SELECT name from specialization WHERE id=$id");
		$this->do='list';
		return DBall($sql);
	}
	
	function admlogin() {
		if(isset($this->post)) {
			$mail = $this->post['mail'];
			$pass = $this->post['pass'];
			$sql = "SELECT * from users WHERE mail='$mail ' 
					AND pass='".md5($pass)."'";
			if (DBnumrows($sql) > 0) {
				$res = DBrow($sql); 	
				$this->session['user'] = $res;
						
				$data = $this->session['user'];	
				setVar( 'uid', 		    (int) $data['id']);				
				setVar( 'edu_country', 	(int) $data['country'] );
				setVar( 'edu_city',    	(int) $data['city_id'] );
				setVar( 'edu_uni',     	(int) $data['country'] );
				setVar( 'edu_spec',    	(int) $data['specialization_id'] );
				setVar( 'edu_fac',     	(int) $data['faculty_id'] );
				setVar( 'edu_term',    	(int) $data['term'] );
				setVar( 'rights',	array_flip(split(',', $data['rights'])));
				
				if(!(IsAdmin() || HasRights('view development') )) {
					$this->logout();
				}				
			}	
		}	
		redirect(BASE_PATH);
	}
	
	
	function login(){
		global $_COOKIE; 
		if(isset($this->post['form'])){
			$data = $this->post['form']; 
			$sql = "SELECT * from users WHERE mail='{$data['mail']}' 
					AND pass='".md5($data['pass'])."'";
			if (DBnumrows($sql)==0){
				echo "login_error"; die();
			}else{ 
				$res = DBrow($sql);		
				$this->session['user'] = $res;
				setVal('uid',$res['id']);
				
				$data = $this->session['user'];
				setVar( 'uid', 		    (int) $data['id']);
				setVar( 'edu_country', 	(int) $data['country'] );
				setVar( 'edu_city',    	(int) $data['city_id'] );
				setVar( 'edu_uni',     	(int) $data['country'] );
				setVar( 'edu_spec',    	(int) $data['specialization_id'] );
				setVar( 'edu_fac',     	(int) $data['faculty_id'] );
				setVar( 'edu_term',    	(int) $data['term'] );
				setVar( 'rights',	array_flip(split(',', $data['rights'])));	
				echo "ok"; die();
			}			
		}
	}
	
	function logout(){
		unsetVal("uid");
		unset($this->session['user']); redirect(BASE_PATH);
	}
	
	function confirm(){
		$code = @$this->path[2];
		$sql = "SELECT 1 from users WHERE confirmcode='$code'";
			$this->do = 'msg';			
			if (DBnumrows($sql)==0){
				return array(
					'msg'=>'wrongCode',
				);
			}
			else{
				DBquery("UPDATE users SET confirmed=2 WHERE confirmcode='$code'");
				return array(
						'msg'=>'registered',
						'redirect'=> BASE_PATH
					);
			}
	}
	
	function genPass(){
		$pass = substr(md5(time()),0,rand(5,8));
		
		return $pass;
	}
	
	function recover(){
		if(isset($this->post['form'])){
			$mail = $this->post['form']['mail'];
			if($mail == '') die();
			$sql = "SELECT * from users WHERE mail='$mail'";
			$this->do = 'msg';			
			if (DBnumrows($sql)==0){
				$this->do = 'recover';
				echo 'error';
			}
			else{
				$user = DBrow($sql);
				$pass = $this->genPass();
				$sql = "UPDATE users SET pass=MD5('$pass') WHERE mail='$mail'";
				DBquery($sql);
				sendMail($mail,T('newpass'),
					tpl('emailrecover',array(
						'username' 	=> $user['name'] . ' ' . $user['surname'] ,
						'usermail' 	=> $user['mail'],
						'pass' 		=> $pass,
						'lang'		=> getVar('lang',G('deflang','ua'))
						)
					   )
					);
				echo "ok";
			}
			die();	
		}
	}
	
	function view(){
		$ret = DBrow("SELECT * FROM users WHERE id={$this->id}");
		$this->title = $ret['name'] . ' ' . $ret['surname'];
		return $ret;
	}
	
	function profile(){
		if($this->id == $this->session['user']['id']){
				$this->session['user'] = DBrow("SELECT * FROM users WHERE id={$this->id}");
				$ret = $this->session['user'];
				$this->title = $ret['name'] . ' ' . $ret['surname'];
		}else{
			if($this->id<1) 
				redirect(BASE_PATH.($this->session['user']['id']==17?'boyko':'id'.$this->session['user']['id']));
			else
				$ret = $this->view();
		}
		
		return $ret;

	}
	
	function saveme(){
		$data  = $this->post['form'];
	  	$sql = "UPDATE users SET 
			confirmed ='" . (int)$data['confirmed'] . "',
			country ='" . (int)$data['country'] . "',
			city_id ='" . (int)$data['city_id'] . "',
			uni_id ='" . (int)$data['uni_id'] . "',
			faculty_id ='" . (int)$data['faculty_id'] . "',
			specialization_id='" . (int)$data['specialization_id'] . "',
			term ='" . (int)$data['term'] . "'
			WHERE id='" . (int)$this->session['user']['id'] . "'";
		DBquery($sql);	
		setVar( 'edu_country', (int)$data['country'] );
		setVar( 'edu_city',	   (int)$data['city_id'] );
		setVar( 'edu_uni',	   (int)$data['uni_id'] );
		setVar( 'edu_spec',	   (int)$data['specialization_id'] );
		setVar( 'edu_fac',	   (int)$data['faculty_id'] );
		setVar( 'edu_term',	   (int)$data['term'] );		
		$this->session['user'] = DBrow("SELECT * FROM users WHERE id='".$this->session['user']['id']."'");
		redirect(BASE_PATH.($this->session['user']['id']==2?'boyko':'id'.$this->session['user']['id']));
	}
	
	
	function savename(){
		$sql = "UPDATE users SET 
					name ='".addslashes(htmlspecialchars($data['name']))."',
					surname ='".addslashes(htmlspecialchars($data['surname']))."'";

		$sql .= "	WHERE id='".(int)$this->session['user']['id']."'";
		DBquery($sql);
		$this->session['user'] = $this->session['user'] = DBrow("SELECT * FROM users WHERE id='".$this->session['user']['id']."'");
		redirect(BASE_PATH.'settings'); die();
	}
	
	
	function settings(){
		if(@$this->post['part']!=''){
			switch($this->post['part']){
				case 'name':
					$ret =  $this->namesave();
				break;
				
				case 'mail':
					$ret = $this->savemail();
				break;
				
				case 'pass':
					$ret =  $this->savepass();
				break;
			}	

			return $ret;

		}	
		$this->title = T('settings');
	} 
		
	function namesave(){
		$data  = $this->post['form'];
		if(mb_strlen($data['name'],'UTF-8') > 2 && mb_strlen($data['surname'],'UTF-8') > 2){ //die('111');
			$sql = "UPDATE users SET 
						name ='".addslashes(htmlspecialchars($data['name']))."',
						surname ='".addslashes(htmlspecialchars($data['surname']))."'
					 WHERE id='".(int)$this->session['user']['id']."'";
			DBquery($sql);		
			 $this->session['user'] = DBrow("SELECT * FROM users WHERE id='".$this->session['user']['id']."'");
			redirect(BASE_PATH.'settings'); die();
		}
			return array( 'nameerror' => 'emptyname');
	
	} 

	function savemail(){		
		if($this->post['newmail'] != ''){
			$checkmail = (bool)DBcell("SELECT * FROM users WHERE mail='".$this->post['newmail']."'");			
			if(!$checkmail){
				if(filter_var($this->post['newmail'], FILTER_VALIDATE_EMAIL)){
					DBquery("UPDATE users SET mail='".addslashes(htmlspecialchars($this->post['newmail']))."' WHERE id='".$this->session['user']['id']."'");
					$this->session['user'] = $this->session['user'] = DBrow("SELECT * FROM users WHERE id='".$this->session['user']['id']."'");
					redirect(BASE_PATH.'settings'); die();
				}else{
					return array( 'mailerror' => 'wrongmailformat');
				}
			}	
			return array( 'mailerror' => 'mailexists');
		}
		return array( 'mailerror' => 'emptymail');	
	} 
	
	function savepass(){
		if(trim($this->post['form']['pass']) !=''){
			$checkpass = (bool)DBcell("SELECT * FROM users WHERE mail='".$this->session['user']['mail']."' AND pass=md5('".$this->post['oldpass']."')");
			if($checkpass){
				if($this->post['form']['pass'] == $this->post['newpass']){
					DBquery("UPDATE users SET pass='".md5(trim($this->post['form']['pass']))."' WHERE id='".$this->session['user']['id']."'");
					$this->session['user'] = $this->session['user'] = DBrow("SELECT * FROM users WHERE id='".$this->session['user']['id']."'");
					redirect(BASE_PATH.'settings'); die();
				}else{
					return array( 'passerror' => 'passdontmatch');
				}
			}
			return array( 'passerror' => 'wrongpass');
		}
		return array( 'passerror' => 'emptypass');
	} 
	

	function savesetting(){ 
		$data  = $this->post['form'];
		if(trim($this->post['form']['pass']) !=''){
			$checkpass = (bool)DBcell("SELECT * FROM users WHERE mail='".$data['mail']."' AND pass=md5('".$this->post['oldpass']."')");
			if($checkpass && ($this->post['form']['pass'] == $this->post['newpass'])){
				DBquery("UPDATE users SET pass='".trim($this->post['form']['pass'])."' WHERE id='".$this->session['user']['id']."'");
			}else{
			}
		}

		if($data['mail'] == $this->session['user']['mail']){
			
			if($this->post['newmail'] != ''){
				$checkmail = (bool)DBcell("SELECT * FROM users WHERE mail='".$this->post['newmail']."'");
				if(!$checkmail){
					DBquery("UPDATE users SET mail='".addslashes(htmlspecialchars($this->post['newmail']))."' WHERE id='".$this->session['user']['id']."'");
				}else{
				}
			}else{
				}
		}else{
		}

		$sql = "UPDATE users SET 
					name ='".addslashes(htmlspecialchars($data['name']))."',
					surname ='".addslashes(htmlspecialchars($data['surname']))."'";
		$sql .= "	WHERE id='".(int)$this->session['user']['id']."'";
		DBquery($sql);
		$this->session['user'] = $this->session['user'] = DBrow("SELECT * FROM users WHERE id='".$this->session['user']['id']."'");
		goBack(); die();
	}
	
	function savecontact(){
		$data  = $this->post['form'];
		$data['vkontakte'] = str_replace('http://','',$data['vkontakte']);
		 $data['vkontakte'] = str_replace('www.','',$data['vkontakte']); 
		$sql = "UPDATE users SET 
			phone ='".addslashes(htmlspecialchars($data['phone']))."',
			skype ='".addslashes(htmlspecialchars($data['skype']))."',
			vkontakte ='".addslashes(htmlspecialchars($data['vkontakte']))."'
			WHERE id='".(int)$this->session['user']['id']."'";
		DBquery($sql);
		$this->session['user'] = $this->session['user'] = DBrow("SELECT * FROM users WHERE id='".$this->session['user']['id']."'");
		redirect(BASE_PATH.'contactinfo'); die();	
	}
	
	function upphoto(){
		if(isset($_FILES['avatar']) && strpos($_FILES['avatar']['type'],'image') !== false ){
			
			$id = $this->session['user']['id'];
			$type = str_replace('image/','',$_FILES['avatar']['type']);
			$filename = "up/photos/$id.jpg";
			$sml = "up/photossml/$id.jpg";
			if(move_uploaded_file($_FILES['avatar']['tmp_name'], $filename)) {
				createthumb($filename,$filename,200,250);	
				createthumbsml($filename,$sml,50,50);
			}			
		}	
		redirect(BASE_PATH);
	}
	
	function mysummaries(){
		$id = $this->session['user']['id'];
		$reports = DBall("SELECT r.* FROM referats r JOIN mysummaries m ON r.id=m.reportid AND m.userid=$id");
		return $reports;
	}
	
	function mylectures(){
		$id = $this->session['user']['id'];
		$lectures = DBall("SELECT l.* FROM lectures l JOIN mylectures m ON l.id=m.lectureid AND m.userid=$id");
		return $lectures;
	}
	
	function seminars(){
		$id = $this->session['user']['id'];
		$seminars = DBall("SELECT s.* FROM seminarquestions s JOIN myseminars m ON s.id=m.seminarid AND m.userid=$id");
		return $seminars;	
	}
	
	function followers(){
		if($this->id>0) {
			$id = $this->id;
			$this->title = DBcell("SELECT  CONCAT( u.name, ' ', u.surname ) FROM users u WHERE id='$id'");
		} else {
			$id = $this->session['user']['id'];				
			$this->title = $this->session['user']['name'] . ' ' . $this->session['user']['surname'];
		}	
		$contacts = array_flip(split(',',DBcell("SELECT followers FROM users WHERE id='$id'"))); unset($contacts['']);
		$contacts = join(',',array_flip($contacts)); $this->session['user']['contacts'] = $contacts;
		if($contacts !=''){
			$contacts = DBall("SELECT u.*, uni.name as university from users u LEFT JOIN universities uni ON uni.id=u.uni_id WHERE u.id IN ($contacts)");
			return $contacts;
		}else return false;
	}
	
	function following(){
		if($this->id>0) {
			$id = $this->id;
			$this->title = DBcell("SELECT  CONCAT( u.name, ' ', u.surname ) FROM users u WHERE id='$id'");
		} else {
			$id = $this->session['user']['id'];				
			$this->title = $this->session['user']['name'] . ' ' . $this->session['user']['surname'];
		}	
		$contacts = array_flip(split(',',DBcell("SELECT following FROM users WHERE id='$id'"))); unset($contacts['']);
		$contacts = join(',',array_flip($contacts)); $this->session['user']['contacts'] = $contacts;
		if($contacts !=''){
			$contacts = DBall("SELECT u.*, uni.name as university from users u LEFT JOIN universities uni ON uni.id=u.uni_id WHERE u.id IN ($contacts)");
			return $contacts;
		}else return false;
	}
	
	function addcontact(){ 
		$id = $this->id;
		$uid = $this->session['user']['id'];
		$value = date("Y-m-d H:i:s");
		$sql =  "INSERT INTO alerts SET uid=$uid, fid=$id, `time`='$value'"; DBquery($sql);
		
		$contacts = split(',',DBcell("SELECT following FROM users WHERE id='$uid'"));
		$contacts[] = $id; 
		$contacts = array_flip($contacts); unset($contacts['']);
		$contacts = join(',',array_flip($contacts)); $this->session['user']['contacts'] = $contacts;
		$sql = "UPDATE users SET following='".$contacts."' WHERE id='$uid'"; 		
		DBquery($sql);
		
		$contacts = split(',',DBcell("SELECT followers FROM users WHERE id='$id'"));
		$contacts[] = $uid; 
		$contacts = array_flip($contacts); unset($contacts['']);
		$contacts = join(',',array_flip($contacts)); $this->session['user']['contacts'] = $contacts;
		$sql = "UPDATE users SET followers='".$contacts."' WHERE id='$id'"; 		
		DBquery($sql);
		
		redirect(BASE_PATH.'following');
	}
	
	function delcontact(){
		$id = $this->id;
		$uid = $this->session['user']['id'];
		$contacts = array_flip(split(',',DBcell("SELECT following FROM users WHERE id='".$this->session['user']['id']."'")));
		unset($contacts[$id]); unset($contacts['']);
		$this->session['user']['following'] = $contacts = join(',',array_flip($contacts));
		DBquery("UPDATE users SET following='$contacts' WHERE id='".$this->session['user']['id']."'");

		$contacts = array_flip(split(',',DBcell("SELECT followers FROM users WHERE id='$id'")));
		unset($contacts[$uid]); unset($contacts['']);
		$this->session['user']['following'] = $contacts = join(',',array_flip($contacts));
		DBquery("UPDATE users SET followers='$contacts' WHERE id='$id'");
		
		redirect(BASE_PATH.'following');
	}
	
	function alerts(){
		$uid = $this->session['user']['id'];
		$value = date("Y-m-d H:i:s");
		$sql = "UPDATE users SET lastalertcheck='$value' WHERE id='$uid'";
		DBquery($sql);
		$sql = "SELECT  CONCAT( u.name, ' ', u.surname ) AS name, u.id FROM alerts a JOIN users u on u.id=a.uid WHERE fid='$uid' ORDER by `time` DESC";
		return dbAll($sql);
	}
	
	
	function saveFilters(){
		$data  = $this->post['form'];
		setVar( 'edu_country', $data['country'] );
		setVar( 'edu_city',	   $data['city_id'] );
		setVar( 'edu_uni',	   $data['uni_id'] );
		setVar( 'edu_spec',	   $data['specialization_id'] );
		setVar( 'edu_fac',	   $data['faculty_id'] );
		setVar( 'edu_term',	   $data['term'] );
		setVar( 'edu_sem',	   $data['seminar'] );
		//inspect($this->session); die();
		goBack();
	}
	
	function saverights(){ 
		$rights = join(',',$this->post['form']['rights']); 
		$sql = sprintf("UPDATE users SET rights='%s' WHERE id=%d", $rights, $this->post['id']); //die($sql);
		DBquery($sql);
		goBack();
	}
	
	function editrights(){
		$sql = sprintf("SELECT rights FROM users WHERE id=%d", $this->id);
		$rights = array_flip(split(',',DBcell($sql)));
		//inspect($rights);
		return $rights;
	}
	
	function editcontacts() { $this->title = T('settings'); }
	function education() { $this->title = T('settings'); }
	
}

?>