<?php
class courseworks extends masterclass{



	function getOptions(){
		$this->defFunc = 'default'; $this->tpl = 'referats';
		$sql = "SELECT * FROM refcategories";// echo $sql;
		$cats = DBall($sql);
		$ret = array();
		$this->options['cat_id'] = array( 0 => '---' ); 
		foreach($cats as $cat){
			$this->options['cat_id'][$cat['id']] = $cat['name'];
		}
		
		$sql = "SELECT * FROM langs WHERE enabled";// echo $sql;
		$langs = DBall($sql);
		$this->options['lang'] = array( 0 => '---' ); 
		foreach($langs as $lang){ $this->options['lang'][$lang['id']] = $lang['name']; }
		//inspect($this->options);
	}
}

?>