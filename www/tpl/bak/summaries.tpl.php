<div class="wrapdiv">
<? if(isAdmin() && $showheader){ ?>
<table class="admSearchTable">	
		<td width="175">		
			<h1>
				<a href="<?=$pre.$class?>">	<?=T('adm_ref2');?></a>		
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
	case '_default':  

		$h='';// inspect($data);
		foreach ($data as $k=>$v){
		 if($h != $v[0]){ $h = substr($v,0,2);?> 
		</fieldset><fieldset><legend><?=$h;?></legend>
		<?php  } ?> 
		<p>	
			<a href="<?=$pre?>summaries/cat/<?=$k;?>"><?=$v;?></a> 				
		</p>
	<? } echo "</fieldset>";
	break;
	
	case 'cat':
		foreach ($data as $row){?>
		<p>	
			<a href="<?=$pre?>summaries/view/<?=$row['id'];?>"><?=$row['name'];?></a>
			<a href="<?=BASE_PATH;?>summaries/add/<?=$row['id'];?>">
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
	<table class="admSearchTableMain" cellspacing="0">
	<tr>
		<thead>
			<td width="100"><b><font color="3e3e3e"><?=T('adm_category');?></font></b></td>
			<td width="50"><b><font color="3e3e3e"><?=T('adm_lang');?></font></b></td>
			<td width="475"><b><font color="3e3e3e"><?=T('adm_name');?></font></b></td>
			<td width="60" align="center"><b><font color="3e3e3e"><?=T('adm_options');?></font></b></td>
		</thead>
	</tr>
	<?php  foreach ($data as $row){ ?>
		<tr>
		<?php
		$id = $row['id']; unset($row['id']);  unset($row['content']); unset($row['filename']);
		foreach($row as $k=>$v){ 
               $out = (isset($options[$k][$v])?T($options[$k][$v]):$v);
                echo "<td>".trimString($out,80)."</td>";  
		}?>
		<? if(isAdmin()) { ?>	
		<td align="center">
			<a href="<?=$pre.$class?>/view/<?=$id;?>">
				<img title="<?=T('hint_view');?>" src="<?=PUB;?>img/admview.png"></a>	
			<a href="<?=$pre.$class?>/item/<?=$id;?>">
				<img title="<?=T('hint_edit');?>" src="<?=PUB;?>img/admedit.png"></a>
			<a href="#" onclick="conf('<?=$pre.$class?>/del/<?=$id;?>')">
				<img title="<?=T('hint_delete');?>" src="<?=PUB;?>img/admdel.png"></a>
		</td>
		<? } ?>
		</tr>		
	<?}?> 
	</table>
	
		<table><tr>
		<?php if($pages>1) for($i=1;$i<=$pages;$i++){ ?>
			<td  style="padding:0px 0px 0px 9px">
			<a href="<?=$pre.$class?>/items/<?=$i;?>/<?=$search;?>"><?=$i;?></a>
			</td>
		<?}?>
		</tr></table>
	<?php break;
	
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Add\Edit  item
	case 'item' : ?>
		<form id="sumform" method="POST" action="<?=$pre.$class?>/save">
		<input type="hidden" name="id" id="id" value="<?=$id;?>">
			<table>
			<?php   unset($data[0]);	?>
				<tr>
					<td align="right"><?=T('adm_category');?>:</td>
					<td>
						<select name=form[cat_id] id=cat_id>
						<? foreach ($options['cat_id'] as $k =>$v){ ?>
									<option value='<?=$k;?>'<? if($k==@$data['cat_id']) echo ' selected="selected"';?>><?=T($v);?></option>
								<? } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right"><?=T('adm_lang');?>:</td>
					<td>
						<select name=form[lang] id=lang>
						<? foreach ($options['lang'] as $k =>$v){ ?>
									<option value='<?=$k;?>'<? if($k==@$data['lang']) echo ' selected="selected"';?>><?=T($v);?></option>
								<? } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right"><?=T('adm_name');?>:</td>
					<td>
						<input type=text value="<?=@$data['name'];?>" name='form[name]' id='name'>
					</td>
				</tr>
				<tr>
					<td align="right"><?=T('adm_content');?>:</td>
					<td>
					<textarea cols=90 rows=20 name='form[content]' id='content'><?=@$data['content'];?></textarea>
						<script type='text/javascript'>
							CKEDITOR.replace( 'content' );
						</script>
					</td>
				</tr>
				<tr>
					<td></td>
					<td align="left">
						<a onclick="$('sumform').submit()" href="javascript:void(0)">
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
//Error
	
	case 'dontexist':	
	default : ?>
	<div>
	<center class="halepa">
		<img src="<?=$pre;?>www/img/halepa.jpg"><br>
		<h2><?=T('halepa');?></h2><br>
		<?=($do=='dontexist'?T('dontexist'):T('halepadesc'));?>
	</center><br><br>
	</div>
<?php break;

	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
}?>
</div>