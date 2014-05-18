<?php
class specialization extends masterclass{



	function extend(){
		$pid = getVar('edu_uni');
		$sql = "SELECT * FROM faculties";
		if($pid > 0) $sql .=" WHERE uni_id=$pid";	
	
		$options = DBall($sql);		
		$ret = array();
		$this->options['faculty_id'] = array( 0 => '---' ); 
		foreach($options as $option){
			$this->options['faculty_id'][$option['id']] = $option['name'];
		}
	}
	
	function items(){
		$pid = getVar('edu_uni');
		if($pid > 0) $addsql.= " JOIN faculties f ON f.id=s.faculty_id AND f.uni_id=$pid"; else $addsql = '';
	
		$this->pages = ceil( DBcell("SELECT count(s.id) FROM specialization s $addsql ") / $this->perpage );
		if($this->page>0) $this->page--;
		$sql = "SELECT s.* FROM specialization s $addsql LIMIT ".$this->page*$this->perpage.",".$this->perpage; 
		$this->page++;
		return DBall($sql);
  	}
	
	function item(){	
		if($this->id>0) 
			return DBrow("SELECT * FROM specialization WHERE id={$this->id}");
		return array();
    	}
    
	function view(){
		if($this->id>0)
			return DBrow("SELECT * FROM specialization WHERE id={$this->id}");
		return array();	
	}		

	function del(){
     		if(isAdmin())  return DBquery("DELETE FROM specialization WHERE id={$this->id}"); else return false;
     	}
     	
    function save(){
     	$data  = $this->post['form'];
	  	$sql = " specialization SET 
			name ='".addslashes(htmlspecialchars($data['name']))."',
			faculty_id ='".addslashes(htmlspecialchars($data['faculty_id']))."'";
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