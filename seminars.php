<?php
class seminars extends masterclass{

	function extend(){
		$this->defFunc= 'my';
		
		$fac_id = (int)@$_SESSION['user']['faculty_id']; //inspect($_SESSION['user']);
		
		$sql = "SELECT * FROM specialization";// WHERE faculty_id=$fac_id";// echo $sql;
		$specializations = DBall($sql);
		$ret = array();
		$this->options['specialization_id'] = array( 0 => '---' ); 
		foreach($specializations as $specialization){
			$this->options['specialization_id'][$specialization['id']] = $specialization['name'];
		}
		
		$sql = "SELECT * FROM faculties";// WHERE faculty_id=$fac_id";// echo $sql;
		$faculties = DBall($sql);
		$ret = array();
		$this->options['faculty_id'] = array( 0 => '---' ); 
		foreach($faculties as $faculty){
			$this->options['faculty_id'][$faculty['id']] = $faculty['name'];
		}
		
		$this->options['term_id'] = array( 0 => '---' ); 
		for ($i = 1 ; $i<11 ; $i++){ 
			$this->options['term_id'][$i] = $i . T(' term');;
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
		$spec = getVar('sem_spec');
		$term = getVar('sem_term');
		$addsql = '';
		if($spec > 0 && $term > 0)
			$addsql.= " WHERE specialization_id=$spec AND s.term_id=$term";
		elseif($spec>0)
			$addsql.= " WHERE specialization_id=$spec";
		elseif($term>0)
			$addsql.= " WHERE term_id=$term";
			
		$this->pages = ceil( DBcell("SELECT count(id) FROM seminars $addsql") / $this->perpage );
		if($this->page>0) $this->page--;
		$sql = "SELECT * FROM seminars $addsql LIMIT ".$this->page*$this->perpage.",".$this->perpage; 
		return DBall($sql);
  	}
	
	function item(){	
		if($this->id>0) 
			return DBrow("SELECT * FROM seminars WHERE id={$this->id}");
		return array();
    	}
     

	
	function del(){
     		if(isAdmin())  return DBquery("DELETE FROM seminars WHERE id={$this->id}"); else return false;
     	}
     	
    function save(){
     		$data  = $this->post['form'];
	  	$sql = " seminars SET
			specialization_id ='".addslashes(htmlspecialchars($data['specialization_id']))."',
			term_id ='".addslashes(htmlspecialchars($data['term_id']))."',
			name ='".addslashes(htmlspecialchars($data['name']))."',
			faculty_id ='".addslashes(htmlspecialchars($data['faculty_id']))."'";

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
	
	
	function rm(){
		$uid = (int)@$_SESSION['user']['id'];
		$sql = dbquery("DELETE FROM myseminars WHERE userid='$uid' AND seminarid={$this->id}");	
		goBack();
	}
	
	function add(){
		$uid = (int)@$_SESSION['user']['id']; //echo $uid; echo $this->id;
		if(!(int)DBcell("SELECT 1 FROM myseminars WHERE userid='$uid' AND seminarid={$this->id}"))
		dbquery("INSERT INTO myseminars SET userid='$uid', seminarid={$this->id}");
		goBack();	
	}
	
	function view(){
		$sql = "SELECT * FROM seminarlessons WHERE seminar_id={$this->id} ORDER BY title ASC";
		return DBall($sql);
	}
	
	function lesson(){
		$sql = "SELECT * FROM seminarquestions WHERE seminarlesson_id={$this->id}";
		return DBall($sql);
	}
	
	function question(){
		$sql = "SELECT * FROM seminarquestions WHERE id={$this->id}";
		return DBrow($sql);
	}
	
	function my(){
		$sql = "SELECT 
				id,
				 CONCAT(UPPER(LEFT(name, 1)), SUBSTRING(name, 2)) as name 
				 FROM seminars ";
				 if(!IsSuperAdmin())
		$sql .=" WHERE
			 faculty_id='".$_SESSION['user']['faculty_id']."' AND
			(specialization_id='".$_SESSION['user']['specialization_id']."' OR specialization_id=0)
			 AND term_id='".$_SESSION['user']['term']."' ";
		$sql .=" ORDER BY name ASC"; //echo $sql;
			return DBall($sql);
	}

}

?>