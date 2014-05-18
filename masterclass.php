<?php

class masterclass{
  	public $id;
	public $className;
	public $get;
	public $post;
	public $limit;
	public $content = '';
	public $do = '';
	public $fields = '';
	public $options = '';
	public $page = 0;
	public $perpage = 10;
	public $pages = 1;
	public $prefix = BASE_PATH; //'?q=';
	public $sql = array();
	public $tpl = 'default';
	public $adminMode = false;
	public $params = array();
	public $orderby = '';
	public $rights = array();
	public $files = '';
	public $defFunc = 'items';
	public $showheader = false;
	public $title = '';
	public $ajax = false;
	public $maintpl = 'page';

  	function __construct($do='',$id=''){
  		global $_GET, $_POST, $_SESSION, $_PATH, $_FILES;
  		$this->get = & $_GET;
  		$this->post = & $_POST;
		$this->session = & $_SESSION;
		$this->path = & $_PATH;
		$this->files = & $_FILES;
		$this->className =  (@$_PATH[0]!=''?$_PATH[0]:'default'); //get_class($this);
		$this->do =  ($do==''?(@$_PATH[1]!=''?$_PATH[1]:''):$do); 	
		//if($this->do == '') $this->do = $this->defFunc;		

		$this->id = ($id==''?(isset($this->post['id'])?$this->post['id']:@$_PATH[2]):$id);
		$this->page = (int)@$_PATH[2];
		$this->search = @$_PATH[3];
		$this->tpl = $this->className;//(file_exists( "tpl/".$this->className.".html")?$this->className:$this->tpl);
		$this->title = T($this->className);
		$this->extend();
		
  	}
	
	function checkRights(){
		if(IsSuperAdmin()) return true;
		if(IsAdmin()) return true;
		//if(HasRights($th
		
		
		return true;

		/*$u_rights = split(',',$this->session['user']['rights']);// = 'users_view,projects_items';
		$m_rights = $this->session['rights'][$this->className];// inspect($m_rights);
		$fc = $this->className . '_' . $this->do;
		

		

		if(isset($m_rights['allow'][$this->do])) return (!isset($u_rights[$fc]));
		
	

		if(isset($m_rights['deny'][$this->do])) return (isset($u_rights[$fc]));
		
		return (bool)$m_rights['default'];*/
	}
	

     
     // выводит содержимое
     function parse(){  
	$do =  $this->do; if($do == '') $do = $this->do = $this->defFunc; $data = '';  //if($this->checkRights()) echo "true"; else echo "false";
	//inspect($this->get);
	//echo $do;
			if($this->do == 'item' || $this->do == 'items') $this->showheader = true;
	if($this->checkRights()){ 
		if(method_exists($this,$do)){ 
			$data = $this->$do();
			//inspect($data); 
			if(is_array($data) && isset($data['id'])) unset($data['id']);
		}

		$this->params['class']		= $this->className;	
		$this->params['do']			= $this->do;
		$this->params['id']			= $this->id;
		$this->params['pre']		= $this->prefix;    //префикс перед запросом. На случай если не пашет .htaccess
		$this->params['data']		= $data;
		$this->params['fields']		= $this->fields;
		$this->params['p']			= $this->page;
		$this->params['page']		= $this->page;
		$this->params['pages']		= $this->pages;
		$this->params['search']		= $this->search;
		$this->params['options']	= $this->options;
		$this->params['rights']		= $this->rights; 
		$this->params['showheader'] = $this->showheader;
		$this->params['title'] 		= $this->title;
		$this->params['path']		= BASE_PATH;
		//inspect($this->params);
	} //echo //$this->content;
	//inspect($this->params);
	//echo PUB;
	//echo $this->className . ' | '. $this->tpl . ' | ' . $this->do;
	$this->content = tpl( $this->tpl , $this->params,$this->adminMode);
		//echo "&middot;";
	return $this->content;
     }
     
     
     
    

	//пустая функция для расширения наследниками, вызывается в конце __construct
	function extend(){}		

	
}


?>