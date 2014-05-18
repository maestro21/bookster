<div class="wrapdiv">
<? if(isAdmin() && $showheader){ ?>
		<table class="admSearchTable">	
		<td width="175">		
			<h1>
				<a href="<?=$pre.$class?>"><?=T('adm_sem2');?></a>		
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
		<form id="sem2form" method="POST" action="<?=$pre.$class?>/save">
		<input type="hidden" name="id" id="id" value="<?=$id;?>">
		<!--<hr color='lightgrey'>-->
			<table class="admAddTable">
			<?php   unset($data[0]); //inspect($data);  inspect($fields); ?>
				<tr>
					<td align="right"><?=T('adm_seminar');?>:</td>
					<td>
						<select name=form[seminar_id] id=seminarlesson_id>
						<? foreach ($options['seminar_id'] as $k =>$v){ ?>
									<option value='<?=$k;?>'<? if($k==@$data['seminar_id']) echo ' selected="selected"';?>><?=T($v);?></option>
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
					<td align="right"><?=T('title');?>:</td>
					<td>
						<input type=text value="<?=@$data['title'];?>" name='form[title]' id='title'>
					</td>
				</tr>
				<tr>
					<td align="right"><?=T('literature');?>:</td>
					<td>
					<textarea cols=70 rows=20 name='form[literature]' id=literature><?=@$data['literature'];?></textarea>
						<script type='text/javascript'>
							bkLib.onDomLoaded(function() {
							 new nicEditor({fullPanel : true,maxHeight : 300}).panelInstance('literature');
							 }); 
						</script>
					</td>
				</tr>
				<!--<tr>
					<td id='descr_time' class='info'><?=T('time');?></td>
					<td class='data'>
						<?	preg_match_all("/[[:digit:]]{2,4}/",@$data['time'],$matches);	
							$nums = $matches[0]; ?> 					
						<input type='text' name=form[time][y] value='<?=@$nums[0];?>' size=4 class="time">-
						<select name=form[time][m]> 
						<? for($i=1;$i<13;$i++){ ?>
									<option value='<?=$i;?>'<? if($i==@$nums[1]) echo ' selected="selected"';?>><?=T("mon_$i");?></option>
								<? } ?>
						</select>
					<input type='text' name=form[time][d] value='<?=@$nums[2];?>' size=2 class="time"> &nbsp&nbsp&nbsp
					<input type='text' name=form[time][h] value='<?=@$nums[3];?>' size=2 class="time">:
					<input type='text' name=form[time][mi] value='<?=@$nums[4];?>' size=2 class="time">:
					<input type='text' name=form[time][s] value='<?=@$nums[5];?>' size=2 class="time">(HH:MM:SS)
					</td>
				</tr>-->
				<tr>
					<td></td>
					<td align="left">
						<a onclick="$('sem2form').submit()" href="javascript:void(0)">
						<div class="button insBtn" align="center"><?=T('adm_submit');?></div>
						</a>
					</td>
				</tr>
			</table>	
		</form>
	<?php break;
	
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Items list - default function	
	case 'items' : ?>
	<table width="833" class="admSearchTableMain" cellspacing="0">
	<tr>
		<thead>
			<td width="30"><b><font color="3e3e3e"><?=T('adm_seminar');?></font></b></td>
			<td width="105"><b><font color="3e3e3e"><?=T('adm_name');?></font></b></td>
			<td width="350"><b><font color="3e3e3e"><?=T('title');?></font></b></td>
			<td width="45"><b><font color="3e3e3e"><?=T('adm_number');?></font></b></td>
			<td width="60" align="center"><b><font color="3e3e3e"><?=T('adm_options');?></font></b></td>
		</thead>
	</tr>
	<?php  foreach ($data as $row){ ?>
		
		<tr>
		
	
		<?php
		foreach($row as $k=>$v)
		{
               $out = (isset($options[$k][$v])?T($options[$k][$v]):$v);
                echo "<td>".trimString($out,80)."</td>";     
		}?>

		<? if(isAdmin()) { ?>	
		<td align="center">
			<a href="<?=$pre.$class?>/view/<?=$row['id'];?>">
				<img title="<?=T('hint_view');?>" src="<?=PUB;?>img/admview.png"></a>
			<a href="<?=$pre.$class?>/item/<?=$row['id'];?>">
				<img title="<?=T('hint_edit');?>" src="<?=PUB;?>img/admedit.png"></a>
			<a href="#" onclick="conf('<?=$pre.$class?>/del/<?=$row['id'];?>')">
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