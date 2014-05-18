<div class="wrapdiv">
<? if(isAdmin() && $showheader){ ?>
<h1><a href="<?=$pre.$class?>"><?=T($class);?></a></h1> 
<a href="<?=$pre.$class?>/items"><?=T('list');?></a> |
<a href="<?=$pre.$class?>/item"><?=T('add');?></a> 
<input type="text" id="search" name="search" value="<?=$search;?>"><input type="button" onclick="doSearch('<?=$path.$class?>')"  value="<?=T('search');?>">
<hr>
<? } ?>

<?php switch($do){ 
	case '_default':  

		$h='';// inspect($data);
		foreach ($data as $k=>$v){
		 if($h != $v[0]){ $h = substr($v,0,2);?> 
 </fieldset><fieldset><legend><?=$h;?></legend>
		<?php  } ?> 
		<p>	
			<a href="<?=$pre?>referats/cat/<?=$k;?>"><?=$v;?></a> 				
		</p>
	<? } echo "</fieldset>";
	break;
	
	case 'cat':
		foreach ($data as $row){?>
		<p>	
			<a href="<?=$pre?>referats/view/<?=$row['id'];?>"><?=$row['name'];?></a>
			<a href="<?=BASE_PATH;?>referats/add/<?=$row['id'];?>">
				 	<img src="<?=PUB;?>img/add.png" align=absmiddle>
				 </a>
		</p>
	<? } break;	
	
	case 'view':  ?>
		<h1><?=$data['name'];?></h1>
		<?=$data['content'];?>
		
	
	<? break;
	
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Items list - default function	
	case 'items' : ?>
	<table>
	<tr>
		<thead>
			<td><?=T('cat');?></td>
			<td><?=T('lang');?></td>
			<td><?=T('name');?></td>
			<td><?=T('options');?></td>
		</thead>
	</tr>
	<?php  foreach ($data as $row){ ?>
		<tr>
		<?php
		$id = $row['id']; unset($row['id']);  unset($row['content']); unset($row['filename']);
		foreach($row as $k=>$v){ 
			echo "<td>".(isset($options[$k][$v])?T($options[$k][$v]):$v)."</td>";	
		}?>
		<? if(isAdmin()) { ?>	
		<td width=150>
			<a href="#" onclick="conf('<?=$pre.$class?>/del/<?=$id;?>')"><?=T('del');?></a>
			<a href="<?=$pre.$class?>/item/<?=$id;?>"><?=T('edit');?></a>
			<a href="<?=$pre.$class?>/view/<?=$id;?>"><?=T('view');?></a>
		</td>
		<? } ?>
		</tr>		
	<?}?> 
	</table>
	
	<?php if($pages>1) for($i=1;$i<=$pages;$i++){ ?>
		<a href="<?=$pre.$class?>/items/<?=$i;?>/<?=$search;?>"><?=$i;?></a>
	<?}?>	
	<?php break;
	
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Add\Edit  item
	case 'item' : ?>
		<form method="POST" action="<?=$pre.$class?>/save">
		<input type="hidden" name="id" id="id" value="<?=$id;?>">
			<table>
			<?php   unset($data[0]);	?>
				<tr>
					<td id='descr_cat_id' class='info'><?=T('category');?></td>
					<td class='data'>
						<select name=form[cat_id] id=cat_id>
						<? foreach ($options['cat_id'] as $k =>$v){ ?>
									<option value='<?=$k;?>'<? if($k==@$data['cat_id']) echo ' selected="selected"';?>><?=T($v);?></option>
								<? } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td id='descr_lang' class='info'><?=T('lang');?></td>
					<td class='data'>
						<select name=form[lang] id=lang>
						<? foreach ($options['lang'] as $k =>$v){ ?>
									<option value='<?=$k;?>'<? if($k==@$data['lang']) echo ' selected="selected"';?>><?=T($v);?></option>
								<? } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td id='descr_name' class='info'><?=T('name');?></td>
					<td class='data'>
						<input type=text value="<?=@$data['name'];?>" name='form[name]' id='name'>
					</td>
				</tr>
				<tr>
					<td id='descr_content' class='info'><?=T('content');?></td>
					<td class='data'>
					<textarea cols=100 rows=20 name='form[content]' id=content><?=@$data['content'];?></textarea>
						<script type='text/javascript'>
							bkLib.onDomLoaded(function() {
							 new nicEditor({fullPanel : true,maxHeight : 300}).panelInstance('content');
							 }); 
						</script>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit">
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
//Error
	
	case 'dontexist':	
	default : include('halepa.tpl.php'); break;

	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
}?>
</div>