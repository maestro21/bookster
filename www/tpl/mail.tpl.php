<?php switch($do){ 
	/////////////////////////////////////////////////////////////////////////////////////////
	
	//recover message
	case 'rec': //inspect($vars);
	$row = $data; $name = DBcell("SELECT CONCAT(name,' ',surname) FROM users WHERE id=$id");
	$myname = $_SESSION['user']['name'] . ' '. $_SESSION['user']['surname'] ;  ?>
		<div>
		<p class="ww"><a class="uname" href="<?=BASE_PATH;?>id<?=$picid;?>"><b><?=($row['to']!= $_SESSION['user']['id']?$myname:$name);?></b></a><br>
		<i> <?=html_entity_decode($row['text']);?></i></p>		
		</div>	
		<div style="width:150px" align="right" valign=top style="padding-right:0px !important">
			<i style="color:#808080" class="uname"><?=D($row['time']);?></i>
			<a href="javascript:void(0)" onclick="del<?if($row['from']==$_SESSION['user']['id']) echo "to"; else echo "from";?>(<?=$row['id'];?>)"><img src="<?=PUB;?>img/<?/* if($row['lastvisit']!='') echo "white";*/?>cross.png" align="absmiddle"></a>		
			<br>
		</div>
		<id><?=$row['id'];?><id>
	<? break;
	
	//get new messages in dialogue
	case 'msg': 
	$name = DBcell("SELECT CONCAT(name,' ',surname) FROM users WHERE id=$id");
	$myname = $_SESSION['user']['name'] . ' '. $_SESSION['user']['surname'] ;  $unread = array();	 ?>
 		<? foreach ($data as $row){ ?>
		<div class="dmsgs" id="msgdiv_<?=$row['id'];?>"
		<? if($row['lastvisit']!=''){ 
			echo " style='background-color:#E4E8ED;'"; $unread[] = $row['id'];
		}else 
			$lv= $row['id'];?>>
			<? //inspect($row); ?>
			<div style="width:50px">
			<? if($row['to']!= $_SESSION['user']['id']) $picid = $_SESSION['user']['id']; else $picid=$id; ?>
			<a class="uname" href="<?=BASE_PATH;?>id<?=$picid;?>">
			<? if (file_exists("up/photossml/{$picid}.jpg")){ ?>
			<img src="<?=BASE_PATH;?>up/photossml/<?=$picid;?>.jpg">
			<? }else{ ?>
			<img src="<?=PUB;?>img/defaultavatarsml.png">
			<? } ?></a>
			</div>
			<div id="msg_<?=$row['id'];?>" class="msgcontent">
				<div>
					<p class="ww"><a class="uname" href="<?=BASE_PATH;?>id<?=$picid;?>"><b><?=($row['to']!= $_SESSION['user']['id']?$myname:$name);?></b></a><br>
					<i> <?=html_entity_decode($row['text']);?></i></p>	
				</div>	
				<div style="width:150px" align="right" valign=top style="padding-right:0px !important">
					<i style="color:#808080" class="uname"><?=D($row['time']);?></i>
					<a href="javascript:void(0)" onclick="del<?if($row['from']==$_SESSION['user']['id']) echo "to"; else echo "from";?>(<?=$row['id'];?>)"><img src="<?=PUB;?>img/<?/* if($row['lastvisit']!='') echo "white";*/?>cross.png" align="absmiddle"></a>		
					<br>
				</div>
			</div>
		</div>
		<?} // $_SESSION['chat'][$id] = $row['id']; //echo $row['time']; inspect($_SESSION);
		 //if($lv>0) echo "<lv>$lv<lv>";
		 //if(sizeof($unread)>0) echo "<unread>".join(',',$unread)."<unread>";
		 echo "<msg>$msgcount<msg>";
	break;
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////
	
	//open dialogue	
	case 'compose': //inspect($data); 
	$name = DBcell("SELECT CONCAT(name,' ',surname) FROM users WHERE id=$id");
	$myname = $_SESSION['user']['name'] . ' '. $_SESSION['user']['surname'] ; 	 $lv= 0; $unread = array(); ?>
	<div class="wrapp" style="width:687px">
		<h4 class="subhd" style="width:682px"><a href="<?=BASE_PATH;?>users/profile/<?=$id;?>"><?=$name;?></a></h4>
			<span class="wptxt" id="msgcount"><? $from = $id; $to= $_SESSION['user']['id']; 
				$s = DBcell("SELECT count(id) FROM mail WHERE (`from`=$from AND `to`=$to) OR (`from`=$to AND `to`=$from)"); 
				echo $s . ' ' .C('messages',$s);?> <? /*T('seminares'); */?></span><br>
	
	<?php //inspect($data); 
	//$data = array();
	if(count($data) < 1){ ?>
		<center class="big"><?=T('no messages');?></center>
	<? }else{ ?>
	<div id="msgwindow">
<!--	<table cellpadding=0 cellspacing=0 border=0 width=687px style="margin:0 10">-->
	<? $unread = ''; foreach ($data as $row){ ?>
		<div class="dmsgs" id="msgdiv_<?=$row['id'];?>"<? if($row['lastvisit']!=''){ 
			echo " style='background-color:#E4E8ED;'"; $unread[] = $row['id'];
		}else 
			$lv= $row['id'];?>>
			<? //inspect($row); ?>
			<div style="width:50px">
			<? if($row['to']!= $_SESSION['user']['id']) $picid = $_SESSION['user']['id']; else $picid=$id; ?>
			<a class="uname" href="<?=BASE_PATH;?>id<?=$picid;?>">
			<? if (file_exists("up/photossml/{$picid}.jpg")){ ?>
			<img src="<?=BASE_PATH;?>up/photossml/<?=$picid;?>.jpg">
			<? }else{ ?>
			<img src="<?=PUB;?>img/defaultavatarsml.png">
			<? } ?></a>
			</div>
			<div id="msg_<?=$row['id'];?>" class="msgcontent">
				<div>
					<p class="ww"><a class="uname" href="<?=BASE_PATH;?>id<?=$picid;?>"><b><?=($row['to']!= $_SESSION['user']['id']?$myname:$name);?></b></a><br>
					<i> <?=$row['text'];?></i></p>	
				</div>	
				<div style="width:150px" align="right" valign=top style="padding-right:0px !important">
					<i style="color:#808080" class="uname"><?=D($row['time']);?></i>
					<a href="javascript:void(0)" onclick="del<?if($row['from']==$_SESSION['user']['id']) echo "to"; else echo "from";?>(<?=$row['id'];?>)"><img src="<?=PUB;?>img/<? /*if($row['lastvisit']!='') echo "white";*/?>cross.png" align="absmiddle"></a>
					<br>
				</div>
			</div>
		</div>
	<?}  /*if($lv>0) echo "<lv>$lv<lv>"; if(sizeof($unread)>0) echo "<unread>".join(',',$unread)."<unread>";*/ ?> 
	<!--</table>-->
	</div>
	<? } ?>
	
	<!--
	<div class="wrapp" style="width:687px">
	<h2><a href="<?=BASE_PATH;?>users/profile/<?=$id;?>"><?=$name;?></a></h2>
	<? foreach ($data as $row){
	?>
			<hr>
			<p style="background-color:#eeeeee;">	
		<? if($row['from']==$_SESSION['user']['id']){ ?>
			<b><?=$_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname'];?></b>
		<?}else{ ?>
		<a href="<?=BASE_PATH;?>id<?=$id;?>"><?=$name;?></a>
		<?}?>
		<?=D($row['time']);?>
		</p>
		<p>
			<?=$row['text'];?>
		</p>
	<? } ?>-->
		<script>
		function checkEnter(e){		
			if (e.keyCode == 13 && !e.shiftKey) {
				sendMsg();
				return false;	
			}
		}
		
		function delfrom(id,c){
			$('msg_'+id).innerHTML='<div class="recmsg"><br><?=T('rec_del');?> <a href="javascript:void(0)" onclick="recoverFrom('+id+')"><?=T('rec_msg');?></a></div>';
			ajax_request('<?=BASE_PATH;?>mail/delfrom/'+id+'/<?=$id;?>');
		}
		
		function delto(id,c){
			$('msg_'+id).innerHTML='<div class="recmsg"><br><?=T('rec_del');?> <a href="javascript:void(0)" onclick="recoverTo('+id+')"><?=T('rec_msg');?></a></div>';
			ajax_request('<?=BASE_PATH;?>mail/delto/'+id+'/<?=$id;?>');
		}
	
		function recoverFrom(id){
			ajax_request('<?=BASE_PATH;?>mail/recto/'+id+'/<?=$id;?>','',recoverMsg);
		}
		
		function recoverTo(id){
			ajax_request('<?=BASE_PATH;?>mail/recfrom/'+id+'/<?=$id;?>','',recoverMsg);
		}
	

	
		function recoverMsg(resp){
			var res = resp.responseText;
			var mid=/<id>(.*)<id>/;
			var id = res.match(mid); //alert(id);
			res = res.replace(mid,"");
			//alert(res);
			$('msg_'+id[1]).innerHTML=res;
			$('msgwindow').scrollTop = $('msgwindow').scrollTop+40;
		}
	
		var visitedPages = 11;//new Array();
		function sendMsg(){
			if(  $('msgarea').value != '<?=T('type text');?>'){
				ajax_request('<?=BASE_PATH;?>mail/send/ajax',$('msgform').serialize());
				$('msgarea').value='';	
			}
		}
		
		var totalheight = $('msgwindow').scrollHeight; //alert(totalheight);
		var scrollallow = true; 
		$('msgwindow').scrollTop = $('msgwindow').scrollHeight;
		
		jQuery("#msgwindow").scroll(function() {		
			var scrollTop = jQuery(this).scrollTop();
			if($('msgwindow').scrollTop == 0 && scrollallow){
				scrollallow = false;
				ajax_request('<?=BASE_PATH;?>mail/getOldMsgs/<?=$id;?>','',parseOldMsgs);
			}
		});
		
		window.onscroll = function() {
		  var scrolled = window.pageYOffset || document.documentElement.scrollTop;
		  //alert(scrolled);
		  //$('msgwindow').scrollTop(scrolled);
		}

		
		
		function parseOldMsgs(resp){
			if(resp.responseText != ''){ 
				$("msgwindow").innerHTML = resp.responseText + $("msgwindow").innerHTML;
			}
			$('msgwindow').scrollTop = $('msgwindow').scrollHeight - totalheight;
			totalheight = $('msgwindow').scrollHeight;
			scrollallow = true;
		}
		
		
		function getNewMsg(){
			ajax_request('<?=BASE_PATH;?>mail/getNewMsgs/<?=$id;?>','',parseNewMsg);
		}
		
		//var _unread = '<?=@join(',',$unread);?>';
		//var _last = 0;
		//alert(_unread);
		function parseNewMsg(resp){
			res = resp.responseText;
			var msgcount = /<msg>(.*)<msg>/;
			var msgscount = res.match(msgcount); 
			res = res.replace(msgcount,'');
			if(msgscount != null){ 	$('msgcount').innerHTML = msgscount[1]; }
		
			
			if(res != ''){ 	
				$("msgwindow").innerHTML += res;
				$('msgwindow').scrollTop = $('msgwindow').scrollHeight;
			}			
			setTimeout('getNewMsg()','2000');	
		}
		
		function getMsg(){
			ajax_request('<?=BASE_PATH;?>mail/getMsg/<?=$id;?>','',parseMsg);
		}	
		
		function parseMsg(resp){
			$("msgwindow").innerHTML = resp.responseText;
			//alert(resp.responseText.trim());
			//if(resp.responseText.trim() !='') 
			$('msgwindow').scrollTop = $('msgwindow').scrollHeight;
			setTimeout('getMsg()','1000');
		}
		setTimeout('getNewMsg()','1000');
	</script>
	 <form  method="POST" action="<?=BASE_PATH;?>mail/send" id="msgform">
	  <input type="hidden" name="form[from]" value="<?=$_SESSION['user']['id'];?>">
	 <input type="hidden" name="form[to]" value="<?=$id;?>">
	 <table cellpadding=0 cellspacing=0 border=0>
		<tr class="msgs msbt">
		<td valign=top width="50px">
			<a  href="<?=BASE_PATH;?>id<?=$_SESSION['user']['id'];?>">
	<? if (file_exists("up/photossml/{$_SESSION['user']['id']}.jpg")){ ?>
			<img src="<?=BASE_PATH;?>up/photossml/<?=$_SESSION['user']['id'];?>.jpg">
			<? }else{ ?>
			<img src="<?=PUB;?>img/defaultavatarsml.png">
			<? } ?>
			</a>
			</td>
			<td>		
			<textarea name="form[text]" cols=60 rows=2 onblur="chk(this,'<?=T('type text');?>')" onfocus="empt(this,'<?=T('type text');?>');" id="msgarea" onkeypress="return checkEnter(event)"><?=T('type text');?></textarea><br>


				<div class="button insBtn" onclick="sendMsg()" ><?=T('submit');?></div>


		</td>
		<td valign=top width="50px">
			<a  href="<?=BASE_PATH;?>id<?=$id;?>">
		<? if (file_exists("up/photossml/$id.jpg")){ ?>
			<img src="<?=BASE_PATH;?>up/photossml/<?=$id;?>.jpg">
			<? }else{ ?>
			<img src="<?=PUB;?>img/defaultavatarsml.png">
			<? } ?>
			</a>
		</td>
		</tr>
	</table>
	

	
	</div>	
	<? break; 
	
	
		//////////////////////////////////////////////////////////////////////////////////////////////
	
		//dialog list
		case 'items':
	 ?>
		<div class="wrapp" style="width:687px">
		<h4 class="subhd" style="width:682px"><?=T('inbox');?></h4>
			<span class="wptxt"><? $s = (is_array($data)?sizeof($data):0); echo $s; ?> <?=C('dialogs',$s);?> <? /*T('seminares'); */?></span>

	
	<?php //inspect($data); 
	//$data = array();
	if(count($data) < 1){ ?>
		<center class="big"><?=T('no messages');?></center>
	<? }else{ ?>
	
		<div class='black_overlay' id='fade'></div>
		<div id="light" class="white_content">
<a href = "javascript:void(0)"  style="float:right" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">
<img src="<?=PUB;?>img/close.png" style="padding:9px"></a>
			<h2 class="hup"><?=T('deldialog');?></h2>
			<form method="post" style="padding:15px;" id="photoForm"  enctype="multipart/form-data" action="<?=BASE_PATH;?>users/upphoto">
				<p><?=T('deldialogconfirm');?></p>
				<a href="javascript:void(0)" style="float:right" onclick="deldialog()">
				<div class="button" style="width:120px"><?=T('del');?></div></a>
			</form>	
		</div>
		
		<div id="msgwindow" style="height:393px !important">
		<table cellpadding=0 cellspacing=0 border=0 width=687px style="margin:0 10">
		<? foreach ($data as $row){ ?>
			<tr class="msgs" <? if($row['lastvisit']!='') echo " style='background-color:#E4E8ED;'";?>>
				<? //inspect($row); ?>
				<td width=50px valign=top onclick="window.location='<?=BASE_PATH;?>mail/compose/<?=$row['id'];?>'"><? if (file_exists("up/photossml/".$row['id'].".jpg")){ ?>
				<img src="<?=BASE_PATH;?>up/photossml/<?=$row['id'];?>.jpg">
				<? }else{ ?>
				<img src="<?=PUB;?>img/defaultavatarsml.png">
				<? } ?>
				</td>
				<td width=400px valign=top onclick="window.location='<?=BASE_PATH;?>mail/compose/<?=$row['id'];?>'">
					 <a class="uname" href="<?=BASE_PATH;?>mail/compose/<?=$row['id'];?>"><b><?=$row['name'];?></b></a><br>
					<!--<?=T('inbox')?> : <?=(int)$row['inbox'];?> | <?=T('sent');?> : <?=(int)$row['sent'];?>-->
					<i><? if($row['to']!= $_SESSION['user']['id']){ ?> <img src="<?=PUB;?>img/arrow.png"> <? } ?>
					<? echo $row['text']; if(strlen($row['text'])>(87-substr_count($row['text'],' '))) echo "..."; ?></i>
				</td>
				<td width=139px onclick="window.location='<?=BASE_PATH;?>mail/compose/<?=$row['id'];?>'" align="right" valign=center style="padding-right:10px !important"><i style="color:#808080" class="uname"><?=D($row['time']);?> </i></td>
				<td width="11px" style="padding:0px!important;padding-top:7px!important;"><a href="javascript:void(0);" onclick="predeldialog(<?=$row['id'];?>)"><img src="<?=PUB;?>img/<?/* if($row['lastvisit']!='') echo "blue";*/?>cross.png"></a></td>
			</tr>
		<?}?> 
		</table>
		<script>
			var dialog = 0;
			function predeldialog(id){
				dialog = id;
				document.getElementById('light').style.display='block';
				document.getElementById('fade').style.display='block'
			}
			
			function deldialog(){
				window.location='<?=BASE_PATH;?>mail/deldialog/'+dialog;
			}
		
			jQuery("div").bind("mousewheel",function(ev, delta) {
				var scrollTop = jQuery(this).scrollTop();
				jQuery(this).scrollTop(scrollTop-Math.round(delta * 40));
			});
		</script>
	</div>
	<? } ?>
		</div>

	<?
break;
	/*default:
		include('default.html');
	break;*/
} ?>	