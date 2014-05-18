<table width="970" cellpadding="0">
	<tr>
		<td width="790">
			<div>
				<a href="<?=BASE_PATH;?>help"><b><?=T('help');?></b></a>	

			<? $pages = DBall("SELECT * FROM pages WHERE lang='".getVar('lang','ua')."'"); $i=0; // inspect($pages);
				foreach ($pages as $page){ echo " &middot; ";  ?>

				<a href="<?=BASE_PATH;?><?=$page['url'];?>"><?=$page['title'];?></a><? /*$i++; if(sizeof($pages) != $i) */ }?> 
			</div>
			
			<div class="sharing">
				<a href="http://vk.com/bookster" target="_blank" class="vk"></a>
				<a href="http://www.facebook.com/bookstercom" target="_blank" class="fb"></a>
			</div>
		 </td>
		<td width="110">
			<? $countries = array (
				'ru' => 'Русский',
				'en' => 'English',
				'ua' => 'Українська',
				); 
			$lang = getVar('lang','ua');
			?>
			<div class="langselect">
				<a href="javascript:void(0)" onclick="showHide('langdropdown')">
					<b><?=$countries[$lang];?></b> &nbsp; <img src="<?=PUB;?>img/<?=$lang;?>.png">
				</a>
				<? unset($countries[$lang]); ?>
				<div id="langdropdown">
					<? foreach ($countries as $k=>$v){ ?>
						<a href="javascript:void(0)" onclick="changeLang('<?=$k;?>')">
							<b><?=$v;?></b>&nbsp; <img src="<?=PUB;?>img/<?=$k;?>.png">
						</a>
					<? } ?> 
					<div class="arrd"></div>
				</div>
			</div>
			<div align="left" class="copy">&copy; <?=date('Y');?> <a href="<?=BASE_PATH;?>">Bookster</a></div>
		</td>
	</tr>
</table>

