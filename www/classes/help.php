<?php
class help extends masterclass{
	
	
	function extend(){
		$this->defFunc = '_list';
		$this->sql['items'] = " SELECT id, question, lang, public FROM help";
		
		$langs = DBall("SELECT * FROM langs");
		foreach ($langs as $lang){
			$this->options['lang'][$lang['abbr']] = $lang['name'];
		}
	}
	

	function ask(){
		if(isset($this->post['form'])){
			$data = $this->post['form'];
			$sql = "INSERT INTO help SET 
					question='".addslashes(htmlspecialchars($data['question']))."',
					lang='".getVar('lang')."',
					uid='".getUid()."',
					public=0";
			DBquery($sql);
			redirect(BASE_PATH.'help');
		}
	}
	
	function search(){
		$text = $this->path[2];
		$this->params['searchtext'] = $text;
		$sql = "SELECT * FROM help WHERE public AND lang='".getVar('lang')."' AND (question LIKE '%$text%' OR answer LIKE '%$text%') ORDER BY id DESC"; //echo $sql;
		return DBall($sql);
	}
	
function view(){
		$this->maintpl = 'page';
		return DBrow("SELECT * FROM help WHERE id={$this->id}");
	}
	
	function items(){
		$this->pages = ceil( DBcell("SELECT count(id) FROM help") / $this->perpage );
		if($this->page>0) $this->page--;
		$sql = "
			SELECT  CONCAT(u.name,' ',u.surname) as username, h.*
			FROM help h
			LEFT JOIN users u ON u.id=h.uid
			ORDER BY id DESC
			LIMIT ".$this->page*$this->perpage.",".$this->perpage; 
			$this->page++;
		return DBall($sql);
  	}
	
	function item(){	
		if($this->id>0) 
			return DBrow("SELECT * FROM help WHERE id={$this->id}");
		return array();
    	}
     

	
	function del(){
     		if(isAdmin())  return DBquery("DELETE FROM help WHERE id={$this->id}"); else return false;
     	}
     	
    function save(){
		if(CheckLogged()) {
			$data  = $this->post['form'];
			$sql = " help SET
				lang ='".getVar('lang',G('deflang','ua'))."',
				question ='".addslashes(htmlspecialchars($data['question']))."',
				public ='".(int)(@$data['public'])."',
				uid ='".(int)(@$data['uid'])."',
				answer='".addslashes(htmlspecialchars($data['answer']))."'";

			if($this->id>0){ 
				$sql = "UPDATE $sql WHERE id={$this->id}";
				return DBquery($sql);
			}else{ 	
				$sql = "INSERT INTO $sql"; 
				$ret = DBquery($sql);
				if($ret) $this->id = DBinsertId();// die(inspect($this->id));
				return $ret;
			}     
		}
    }	
	
	function _list(){
		$this->maintpl = 'page';
		$sql = "SELECT * FROM help WHERE public AND lang='".getVar('lang')."' ORDER BY id DESC";
		return DBall($sql);
	}
	
	function showhide(){
		$sql = sprintf("UPDATE help SET public = ABS(public-1) WHERE id=%d", $this->id); //echo $sql; die();
		DBquery($sql); 
		redirect(BASE_PATH.'seminars/items'); die();
	}

}

?>