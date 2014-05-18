<div class="wrapdiv">
<? if(isAdmin() && $showheader){ ?>
<table class="admSearchTable">	
		<td width="175">		
			<h1>
				<a href="<?=$pre.$class?>">	<?=T('adm_ref1');?></a>		
				<a href="<?=$pre.$class?>/item" class="plusindent"> <img title="<?=T('hint_add');?>" src="<?=PUB;?>img/admadd.png"></a>
			</h1>	 
		</td>

		<td>
			<input type="text" class="bigsearch search" id="search" name="search" value="<?=$search;?>">
		</td>

		<td>		
			<div class="searchpic" onclick="doSearch('<?=$path.$class?>')">
			<img src="<?=PUB;?>img/search-white.png">	</div>
		</td>		
		</table>

		<hr color="lightgray">
<? } ?>
<?php switch($do){ 

	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	//Initialization - installation
	case 'ini': echo T('ini_msg');
	break;
	
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Items list - default function	
	case 'items' : ?>
	<table class="admSearchTableMain" cellspacing="0">
	<tr>
		<thead>
			<td width="240"><b><font color="3e3e3e"><?=T('adm_category_ua');?></font></b></td>
			<td width="240"><b><font color="3e3e3e"><?=T('adm_category_ru');?></font></b></td>
			<td width="240"><b><font color="3e3e3e"><?=T('adm_category_en');?></font></b></td>
			<td width="60" align="center"><b><font color="3e3e3e"><?=T('adm_options');?></font></b></td>
		</thead>
	</tr>
	<?php  foreach ($data as $row){ 
		$id = $row['id'];?>
		<tr>
		<td>
			<?=$row['name_ua'];?>
		</td>
		<td>
			<?=$row['name_ru'];?>
		</td>
		<td>
			<?=$row['name_en'];?>
		</td>
		<? if(isAdmin()) { ?>	
			<td align="center">
				<a href="<?=$pre.$row['url'];?>">
					<img title="<?=T('hint_view');?>" src="<?=PUB;?>img/admview.png"></a>
				<a href="<?=$pre.$class?>/item/<?=$id;?>">
					<img title="<?=T('hint_edit');?>" src="<?=PUB;?>img/admedit.png"></a>
				<a href="javascript:void(0)" onclick="conf('<?=$pre.$class?>/del/<?=$id;?>')">
					<img title="<?=T('hint_delete');?>" src="<?=PUB;?>img/admdel.png"></a>
			</td>
		<? } ?>
		</tr>		
	<?}?> 
	</table>
	
	<div class="pagination">
		<?php echo pagination($page, $pages, $pre . $class . '/items/{p}/' . $search); ?>
	</div>		
	<?php break;
	
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Add\Edit  item
	case 'item' : ?>
		<form method="POST" action="<?=$pre.$class?>/save" id="refform">
		<input type="hidden" name="id" id="id" value="<?=$id;?>">
			<table class="admAddTable">
			<?php  // unset($data[0]); //inspect($data);  inspect($fields);?>
				<tr>
					<td align="right"><?=T('adm_name_ua');?>:</td>
					<td><input type=text value="<?=@$data['name_ua'];?>" name='form[name_ua]' id='name'></td>
				</tr>		
				<tr>
					<td align="right"><?=T('adm_name_ru');?>:</td>
					<td><input type=text value="<?=@$data['name_ru'];?>" name='form[name_ru]' id='name'></td>
				</tr>
				<tr>
					<td align="right"><?=T('adm_name_en');?>:</td>
					<td><input type=text value="<?=@$data['name_en'];?>" name='form[name_en]' id='name'></td>
				</tr>				
				<tr>
					<td></td>
					<td align="left">
						<a onclick="$('refform').submit()" href="javascript:void(0)">
						<div class="button insBtn" align="center"><?=T('adm_submit');?></div>
						</a>
					</td>
				</tr>
			</table>	
		</form>
	<?php break;
	
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Save
	case 'save' : echo T('save_msg'); redirect($pre.$class.'/item/'.$id,1);
	break;
		
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Delete
	case 'del' : echo T('del_msg'); redirect($pre.$class.'/items',1);
	break;

	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////

	// View
	case 'view' :  ?> <table>
		<?php foreach ($data as $k => $v){ ?>
			<tr>
				<td><?=T($k);?></td>
				<td><?=(isset($options[$k])?T($options[$k][$v]):$v);?></td>		
			</tr>	
		<?php	
		} ?>
		</table> <?php
	break;			
	
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////

	//Error
	
	default : include('halepa.tpl.php'); break;

	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////

 } ?> 	
</div>