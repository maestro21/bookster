<div class="wrapdiv">
<? if(isAdmin() && $showheader){ ?>
	<table class="admSearchTable">	
		<td width="175">		
			<h1>
				<a href="<?=$pre.$class?>"><?=T('adm_sem1');?></a>		
				<a href="<?=$pre.$class?>/item" class="plusindent"><img title="<?=T('hint_add');?>" src="<?=PUB;?>img/admadd.png"></a>
				<? echo tpl( 'edu', array( '_filter' => true ) );  ?>
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
	
	<?php 
	switch($do){ 
		
				
		//my seminars old
		case 'my': $user = $_SESSION['user']; 
			$h='';
			foreach ($data as $row){
			$cat = $row['name'];
			if($h != substr($cat,0,2)){ $h = substr($cat,0,2);?> 
			</fieldset><fieldset><legend><?=$h;?></legend>

			<?php  } ?> 
			<p>	
				<a href="<?=$pre?>seminars/view/<?=$row['id'];?>"><?=$row['name'];?></a> 
			</p>
		<? } echo "</fieldset>";
		
		break;
		
		
		// top level - univerities
		 case 'all': ?>
			<center>
				<table class="setka" border="0" cellpadding="0" cellspacing="0">
				<? for ($i = 0 ; $i < 12; $i ++ ) { 
					if( $i % 4 == 0) { 
						echo "<tr>";
						if( $i > 2) echo "<td colspan=4 class='sep'><img src='{$pre}www/img/hdiv.jpg'><tr>"; 
					}?>
					<td <? if ($i % 4 == 3) echo " class='nobg'";?>>				
						<? if($i == 5) { ?> <a href="<?=$pre?>seminars/lessons/1"><img src="<?=$pre?>up/logosuni/1.png" height="90"></a> <? }  ?>
					</td>							
				<? } ?>
				</table>
			</center>
			
			<div class="semlist">
			<? foreach ($data as $row){?>
				<p><a href="<?=$pre?>seminars/lessons/<?=$row['id'];?>"><?=$row['name'];?></a></p>
			<? } ?>
			</div>
		<?
		break;
		
		
		// 2nd lvl - lessons
		
		case 'lessons':  ?>
			<table class="setka sexyfilter" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<a href="javascript:void(0)" class="amain" onclick="showHide('dropdown_fak')"><?=(getVar('edu_fac')>0 ? DBcell("SELECT name from faculties WHERE id=".getVar('edu_fac')) : T('Faculty'));?></a>
						<div id="dropdown_fak">
							<? $faks = DBall("SELECT * FROM faculties WHERE uni_id=".(int)(getVar('edu_uni')>0?getVar('edu_uni'):$id). "  ORDER BY name ASC"); ?>
							
							<!--<a href="<?=$pre;?>filter/edu_fac/0"><?=T('All');?></a>	
							<? foreach ($faks as $fac) { ?>
								<a href="<?=$pre;?>filter/edu_fac/<?=$fac['id'];?>"><?=$fac['name'];?></a>
							<? } ?>-->
							
							<a href="<?=$pre;?>seminars/lessons/<?=$id;?>/0/0/<?=getVar('edu_term');?>"><?=T('All');?></a>	
							<? foreach ($faks as $fac) { ?>
								<a href="<?=$pre;?>seminars/lessons/<?=$id;?>/<?=$fac['id'];?>/0/<?=getVar('edu_term');?>"><?=$fac['name'];?></a>
							<? } ?>
						</div>
					</td>
					<td>
					<a href="javascript:void(0)" class="amain" onclick="showHide('dropdown_spec')"><?=(getVar('edu_spec')>0 ? DBcell("SELECT name from specialization WHERE id=".getVar('edu_spec')) : T('Specialization'));?></a>
						<div id="dropdown_spec">
						<? if((int)(getVar('edu_fac')>0)) {
						
							$specs = DBall("SELECT * FROM specialization WHERE faculty_id=".getVar('edu_fac'). "  ORDER BY name ASC"); ?>
							
							<a href="<?=$pre;?>seminars/lessons/<?=$id;?>/<?=getVar('edu_fac');?>/0/<?=getVar('edu_term');?>"><?=T('All');?></a>	
							<? foreach ($specs as $spec) { ?>
								<a href="<?=$pre;?>seminars/lessons/<?=$id;?>/<?=getVar('edu_fac');?>/<?=$spec['id'];?>/<?=getVar('edu_term');?>"><?=$spec['name'];?></a>						
							<? } ?>
							
							<!--<a href="<?=$pre;?>filter/edu_spec/0"><?=T('All');?></a>	
							<? foreach ($specs as $spec) { ?>
								<a href="<?=$pre;?>filter/edu_spec/<?=$spec['id'];?>"><?=$spec['name'];?></a>						
							<? } ?> -->
						
						<? } ?>
						</div>
					</td>
					<td class='nobg'>
						<a href="javascript:void(0)" class="amain" onclick="showHide('dropdown_term')"><?=(getVar('edu_term')>0 ? R(getVar('edu_term')). ' ' : '') . T('term');?></a>
						<div id="dropdown_term">
						<!--<a href="<?=$pre;?>filter/edu_term/0"><?=T('All');?></a>	
						<? for ($i=1; $i<11; $i++){ ?>
							<a href="<?=$pre?>filter/edu_term/<?=$i;?>"><?=R($i). ' ' . T('term');?></a>
						<? } ?>-->
						
						<a href="<?=$pre;?>seminars/lessons/<?=$id;?>/<?=(int)getVar('edu_fac');?>/<?=(int)getVar('edu_spec');?>/0"><?=T('All');?></a>	
						<? for ($i=1; $i<11; $i++){ ?>
							<a href="<?=$pre?>seminars/lessons/<?=$id;?>/<?=(int)getVar('edu_fac');?>/<?=(int)getVar('edu_spec');?>/<?=$i;?>"><?=R($i). ' ' . T('term');?></a>
						<? } ?>
						</div>
					</td>
				</tr>
			</table>

			<p class="searchresults"><?=T('found');?> <?=sizeof($data);?> <?=C('disciples',sizeof($data));?>.</p>
			<?$h='';
			foreach ($data as $row){
			$cat = $row['name'];
			if($h != substr($cat,0,2)){ $h = substr($cat,0,2);?> 
			</fieldset><fieldset><legend><?=$h;?></legend>

			<?php  } ?> 
			<p>	
				<a href="<?=$pre?>seminars/view/<?=$row['id'];?>"><?=$row['name'];?></a> 
			</p>
			<? } ?>
		</fieldset>
		
		
		<?php break;

		
		///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
		
		//first level - seminar type. I.e. `History` */
		case 'view': ?> 
		<h2><?=$title;?></h2>
		<?	foreach ($data as $row){ ?>
			<fieldset>
				<legend><? $titles = split('-',$row['title']);  foreach($titles as $k=> $v)$titles[$k] = R($v); echo join('-',$titles);?></legend>	
				<p><a href="<?=$pre?>seminars/lesson/<?=$row['id'];?>"><?=$row['name'];?></a> </p> 
			</fieldset>
		<? }
		break;
	
		///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
		 
		//second level - seminar lesson with list of questions. I.e. `Eastern Slavs in 10th century`
		case 'lesson': ?><h2><?=$title;?></h2>

			<? $i=0; foreach ($data as $row){ ?>
			<fieldset>
				<legend><? $i++; echo $i;?></legend>	
				<p><a href="<?=$pre?>seminars/question/<?=$row['id'];?>"><?=$row['question'];?></a> 
				<a href="<?=$pre?>seminars/add/<?=$row['id'];?>"><img src="<?=PUB;?>img/add.png" class="px1" title="<?=T('addtodesc');?>" alt="<?=T('addtodesc');?>" text="<?=T('addtodesc');?>" align="absmiddle"></a> </p>
	 		</fieldset>
			<? } ?>
			
			<h2><?=T('literature');?></h2>
			<div class="lit"><?=$literature;?></div>
			
		<?php 		
		break; /**/
				
		
		///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
		
		//third level - exact question
		case 'question': 
			?>
			<div><h2><?=$data['question'];?></h2><br>
				<?=$data['answer'];?>
				<?php if(sizeof($data['recommended']) > 0) { ?><br>
				<h2><?=t('Recommended');?>:</h2>
				<ol>
				<?php foreach ($data['recommended'] as $row) { ?>
					<li><a href="<?=$pre . $row['type'] . $row['id'];?>"><?=$row['title'];?></a></li>
					<?php } ?>
					</ol>
				<?php } ?>
			</div>
			<?		
		break;
		
		///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
		
		// Items list - default function	
		case 'items' :  ?>
		<table width="833" class="admSearchTableMain" cellspacing="0">
		<tr>
			<thead>
				<td width="90"><b><font color="3e3e3e"><?=T('adm_spec');?></font></b></td>
				<td width="200"><b><font color="3e3e3e"><?=T('adm_fac');?></font></b></td>
				<td width="45"><b><font color="3e3e3e"><?=T('term');?></font></b></td>
				<td width="245"><b><font color="3e3e3e"><?=T('adm_name');?></font></b></td>
				<td width="100" align="center"><b><font color="3e3e3e"><?=T('adm_options');?></font></b></td>
			</thead>
		</tr>
		<?php  foreach ($data as $row){ ?>
			<tr<?php if(!$row['visible']) echo ' class="hidden"';?>>
			<?php
			$id = $row['id']; unset($row['id']); 
			foreach($row as $k=>$v){
				if($k != 'visible') {
					$out = (isset($options[$k][$v])?T($options[$k][$v]):$v);
					echo "<td>".trimString($out,80)."</td>"; 
				}				
			}?>
			<? if(isAdmin()) { ?>	
			<td align="center">
				<nobr><a href="<?=$pre.$class?>/view/<?=$id;?>">
					<img title="<?=T('hint_view');?>" src="<?=PUB;?>img/admview.png"></a>
				<a href="<?=$pre.$class?>/showhide/<?=$id;?>">
					<img title="<?=($row['visible']?T('hint_hide'):T('hint_show'));?>" src="<?=PUB;?>img/admview_<?=(int)$row['visible'];?>.png"></a>	
				<a href="<?=$pre.$class?>/item/<?=$id;?>">
					<img title="<?=T('hint_edit');?>" src="<?=PUB;?>img/admedit.png"></a>
				<a href="javascript:void(0)" onclick="conf('<?=$pre.$class?>/del/<?=$id;?>')">
					<img title="<?=T('hint_delete');?>" src="<?=PUB;?>img/admdel.png"></a>
				</nobr>				
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
			
			<form method="POST" action="<?=$pre.$class?>/save" id="semform">
			<input type="hidden" name="id" id="id" value="<?=$id;?>">
			<!--<hr color="lightgrey">-->
				<table class="admAddTable">
				<?php   unset($data[0]); 	?>
					<tr>
						<td align="right"><?=T('adm_spec');?>:</td>
						<td >
							<select name=form[specialization_id] id=specialization_id>
							<? foreach ($options['specialization_id'] as $k =>$v){ ?>
										<option value='<?=$k;?>'<? if($k==@$data['specialization_id']) echo ' selected="selected"';?>><?=T($v);?></option>
									<? } ?>
							</select>		
						</td>
					</tr>
					<tr>
						<td align="right"><?=T('term');?>:</td>
						<td >
							<select name=form[term_id] id=term_id>
							<? foreach ($options['term_id'] as $k =>$v){ ?>
										<option value='<?=$k;?>'<? if($k==@$data['term_id']) echo ' selected="selected"';?>><?=T($v);?></option>
									<? } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><?=T('adm_fac');?>:</td>
						<td >
							<select name=form[faculty_id] id=faculty_id>
							<? foreach ($options['faculty_id'] as $k =>$v){ ?>
										<option value='<?=$k;?>'<? if($k==@$data['faculty_id']) echo ' selected="selected"';?>><?=T($v);?></option>
									<? } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><?=T('adm_name');?>:</td>
						<td >
							<input type=text value="<?=@$data['name'];?>" name='form[name]' id='name'>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="left">
							<a onclick="$('semform').submit()" href="javascript:void(0)">
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
		//Error
		
		case 'dontexist':	
		default : include('halepa.tpl.php'); break;

		///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
		
	}?>
</div>