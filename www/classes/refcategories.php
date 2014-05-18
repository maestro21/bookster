<?php
class refcategories extends masterclass{



	function items(){
		$this->pages = ceil( DBcell("SELECT count(id) FROM refcategories") / $this->perpage );
		if($this->page>0) $this->page--;
		$sql = "SELECT * FROM refcategories LIMIT ".$this->page*$this->perpage.",".$this->perpage; 
		$this->page++;
		return DBall($sql);
  	}
	
	function item(){	
		if($this->id>0) 
			return DBrow("SELECT * FROM refcategories WHERE id={$this->id}");
		return array();
    	}
    
	function view(){
		if($this->id>0)
			return DBrow("SELECT * FROM refcategories WHERE id={$this->id}");
		return array();	
	}		

	function del(){
     		if(isAdmin())  return DBquery("DELETE FROM refcategories WHERE id={$this->id}"); else return false;
     	}
     	
    function save(){
     	$data  = $this->post['form'];
	  	$sql = " refcategories SET 
			name_ua ='".addslashes(htmlspecialchars($data['name_ua']))."',
			name_ru ='".addslashes(htmlspecialchars($data['name_ru']))."',
			name_en ='".addslashes(htmlspecialchars($data['name_en']))."'
			";
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