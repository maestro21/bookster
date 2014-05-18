<?php
class langs extends masterclass{
	
	function save(){
		file_put_contents("lang/{$this->post['form']['abbr']}.txt",$this->post['form']['labels']);
		
		$data  = $this->post['form'];
	  	$sql = " langs SET
			abbr ='".addslashes(htmlspecialchars($data['abbr']))."',
			name ='".addslashes(htmlspecialchars($data['name']))."',
			enabled ='".(int)(@$data['enabled'])."'";
		//inspect($data);
		//echo $sql; die();	
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
	
	function item(){
		if($this->id>0) 
			$data = DBrow("SELECT * FROM langs WHERE id={$this->id}");
		$data['labels'] = @file_get_contents("lang/{$data['abbr']}.txt");
		$this->fields['labels'] = array( 'name' => 'labels', 'type'=>'file', 'widget'=>'textarea');
		return $data;
	}

	function items(){
		$sql = "SELECT * FROM langs"; 
		return DBall($sql);
  	}
	
		
	function del(){
     	if(isAdmin())  return DBquery("DELETE FROM langs WHERE id={$this->id}"); else return false;
    }
	
} ?>