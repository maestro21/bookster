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
	case 'item' : /* //inspect($_SESSION);
	 ?>
		<div style="padding:15px;font-weight:bold;"><?=T('adm_filter');?> :
		<!--<? $res = DBall("SELECT * FROM universities"); $uni = array( 0 => T('all universities'));
		foreach ($res as $row){ $uni[$row['id']]=$row['name']; }
		$uniid = getVar('sem_uni',0); //inspect($uni); 	?>
		<a onclick="showHide('unidropdown')" href="#"><?=$uni[$uniid];?></a>		
		<div class="dropdownmenu" id="unidropdown" style="margin-left:10px;">
			<? foreach ($uni as $k=>$v){ ?>
				<a href="<?=BASE_PATH.'filter/sem_uni/'.$k;?>"><?=$v;?></a>
			<? } ?>
		</div>
		
		<? if ($uniid>0){ 
			$res = DBall("SELECT * FROM faculties WHERE uni_id=$uniid"); $fac = array( 0 => T('all faculties'));
			foreach ($res as $row){ $fac[$row['id']]=$row['name']; }
			$facid = getVar('sem_fac',0); //inspect($uni); 
			?>
			&rarr; <a onclick="showHide('facdropdown')" href="#"><?=$fac[$facid];?></a>		
			<div class="dropdownmenu" id="facdropdown" style="margin-left:210px;">
				<? foreach ($fac as $k=>$v){ ?>
					<a href="<?=BASE_PATH.'filter/sem_fac/'.$k;?>"><?=$v;?></a>
				<? } ?>
			</div>
			
			<?			
		} ?> -->
		
		
		<?php $facid = 1; 
			if ($facid>0){
			$term = getVar('sem_term');
			 ?>

			
			<a onclick="showHide('termdropdown')" href="#">
			
			<?=($term>0?R($term).' '.T('term'):T('all terms'));?></a>
			<div class="dropdownmenu" id="termdropdown" style="margin-left:30px;">
				<a href="<?=BASE_PATH.'filter/sem_term/0';?>"><?=T('all terms');?></a>
				<? for ($i = 1 ; $i<11 ; $i++){ ?>
					<a href="<?=BASE_PATH.'filter/sem_term/'.$i;?>"><?=R($i).' '.T('term');?></a>
				<? } ?>
			</div>
			&larr; &rarr;
			<?
			$res = DBall("SELECT * FROM specialization WHERE faculty_id=$facid"); $spec = array( 0 => T('all spec'));
			foreach ($res as $row){ $spec[$row['id']]=$row['name']; }
			$specid = getVar('sem_spec',0); //inspect($spec); 
			?>
			 <a onclick="showHide('specdropdown')" href="#"><?=$spec[$specid];?></a>		
			<div class="dropdownmenu" id="specdropdown" style="margin-left:100px;">
				<? foreach ($spec as $k=>$v){ ?>
					<a href="<?=BASE_PATH.'filter/sem_spec/'.$k;?>"><?=$v;?></a>
				<? } ?>
			</div>
			
						
		<? } ?>
		
		<? if ($term>0 && $facid>0){ 
			$sql = "SELECT * FROM seminars WHERE term_id=$term AND faculty_id=$facid".(@$specid>0?" AND specialization_id=$specid":"");
			//echo $sql;
			$res = DBall($sql); 
			$sem = array( 0 => T('all seminars'));
			foreach ($res as $row){ $sem[$row['id']]=$row['name']; }
			$semid = getVar('sem_sem',0); //inspect($uni); 
			?>
			&rarr; <a onclick="showHide('semdropdown')" href="#"><?=$sem[$semid];?></a>		
			<div class="dropdownmenu" id="semdropdown" style="margin-left:300px;">
				<? foreach ($sem as $k=>$v){ ?>
					<a href="<?=BASE_PATH.'filter/sem_sem/'.$k;?>"><?=$v;?></a>
				<? } ?>
			</div>
			
			<?			
		} ?>
		
		
		</div>		
	
		<hr color='lightgrey'> <? /**/ ?>
		
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
			
			
		</form>
	<?php break;
	
///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Items list - default function	
	case 'items' : /** ?>
	<div style="padding:15px;font-weight:bold;"><?=T('adm_filter');?> :
		<!--<? $res = DBall("SELECT * FROM universities"); $uni = array( 0 => T('all universities'));
		foreach ($res as $row){ $uni[$row['id']]=$row['name']; }
		$uniid = getVar('sem_uni',0); //inspect($uni); 	?>
		<a onclick="showHide('unidropdown')" href="#"><?=$uni[$uniid];?></a>		
		<div class="dropdownmenu" id="unidropdown" style="margin-left:10px;">
			<? foreach ($uni as $k=>$v){ ?>
				<a href="<?=BASE_PATH.'filter/sem_uni/'.$k;?>"><?=$v;?></a>
			<? } ?>
		</div>
		
		<? if ($uniid>0){ 
			$res = DBall("SELECT * FROM faculties WHERE uni_id=$uniid"); $fac = array( 0 => T('all faculties'));
			foreach ($res as $row){ $fac[$row['id']]=$row['name']; }
			$facid = getVar('sem_fac',0); //inspect($uni); 
			?>
			&rarr; <a onclick="showHide('facdropdown')" href="#"><?=$fac[$facid];?></a>		
			<div class="dropdownmenu" id="facdropdown" style="margin-left:210px;">
				<? foreach ($fac as $k=>$v){ ?>
					<a href="<?=BASE_PATH.'filter/sem_fac/'.$k;?>"><?=$v;?></a>
				<? } ?>
			</div>
			
			<?			
		} ?> -->
		
		
		<?php $facid = 1; 
			if ($facid>0){
			$term = getVar('sem_term');
			 ?>

			
			<a onclick="showHide('termdropdown')" href="#">
			
			<?=($term>0?R($term).' '.T('term'):T('all terms'));?></a>
			<div class="dropdownmenu" id="termdropdown" style="margin-left:30px;">
				<a href="<?=BASE_PATH.'filter/sem_term/0';?>"><?=T('all terms');?></a>
				<? for ($i = 1 ; $i<11 ; $i++){ ?>
					<a href="<?=BASE_PATH.'filter/sem_term/'.$i;?>"><?=R($i).' '.T('term');?></a>
				<? } ?>
			</div>
			&larr; &rarr;
			<?
			$res = DBall("SELECT * FROM specialization WHERE faculty_id=$facid"); $spec = array( 0 => T('all spec'));
			foreach ($res as $row){ $spec[$row['id']]=$row['name']; }
			$specid = getVar('sem_spec',0); //inspect($spec); 
			?>
			 <a onclick="showHide('specdropdown')" href="#"><?=$spec[$specid];?></a>		
			<div class="dropdownmenu" id="specdropdown" style="margin-left:100px;">
				<? foreach ($spec as $k=>$v){ ?>
					<a href="<?=BASE_PATH.'filter/sem_spec/'.$k;?>"><?=$v;?></a>
				<? } ?>
			</div>
			
						
		<? } ?>
		
		<? if ($term>0 && $facid>0){ 
			$sql = "SELECT * FROM seminars WHERE term_id=$term AND faculty_id=$facid".(@$specid>0?" AND specialization_id=$specid":"");
			//echo $sql;
			$res = DBall($sql); 
			$sem = array( 0 => T('all seminars'));
			foreach ($res as $row){ $sem[$row['id']]=$row['name']; }
			$semid = getVar('sem_sem',0); //inspect($uni); 
			?>
			&rarr; <a onclick="showHide('semdropdown')" href="#"><?=$sem[$semid];?></a>		
			<div class="dropdownmenu" id="semdropdown" style="margin-left:300px;">
				<? foreach ($sem as $k=>$v){ ?>
					<a href="<?=BASE_PATH.'filter/sem_sem/'.$k;?>"><?=$v;?></a>
				<? } ?>
			</div>
			
			<?			
		} ?>
		
		
		</div>	
	
		<hr color="lightgray">	
		<? /**/ ?>
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
	
	<table><tr>
	<?php if($pages>1) for($i=1;$i<=$pages;$i++){ ?>
		<td  style="padding:0px 0px 0px 9px">
		<a href="<?=$pre.$class?>/items/<?=$i;?>/<?=$search;?>"><?=$i;?></a>
		</td>
	<?}?>
	</tr></table>
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

 } ?>
 </div>