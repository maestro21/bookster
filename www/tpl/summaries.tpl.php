<? if($do != '_list') { ?><div class="wrapdiv summaries">
<? if((isAdmin() || HasRights('upload summaries')) && $showheader){ ?>
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

<? } } ?>

<?php switch($do){ 
	case '_default':  
		?>
		
		<div class="leftmenu">
			<form id="refOptionForm">
			<?php foreach ($data  as $on => $option) { unset($option[0]);?> 
				<p class="main"><input type="checkbox" id="<?=$on?>" name="<?=$on;?>_all" checked="checked" onchange="checkAll('all','<?=$on;?>')"><?=T($on);?></p>
				<?php foreach ($option as $k => $v) {?>
					<p>
					<input type="checkbox" class="<?=$on?>" name="<?=$on;?>[]" value="<?=$k;?>" onchange="checkAll('item','<?=$on;?>')"> <?=$v;?></p>
				<? } ?>
			<? } ?>
			</form>
		</div>
		
		<div id="summary_content">
			
		</div>
		<script>refreshSummaries(0);</script>
	<? 
	break;
		
	case '_list': //print_r($total);?>	
	<table class="admSearchTable">
		<tr>
			<td>
				<input type="text" class="bigsearch search" id="search" name="search" value="<?=$search;?>" 
				onkeypress="clickSearch(event,'<?=BASE_PATH;?>','search','summaries');">
			</td>
			<td>	
				<div class="searchpic" onclick="pubSearch('<?=$path;?>','search','summaries');">
				<img src="<?=PUB;?>img/search-white.png">	</div>
			</td>
		</tr>
	</table>	
	<p class="searchresults">
		<?php
			$_summaries = (int) @$total[1];
			$_courses 	= (int) @$total[2];		
		if( ($_summaries == 0) && ($_courses == 0) ) { ?>
			<?=T('nothing found');?>.
		<?php } elseif( ($_summaries > 0) && ($_courses == 0) ) { ?>
			<?=T('found');?> <?=$_summaries;?> 
			<?=C('summaries',$_summaries);?> .
		<?php } elseif( ($_summaries == 0) && ($_courses > 0) ) { ?>
			<?=T('found');?> <?=$_courses;?> 
			<?=C('courses', $_courses);?>.
		<?php } else {  ?>
			<?=T('found');?> <?=$_summaries;?> 
			<?=C('summaries',$_summaries);?> 
			<?=T('and');?>
			<?=$_courses;?> 
			<?=C('courses', $_courses);?>.
		<?php } ?></p>
	<?php
		$h = '';
		foreach ($data as $row){
		$cat = $row['name'];
		if($h != substr($cat,0,2)){ $h = substr($cat,0,2);?> 
		</fieldset>
		<fieldset>
			<legend><?=$h;?></legend>	
			<?php  } ?> 
			<p>	
				<a href="<?=$pre?>summaries/view/<?=$row['id'];?>"><?=$row['name'];?></a> 
			</p>
			<? } ?>
		</fieldset>
		
		<div class="pagination">
			<?php echo pagination($page, $pages, '', 'refreshSummaries({p})'); ?>
		</div>
	<?		
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
		<?php if(sizeof($data['recommended']) > 0) { ?><br><br>
		<h2><?=t('Recommended');?>:</h2>
		<ol>
		<?php foreach ($data['recommended'] as $row) { ?>
			<li><a href="<?=$pre . $row['type'] . $row['id'];?>"><?=$row['title'];?></a></li>
			<?php } ?>
			</ol>
		<?php } ?>
		</div>
	
	<? break;
	
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Items list - default function	
	case 'items' : ?>
	<table class="admSearchTableMain" cellspacing="0">
	<tr>
		<thead>
			<td width="100"><b><font color="3e3e3e"><?=T('adm_type');?></font></b></td>
			<td width="100"><b><font color="3e3e3e"><?=T('adm_author');?></font></b></td>
			<!--<td width="100"><b><font color="3e3e3e"><?=T('adm_category');?></font></b></td>-->
			<td width="50"><b><font color="3e3e3e"><?=T('adm_lang');?></font></b></td>
			<td width="375"><b><font color="3e3e3e"><?=T('adm_name');?></font></b></td>
			<td width="60" align="center"><b><font color="3e3e3e"><?=T('adm_options');?></font></b></td>
		</thead>
	</tr>
	<?php  foreach ($data as $row){ $id = $row['id'];?>
		<tr>
		<?php 
		//inspect($row);
		/*
		$id = $row['id']; unset($row['id']);  unset($row['content']); unset($row['filename']);
		foreach($row as $k=>$v){ 
               $out = (isset($options[$k][$v])?T($options[$k][$v]):$v);
                echo "<td>".trimString($out,80)."</td>";  
		} */ ?>
		<td width="100"><b><font color="3e3e3e"><?=$options['type'][$row['type']];?></font></b></td>
		<td width="100"><b><font color="3e3e3e"><?=$row['author'];?></font></b></td>
		<!--<td width="100"><b><font color="3e3e3e"><?=$options['cat_id'][$row['cat_id']];?></font></b></td>-->
		<td width="50"><b><font color="3e3e3e"><?=$row['lang'];?></font></b></td>
		<td width="375"><b><font color="3e3e3e"><?=trimString($row['name'],80);?></font></b></td>
		
		
		
		<td align="center">
			<a href="<?=$pre.$class?>/view/<?=$id;?>">
				<img title="<?=T('hint_view');?>" src="<?=PUB;?>img/admview.png"></a>	
			<a href="<?=$pre.$class?>/item/<?=$id;?>">
				<img title="<?=T('hint_edit');?>" src="<?=PUB;?>img/admedit.png"></a>
		<? if(isAdmin()){ ?>	
			<a href="#" onclick="conf('<?=$pre.$class?>/del/<?=$id;?>')">
				<img title="<?=T('hint_delete');?>" src="<?=PUB;?>img/admdel.png"></a>
		<? } ?>
		</td>
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
		<form id="sumform" method="POST" action="<?=$pre.$class?>/save">
		<input type="hidden" name="id" id="id" value="<?=$id;?>">
			<table class="admAddTable">
			<?php   unset($data[0]);	?>
				<tr>
					<td align="right"><?=T('adm_type');?>:</td>
					<td colspan="2">
						<select name="form[type]" id="type">
						<? foreach ($options['type'] as $k =>$v){ ?>
									<option value='<?=$k;?>'<? if($k==@$data['type']) echo ' selected="selected"';?>><?=T($v);?></option>
								<? } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right"><?=T('adm_category');?>:</td>
					<td colspan="2">	
					<div class="td">
						<?php $prorow = count($options['cat_id']) / 3; $i = 0 ;?>
				<?php foreach ($options['cat_id'] as $k =>$v){ if($i > $prorow) { echo "</div><div class='td'>"; $i = 0; } $i++; ?>
				<input type="checkbox" name="form[cats][]" value='<?=$k;?>'<? if(isset($data['cats'][$k])) echo ' checked=checked';?>><?=T($v);?><br>
								<? } ?>
					</div>
				</tr>
				<tr>
					<td align="right"><?=T('adm_lang');?>:</td>
					<td colspan="2">
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
					<td>
						<div class="errors">
							<p id="sum_exists_error_div">
							<?php echo T('summary_already_exist_msg'); ?>
							</p>
						</div>
					</td>
				</tr>
				<tr>
					<td align="right"><?=T('adm_tags');?>:</td>
					<td>
						<ul id="singleFieldTags"></ul>
						<input type="hidden" value="<?=@$data['tags'];?>" name='form[tags]' id='tags'>
					</td>
				</tr>
				<tr>
					<td align="right"><?=T('adm_content');?>:</td>
					<td colspan="2">
					<textarea cols=90 rows=20 name='form[content]' id='content'><?=@$data['content'];?></textarea>
						<script type='text/javascript'>
							CKEDITOR.replace( 'content' );
						</script>
					</td>
				</tr>
				<tr>
					<td></td>
					<td align="left" colspan="2">
						<?php if($id > 0) { ?>
							<a onclick="$('sumform').submit();" href="javascript:void(0)">
						<? } else { ?>
							<a onclick="checkSummaryForm();" href="javascript:void(0)">
						<? } ?>
						<div class="button insBtn" align="center"><?=T('adm_submit');?></div>
						</a>
					</td>
				</tr>
			</table>	
		</form>
		
		<script>
		 j(function(){
            var sampleTags = ['<?php echo implode("','", DBcol("SELECT DISTINCT tag
FROM seminar_tags
UNION SELECT DISTINCT tag
FROM summary_tags"));?>'];
			j('#singleFieldTags').tagit({
                availableTags: sampleTags,
                // This will make Tag-it submit a single form value, as a comma-delimited field.
                singleField: true,
				allowSpaces: true,
                singleFieldNode: j('#tags')
            });
		});
		</script>
	<?php break;
	
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Already exist
	case 'alreadyexist' : echo T('summary_already_exist_msg'); redirect($pre.$class.'/item/',3);
	break;
	
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
<? if($do != '_list') { ?>
</div>
<? } ?>