<div class="wrapdiv">
	<div style="width:208px !important; float:left; border-right:1px lightgray solid; height:200px" class="leftmenu">
		<p class="s"><?=T('search in');?></p>
		<? foreach ($whereToSearch as $module){?>
		<a href="<?=BASE_PATH;?>search/<?=$id;?>/<?=$module;?>" class="b"><?=T($module);?></a>
		<? } ?>
		<p style="height:15px"> </p>
	</div>
	
	<div class="wrapp" style="display:table-cell;min-height:250px; padding-top:0px;">
		<!--<h2><?=T('search results for')." '$id' ".T('in')." ".T($searchmodule);?></h2> -->
		<table class="nowrp" cellpadding=0 cellspacing=0 border=0>
			<tr>
				<td>
			<input type="text"  class="bigsearch" id="eBigSearch" value="<?=$id;?>" onkeypress="clickSearch(event,'<?=BASE_PATH;?>','eBigSearch','<?=$searchmodule;?>');"> 
				</td>
				<td style="padding-left:15px !important">	
					<div class="searchpic"  onclick="sndSearch('eBigSearch','<?=BASE_PATH;?>','<?=$searchmodule;?>')">
						<img src="<?=PUB;?>img/search-white.png">
					</div>					
				</td>
			</tr>
			<tr>
				<td colspan=2>
					
					<p><i><? if($pages > 0 ) { ?><?=T('resultcount');?> <?=$pages;?> <? }else  echo T('noresult');  ?> </i></p>
				</td>
			</tr>	
		</table>
		
	<?// echo $count ;
	//inspect($data);
	foreach($data as $row){
			switch($searchmodule){
			
				case 'seminars':  
				?>
					<p class="searchlist">
						<img src="<?=PUB;?>img/iconoy.jpg" align="absmiddle"><a href="<?=$pre?>seminars/question/<?=$row['id'];?>"><?=$row['question'];?></a>
					</p>
				
				<? 	
				
				break;
				
				case 'users':  /* ?>
				
				
					<table cellpadding=0 cellspacing=0 border=0 width=687px style="margin:0 10">
					<?php //inspect($data); 
					 ?>
						<tr class="userlist">
							<? //inspect($row); ?>
							<td width=50px>
								<? if (file_exists("up/photossml/".$row['id'].".jpg") ) { ?>
									<img src="<?=BASE_PATH;?>up/photossml/<?=$row['id'];?>.jpg">
								<? } else { ?>
									<img src="<?=PUB;?>img/defaultavatarsml.png">
								<? } ?>
							</td>
							<td width=400px>
								 <a href="<?=BASE_PATH;?>id<?=$row['id'];?>"><?=$row['name'] . ' ' . $row['surname'];?></a>
							</td>
						</tr>
			
					</table>
				
							
				
				<? */
				if($row['id']=='1') $row['university'] = 'ISMA';
				$contacts = array_flip(split(',',$_SESSION['user']['contacts']));
				?>
				<table class="contacttable" cellpadding=0 cellspacing=0>
					<tr>
						<td width="55px">
						<a href="<?=BASE_PATH;?>id<?=$row['id'];?>">
							<? if (file_exists("up/photossml/{$row['id']}.jpg")){ ?>
							<img src="<?=BASE_PATH;?>up/photossml/<?=$row['id'];?>.jpg">
							<? }else{ ?>
							<img src="<?=PUB;?>img/defaultavatarsml.png">
							<? } ?>
							</a>
						<td width="460px">
							<a href="<?=BASE_PATH;?>id<?=$row['id'];?>"><?=$row['name'];?> <?=$row['surname'];?></a><br>
							<p><a href="<?=BASE_PATH;?>users/uni/<?=$row['uni_id'];?>"><?=$row['university'];?></a></p>
						</td>
						<td width="131px">	
							<? if($row['id']!=$_SESSION['user']['id']){  ?>			 
							<p>	<a href="<?=BASE_PATH;?>messages/compose/<?=$row['id'];?>">
								<?=T('write mail');?>
							 </a>	</p>
							 <p>			 
								 
							 <?  if(isset($contacts[$row['id']])){ ?>
								<?=T('already in contacts');?>
							 <? } else { ?>
								 <a href="<?=BASE_PATH;?>users/addcontact/<?=$row['id'];?>">
									<?=T('addcontact');?>
								</a>
							 <? } } ?>
							 </p>
						</td>
					</tr>	
				</table>
	
				<?	break;
				
				 case 'summaries':   
					?>
					<p>	
						<a href="<?=$pre?>summaries/view/<?=$row['id'];?>"><?=$row['name'];?></a>
					</p>
				<?  break;	
				
				  default:?>
			
				<? break;
				 }
		}?>
	</div>
</div>
