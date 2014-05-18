<?php
class faculties extends masterclass{


	function extend(){
		$pid = getVar('edu_city');
		$sql = "SELECT * FROM universities";
		if($pid > 0) $sql .=" WHERE city_id=$pid";	
	
		$countries = DBall($sql);
		$ret = array();
		$this->options['uni_id'] = array( 0 => '---' ); 
		foreach($countries as $country){
			$this->options['uni_id'][$country['id']] = $country['name'];
		}
	}

	function items(){
		$pid = getVar('edu_city');
		if($pid > 0) $addsql.= " JOIN universities u ON u.id=f.uni_id AND u.city_id=$pid"; else $addsql = '';
	
		$this->pages = ceil( DBcell("SELECT count(f.id) FROM faculties f $addsql ") / $this->perpage );
		if($this->page>0) $this->page--;
		$sql = "SELECT f.* FROM faculties f $addsql LIMIT ".$this->page*$this->perpage.",".$this->perpage; 
		$this->page++;
		return DBall($sql);
  	}
	
	function item(){	
		if($this->id>0) 
			return DBrow("SELECT * FROM faculties WHERE id={$this->id}");
		return array();
    	}
    
	function view(){
		if($this->id>0)
			return DBrow("SELECT * FROM faculties WHERE id={$this->id}");
		return array();	
	}		

	function del(){
     		if(isAdmin())  return DBquery("DELETE FROM faculties WHERE id={$this->id}"); else return false;
     	}
     	
    function save(){
     	$data  = $this->post['form'];
	  	$sql = "uni_id ='".(int)($data['uni_id'])."',
			name ='".addslashes(htmlspecialchars($data['name']))."'";
		//inspect($data); die();
		if($this->id>0){ 
			$sql = "UPDATE faculties SET $sql WHERE id={$this->id}";
			return DBquery($sql);
		}else{ 	
			$sql = "INSERT INTO faculties SET $sql";
			$ret = DBquery($sql);
			if($ret) $this->id = DBinsertId();// die(inspect($this->id));
			return $ret;
		}     
     }
	
}

?>