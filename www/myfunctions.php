<?
function pub_doLogin()
{
	$sql = "SELECT * from users where login='".getPost('login')."' AND pass=md5('".getPost('pass')."')"; 
	//inspect($sql); die();
	if (DBnumrows($sql)>0){
		$user = DBrow($sql);
		$user['logged'] = 1;
		setVar('admin',$user);		
	}
	goBack();
}

function pub_doLogout()
{
	unsetVar('admin');
	unsetVar('logged');
	//print_r($_SESSION); die();
	//debug(getVar('user'));
}

function trimString ($str, $count)
{
      $sub = substr($str, 0, $count);
      if(strlen($str)>strlen($sub)){
           return $sub . '...' ;
      }else{
            return $str;
      }
}

function addAd($content){
	$find = htmlentities('<br /><br /><br />');
	$pos1 = strpos($content, $find);
	//$pos2 = strpos($content, $find, $pos1 + strlen($find)); 
	$ret =  substr($content,0, $pos1) . '<br /><br />' . tpl('adgoogle') . '<br /><br />' . substr($content,$pos1 +strlen($find));
	return $ret;
}

function addSemAd($matches) { 
	setVar('ad', getVar('ad') + 1);
	if(getVar('ad') == 3)
		return '<br /><br />' . tpl('adgoogle') . '<br /><br />';
}

?>