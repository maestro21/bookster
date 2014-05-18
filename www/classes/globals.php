<?php
class globals extends masterclass{



	function items(){
		$this->pages = ceil( DBcell("SELECT count(id) FROM globals") / $this->perpage );
		if($this->page>0) $this->page--;
		$sql = "SELECT * FROM globals LIMIT ".$this->page*$this->perpage.",".$this->perpage; 
		$this->page++;
		return DBall($sql);
  	}
	
	function item(){	
		if($this->id>0) 
			return DBrow("SELECT * FROM globals WHERE id={$this->id}");
		return array();
    	}
    
	function view(){
		if($this->id>0)
			return DBrow("SELECT * FROM globals WHERE id={$this->id}");
		return array();	
	}		

	function del(){
     		if(isAdmin())  return DBquery("DELETE FROM globals WHERE id={$this->id}"); else return false;
     	}
     	
    function save(){
     	$data  = $this->post['form'];
	  	$sql = " globals SET 
			name ='".addslashes(htmlspecialchars($data['name']))."',
			value ='".addslashes(htmlspecialchars($data['value']))."'";
		//inspect($data); die();
		if($this->id>0){ 
			$sql = "UPDATE $sql WHERE id={$this->id}";
			return DBquery($sql);
		}else{ 	
			$sql = "INSERT INTO  $sql";
			$ret = DBquery($sql);
			if($ret) $this->id = DBinsertId();// die(inspect($this->id));
			return $ret;
		}     
     }
	
}

?>