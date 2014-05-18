<?php
class seminarlessons extends masterclass{

	function extend(){
	//	$fac_id = (int)@$_SESSION['user']['faculty_id']; //inspect($_SESSION['user']);
		$sql = "SELECT * FROM seminars";// WHERE faculty_id=$fac_id";// echo $sql; TODO
		$spec = getVar('edu_spec');//getVar('sem_spec');
		$term = getVar('edu_term');//getVar('sem_term');
		if($spec > 0 && $term > 0)
			$sql.= " WHERE specialization_id=$spec AND term_id=$term";
		elseif($spec>0)
			$sql.= " WHERE specialization_id=$spec";
		elseif($term>0)
			$sql.= " WHERE term_id=$term";
		
		
		$seminars = DBall($sql); //inspect($seminars);
		$ret = array();
		$this->options['seminar_id'] = array( 0 => '---' ); 
		foreach($seminars  as $seminar){
			$this->options['seminar_id'][$seminar['id']] = $seminar['name'];
		}	
	}
	
	function items(){
		
		$addsql = '';
		$spec = getVar('edu_spec');//getVar('sem_spec');
		$term = getVar('edu_term');//getVar('sem_term');
		if($spec > 0 && $term > 0)
			$addsql.= " WHERE s.specialization_id=$spec AND s.term_id=$term";
		elseif($spec>0)
			$addsql.= " WHERE s.specialization_id=$spec";
		elseif($term>0)
			$addsql.= " WHERE s.term_id=$term";
		if ($addsql != '') 	$addsql = " JOIN seminars s ON s.id = sl.seminar_id ".$addsql;
		
		$this->pages = ceil( DBcell("SELECT count(sl.id) FROM seminarlessons sl $addsql") / $this->perpage );
		if($this->page>0) $this->page--;
		$sql = "SELECT sl.id, sl.seminar_id, sl.name, sl.title FROM seminarlessons sl $addsql ORDER BY sl.seminar_id, sl.title ASC LIMIT ".$this->page*$this->perpage.",".$this->perpage; 
		$this->page++;
		return DBall($sql);
  	}
	
	function item(){	
		if($this->id>0) {
			$row = DBrow("SELECT * FROM seminarlessons WHERE id={$this->id}");
			$row['tags'] =  implode(',',DBcol("SELECT tag FROM seminar_tags WHERE seminar_id={$this->id}"));
			return $row;
		}
		return array();
    }
     
	function view(){
		return DBrow("SELECT * FROM semiralessons WHERE id={$this->id}");
	}
	
	function del(){
     		if(isAdmin())  return DBquery("DELETE FROM seminarlessons WHERE id={$this->id}"); else return false;
     	}
     	
    function save(){
     	$data  = $this->post['form'];
	  	$sql = " seminarlessons SET
			seminar_id ='".addslashes(htmlspecialchars($data['seminar_id']))."',
			literature ='".addslashes(htmlspecialchars($data['literature']))."',
			name ='".addslashes(htmlspecialchars($data['name']))."',
			title ='".addslashes(htmlspecialchars($data['title']))."'";

		if($this->id>0){ 
			$sql = "UPDATE $sql WHERE id={$this->id}";
			$ret = DBquery($sql);
		}else{ 	
			$sql = "INSERT INTO $sql";
			$ret = DBquery($sql);
			if($ret) $this->id = DBinsertId();// die(inspect($this->id));
			$this->recount_lessons();
		}
		
		return $ret;
    }

} ?>