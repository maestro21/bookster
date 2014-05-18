<?php
class seminarquestions extends masterclass{
	function extend(){
	//	$fac_id = (int)@$_SESSION['user']['faculty_id']; //inspect($_SESSION['user']);
		$sql = "SELECT * FROM seminarlessons";// WHERE faculty_id=$fac_id";// echo $sql; TODO
		
		$sem = getVar('edu_sem');//getVar('sem_sem');
		if($sem > 0) $sql.= " WHERE seminar_id=$sem";
		///echo $sql;
		$lessons = DBall($sql); //inspect($lessons);
		$ret = array();
		$this->options['seminarlesson_id'] = array( 0 => '---' ); 
		foreach($lessons  as $lesson){
			$this->options['seminarlesson_id'][$lesson['id']] = $lesson['name'];
		}
	
	}
	
	function view(){
		return DBrow("SELECT * FROM seminarquestions WHERE id={$this->id}");
	}
	
	function items(){
		$spec = getVar('edu_spec');//getVar('sem_spec');
		$term = getVar('edu_term');//getVar('sem_term'); //inspect($this->session);
		$sem = getVar('edu_sem');//getVar('sem_sem');
		$addsql = '';
		if($sem > 0)
			$addsql .= " WHERE sl.seminar_id=$sem";
		elseif($spec > 0 && $term > 0)
			$addsql.= " WHERE s.specialization_id=$spec AND term_id=$term";
		elseif($spec>0)
			$addsql.= " WHERE s.specialization_id=$spec";
		elseif($term>0)
			$addsql.= " WHERE s.term_id=$term";
		if ($addsql != '') 	$addsql = " JOIN seminarlessons sl ON sl.id=sq.seminarlesson_id JOIN seminars s ON s.id = sl.seminar_id ".$addsql;	
			
		$this->pages = ceil( DBcell("SELECT count(sq.id) FROM seminarquestions sq $addsql") / $this->perpage );
		if($this->page>0) $this->page--;
		$sql = "SELECT sq.id, sq.seminarlesson_id, sq.question, sq.`order` FROM seminarquestions sq $addsql ORDER BY sq.seminarlesson_id, sq.`order` ASC LIMIT ".$this->page*$this->perpage.",".$this->perpage; //echo $sql;
		$this->page++;
		return DBall($sql);
  	}
	
	function item(){	
		if($this->id>0) { 
			$row = DBrow("SELECT * FROM seminarquestions  WHERE id={$this->id}");
			$row['tags'] =  implode(',',DBcol("SELECT tag FROM seminar_tags WHERE seminar_id={$this->id}"));
			return $row;
		}
		return array();
    }
     

	
	function del(){
     		if(isAdmin())  return DBquery("DELETE FROM seminarquestions WHERE id={$this->id}"); else return false;
     	}
     	
    function save(){
     	$data  = $this->post['form'];
	  	$sql = " seminarquestions SET
			seminarlesson_id ='".addslashes(htmlspecialchars($data['seminarlesson_id']))."', 
			`order` ='".(int)$data['order']."', 
			question ='".addslashes(htmlspecialchars($data['question']))."',
			answer='".addslashes(htmlspecialchars($data['answer']))."'";

		if($this->id>0){ 
			$sql = "UPDATE $sql WHERE id={$this->id}"; //echo $sql;
			$ret = DBquery($sql);
		}else{ 	
			$sql = "INSERT INTO $sql";
			$ret = DBquery($sql);
			if($ret) $this->id = DBinsertId();// die(inspect($this->id));
		} 

		$sql = "DELETE FROM seminar_tags WHERE seminar_id = " .$this->id;
		DBquery($sql);
		$data['tags'] = explode(',',$data['tags']);
		if(	sizeof($data['tags']) > 0 ){
			foreach($data['tags'] as $tag){
				$tag = addslashes(htmlspecialchars(trim($tag)));
				$sql = "INSERT INTO seminar_tags SET seminar_id={$this->id}, tag='$tag'";
				DBquery($sql);
			}
		}
		
		return $ret;		
    }

} ?>