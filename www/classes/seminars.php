<?php
class seminars extends masterclass{

	function extend(){
		//$this->defFunc= 'my';
		
		//$fac_id = (int)@$_SESSION['user']['faculty_id'];
		$pid = getVar('edu_fac');
		$sql = "SELECT * FROM specialization";
		if($pid > 0) $sql .=" WHERE faculty_id=$pid";	//echo $sql;
		$specializations = DBall($sql);
		$ret = array();
		$this->options['specialization_id'] = array( 0 => '---' ); 
		foreach($specializations as $specialization){
			$this->options['specialization_id'][$specialization['id']] = $specialization['name'];
		}
		
		$pid = getVar('edu_uni');
		$sql = "SELECT * FROM faculties";
		if($pid > 0) $sql .=" WHERE uni_id=$pid";		
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
		
		$this->defFunc = 'levelselect';
		
	}
	
	
	function listById(){
		$res = DBall("SELECT * from cities WHERE country_id='{$this->id}'");
		foreach ($res as $c){
			echo "<option id='".$c['id']."'>".$c['name']."</option>";
		}
		die();
	}
	
	
	/**/
	function items(){ 
		//$this->do = $this->defFunc = 'my';
		$fac  = getVar('edu_fac');
		$spec = getVar('edu_spec');//getVar('sem_spec');
		$term = getVar('edu_term');//getVar('sem_term');
		$addsql = ' WHERE 1';
		if($fac > 0)
			$addsql.= " AND faculty_id=$fac";
		if($spec > 0)
			$addsql.= " AND ( specialization_id=$spec OR specialization_id=0)";
		if($term > 0)
			$addsql.= " AND term_id=$term";
		$sql = "SELECT count(id) FROM seminars $addsql"; //die($sql);
		$this->pages = ceil( DBcell($sql) / $this->perpage );
		if($this->page>0) $this->page--; 
		$sql = "SELECT * FROM seminars $addsql ORDER BY name ASC LIMIT ".$this->page*$this->perpage.",".$this->perpage;  // echo $sql;
		$this->page++;
		return DBall($sql);
  	}/**/
	
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
			specialization_id ='".parseString($data['specialization_id'])."',
			term_id ='".parseString($data['term_id'])."',
			name ='".parseString($data['name'])."',
			faculty_id ='".parseString($data['faculty_id'])."'";
		
		
		
		if($this->id>0){ 
			$sql = "UPDATE $sql WHERE id={$this->id}";
			$ret = DBquery($sql);
		}else{ 	
			$sql = "INSERT INTO $sql";
			$ret = DBquery($sql);
			if($ret) $this->id = DBinsertId();
		}   
		return $ret;		
    }
	
	//deleting seminar from my list
	function rm(){
		$uid = (int)@$_SESSION['user']['id'];
		$sql = dbquery("DELETE FROM myseminars WHERE userid='$uid' AND seminarid={$this->id}");	
		goBack();
	}
	
	//adding seminar from my list
	function add(){
		$uid = (int)@$_SESSION['user']['id'];
		if(!(int)DBcell("SELECT 1 FROM myseminars WHERE userid='$uid' AND seminarid={$this->id}"))
		dbquery("INSERT INTO myseminars SET userid='$uid', seminarid={$this->id}");
		goBack();	
	}
	
	//first level - seminar type. I.e. `History`
	function view(){
		$sql = "SELECT * FROM seminarlessons WHERE seminar_id={$this->id} ORDER BY title ASC";
		$this->title = DBcell("SELECT name FROM seminars WHERE id={$this->id}");
		return DBall($sql);
	}
	
	//second level - seminar lesson with list of questions. I.e. `Eastern Slavs in 10th century`
	function lesson(){
		$sql = "SELECT * FROM seminarquestions WHERE seminarlesson_id={$this->id} order by `order` ASC";
		$this->title = DBcell("SELECT name FROM seminarlessons WHERE id={$this->id}");
		$this->params['literature'] = str_replace("\n","<br>",DBcell("SELECT literature FROM seminarlessons WHERE id={$this->id}"));
		return DBall($sql);
	}
	
	//third level - exact question
	function question(){
		$this->params['ad'] = TRUE;
		$sql = "SELECT * FROM seminarquestions WHERE id={$this->id}";
		$row = DBrow($sql);
		$_tags = DBcol("SELECT tag FROM seminar_tags WHERE seminar_id={$this->id}");
		$tags = implode("','", $_tags);
		$row['recommended'] = DBall("
		SELECT id,  `type` , title, total
		FROM (
			SELECT s1.id,  'seminars/question/' AS  `type` , s1.question AS title, COUNT( st1.tag ) AS total
			FROM seminarquestions s1
			JOIN seminar_tags st1 ON st1.seminar_id = s1.id
			WHERE st1.tag IN ('$tags')  AND s1.id!={$this->id} 
			GROUP BY s1.id
			UNION 
			SELECT s2.id,  'summaries/view/' AS  `type` , s2.name AS title, COUNT( st2.tag ) AS total
			FROM summaries s2
			JOIN summary_tags st2 ON st2.summary_id = s2.id
			WHERE st2.tag IN ('$tags') 
			GROUP BY s2.id
		)t
		ORDER BY total DESC , title ASC
		LIMIT 0,5
		");
		
		/*$row['seminars'] = DBall("SELECT s.*, COUNT( st.tag ) AS total FROM seminarquestions s JOIN seminar_tags st ON st.seminar_id = s.id WHERE st.tag IN ('$tags')  AND s.id!={$this->id} 
		GROUP BY s.id ORDER BY total DESC, question ASC");
		$row['summaries'] = DBall("SELECT s.*, COUNT( st.tag ) AS total  FROM summaries s JOIN summary_tags st ON st.summary_id = s.id WHERE st.tag IN ('$tags') GROUP BY s.id ORDER BY total DESC, name ASC");*/
		$this->title = $row['question'];	
		$data['answer'] = str_replace('<br /><br />&nbsp;<br /><br />',$data['answer']);
		$_tags = trim(implode(", ", $_tags));
		if($_tags != '') setVar('meta_keywords',$_tags);		
		return $row;
	}
	
	//list of my seminars
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
		$sql .=" ORDER BY name ASC"; 
			return DBall($sql);
	}
	
	//top level - all universities
	function all() {
		$sql =  sprintf("SELECT * FROM universities");		
		return DBall($sql);
	}
	
	/*//university - list of faculties
	function uni() {
		$sql =  sprintf("SELECT * FROM faculties WHERE uni_id=%d", $this->id);		
		return DBall($sql);
	}
	
	//faculty - list of specializations
	function faculty() {
		$sql =  sprintf("SELECT * FROM specialization WHERE faculty_id=%d ORDER BY name ASC", $this->id);		
		return DBall($sql);
	} */
	
	
	//faculty lessons
	function lessons() {		
		/*$spec = (int)$this->id;			if ($spec == 0) $spec = (int)getVar('edu_spec'); 
		$term = (int)$this->path[3];	if ($term == 0) $term = (int)getVar('edu_term'); if ($term == 0) $term = 1;
		
		$sql  =  sprintf("SELECT * FROM seminars WHERE (specialization_id=%d OR specialization_id=0) AND term_id=%d ORDER BY name ASC", $spec, $term);*/
		
		//inspect($this->session); die();
		
		$uni = $this->id; 
		if($uni != getVar('edu_uni')) {
			setVar('edu_fac', '');
			setVar('edu_spec','');
			setVar('edu_term','');
		}
		//setVar('edu_uni',$uni);
		
		$this->title = DBcell("SELECT name from universities WHERE id={$this->id}");
		
		if(isset($this->path[3])) setVar('edu_fac',  (int)$this->path[3]);
		if(isset($this->path[4])) setVar('edu_spec', (int)$this->path[4]);
		if(isset($this->path[5])) setVar('edu_term', (int)$this->path[5]);
		
		$fak =  (int)getVar('edu_fac');
		$spec = (int)getVar('edu_spec');
		$term = (int)getVar('edu_term');
		
		$sql = "SELECT * FROM seminars WHERE visible";
		if ($fak > 0) {
			$sql .= " AND faculty_id=$fak";
		} else {
			$sql .= ' AND faculty_id IN ('.join(',',DBcol("SELECT id FROM faculties WHERE uni_id=$uni")).')';
		}
		
		if ($spec > 0) 
			$sql .= " AND (specialization_id=$spec OR specialization_id=0)";
			
		if ($term > 0)
			$sql .= " AND term_id=$term";
		
		$sql .=" ORDER BY name ASC";		
		
			//echo $sql;
		return DBall($sql);		
	}

	//selecting where to redirect user;
	function levelselect() {
	
		/*if (getVar('edu_term') > 0)
			redirect(BASE_PATH.'seminars/lessons/'. getVar('edu_spec'). '/' . getVar('edu_term'));
		elseif (getVar('edu_spec') > 0)
			redirect(BASE_PATH.'seminars/spec/'. getVar('edu_spec'));
		elseif (getVar('edu_fac') > 0)
			redirect(BASE_PATH.'seminars/fak/'. getVar('edu_fac'));
		elseif (getVar('edu_uni') > 0)
			redirect(BASE_PATH.'seminars/uni/'. getVar('edu_uni'));
		else
			redirect(BASE_PATH.'seminars/all');*/
		
		//inspect($this->session);
		
		//inspect($this->session); die();
		if ((int)getVar('edu_uni') == 0 ||
			(int)getVar('edu_city') == 0 ||
			(int)getVar('edu_country') == 0 ) {
			redirect(BASE_PATH.'seminars/all');
		} else {
			redirect( BASE_PATH.'seminars/lessons/'. (int)getVar('edu_uni') . '/' . (int)getVar('edu_fac') . '/' . (int)getVar('edu_spec') . '/' . (int)getVar('edu_term') );
		}
		
		/*if (getVar('edu_uni') == 0 ||
			getVar('edu_city') == 0 ||
			getVar('edu_country') == 0 )	
			redirect(BASE_PATH.'seminars/all');
		elseif (getVar('edu_fac') == 0)	
			redirect(BASE_PATH.'seminars/uni/'. getVar('edu_uni'));
		elseif (getVar('edu_spec') == 0)
			redirect(BASE_PATH.'seminars/faculty/'. getVar('edu_fac'));
		elseif (getVar('edu_term') == 0)
			redirect(BASE_PATH.'seminars/spec/'. getVar('edu_spec'));
		else
			redirect(BASE_PATH.'seminars/lessons/'. getVar('edu_spec'). '/' . getVar('edu_term'));*/
	}
	
	function spec() { }
	
	
	function showhide(){
		$sql = sprintf("UPDATE seminars SET visible = ABS(visible-1) WHERE id=%d", $this->id); //echo $sql; die();
		DBquery($sql); 
		redirect(BASE_PATH.'seminars/items'); die();
	}
}

?>