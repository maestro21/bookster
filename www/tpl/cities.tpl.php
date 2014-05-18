<div class="wrapdiv">
<? if(isAdmin() && $showheader){ ?>
<table class="admSearchTable">
	<tr>
		<td width="175">
			<h1>
			<a href="<?=$pre.$class?>/items"><?=T('adm_cities');?></a>
			<a href="<?=$pre.$class?>/item" class="plusindent"><img title="<?=T('hint_add');?>" src="<?=PUB;?>img/admadd.png"></a>
			<h1> 
		</td>
	
		<td>
			<input type="text" class="bigsearch search" id="search" name="search" value="<?=$search;?>">
		</td>
	
		<td>
			<div class="searchpic" onclick="doSearch('<?=$path.$class?>')">
			<img src="<?=PUB;?>img/search-white.png">	</div>
		</td>
	</tr>
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
			<td width="100"><b><font color="3e3e3e"><?=T('adm_country');?></font></b></td>
			<td width="580"><b><font color="3e3e3e"><?=T('adm_city');?></font></b></td>
			<td width="60" align="center"><b><font color="3e3e3e"><?=T('adm_options');?></font></b></td>
		</thead>
	</tr>
	<?php  foreach ($data as $row){ ?>
	
		<tr>
		<?php
		$id = $row['id']; unset($row['id']); 
		foreach($row as $k=>$v){
			echo "<td>".(isset($options[$k][$v])?T($options[$k][$v]):$v)."</td>";	
		}?>
		
		<? if(isAdmin()) { ?>
		
		<td align="center">
			<a href="<?=$pre.$class?>/view/<?=$id;?>">
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
		<form id="cityform" method="POST" action="<?=$pre.$class?>/save">
		<input type="hidden" name="id" id="id" value="<?=$id;?>">
			<table class="admAddTable">
			<?php //inspect($options);  unset($data[0]); //inspect($data);  inspect($fields);?>
				<tr>
					<td align="right"><?=T('adm_country');?>:</td>
					<td>
						<select name="form[country_id]" id="country_id">
							<? foreach ($options['country_id'] as $k =>$v){ ?>
								<option value='<?=$k;?>'<? if($k==@$data['country_id']) echo ' selected="selected"';?>><?=T($v);?></option>
							<? } ?>
						</select></td>
				</tr>
				<tr>
					<td align="right"><?=T('adm_name');?>:</td>
					<td><input type=text value="<?=@$data['name'];?>" name='form[name]' id='name'></td>
				</tr>				
				<tr>
					<td></td>
					<td align="left">
						<a onclick="$('cityform').submit()" href="javascript:void(0)">
						<div class="button insBtn" align="center"><?=T('adm_submit');?></div>
						</a>
					</td>
				</tr>
			</table>	
		</form>
	<?php break;
	
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Save
	case 'save' : echo T('save_msg'); redirect($pre.$class.'/item/'.$id,3);
	break;
		
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Delete
	case 'del' : echo T('del_msg'); redirect($pre.$class.'/items',3);
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
	
	case 'dontexist':	
	default : include('halepa.tpl.php'); break;

	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////

 } ?> 	
</div>