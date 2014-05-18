<?php

class search extends masterclass{

	function extend(){  $this->search = $this->do; $this->do = 'items'; }
	
	
	function items(){
		//die('111');
		$module = ($this->id!=''?$this->id:'seminars');
		//if($module=='papers') $module='referats';
		$search = $this->search;
		$this->id = $this->search;
		$this->do = 'items';
		$fields = array(
			'summaries' => array( 
					'name',
					'content',
					'countsql' => 'SELECT count(id) from summaries',
				),	
							
			'users' => array( 
				'u`.`name',
				'u`.`surname',
				'sql' => 'SELECT u.*, uni.name as university from users u LEFT JOIN universities uni ON uni.id=u.uni_id',
				'countsql' => 'SELECT count(id) from users u',
				),	
			'seminars' => array(
				'sql' => 'SELECT * FROM seminarquestions',
				'countsql' => 'SELECT count(id)  FROM seminarquestions',
				'question',
				'answer',
				/*'sql' => 'SELECT s . * , t.questions, t.answers
						FROM (				
							SELECT seminarlesson_id AS sid,
								 GROUP_CONCAT( ss.question ) AS questions,
								 GROUP_CONCAT( ss.answer ) AS answers
							FROM seminarlessons s
							RIGHT JOIN seminarquestions ss ON ss.seminarlesson_id = s.id
							GROUP BY seminarlesson_id
						) AS t
						LEFT JOIN seminarlessons s ON s.id = t.sid',
				'countsql' => 'SELECT count(id)
						FROM (				
							SELECT seminarlesson_id AS sid,
								 GROUP_CONCAT( ss.question ) AS questions,
								 GROUP_CONCAT( ss.answer ) AS answers
							FROM seminarlessons s
							RIGHT JOIN seminarquestions ss ON ss.seminarlesson_id = s.id
							GROUP BY seminarlesson_id
						) AS t
						LEFT JOIN seminarlessons s ON s.id = t.sid',


				'questions',
				'answers',
				'name', */
				),	
				
			);
		$this->params['searchmodule'] = $module; //echo $module;
		$sql = '';	$sqlcount = '';
		$this->params['whereToSearch'] = array( 'seminars','users','summaries');
		/*foreach ($fields as $field =>$arr){
			$this->params['whereToSearch'][] = $field;
		}*/
		$tmp = array();
		if(isset($fields[$module]['sql'])){
			$sql = $fields[$module]['sql'];
			unset($fields[$module]['sql']);
		}else
			$sql = "SELECT * from $module";
			
		if(isset($fields[$module]['countsql'])){
			$sqlcount = $fields[$module]['countsql'];
			unset($fields[$module]['countsql']);
		}else
			$sqlcount = "SELECT * from $module";	
			
		foreach($fields[$module] as $field)
			$tmp[] = " `$field` LIKE '%".addslashes($search)."%' ";			
			
		$cond = join("OR",$tmp);// echo $cond;
		if($cond!=''){
			$sql .= " WHERE $cond";
			$sqlcount .= " WHERE $cond";
		}
		//echo $sql;
		$this->pages =  DBcell($sqlcount); //echo $sqlcount;
		return DBall($sql);
		//echo $this->sql['count'];
		//$this->sql['checktable'] = "show tables like '$module'";
		//echo $this->sql['items'];
	}


} ?>