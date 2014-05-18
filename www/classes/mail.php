<?php

class mail extends masterclass{

	function extend(){
		$uid = $this->session['user']['id'];

	}
	
	//delete dialog
	function deldialog(){
		$from = $this->session['user']['id'];
		$to = $this->id;	
		DBquery("UPDATE mail SET delto=1 WHERE `from`=$from AND `to`=$to");
		DBquery("UPDATE mail SET delfrom=1 WHERE `to`=$from AND `from`=$to");
		redirect(BASE_PATH.'mail');die();
	}
	

	function getMsgCount($from,$to){
		$sql = "SELECT count(id) FROM mail WHERE (`from`=$from AND `to`=$to AND delto=0) OR (`from`=$to AND `to`=$from AND delfrom=0)"; //echo $sql;
		$msgcount = DBcell($sql);
		$msgcount = $msgcount. ' '. C('messages',$msgcount);
		return $msgcount;
	}
	
	
	//delete your message
	function delfrom(){
		$id = (int)$this->id;
		DBquery("UPDATE mail SET delfrom=1 WHERE id='$id'"); 		echo $sql;
		$msgcount = $this->getMsgCount($this->session['user']['id'],(int)$this->path[3]);
		//echo "<msg>$msgcount<msg>";
		die();
	}
	
	
	//delete your friend`s message
	function delto(){
		$id = (int)$this->id;
		DBquery("UPDATE mail SET delto=1 WHERE id='$id'");	echo $sql;
		$msgcount = $this->getMsgCount($this->session['user']['id'],(int)$this->path[3]);
		//echo "<msg>$msgcount<msg>";
		die();
	}
	
	//recover your message
	function recfrom(){
		$id = (int)$this->id;
		DBquery("UPDATE mail SET delto=0 WHERE id='$id'");	
		$data = //array( 0 =>
		DBrow("SELECT * FROM mail WHERe id='$id'");
		//);
		echo trim(tpl('mail',array('data'=>$data,'do'=>'rec', 'mid'=>$id,'id'=>(int)$this->path[3])));
		die();
	}
	
	//recover your friend`s message
	function recto(){
		$id = (int)$this->id;
		DBquery("UPDATE mail SET delfrom=0 WHERE id='$id'");	
		$data = //array( 0 => 
		DBrow("SELECT * FROM mail WHERe id='$id'");
		//);
		echo trim(tpl('mail',array('data'=>$data,'do'=>'rec', 'mid'=>$id,'id'=>(int)$this->path[3])));
		die();
	}
	
	//check for new messages
	function newMsg(){
		$sql =  "SELECT count(id) FROM mail WHERE `time`>'".$this->session['chat'][$this->id]."' AND ( (`from`=$from AND `to`=$to AND delto=0) OR (`from`=$to AND `to`=$from AND delfrom=0) )";
		$res = DBcell($sql);
		if($res>0) 	echo "yes"; die();
	}
	

	function items(){
		$uid = $this->session['user']['id'];
		$value = date("Y-m-d H:i:s");

		$contacts = '0'.DBcell("SELECT following FROM users WHERE id='$uid'");
		
		$this->sql['items'] ="SELECT mytable. * , l.lastvisit, CONCAT( u.name, ' ', u.surname ) AS name
						FROM (

						SELECT m.`to` , (
						m.`from` + m.`to` -$uid
						) AS id, substring( text, 1, 44 ) AS text, `time`
						FROM mail m
						WHERE (`from` = '$uid' AND m.delto=0)
						OR (`to` = '$uid' AND m.delfrom=0)
						ORDER BY `time` DESC
						) AS mytable
						LEFT JOIN users u ON u.id = mytable.`id`
						LEFT JOIN visits l ON 
						( mytable.id = l.uid
						AND $uid = l.fid
						AND mytable.`time` > l.lastvisit ) OR
						( mytable.id = l.fid 
						AND $uid = l.uid
						AND mytable.`time` > l.lastvisit )
						GROUP BY id
						ORDER BY `time` DESC";

		return DBall($this->sql['items']);
	}
	
	//open dialogue
	function compose(){
		$from = $_SESSION['user']['id'];
		$to = $this->id;
		$value = date("Y-m-d H:i:s", strtotime ( '-2 seconds' , strtotime ( date("Y-m-d H:i:s") ) ) );
		
		$sql = "REPLACE INTO visits SET uid='$from', fid='$to', lastvisit='$value'"; DBquery($sql);
		$sql = "SELECT m . * , l.lastvisit
		FROM mail m
		LEFT JOIN visits l ON m.to = l.uid
		AND m.from = l.fid
		AND m.time > l.lastvisit
		WHERE (`from`=$from AND `to`=$to AND delto=0) OR (`from`=$to AND `to`=$from AND delfrom=0) ORDER BY `time` DESC LIMIT 0,6";
		$ret = array_reverse(DBall($sql));	//echo $sql;
		if(sizeof($ret)>0){
			$this->session['oldchat'][$this->id] = (int)$ret[0]['id'];	
			$this->session['chat'][$this->id] = (int)$ret[sizeof($ret)-1]['id'];			
		}
		$sql = "UPDATE users SET lastmsgcheck='$value' WHERE id='$from'"; dbquery($sql);
		$this->title = DBcell("SELECT CONCAT(name,' ',surname) FROM users WHERE id=$to");
		return $ret;
	}
	
	//get new messages in dialogue
	function getNewMsgs(){
		$id = (int)$this->session['chat'][$this->id];
		//	inspect($this->session);
		$from = $this->session['user']['id']; //echo $this->session['chat'][$this->id];
		$to = $this->id;
		$msgcount = $this->getMsgCount($from,$to);
		$sql = "SELECT m . * , l.lastvisit
		FROM mail m
		LEFT JOIN visits l ON m.to = l.uid
		AND m.from = l.fid
		AND m.time > l.lastvisit
		WHERE ((`from`=$from AND `to`=$to AND delto=0) OR (`from`=$to AND `to`=$from AND delfrom=0)) AND m.id>$id ORDER BY `time` ASC";
		//echo $sql;
		$data = DBall($sql);

		$sql = "REPLACE INTO visits SET uid='$from', fid='$to', lastvisit='".date("Y-m-d H:i:s")."'"; DBquery($sql);
	/*	$lv = DBcell("SELECT MAX(m.id) FROM mail m
		JOIN visits l ON m.to = l.uid
		AND m.from = l.fid
		AND m.time < l.lastvisit
		WHERE ((`from`=$from AND `to`=$to AND delto=0) OR (`from`=$to AND `to`=$from AND delfrom=0))");*/
		if(sizeof($data)>0){
			$this->session['chat'][$this->id] = $data[sizeof($data)-1]['id']; 
			}
			
	
		echo trim(tpl('mail',array('data'=>$data,'do'=>'msg', 'id'=>$this->id, /*'lv'=>$lv ,*/ 'msgcount' => $msgcount)));
		die();
	} 
	
	//get old messages from AJAX scrollback.
	function getOldMsgs(){ 
		$id = (int)$this->session['oldchat'][$this->id];
		$from = (int)$this->session['user']['id'];
		$to = (int)$this->id;
		$sql = "SELECT m . * , l.lastvisit
		FROM mail m
		LEFT JOIN visits l ON m.to = l.uid
		AND m.from = l.fid
		AND m.time > l.lastvisit
		WHERE ((`from`=$from AND `to`=$to AND delto=0) OR (`from`=$to AND `to`=$from AND delfrom=0))  AND m.id<$id ORDER BY `time` DESC LIMIT 0,6";
		
		$data = array_reverse(DBall($sql));
		
		//echo $sql;
		if(sizeof($data)>0){
			$this->session['oldchat'][$this->id] = $data[0]['id'];
			echo tpl('mail',array('data'=>$data,'do'=>'msg', 'id'=>$this->id));
		}	
		die();
	}
	
	
	//update contact list
	function updateContacts($owner,$user){
	
		$contacts = split(',',DBcell("SELECT following FROM users WHERE id='$owner'"));
		$contacts[] = $user;
		DBquery("UPDATE users SET following='".join(',',$contacts)."' WHERE id=$owner");
	}

	function send(){
		$data  = $this->post['form'];
		$sql = "INSERT INTO mail SET
			`from` ='".parseString($data['from'])."',
			`to` ='".parseString($data['to'])."',
			text ='".parseString(nl2br($data['text']))."',
			topic='".parseString($data['topic'])."', `time`='".date("Y-m-d H:i:s")."'";
		DBquery($sql);	
		if($this->id=='ajax') die();
		redirect(BASE_PATH.'mail');
	}
	

}?>