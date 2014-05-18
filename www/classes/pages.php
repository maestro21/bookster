<?php
class pages extends masterclass
{
    function extend()
    {
        if ($this->path[0] != 'pages' && $this->path[0] != '')
            $this->defFunc = 'view';
        $langs = DBall("SELECT * FROM langs");
        foreach ($langs as $lang) {
            $this->options['lang'][$lang['abbr']] = $lang['name'];
        }
        $this->tpl = $this->className = 'pages';
		if($this->path[0] == 'sitemap') $this->defFunc = 'sitemap';
		if($this->path[0] == 'mksitemap') $this->defFunc = 'mksitemap';
    }
	
	function mksitemap(){
		if(isAdmin()){
			$pages =  DBcol("SELECT url FROM pages GROUP BY url");
			$sq  =  DBcol("SELECT id FROM seminarquestions");
			$sm  =  DBcol("SELECT id FROM summaries");
			$f = fopen("sitemap.xml","w");
			fwrite($f,"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
				<urlset
					  xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
					  xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
					  xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
							http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\"><url>
				  <loc>http://bookster.com.ua/</loc>
				</url>"
			);
			foreach ($pages as $page){
				fwrite($f,"<url>
				  <loc>".BASE_PATH.$page."</loc>
				</url>");
			}
			
			foreach ($sq as $q){
				fwrite($f,"<url>
				  <loc>".BASE_PATH.'seminars/question/'.$q."</loc>
				</url>");
			}
			
			foreach ($sm as $s){
				fwrite($f,"<url>
				  <loc>".BASE_PATH.'summaries/view/'.$s."</loc>
				</url>");
			}
			
			fwrite($f,"</urlset>");
			fclose($f);
		}
	}	
	
	function sitemap(){
		$data =  DBall("SELECT id,question FROM seminarquestions");
		return $data;
	}
	
    function view()
    {
		$this->maintpl = 'page';
		$forbidden 	= array_flip(array('lectures', 'tips', 'groups', 'analytics', 'careers', 'about', 'privacy'));
	
        $sql              = "SELECT * FROM pages WHERE lang = '" . getVar('lang') . "' AND url='" . $this->path[0] . "'";
        $data             = DBrow($sql);
        $this->showheader = false;
		$this->title 	  = $data['title'];
        if ($data && !isset($forbidden[$data['url']]))
            return $data;
        else
            $this->do = 'error';
    }
	
    function item()
    {
        if ($this->id > 0)
            return dbrow("SELECT * FROM pages WHERE id='{$this->id}'");
        else
            return array();
    }
	
    function items()
    {
        $sql = "SELECT id,lang,url,title FROM pages ";
        if ($this->page > 0) $this->page--;
        $sql .= " LIMIT " . $this->page * $this->perpage . "," . $this->perpage;
        $res         = DBall($sql);
        $this->pages = ceil(DBfield("SELECT count(id) FROM pages") / $this->perpage);
		$this->page++;
        return $res;
    }
	
    function del()
    {
        $sql = "DELETE * FROM pages WHERE id='{$this->id}'";
        return DBquery($sql);
    }
	
    function save()
    {
        $data = $this->post['form'];
        $sql  = " pages SET
			lang ='" . parseString($data['lang']) . "',
			url ='" . parseString($data['url']) . "',
			title ='" . parseString($data['title']) . "',
			text ='" . parseString($data['text']) . "'";
        if ($this->id > 0) {
            $sql = "UPDATE $sql WHERE id='" . (int) $this->id . "'";
            ;
            DBquery($sql);
        } else {
            $ret = DBquery("INSERT INTO $sql");
            if ($ret)
                $this->id = DBinsertId();
        }
        redirect(BASE_PATH . 'pages/item/' . $this->id);
    }
}
?>