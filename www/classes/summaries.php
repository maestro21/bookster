<?php
class summaries extends masterclass{



	function extend(){
		//$this->perpage = 1;
		$this->defFunc = '_default';
		$sql = "SELECT * FROM refcategories order by name_".getVar('lang')." asc";// echo $sql;
		$cats = DBall($sql);
		$ret = array();
		$this->options['cat_id'] = array(); 
		foreach($cats as $cat){
			$this->options['cat_id'][$cat['id']] = $cat['name_'.getVar('lang')];
		}
		
		$sql = "SELECT * FROM langs WHERE enabled";// echo $sql;
		$langs = DBall($sql);
		$this->options['lang'] = array( 0 => '---' ); 
		foreach($langs as $lang){ $this->options['lang'][$lang['abbr']] = $lang['name']; } 
		//inspect($this->options);
		
		$this->options['type'] = array( 0 => '---', 1 => T('summary'), 2 => T('course') );
		
		if($this->do == '_list') $this->ajax = true;
		$this->perpage = 50;
	}
	
	
	function _default(){
		$data = array(
			'type'  => $this->options['type'],
			'langs' => $this->options['lang'] ,
			'cats'	=> $this->options['cat_id'],
		);		
		return $data;
	}
	
	function cat(){
		$sql = "SELECT * FROM summaries WHERE cat_id='{$this->id}' AND lang='".getVar('lang')."'";
		return DBall($sql);
	}
	
	function rm(){
		$uid = (int)@$_SESSION['user']['id'];
		$sql = dbquery("DELETE FROM mysummaries WHERE userid='$uid' AND reportid={$this->id}");	
		goBack();
	}
	
	function add(){
		$uid = (int)@$this->session['user']['id']; //echo $uid; echo $this->id;
		if(!(int)DBcell("SELECT 1 FROM mysummaries WHERE userid='$uid' AND reportid={$this->id}"))
		dbquery("INSERT INTO mysummaries SET userid='$uid', reportid={$this->id}");
		goBack();	
	}

	function _list(){	
		//print_r($this->post); die();
		if($this->page == 0) $this->page = 1;
		
		$cond = " LEFT JOIN summaries_to_categories as s2c ON s2c.sum_id=s.id WHERE 1";
		
		$filters = array( 'type' => 'type', 'cats' => 's2c`.`cat_id', 'langs' => 'lang' );
		
		foreach ($filters as $k => $v) {
			if(!isset($this->post[$k.'_all'])){
				if($this->post[$k] == '') $this->post[$k] = array(0);
				$cond .= sprintf(" AND `$v` IN ('%s')", @implode("','", $this->post[$k]));
			}
		}		
		 
		$sql = "SELECT count(DISTINCT(s.id)) as total, `type` FROM summaries s $cond GROUP BY `type`"; //echo $sql;// die();
		$_res = DBall($sql); 
		$total = array();
		foreach ($_res as $row){
			$total[$row['type']] = $row['total'];
		}
		$this->params['total'] = $total;
		$this->pages = ceil( array_sum($total) / $this->perpage ); 
	
		$offset = ($this->page - 1) * $this->perpage;
		$sql = "SELECT DISTINCT s.* FROM summaries s $cond ORDER BY name ASC LIMIT $offset,".$this->perpage; 
		// $sql; die();
		return DBall($sql);
	}
	

	function items(){
		$this->pages = ceil( DBcell("SELECT count(id) FROM summaries") / $this->perpage );
		if($this->page>0) $this->page--;
		if(isAdmin()) $sql = ''; else $sql = " WHERE s.author_id = " . (int)@$this->session['user']['id'];
		$sql = "SELECT s.*, u.name AS author  FROM summaries s LEFT JOIN users u ON u.id = s.author_id $sql LIMIT ".$this->page*$this->perpage.",".$this->perpage; 
		$this->page++;
		return DBall($sql);
  	}
	
	function item(){	
		if($this->id>0) {
			$ret = DBrow("SELECT * FROM summaries WHERE id={$this->id}");
			$ret['cats'] = array_flip(DBcol("SELECT cat_id FROM summaries_to_categories WHERE sum_id={$this->id}"));
			$ret['tags'] = implode(',',DBcol("SELECT tag FROM summary_tags WHERE summary_id={$this->id}"));
			return $ret;
		}		
		return array();
    }
    
	function view(){
		$this->params['ad'] = TRUE;
		if($this->id>0) {
			$row = DBrow("SELECT * FROM summaries WHERE id={$this->id}");
			$this->title = $row['name'];
			$_tags = DBcol("SELECT tag FROM summary_tags WHERE summary_id={$this->id}");
			$tags = implode("','", $_tags);
			$row['recommended'] = DBall("
			SELECT id,  `type` , title, total
			FROM (
				SELECT s1.id,  'seminars/question/' AS  `type` , s1.question AS title, COUNT( st1.tag ) AS total
				FROM seminarquestions s1
				JOIN seminar_tags st1 ON st1.seminar_id = s1.id
				WHERE st1.tag IN ('$tags')
				GROUP BY s1.id
				UNION 
				SELECT s2.id,  'summaries/view/' AS  `type` , s2.name AS title, COUNT( st2.tag ) AS total
				FROM summaries s2
				JOIN summary_tags st2 ON st2.summary_id = s2.id
				WHERE st2.tag IN ('$tags')  AND s2.id!={$this->id}  
				GROUP BY s2.id
			)t
			ORDER BY total DESC , title ASC
			LIMIT 0,5
			");
			/*$row['summaries'] = DBall("SELECT s.* , count(st.tag) as total FROM summaries s JOIN summary_tags st ON st.summary_id = s.id WHERE st.tag IN ('$tags') AND s.id!={$this->id} GROUP BY s.id ORDER BY total DESC, name ASC");
			$row['seminars'] = DBall("SELECT s.* , count(st.tag) as total FROM seminarquestions s JOIN seminar_tags st ON st.seminar_id = s.id WHERE st.tag IN ('$tags') GROUP BY s.id ORDER BY total DESC, question ASC");*/
			$_tags = trim(implode(", ", $_tags));
			if($_tags != '') setVar('meta_keywords',$_tags);
			return $row;
		}
		return array();	
	}		

	function del(){
     		if(isAdmin())  return DBquery("DELETE FROM summaries WHERE id={$this->id}"); else return false;
     	}
     	
    function save(){	
     	$data  = $this->post['form'];
		$sql = "lang 	='".addslashes(htmlspecialchars($data['lang']))."',
			content ='".addslashes(htmlspecialchars($data['content']))."',
			type 	='".(int)($data['type'])."',
			name 	='".addslashes(htmlspecialchars($data['name']))."'";

		if($this->id>0){ 
			$sql = "UPDATE summaries SET $sql WHERE id={$this->id}";			
			DBquery($sql); 
		}else{ 	
			$res = DBcell("SELECT 1 FROM summaries WHERE name='".addslashes(htmlspecialchars($data['name']))."'");
			if($res){
				$this->do = 'alreadyexist';
				return false;
			}
		
			$uid = (int)@$this->session['user']['id']; 
			$sql = "INSERT INTO summaries SET author_id=$uid, $sql";
			$ret = DBquery($sql);
			if($ret) $this->id = DBinsertId();// die(inspect($this->id));
		}
		
		$sql = "DELETE FROM summaries_to_categories WHERE sum_id = " .$this->id;
		DBquery($sql);
		if(	$data['cats'] ){
			foreach($data['cats'] as $cat){
				$sql = "INSERT INTO summaries_to_categories SET sum_id={$this->id}, cat_id=$cat";
				DBquery($sql);
			}
		}
		
		$sql = "DELETE FROM summary_tags WHERE summary_id = " .$this->id;
		DBquery($sql);
		$data['tags'] = explode(',',$data['tags']);
		if(	sizeof($data['tags']) > 0 ){
			foreach($data['tags'] as $tag){
				$tag = addslashes(htmlspecialchars(trim($tag)));
				$sql = "INSERT INTO summary_tags SET summary_id={$this->id}, tag='$tag'";
				DBquery($sql);
			}
		}
		
		redirect(BASE_PATH.'summaries/item/'.$this->id);	
     }
	
	function checkname() {
		$name = $this->post['name'];
		$res  = !(bool)DBcell("SELECT 1 FROM summaries WHERE name='$name'");
		if($res) echo "ok"; else echo "error";
		die();
	}
	
}

?>