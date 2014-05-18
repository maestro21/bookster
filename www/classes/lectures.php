<?php
class lectures extends masterclass{


	function extend(){
		$this->defFunc= 'my';
	}
	
	
	function rm(){
		$uid = (int)@$_SESSION['user']['id'];
		$sql = dbquery("DELETE FROM mylectures WHERE userid='$uid' AND lectureid={$this->id}");	
		goBack();
	}
	
	function add(){
		$uid = (int)@$_SESSION['user']['id']; //echo $uid; echo $this->id;
		if(!(int)DBcell("SELECT 1 FROM mylectures WHERE userid='$uid' AND lectureid={$this->id}"))
			dbquery("INSERT INTO mylectures SET userid='$uid', lectureid={$this->id}");
		goBack();	
	}
	
	function my(){
		return DBall("SELECT * FROM lectures WHERE factulty_id='".$_SESSION['user']['faculty_id']."' AND term_id='".$_SESSION['user']['term']."' ORDER BY name ASC");
	}

	function getOptions(){
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

}

?>