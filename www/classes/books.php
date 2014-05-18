<?php
class books extends masterclass
{
    function extend()
    {

    }	
	
	function up() {
		if($this->files['file']) {
			file_put_contents('up/books/tmp.tmp',file_get_contents($this->files['file']['tmp_name']),FILE_APPEND);
		}
		die();
	}
	

    function items()
    {
        $sql = "SELECT *  FROM books ";
        if ($this->page > 0) $this->page--;
        $sql .= " LIMIT " . $this->page * $this->perpage . "," . $this->perpage;
        $res         = DBall($sql);
        $this->pages = ceil(DBfield("SELECT count(id) FROM books") / $this->perpage);
		$this->page++;
        return $res;
    }
	
    function del()
    {
        $sql = "DELETE * FROM books WHERE id='{$this->id}'";
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
				rename('up/books/tmp.tmp','up/books/' . $this->id . '.pdf');
        }
        redirect(BASE_PATH . 'pages/item/' . $this->id);
    }
}
?>