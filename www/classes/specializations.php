<?php
class specialization extends masterclass{


	function extends(){
		$uni_id = (int)@$_SESSION['user']['uni_id'];
		$sql = "SELECT * FROM faculties WHERE uni_id=$uni_id";// echo $sql;
		$faculties = DBall($sql);
		$ret = array();
		$this->options['factulty_id'] = array( 0 => '---' ); 
		foreach($faculties as $faculty){
			$this->options['factulty_id'][$faculty['id']] = $faculty['name'];
		}
		
		$this->options['term_id'] = array( 0 => '---' ); 
		for ($i = 1 ; $i<11 ; $i++){ 
			$this->options['term_id'][$i] = $i . T(' term');;
		}
		//inspect($this->options);
	}
	
	function items(){
		$this->pages = ceil( DBcell("SELECT count(id) FROM specialization") / $this->perpage );
		if($this->page>0) $this->page--;
		$sql = "SELECT * FROM specialization LIMIT ".$this->page*$this->perpage.",".$this->perpage; 
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