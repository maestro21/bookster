<?php if(CheckLogged()) { ?>
	<div class="submenu td page"> 
		<?php $homepath = BASE_PATH; ?>
		<a href="<?=$homepath;?>"><img src="<?=PUB;?>img/logo.png" height="27px" border=0 class="logosml"></a>	
		<a href="<?=$homepath;?>" onmouseover="showHideH('home')" onmouseout="showHideH('home')">
			<img src="<?=PUB;?>img/home.png" id="i_home"  class="menupic">
			<span class="dropdownmenu mainmenu" id="home"><?=T('home');?></span>
		</a>
		<?php $menuitems = array(
					'courses',
					'seminars',
					'summaries',
					'tips',
				);
		foreach($menuitems as $menuitem) {?>					
			<a href="<?=BASE_PATH . $menuitem;?>" onmouseover="showHideH('<?php echo $menuitem;?>')" onmouseout="showHideH('<?php echo $menuitem;?>')">
				<? if($class == $menuitem) { ?><img src="<?=PUB;?>img/<?php echo $menuitem;?>_h.png"  class="menupic"> <? } else { ?><img src="<?=PUB;?>img/<?php echo $menuitem;?>.png" id="i_<?php echo $menuitem;?>"  class="menupic"><? } ?>
			<span class="dropdownmenu mainmenu" id="<?php echo $menuitem;?>"><?=T($menuitem);?></span>
			</a>
		<?php } ?>
	</div>	
	<div class="userdiv">
		<?php /**/ echo tpl('userblock'); /**/ ?>
	</div>					
<?php } else {?>
	<?php /**/ echo tpl('users',array('do'=>'login')); /**/ ?>
	<a href="javascript:void(0)" data-modal="modal-login" class="loginbtn sup t2 click">
		<img src="<?=BASE_PATH;?>www/img/first_login.png" align="absmiddle" height="32"> <?=T('login');?>
	</a>
	<a href="<?=BASE_PATH;?>">
		<img src="<?=BASE_PATH;?>www/img/logo.png" class="logosml">
	</a>
<? } ?>		

