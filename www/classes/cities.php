<?php
class cities extends masterclass{


	function extend(){
		$countries = DBall("SELECT * FROM countries");
		$ret = array();
		$this->options['country_id'] = array( 0 => '---' ); 
		foreach($countries as $country){
			$this->options['country_id'][$country['id']] = $country['name'];
		}
	}
	
	function listById(){
		$res = DBall("SELECT * from cities WHERE country_id='{$this->id}'");
		foreach ($res as $c){
			echo "<option id='".$c['id']."'>".$c['name']."</option>";
		}
		die();
	}
	
	
	function items(){
		$this->pages = ceil( DBcell("SELECT count(id) FROM cities") / $this->perpage );
		if($this->page>0) $this->page--;
		$sql = "SELECT * FROM cities LIMIT ".$this->page*$this->perpage.",".$this->perpage; 
		$this->page++;
		return DBall($sql);
  	}
	
	function item(){	
		if($this->id>0) 
			return DBrow("SELECT * FROM cities WHERE id={$this->id}");
		return array();
    	}
    
	function view(){
		if($this->id>0)
			return DBrow("SELECT * FROM cities WHERE id={$this->id}");
		return array();	
	}		

	function del(){
     		if(isAdmin())  return DBquery("DELETE FROM cities WHERE id={$this->id}"); else return false;
     	}
     	
    function save(){
     	$data  = $this->post['form'];
	  	$sql = "country_id ='".addslashes(htmlspecialchars($data['country_id']))."',
			name ='".addslashes(htmlspecialchars($data['name']))."'";

		if($this->id>0){ 
			$sql = "UPDATE cities SET $sql WHERE id={$this->id}";
			return DBquery($sql);
		}else{ 	
			$sql = "INSERT INTO cities SET $sql";
			$ret = DBquery($sql);
			if($ret) $this->id = DBinsertId();// die(inspect($this->id));
			return $ret;
		}     
     }


	 
}

?>