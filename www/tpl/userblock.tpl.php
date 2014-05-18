<?php global $_PATH; $path = $_PATH; $_p = '_p';
	$id =	$_SESSION['user']['id']; // inspect($_SESSION);
	$data = DBrow("SELECT * FROM users WHERE id='".$_SESSION['user']['id']."'");
	$sql = "SELECT count(id) FROM alerts WHERE fid='$id' AND `time`>'".$data['lastalertcheck']."'"; //echo $sql;
	$alerts = DBcell($sql);
	$sql = "SELECT count(id) FROM mail WHERE `to`='$id' AND `time`>'".$data['lastmsgcheck']."'"; // echo $sql;
	$msgs = DBcell($sql);
	?>
	<div>
		<a href="<?=BASE_PATH;?>feed"><img src="<?=PUB;?>img/friends<?=($alerts>0?'new':$_p);?>.png" style="margin-top:-4px;" align="absmiddle"></a> 
		<a href="<?=BASE_PATH;?>mail"><img src="<?=PUB;?>img/msgs<?=($msgs>0?'new':$_p);?>.png" style="margin-top:-2px;" align="absmiddle"></a>
	</div>
	<div>	
		<a href="javascript:void(0);" onclick="showHide('dropdownmenu1');j('#dropdownmenu2').hide()"><?=$_SESSION['user']['name'].' '.$_SESSION['user']['surname']?> <img src="<?=PUB;?>img/arr.png" align="absmiddle"></a>
		<div id="dropdownmenu1"  class="dropdownmenu<?php if(IsAdmin() || HasRights()) echo " ddm1"; ?>">
			<div class="arrt"></div>
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
	</div>
	<?php if(IsAdmin() || HasRights('administer')){ ?>
	<div>
		<a href="javascript:void(0);" onclick="showHide('dropdownmenu2');j('#dropdownmenu1').hide()"> <img src="<?=PUB;?>img/wheel.png" style="height:10px !important;vertical-align:middle;"></a>
			<div id="dropdownmenu2" class="dropdownmenu">
				<div class="arrt"></div>
					<? 
						$rights = array(
							'summaries/items' => 'upload summaries' 
						);
						$modules= array(
							'globals' 			=> T('adm_globs'),
							'pages' 			=> T('adm_pages'),
							'langs' 			=> T('adm_langs'),
							'help/items' 		=> T('adm_help'),											
							'countries' 		=> T('adm_countries'),
							'cities' 			=> T('adm_cities'),
							'universities' 		=> T('adm_unis'),
							'faculties' 		=> T('adm_facs'),
							'specialization' 	=> T('adm_spec'),
							'seminars/items' 	=> T('adm_sem1'),
							'seminarlessons' 	=> T('adm_sem2'),
							'seminarquestions' 	=> T('adm_sem3'),
							'refcategories' 	=> T('adm_ref1'),
							'summaries/items' 	=> T('adm_ref2'),
							'mksitemap' 		=> T('make a sitemap'),												
						);
			foreach ($modules as $k => $v){ if(IsAdmin() || HasRights((isset($rights[$k])?$rights[$k]:'admin'))) {?>
				<a href="<?=BASE_PATH.$k;?>"><?=T($v);?></a> 
			<? } } ?>
				<!--<a href="#"><?=T('Settings');?></a><br>-->
			</div>
	</div>			
	<? } ?>
	
	
	<br> <? 
	if($path[0] == 'search' ) $val = $path[1]; else $val = T('search'); ;?>
		<input type="text"  class="search inactive" id="eSearch" value="<?=$val;?>" onfocus="empt(this,'<?=T('search');?>', null, 'search')" onblur="chk(this,'<?=T('search');?>',null,'search')" onkeypress="clickSearch(event,'<?=BASE_PATH;?>','eSearch','');"> 
