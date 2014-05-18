<?php
class countries extends masterclass{
	function items(){
		$sql = "SELECT * FROM countries"; 
		return DBall($sql);
  	}
	
	function item(){	
		if($this->id>0) 
			return DBrow("SELECT * FROM countries WHERE id={$this->id}");
		return array();
    	}
     
	function view(){
		if($this->id>0) 
			return DBrow("SELECT * FROM countries WHERE id={$this->id}");
		return array();
	}
	
	function del(){
     		if(isAdmin())  return DBquery("DELETE FROM countries WHERE id={$this->id}"); else return false;
     	}
     	
    function save(){
     	$data  = $this->post['form'];
	  	$sql = "abbr ='".addslashes(htmlspecialchars($data['abbr']))."',
			name ='".addslashes(htmlspecialchars($data['name']))."'";

		if($this->id>0){ 
			$sql = "UPDATE countries SET $sql WHERE id={$this->id}";
			return DBquery($sql);
		}else{ 	
			$sql = "INSERT INTO countries SET $sql";
			$ret = DBquery($sql);
			if($ret) $this->id = DBinsertId();// die(inspect($this->id));
			return $ret;
		}     
     }
}
?>	