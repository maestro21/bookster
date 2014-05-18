<div class="wrapdiv">
<?php
if(isAdmin() && $showheader){ ?>
	<table class="admSearchTable">	
		<td width="175">		
			<h1>
				<a href="<?=$pre.$class?>">	<?=T('adm_help');?></a>		
				<a href="<?=$pre.$class?>/item" class="plusindent"> <img title="<?=T('hint_add');?>" src="<?=PUB;?>img/admadd.png"></a>
			</h1>
		</td>

		<td>
			<input type="text" class="bigsearch search" id="search" name="search" value="<?=@$search;?>">
		</td>

		<td>		
			<div class="searchpic" onclick="doSearch('<?=$path.$class?>')">
			<img src="<?=PUB;?>img/search-white.png">	</div>
		</td>		
	</table>

<hr color="lightgray">

<? } ?>

<?php switch($do){ 
	case 'ask': //inspect($data);  ?>
	
	 <form  method="POST" action="<?=BASE_PATH;?>help/save">
	<b><?=T('question');?></b><br>
	 <textarea name="form[question]" cols=50 rows=10></textarea><br>
	 <input type=submit>

	<? break; 
	
	case 'search':
	case '_list':
	//inspect($data);
		 ?>
		<div class='black_overlay' id='fade'></div>
			<div id="light" class="white_content">
			<a href = "javascript:void(0)"  style="float:right" onclick = "$('light').style.display='none';$('fade').style.display='none'">
			<img src="<?=PUB;?>img/close.png" style="padding:9px"></a>
				<h2 class="hup"><?=T('askquestion');?></h2>
					 <form  method="POST" id="msgform" action="<?=BASE_PATH;?>help/ask">
					  <input type="hidden" name="form[uid]" value="<?=getUID();?>">
					 <br><textarea name="form[question]" class="msgarea" rows=10></textarea><br>
				
				<!--	<?=T('lang');?>
					<select name="form[lang]" id="lang">
						<? foreach ($options['lang'] as $k =>$v){ ?>
							<option value='<?=$k;?>'<? if($k==@$data['lang']) echo ' selected="selected"';?>><?=T($v);?></option>
						<? } ?>
					</select>	-->			
					<a href="javascript:void(0)" class="blueButton" style="float:right;margin-top:10px;margin-right:2px;" onclick="$('msgform').submit()">
						<div><?=T('submit');?></div></a>
					</form>		
			</div>	
		<div class="pagewrap">
		 <h2><?=T('helptitle');?></h2>
	<table class="nowrp helptable" cellpadding=0 cellspacing=0 border=0>
			<tr>
				<td>
			<input type="text" name="bigsearch" class="bigsearch search" id="hSearch"
			 onfocus="empt(this,'<?=T('helpsearch');?>')" onblur="chk(this,'<?=T('helpsearch');?>')"
			value="<?=(@$searchtext==''?T('helpsearch'):@$searchtext);?>"> 
				</td>
				<td style="padding-left:15px !important">	
					<div class="searchpic"  onclick="helpSearch('<?=BASE_PATH;?>help/search/')">
						<img src="<?=PUB;?>img/search-white.png">
					</div>					
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<?php if(CheckLogged())  { ?>
					<p class="a123"><?=T('didntfind');?> 
					
					<a href = "javascript:void(0)" onclick = "$('light').style.display='block';$('fade').style.display='block'"> <?=T('askquestion');?></a>
					</p>
					<? } ?>
				</td>
			</tr>	
		</table>
		 
		<ol>
		<? foreach ($data as $row){ ?>
			<li><a href="<?=BASE_PATH;?>help/view/<?=$row['id'];?>"><?=$row['question'];?></a></li>
		<? } ?>
		</ol>
		</div>
		<?
	break;
	
	case 'view':
		?>
		<div class="pagewrap">
		<h2><?=$data['question'];?></h2>
		<br>
		<?=$data['answer'];?>
		</div>
	<? 
	break;
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	//Initialization - installation
	case 'ini': echo T('ini_msg');
	break;
	
	///////////////////////// ///////////////////////// ///////////////////////// /////////////////////////
	
	// Items list - default function	
	case 'items' : ?>
	<table class="admSearchTableMain" width="833" cellspacing="0">
	<tr width="833">
		<thead>
			<td width="173"><b><font color="3e3e3e"><?=T('adm_username');?></font></b></td>
			<td width="235"><b><font color="3e3e3e"><?=T('adm_question');?></font></b></td>
			<td width="235"><b><font color="3e3e3e"><?=T('adm_solution');?></font></b></td>
			<td width="70"><b><font color="3e3e3e"><?=T('adm_lang');?></font></b></td>
			<td width="120" align="center"><b><font color="3e3e3e"><?=T('adm_options');?></font></b></td>			
		</thead>
	</tr>
	<?php  foreach ($data as $row){ ?>
		<tr<?php if(!$row['public']) echo ' class="hidden"';?>>
		<?php
		$id = $row['id']; unset($row['id']);  unset($row['uid']); 
		foreach($row as $k=>$v){
			if($k != 'public') {
               $out = (isset($options[$k][$v])?T($options[$k][$v]):$v);
                echo "<td>".trimString($out,80)."</td>";  
			}	
		}?>
		<? if(isAdmin()) { ?>	
		<td align="center">			
			<a href="<?=$pre.$class?>/view/<?=$id;?>">
				<img title="<?=T('hint_view');?>" src="<?=PUB;?>img/admview.png"></a>	
			<a href="<?=$pre.$class?>/showhide/<?=$id;?>">
				<img title="<?=($row['public']?T('hint_hide'):T('hint_show'));?>" src="<?=PUB;?>img/admview_<?=(int)$row['public'];?>.png"></a>	
		
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
		<form id="helpform" method="POST" action="<?=$pre.$class?>/save">
		<input type="hidden" name="id" id="id" value="<?=$id;?>">
			<table class="admAddTable">
			<?php   unset($data[0]); //inspect($data);  inspect($fields);?>				
				<tr>
					<td align="right"><?=T('adm_question');?>:</td>
					<td><input type=text value="<?=@$data['question'];?>" name='form[question]' id='question'></td>
				</tr>	
				<tr>
					<td align="right"><?=T('adm_solution');?>:</td>
					<td>
						<textarea cols=90 rows=20 name='form[answer]' id=text><?=@$data['answer'];?></textarea>
					</td>
				</tr>
				<tr>
					<td align="right"><?=T('adm_lang');?>:</td>
					<td>
						<select name="form[lang]" id="lang">
							<? foreach ($options['lang'] as $k =>$v){ ?>
								<option value='<?=$k;?>'<? if($k==@$data['lang']) echo ' selected="selected"';?>><?=T($v);?></option>
							<? } ?>
						</select></td>
				</tr>
				<tr>
					<td align="right"><?=T('adm_public');?>:</td>
					<td><input type=checkbox  value=1 <? if(@$data['public']==1) echo "checked";?> name='form[public]' id='public'></td>
				</tr>					
				<tr>
					<td></td>
					<td align="left">
						<a onclick="$('helpform').submit()" href="javascript:void(0)">
						<div class="button insBtn" align="center"><?=T('adm_submit');?></div>
						</a>
				</tr>
			</table>	
		</form>
		<script type='text/javascript'>
			bkLib.onDomLoaded(function() {
			 new nicEditor({fullPanel : true,maxHeight : 300}).panelInstance('text');
			 }); 
		</script>
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

} ?>
</div>
