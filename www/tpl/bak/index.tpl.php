<!DOCTYPE html>
<html>
	<head>
		<title><? if ($title != '' ) echo $title . ' | ';?>Bookster</title>
		<LINK REL="SHORTCUT ICON" href="<?=BASE_PATH;?>www/img/icon.png">
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<meta name="google-site-verification" content="XZVFMF7bF0WRPqxUFzbLjwo7MERj9Spm7sIEJqsFaG8" />
		<link rel="stylesheet" type="text/css" href="<?=PUB;?>style.css"> 
		<script language="javascript" src="<?=BASE_PATH;?>ajax.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>
		<script language="javascript" src="<?=BASE_PATH;?>ajax.js"></script>
		<script language="javascript" src="<?=BASE_PATH;?>ckeditor/ckeditor.js"></script>
		<script language="javascript"><?=stpl('functions.js');?>
		CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
		CKEDITOR.config.width ='750px';
		CKEDITOR.config.height='300px';
		</script>
		<script language="javascript">jQuery.noConflict();</script>
	</head>	
	<body>
		<center>
		<div class="wrap">
			<div class="header inside">
				<div class="submenu td"> <? $homepath = BASE_PATH.($_SESSION['user']['id']==17?'boyko':'id'.$_SESSION['user']['id']);?>
					<a href="<?=$homepath;?>"><img src="<?=PUB;?>img/logo.png" height="27px" border=0 style="padding-right:12px !important;" class="logosml"></a>
					<a href="<?=$homepath;?>" onmouseover="showHideH('home')" onmouseout="showHideH('home')">
						<img src="<?=PUB;?>img/home.png" id="i_home"  class="menupic">
						<span class="des" id="home"><?=T('home');?></span>
					</a>
					<a href="<?=BASE_PATH;?>lectures" onmouseover="showHideH('lectures')" onmouseout="showHideH('lectures')">
						<? if($class=='lectures') { ?><img src="<?=PUB;?>img/lectures_h.png"  class="menupic"> <? } else { ?><img src="<?=PUB;?>img/lectures.png" id="i_lectures"  class="menupic"><? } ?>
					<span class="des" id="lectures"><?=T('lectures');?></span>
					</a>
					<a href="<?=BASE_PATH;?>seminars" onmouseover="showHideH('seminars')" onmouseout="showHideH('seminars')">
						<? if($class=='seminars') { ?><img src="<?=PUB;?>img/seminars_h.png"  class="menupic"> <? } else { ?><img src="<?=PUB;?>img/seminars.png" id="i_seminars"  class="menupic"><? } ?>
						<span class="des" id="seminars"><?=T('seminars');?></span>
					</a>
					<a href="<?=BASE_PATH;?>summaries" onmouseover="showHideH('summaries')" onmouseout="showHideH('summaries')">
						<? if($class=='summaries') { ?><img src="<?=PUB;?>img/summaries_h.png"  class="menupic"> <? } else { ?><img src="<?=PUB;?>img/summaries.png" id="i_summaries"  class="menupic"><? } ?>
						<span class="des" id="summaries"><?=T('summaries');?></span>
					</a>
				<!--<a href="<?=BASE_PATH;?>courseworks" onmouseover="showHide('course')" onmouseout="showHide('course')">
						<img src="<?=PUB;?>img/referats.png">
						<span class="des" style="left:360" id="course"><?=T('course');?></span>
					</a>-->
					<a href="<?=BASE_PATH;?>tips" onmouseover="showHideH('tips')" onmouseout="showHideH('tips')">
						<? if($class=='tips') { ?><img src="<?=PUB;?>img/tips_h.png"  class="menupic"> <? } else { ?><img src="<?=PUB;?>img/tips.png" id="i_tips"  class="menupic"><? } ?>
						<span class="des" id="tips"><?=T('tips');?></span>
					</a>
					
					<? 
					/*	 $modules= array(
								'seminars',
								'referats',
							);
					foreach ($modules as $module){ ?>
						<!--<a href="<?=BASE_PATH.$module;?>"><?=T($module);?></a> -->
						<? } */?>
				</div>
				<div class="td userdiv">
					<? 
					$id =	$_SESSION['user']['id']; // inspect($_SESSION);
					$data = DBrow("SELECT * FROM users WHERE id='".$_SESSION['user']['id']."'");
					$sql = "SELECT count(id) FROM alerts WHERE fid='$id' AND `time`>'".$data['lastalertcheck']."'"; //echo $sql;
					$alerts = DBcell($sql);
					$sql = "SELECT count(id) FROM mail WHERE `to`='$id' AND `time`>'".$data['lastmsgcheck']."'"; // echo $sql;
					$msgs = DBcell($sql);
					?>
					<a href="<?=BASE_PATH;?>feed"><img src="<?=PUB;?>img/friends<?=($alerts>0?'new':'');?>.png" style="margin-top:-4px;" align="absmiddle"></a> 
					<a href="<?=BASE_PATH;?>mail"><img src="<?=PUB;?>img/msgs<?=($msgs>0?'new':'');?>.png" style="margin-top:-2px;" align="absmiddle"></a>		
					<a href="javascript:void(0);" onclick="showHide('dropdownmenu1')"><?=$_SESSION['user']['name'].' '.$_SESSION['user']['surname']?> <img src="<?=PUB;?>img/arr.png" align="absmiddle"></a>
						<div id="dropdownmenu1"  class="dropdownmenu">
							<a href="<?=BASE_PATH;?>mail"><?=T('inbox');?></a>
							<a href="<?=BASE_PATH;?>groups"><?=T('groups');?></a>
							<a href="<?=BASE_PATH;?>analytics"><?=T('stats');?></a>
							<!--<a href="<?=BASE_PATH;?>users/upphoto"><?=T('upload photo');?></a><br>-->
							<a href="<?=BASE_PATH;?>settings"><?=T('settings');?></a>
							<!--<a href="<?=BASE_PATH;?>users/education"><?=T('my education');?></a><br> -->
							<a href="<?=BASE_PATH;?>users/logout"><?=T('logout');?></a>	
							
							
								<!-- <?  $modules= array(
										'users',
										
									);
									foreach ($modules as $module){ ?>
								<a href="<?=BASE_PATH.$module;?>"><?=T($module);?></a> <br>
								<? } ?> -->
							<!--<a href="#"><?=T('Settings');?></a><br>-->
						</div>	
					
					<? if(IsAdmin()){ ?>
						<a href="javascript:void(0);" onclick="showHide('dropdownmenu2')"> <img src="<?=PUB;?>img/wheel.png" height=10></a>
							<div id="dropdownmenu2" class="dropdownmenu">
									<? $modules= array(
											//'users',
											'globals' => T('adm_globs'),
											'pages' => T('adm_pages'),
											'langs' => T('adm_langs'),
											'help/items' => T('adm_help'),											
											'countries' => T('adm_countries'),
											'cities' => T('adm_cities'),
											'universities' => T('adm_unis'),
											'faculties' => T('adm_facs'),
											'specialization' => T('adm_spec'),
											//'labels',
											//'subjects',
											'seminars/items' => T('adm_sem1'),
											'seminarlessons' => T('adm_sem2'),
											'seminarquestions' => T('adm_sem3'),
											'refcategories' => T('adm_ref1'),
											'summaries/items' => T('adm_ref2'),
											'mksitemap' => T('make a sitemap'),												
										);
 foreach ($modules as $k => $v){ ?>
         <a href="<?=BASE_PATH.$k;?>"><?=T($v);?></a> 
         <? } ?>
								<!--<a href="#"><?=T('Settings');?></a><br>-->
							</div>	
					<? } ?>	
				
					<br> <? //inspect($path); 
					if($path[0] == 'search' ) $val = $path[1]; else $val = T('search'); ;?>
						<input type="text"  class="search" id="eSearch" value="<?=$val;?>" onfocus="empt(this,'<?=T('search');?>')" onblur="chk(this,'<?=T('search');?>')" onkeypress="clickSearch(event,'<?=BASE_PATH;?>','eSearch','');"> 
				</div>
				
			</div>

	
	
			<div class="content">
				<div class="wrapper">
					<?=$content;?>
				</div>
			</div>
			
			<div class="footer">
				<?=tpl('footer');?>
			</div>	
		</div>
		<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29509274-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	</body>
</html>