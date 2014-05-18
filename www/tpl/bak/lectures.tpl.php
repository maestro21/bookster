<div class="wrapdiv">
<? if(isAdmin() && $showheader){ ?>
<h1><a href="<?=$pre.$class?>"><?=T($class);?></a></h1> 
<a href="<?=$pre.$class?>/items"><?=T('list');?></a> |
<a href="<?=$pre.$class?>/item"><?=T('add');?></a> 
<input type="text" id="search" name="search" value="<?=$search;?>"><input type="button" onclick="doSearch('<?=$path.$class?>')"  value="<?=T('search');?>">
<hr>
<? } ?>

<?php 
	switch($do){ 
	case 'my':  
		 $user = $_SESSION['user']; ?>
		
		<? $uni = DBrow("SELECT * from universities WHERe id='".(int)$user['uni_id']."'"); ?>
					<a href="#"><?=$uni['name'];?></a> <img src="<?=PUB;?>img/dot.gif" align="absmiddle">
		<? $fac = DBrow("SELECT * from faculties WHERe id='".(int)$user['faculty_id']."'"); ?>
					<a href="<?=BASE_PATH;?>users/faculty/<?=$fac['id'];?>"><?=$fac['name'];?></a> <img src="<?=PUB;?>img/dot.gif" align="absmiddle"> 
		<? $spec = DBrow("SELECT * from specialization WHERe id='".(int)$user['specialization_id']."'"); ?>
					<a href="<?=BASE_PATH;?>users/specialization/<?=$spec['id'];?>"><?=$spec['name'];?></a> <img src="<?=PUB;?>img/dot.gif" align="absmiddle">
					
					<a href="#"><?=R($data['term']).' '.T('term');?></a>			
	<?
		$h='';
		foreach ($data as $row){
		$cat = $row['name'];
		 if($h != substr($cat,0,2)){ $h = substr($cat,0,2);?> 
		 </fieldset><fieldset><legend><?=$h;?></legend>
		<!--<p>
			<img src="<?=$pre;?>img/line.jpg" width="20px" height="10px">
			<?=$h;?>
			<img src="<?=$pre;?>img/line.jpg" width="635px" height="10px">
		</p> -->
		<?php  } ?> 
		<p>	
			<a href="<?=$pre?>lectures/view/<?=$row['id'];?>"><?=$row['name'];?></a> 
		</p>
	<? } echo "</fieldset>";
	
	break;
	
	break;
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Items list - default function	
	case 'items' : ?>
	<table>
	<tr>
		<?php foreach ($fields as $k=>$v){?>
			<th><a href="<?=$pre?>filter/sort_<?=$class;?>/<?=$k.'_'.getFilterState($class,$k);?>"><?=T($k);?></a><?=filterImg($class,$k);?></th>
		<? }?>
	</tr>
	<?php  foreach ($data as $row){ ?>
		<tr>
		<?php
		$id = $row['id']; unset($row['id']); 
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
			<?php   unset($data[0]); //inspect($data);  inspect($fields);
				echo drawForm($fields,$data,$options); 
			?>
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
	}
//Error
	
	case 'dontexist':	
	default : ?>
	<div>
	<center class="halepa">
		<img src="<?=$pre;?>img/halepa.jpg"><br>
		<h2><?=T('halepa');?></h2><br>
		<?=($do=='dontexist'?T('dontexist'):T('halepadesc'));?>
	</center><br><br>
	</div>
<?php break;

	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
?></div>