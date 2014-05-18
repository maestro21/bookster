<div class="wrapdiv">
	<?php
	if(isAdmin() && $showheader){ ?>
		<table class="admSearchTable">	
		<td width="175">		
			<h1>
				<a href="<?=$pre.$class?>"><?=T('adm_sem3');?></a>		
				<a href="<?=$pre.$class?>/item" class="plusindent"> <img title="<?=T('hint_add');?>" src="<?=PUB;?>img/admadd.png"></a>				
				<? echo tpl( 'edu', array( '_filter' => true ) );?>	
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

<?php  switch($do){  
	case 'item' : ?>
		
		<form id="seminarq" method="POST" action="<?=$pre.$class?>/save">
		<input type="hidden" name="id" id="id" value="<?=$id;?>">
		<table class="admAddTable">
			<?php   unset($data[0]); ?>
				<tr>
					<td align="right"><?=T('adm_lesson');?>:</td>
					<td align="left">
						<select name=form[seminarlesson_id] id=seminarlesson_id>
						<? foreach ($options['seminarlesson_id'] as $k =>$v){ ?>
									<option value='<?=$k;?>'<? if($k==@$data['seminarlesson_id']) echo ' selected="selected"';?>><?=trimString(T($v),120);?></option>
								<? } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right"><?=T('adm_number');?>:</td>
					<td>
						<input type=text value="<?=@$data['order'];?>" name='form[order]' id='order'>
					</td>
				</tr>
				<tr>
					<td align="right"><?=T('adm_question');?>:</td>
					<td>
						<input type=text value="<?=@$data['question'];?>" name='form[question]' id='question'>
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
					<td align="right"><?=T('adm_answer');?>:</td>
					<td>
					<textarea cols=90 rows=20 name='form[answer]'  id='answer'><?=@$data['answer'];?></textarea>
						<script type='text/javascript'>
							CKEDITOR.replace( 'answer' );
						</script>
					</td>
				</tr>
				<tr>
					<td></td>
					<td align="left">
						<a onclick="$('seminarq').submit()" href="javascript:void(0)">
						<div class="button insBtn" align="center"><?=T('adm_submit');?></div>
						</a>
					</td>
				</tr>
			</table>	
			
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
		</form>
	<?php break;
	
///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Items list - default function	
	case 'items' : ?>
	<table width="833" class="admSearchTableMain" cellspacing="0">
	<tr>
		<thead>
			<td width="200"><b><font color="3e3e3e"><?=T('adm_lesson');?></font></b></td>
			<td width="405"><b><font color="3e3e3e"><?=T('adm_question');?></font></b></td>
			<td width="20"><b><font color="3e3e3e"><?=T('adm_number');?></font></b></td>			
			<td width="60" align="center"><b><font color="3e3e3e"><?=T('adm_options');?></font></b></td>
		</thead>
	</tr>
	<?php  foreach ($data as $row){ ?>
		<tr>
		<?php
		$id = $row['id']; unset($row['id']); 
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