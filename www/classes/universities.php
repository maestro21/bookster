<?php
class universities extends masterclass{


	function extend(){
		$pid = getVar('edu_uni');
		$sql = "SELECT * FROM cities";
		if($pid > 0) $sql .=" WHERE country_id=$pid";
		$cities = DBall($sql);
		
		$ret = array();
		$this->options['city_id'] = array( 0 => '---' ); 
		foreach($cities as $city){
			$this->options['city_id'][$city['id']] = $city['name'];
		}
	}
	
	function items(){
		$pid = getVar('edu_country');
		if($pid > 0) $addsql.= " JOIN cities c ON c.id=u.city_id AND c.country_id=$pid"; else $addsql = '';
		
		$this->pages = ceil( DBcell("SELECT count(u.id) FROM universities u $addsql ") / $this->perpage );
		if($this->page>0) $this->page--;
		$sql = "SELECT u.* FROM universities u $addsql LIMIT ".$this->page*$this->perpage.",".$this->perpage; 
		$this->page++;
		return DBall($sql);
  	}
	
	function item(){	
		if($this->id>0) 
			return DBrow("SELECT * FROM universities WHERE id={$this->id}");
		return array();
    	}
    
	function view(){
		if($this->id>0)
			return DBrow("SELECT * FROM universities WHERE id={$this->id}");
		return array();	
	}		

	function del(){
     		if(isAdmin())  return DBquery("DELETE FROM universities WHERE id={$this->id}"); else return false;
     	}
     	
    function save(){
     	$data  = $this->post['form'];
	  	$sql = "city_id ='".(int)($data['city_id'])."',
			name ='".addslashes(htmlspecialchars($data['name']))."'";

		if($this->id>0){ 
			$sql = "UPDATE universities SET $sql WHERE id={$this->id}";
			return DBquery($sql);
		}else{ 	
			$sql = "INSERT INTO universities SET $sql";
			$ret = DBquery($sql);
			if($ret) $this->id = DBinsertId();// die(inspect($this->id));
			return $ret;
		}     
     }
}

?>