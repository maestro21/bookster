<table width="100%" cellpadding="0">
	<tr>
		<td width="800">
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
		<td width="100">
			<? $countries = array (
				'ru' => 'Русский',
				'en' => 'English',
				'ua' => 'Українська',
				); 
			$lang = getVar('lang','ua');
			?>
			<div class="langselect">	
				<a href="javascript:void(0)" onclick="showHide('langdropdown')">
					<img src="<?=PUB;?>img/<?=$lang;?>.png"> &nbsp;
					<b><?=$countries[$lang];?></b>
				</a>
				<? unset($countries[$lang]); ?>
				<div id="langdropdown">
					<? foreach ($countries as $k=>$v){ ?>
						<a href="<?=BASE_PATH;?>filter/lang/<?=$k;?>">
							<img src="<?=PUB;?>img/<?=$k;?>.png"> &nbsp;<b><?=$v;?></b>
						</a>
					<? } ?> 
				</div>
			</div>
			<div align="left" class="copy">&copy; <?=date('Y');?> Bookster</div>
		</td>
	</tr>
</table>

