<?php //echo '111'.$do; 
switch($do){ 	
	case 'editrights':  //inspect($data);
		$rightlist = array(
			'upload summaries', 
			'view development',
			'administer',
		);
		?>	
		<div class="wrapp">
		<h2><?=T('edit user rights for user').' #'.$id;?></h2>
	<form id="loginForm" method="POST" action="<?=BASE_PATH;?>users/saverights">
	<input type="hidden" name="id" id="id" value="<?=$id;?>">
	<table>
	<?php foreach ($rightlist as $r) { ?>
		<tr>
			<td align="right"><?=T($r);?></td>
			<td><input type=checkbox  value='<?=T($r);?>' <? if(isset($data[$r])) echo "checked";?> name='form[rights][]' id='rights'></td>
		</tr>
	<? } ?>	
	</table>
	<input type="submit">
	</form>
	</div>
	<?break;
	
	case 'alerts': ?> 
	<div class="wrapp">
	<? foreach ($data as $row){?>
	<table class="contacttable" cellpadding=0 cellspacing=0 width="690">
		<tr width="690">
			<td width="55">
				<a href="<?=BASE_PATH;?>id<?=$row['id'];?>">
							<? if (file_exists("up/photossml/{$row['id']}.jpg")){ ?>
								<img src="<?=BASE_PATH;?>up/photossml/<?=$row['id'];?>.jpg">
							<? }else{ ?>
								<img src="<?=PUB;?>img/defaultavatarsml.png"><? } ?>
				</a>
			</td>

			<td>
				<a href="<?=BASE_PATH;?>id<?=$row['id'];?>"><?=$row['name'];?></a> <?=T('feed_friendadded');?>
			</td>
		</tr>
	</table>
	
	<? } ?>
	</div>
    <? break;
	
	////////////////////////this
	case 'list': ?>
	<div class="wrapp">
	<table class="contacttable" cellpadding=0 cellspacing=0 border-bottom-width=0>
	<?	$contacts = array_flip(split(',',$_SESSION['user']['contacts']));// inspect($contacts); 
	$total = sizeof($data); $i=1; foreach ($data as $row){ if($row['id']=='1') $row['university'] = 'ISMA'; ?>
		<?// if ($i==$total) echo ' class="noborder"'; $i++; ?>
			<td width="55px">
				<a href="<?=BASE_PATH;?>id<?=$row['id'];?>">
					<? if (file_exists("up/photossml/{$row['id']}.jpg")){ ?>
							<img src="<?=BASE_PATH;?>up/photossml/<?=$row['id'];?>.jpg">
						<? }else{ ?>
							<img src="<?=PUB;?>img/defaultavatarsml.png">
					<? } ?>
				</a>
			</td>
			<td width="450px">
				<a href="<?=BASE_PATH;?>id<?=$row['id'];?>"><?=$row['name'];?> <?=$row['surname'];?></a><br>
					<p><?=$row['university'];?></p>
			</td>
			<td width="141px">	
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
				 <p><?  if (IsAdmin() || IsSuperAdmin()) { ?>
					<a href="<?=BASE_PATH;?>users/editrights/<?=$row['id'];?>"><?=T('edit rights');?></a>
				  <? } ?>
				  </p>
			</td>
		</tr>	
	<?  }?> 
	</table>
	</div>
		
	
	<? break;
	case 'login': ?>
	<div class="modal mdmotion" id="modal-login">	
		<div class="modalwindow">
		<form id="loginForm" method="POST" action="<?=BASE_PATH;?>login" onsubmit="return false;">			
			<div class="regtable center">
				<center>
					<div  onclick="doFBLogin()" class="fbMegabutton" id="select-button-signup-fb">
						<div class="icon-wrap">
						  <img src="<?=BASE_PATH;?>www/img/icon-fb.png" style="margin-top:8px">
						</div>
						<?=T('facebook login');?>
					</div>
					
					<div class="vk_btn  big" id="vk_btn" onclick="VK.Auth.login(authInfo);"><div><?=T('vkontakte login');?></div></div>
					
					<strong class="line-thru"><?=t('or');?></strong>
						
					<input name="form[mail]" id="login_mail" onfocus="empt(this,'<?=T('email');?>')" onblur="chk(this,'<?=T('email');?>')" value="<?=T('email');?>">

					<input name="form[pass]" id="login_pass" type="password" value="" onfocus="empt(this,'<?=T('pass');?>','passfield')" onblur="chk(this,'<?=T('pass');?>','passfield')"><br>
					<label for="login_pass" id="passfield" class="passfield"><?=T('pass');?></label>


					<a href="javascript:void(0)" onclick="checkLoginForm()">
						<div class="bigGreenButton"><?=T('login');?></div>				
					</a>
					
					<a href="javascript:void(0)" class="switch pass click md-close" data-modal="modal-recover"><?=T('forgot pass');?></a>
					
					<div class="errors">
							<p><?=T("wrong reg");?></p>
					</div>				
				</center>
			</div>
		</form>
		</div>
	</div>
	
	<div class="modal mdmotion" id="modal-recover">	
		<div class="modalwindow">
		<form id="recoverForm" class="pad5" method="POST" action="<?=BASE_PATH;?>recover" onsubmit="return false;">
			<div class="regtable">
				<center>
					<h2><?=T('recover');?></h2>
					<div class="sendmaildiv">		
						<?=T('enteremail');?></div>
					<input name="form[mail]" id="restore_mail" style="margin-bottom:5px;margin-top:10px;"><br>
					<a href="javascript:void(0)" onclick="checkMailForm()">
						<div class="bigGreenButton" style="margin-left:5px !important;"><?=T('submit');?></div>
					</a><br>
					<a href="javascript:void(0)" data-modal="modal-login" class="switch click md-close">&larr; <?php echo T('go back');?></a>
					<div class="errors">
							<p><?=T('wrongMail');?></p>
					</div>
					<div id="sentmail" style="display:none">
						<table width="100%"><tr><td class="sm"><?=T('sentMail');?></td></tr></table>
					</div>
				</center>
			</div>
		</form>
	
	<script>
		j( document ).ready(function() {
			FB.init({  
				appId: 	550569404980092, 
				status: true,   
				cookie: true,  
				xfbml: true,  
				oauth: true  
				}); 
				
			VK.init({
			  apiId: 3791150
			});
		});
	</script>	
	</div>
	</div>

	<div class="md-overlay"></div>
				<!-- Modal -->
	<div id="formModal" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
		</div>
		<div class="modal-body"></div>
		<div class="modal-footer"></div>
	</div>	
<? break;

	case 'register': ?> 	
	<form id="regiForm" method="POST" action="<?=BASE_PATH;?>register" onsubmit="return false;"><div class="md-close"></div>
		<div class="regtable center">
			
			<center>
			<div  onclick="doFBLogin()" class="fbMegabutton" id="select-button-signup-fb">
				<div class="icon-wrap">
				  <img src="<?=BASE_PATH;?>www/img/icon-fb.png" style="margin-top:8px">
				</div>
				<?=T('facebook register');?>
			</div>
			</center>
			
			<div class="vk_btn  big" id="vk_btn" onclick="VK.Auth.login(authInfo);"><div><?=T('vkontakte register');?></div></div>
			
			<strong class="line-thru"><?=t('or');?></strong>
			
			<input name="form[name]" onfocus="empt(this,'<?=T('first name');?>')" onblur="chk(this,'<?=T('first name');?>')" id="regName" value="<?=T('first name');?>">
				
			<input name="form[surname]" onfocus="empt(this,'<?=T('last name');?>')" onblur="chk(this,'<?=T('last name');?>')" id="regSurName" value="<?=T('last name');?>">
				
			<input name="form[mail]" onfocus="empt(this,'<?=T('email');?>')" onblur="chk(this,'<?=T('email');?>')" id="regMail" value="<?=T('email');?>">
			
			<input name="form[pass]" onfocus="empt(this,'<?=T('pass');?>','reg_passfield')" onblur="chk(this,'<?=T('pass');?>','reg_passfield')" id="reg_pass" type="password" value=""><br>
						<label for="reg_pass" id="reg_passfield" class="passfield"><?=T('pass');?></label>
			
			<div class="bigGreenButton" onclick="checkRegForm()"><?=T('signup');?></div>
				
			<div class="errors">
					<p class="alreadyRegistered"><?=T('alreadyRegistered');?></p>
					<p class="fieldserror"><?=T('fieldserror');?></p>
					<p class="formaterror"><?=T('formaterror');?></p>
					<p class="mailerror"><?=T('mailerror');?></p>
			</div>	
		</div>
	</form>		
	<script>
		j( document ).ready(function() {
			FB.init({  
				appId: 	550569404980092, 
				status: true,   
				cookie: true,  
				xfbml: true,  
				oauth: true  
				}); 
				
			VK.init({
			  apiId: 3791150
			});
		});
	</script>
				
<? break;

	case 'recover': ?> 
	<form id="regiForm" class="pad5" method="POST" action="<?=BASE_PATH;?>restore">
		<table><tr><td>
<div class="regtable">
		<h2><?=T('recover');?></h2>
		
		<div class="sendmaildiv">		
		<?=T('enteremail');?></div>
		<input name="form[mail]"  style="margin-bottom:5px;margin-top:10px;"><br>
		<a href="javascript:void(0)" onclick="$('regiForm').submit()">
			<div class="button" style="width:100px;margin-left:2px;"><?=T('submit');?></div>
		</a>
		<? if(@$data=='error'){ ?>
		<div id="regErrors">
				<div style="margin:2px !important; margin-top:5px !important; width:320px !important;"><?=T('wrongMail');?></div>
		</div>
		<? } ?>
</div>
		</table>
	</form>
	
<? break;

	case 'msg':
		if(isset($data['msg'])) echo "<div class='usermsg'>".T($data['msg'])."</div>"; 
		if(isset($data['redirect'])) redirect($data['redirect'],3,0);
	break;
	
	
	case 'profile':  
	$myid = $_SESSION['user']['id'];
	$my = (bool)($id == $_SESSION['user']['id']);  ?> 
	<center>
	<table cellpadding=0 cellspacing=0 width="100%">
		<tr>
			<td class="leftmenu"  width="200px" valign="top" style="padding-bottom:0px;">
				<? if($my){ ?> 
				<div class='black_overlay' id='fade'></div>
				<div id="light" class="white_content">
					<a href = "javascript:void(0)"  style="float:right" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">
					<img src="<?=PUB;?>img/close.png" style="padding:9px"></a>
					<h2 class="hup"><?=T('upload photo');?></h2>
					<form method="post" style="padding:15px;" id="photoForm"  enctype="multipart/form-data" action="<?=BASE_PATH;?>users/upphoto">
						<p class="descFormat"><?=T('allowed image types');?></p>
						<center><input type="file" name="avatar">	</center>					
						<p><?=T('allowed image size');?></p>
						<a href="javascript:void(0)" style="float:right" onclick="$('photoForm').submit()">
						<div class="button" style="width:120px"><?=T('upload');?></div></a>
					</form>	
				</div>
				
				<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"> 
				<? } ?>
					<? $url =  "up/photos/{$id}.jpg"; //echo $url;
					if(!file_exists($url)) $url = FILE_PATH."img/default-avatar.jpg"; $url = BASE_PATH.$url;//echo $url; ?>
				<img src="<?=$url;?>" align="right" width="200" style="margin-left:2px">
				<? if($my){ ?></a> <? } ?>
				<? 	if($id==1){
						$uni = "ISMA";
						$unilink="http://www.isma.lv";
						$fac = "Information Technologies";
						$spec = "WEB development";
						/*$term = "Finished"; */
						$status = T('Administrator'); 
				
					}else{
						$uniid = (int)$data['uni_id']; $facid= (int)$data['faculty_id']; $specid=(int)$data['specialization_id'];
						$uni = ($uniid>0?DBcell("SELECT name from universities WHERe id='$uniid'"):T('Not selected'));
						$unilink = BASE_PATH."users/uni/$uniid";
						$fac = ($facid>0?DBcell("SELECT name from faculties WHERe id='$facid'"):T('Not selected'));
				 		$spec = ($specid>0?DBcell("SELECT name from specialization WHERe id='$specid'"):T('Not selected')); 
				 		/* $term = R($data['term']).' '.T('term'); */
				 		$status = T('Student');
				 	}
				 	if($data['term'] == 11) $term = T('graduated'); elseif($data['term']>0) $term = R($data['term']).' '.T('term'); else $term = T('Not selected');
				 	
				 ?>
				 
			</td>
			<td  valign="top" class="wraptop desktop" rowspan=2>
				<? if($my){ // inspect($data); ?>
								
				<? }else{ ?>
				<div class='black_overlay' id='fade'></div>
				<div id="light" class="white_content">
					<a href = "javascript:void(0)"  style="float:right" onclick = "$('light').style.display='none';$('fade').style.display='none'">
					<img src="<?=PUB;?>img/close.png" style="padding:9px"></a>
					<h2 class="hup"><?=T('compose');?></h2>
					 <form  method="POST" id="msgform" action="<?=BASE_PATH;?>mail/send">
					 <input type="hidden" name="form[from]" value="<?=$_SESSION['user']['id'];?>">
					 <input type="hidden" name="form[to]" value="<?=$id;?>">
					
					 <br><textarea name="form[text]" " class="msgarea" rows=10></textarea><br>
				
					<a href="javascript:void(0)" class="login" style="float:right;margin-top:10px;margin-right:2px;" onclick="$('msgform').submit()">
						<div><?=T('submit');?></div></a>
					</form>	
				</div>
				 <a href="javascript:void(0)" onclick="$('light').style.display='block';$('fade').style.display='block'">
				 	<img src="<?=PUB;?>img/chat.png" align=absmiddle width=30px>
				 </a>
				 </div>
				 <? $contacts = array_flip(split(',',$_SESSION['user']['following'])); //inspect($_SESSION['user']);
				  if(isset($contacts[$id])){ ?>
				  <a href="<?=BASE_PATH;?>users/delcontact/<?=$id;?>">
				 	<img src="<?=PUB;?>img/cross.png" align=absmiddle>
				 </a>
				 <? } else { ?>
				 <a href="<?=BASE_PATH;?>users/addcontact/<?=$id;?>">
				 	<img src="<?=PUB;?>img/add.png" align=absmiddle>
				 </a>
				 <? } ?>
			 <? } ?>

			<? if($my){ 
				$id = $_SESSION['user']['id'];				
				$lectures = array_reverse(DBall("SELECT l.* FROM lectures l JOIN mylectures m ON l.id=m.lectureid AND m.userid=$id"));
				$seminars = array_reverse(DBall("SELECT s.* FROM seminarquestions s JOIN myseminars m ON s.id=m.seminarid AND m.userid=$id"));
				$summaries = array_reverse(DBall("SELECT r.* FROM summaries r JOIN mysummaries m ON r.id=m.reportid AND m.userid=$id"));
			?>
			

				<h4><a href="<?=BASE_PATH;?>myseminars"><?=T('My Seminars');?></a></h4>
				<span class="wptxt"><? $s = sizeof($seminars);  echo $s; ?> <?=C('tasks',$s);?> <? /*T('seminares'); */?></span>
				<? if($s>0){ $i=0; foreach ($seminars as $seminar){ if($i<3){ ?>
				<p class="wpp"><img src="<?=PUB;?>img/iconoy.jpg" align="absmiddle"> <a href="<?=$pre;?>seminars/question/<?=$seminar['id'];?>"><?=$seminar['question'];?></a> 
				<a href="<?=$pre;?>seminars/rm/<?=$seminar['id'];?>"><img src="<?=PUB;?>img/cross.png" class="px1" title="<?=T('del');?>" alt="<?=T('del');?>" text="<?=T('del');?>" align="absmiddle"></a></p>
				<? } $i++; } 
				} else{ ?>
				<p class="wpp"><img src="<?=PUB;?>img/iconoy.jpg" align="absmiddle"> <?=T('no seminars'); ?></p>
				<? } ?>

			
			<p>
				<h4><a href="javascript:void(0)"><span><?=T('My Lectures');?></span></a></h4>
				<span class="wptxt"><? $l = sizeof($lectures); echo $l; ?> <?=C('lectures',$l);?></span>				
				<? if($l>0){ foreach ($lectures as $lecture){ ?>
				<p class="wpp"><img src="<?=PUB;?>img/iconoy.jpg" align="absmiddle"> <a href="<?=$pre;?>lectures/view/<?=$lecture['id'];?>"><?=$lecture['name'];?></a> 
				<a href="<?=$pre;?>lectures/rm/<?=$lecture['id'];?>"><img src="<?=PUB;?>img/cross.png" class="px1" align="absmiddle"></a></p>
				<? }} else{ ?>
				<p class="wpp"><img src="<?=PUB;?>img/iconoy.jpg" align="absmiddle"> <?=T('no lectures'); ?></p>
				<? } ?>
			</p>

			<p>
				<h4><a href="<?=BASE_PATH;?>mysummaries"><?=T('My summaries');?></a></h4>
				<span class="wptxt"><? $r = sizeof($summaries); echo $r;?> <?=C('summaries',$r);?></span>
				<? if($r>0) { $i=0; foreach ($summaries as $referat){if($i<3){ ?>
				<p class="wpp"><img src="<?=PUB;?>img/iconoy.jpg" align="absmiddle"> <a href="<?=$pre;?>summaries/<?=$referat['id'];?>"><?=$referat['name'];?></a> 
				<a href="<?=$pre;?>summaries/rm/<?=$referat['id'];?>"><img src="<?=PUB;?>img/cross.png" class="px1" align="absmiddle"></a></p>
				<? } $i++; } if($r>3){?>
				<p class="wpp"><a href="<?=BASE_PATH;?>users/summaries"><?=T('My summaries');?></a></p>
				<?  }
				} else{ ?>
				<p class="wpp"><img src="<?=PUB;?>img/iconoy.jpg" align="absmiddle"> <?=T('no summaries'); ?></p>
				<? } ?>
			</p>
			<? } ?>
			</td>			
		</tr>
		<tr>
			<td class="leftmenu"  width="200px" valign="top">
				
				<div class="name"><?=$data['name'].' '.$data['surname'];?></div> 	
				<a href="javascript:void(0)" onclick="showHide('aboutme')" class="b"><?=T('About');?></a>
					<div id="aboutme">			
						<p><?=T('University');?>:<br> 
						<a href="<?=$unilink;?>"><?=$uni;?></a></p>
						<p><?=T('Faculty');?>:<br>
						<a href="<?=BASE_PATH;?>users/faculty/<?=(int)$data['faculty_id'];?>"><?=$fac;?></a></p>
						<p><?=T('Specialization');?>:<br></a>
						<a href="<?=BASE_PATH;?>users/specialization/<?=(int)$data['specialization_id'];?>"><?=$spec;?></a></p>
						</p>
						<? /* if($data['term'] == 11) { 
							<p><?=T('Status');?>:<br>
							<a href="<?=BASE_PATH;?>users/all"><?=T('graduated');?></a></p>
						<? }else{ */ ?>
							<p><?=T('term');?>:<br>
							<a href="<?=BASE_PATH;?>users/term/<?=(int)$data['faculty_id'];?>/<?=$data['term'];?>"><?=$term;?></a></p>
							<p><?=T('Status');?>:<br>
							<a href="<?=BASE_PATH;?>users/all"><?=$status;?></a></p>
						<?// } ?>
					</div>	
					 <a href="javascript:void(0)" onclick="showHide('contactinfo')" class="b"><?=T('contactsettings');?></a>
						<div id="contactinfo">	
							<p><?=T('phone');?>:<br> 
								<a href="javascript:void(0)"><?=$data['phone'];?></a>
							</p>
							<p><?=T('Skype');?>:<br> 
								<a href="javascript:void(0)"><?=$data['skype'];?></a>
							</p>
							<p><?=T('vkontakte');?>:<br> 
								<? $data['vkontakte'] = str_replace('www.','',$data['vkontakte']); 
								$url = parse_url('http://'.$data['vkontakte']); //inspect($url);
									$url = $url['host']; ?>
								<a href="http://<?=$data['vkontakte'];?>" target="_blank"><?=$url;?></a>
							</p>
						</div>
					<a href="<?=BASE_PATH.'following'.($my?'':'/'.$id);?>"  class="b"><?=T('following');?> 
						<span class="right"><?=($data['following'] == ''? 0 : count(explode(',',$data['following']))); ?></span>
					</a>	
					<a href="<?=BASE_PATH.'followers'.($my?'':'/'.$id);?>"  class="b"><?=T('followers');?>
						<span class="right"><?=($data['followers'] == ''? 0 : count(explode(',',$data['followers']))); ?></span>
					</a>	
			</td>
		</tr>		
	</table>
	</center>
	<? /*}*/  if(!@$first) 	break;
	
	
	case 'education': { $id = $_SESSION['user']['id']; ?>
	<div class="wrapp">
	 <form  method="POST" action="<?=BASE_PATH;?>users/saveme" id="eduform">
	 <input type="hidden" name="id" value="<?=$id;?>">
	  <input type="hidden" name="form[confirmed]" value="2">
	  
	  <? $data = $_SESSION['user']; // if($data['confirmed'] == 2 ) { ?>
	  <div class="leftmenu" style="width:208px; float:left;border-right:1px lightgray solid;">
		<a href="<?=BASE_PATH;?>settings" class="b"><?=T('startsettings');?></a>
		<a href="<?=BASE_PATH;?>users/education" class="b"><?=T('education');?></a>
		<a href="<?=BASE_PATH;?>contactinfo" class="b"><?=T('contactsettings');?></a>	
		<p style="height:25px"> </p>		
	</div>
	<? //}

	include('edu.tpl.php');
	
	?></form>
	
	<? if($data['confirmed'] == 26585 ) { //inspect($data); ?>
	<script language="javascript">
		setSelVal('<?=$data['term'];?>','termsel');
		setSelVal('<?=$data['country'];?>','countrysel');
		setTimeout("drawSelect('cities','<?=$data['country'];?>','country_id','city','drawUnies','<?=$data['city_id'];?>');",300);
		setTimeout("drawSelect('universities','<?=$data['city_id'];?>','city_id','uni','drawFacs','<?=$data['uni_id'];?>');",600);
		setTimeout("drawSelect('faculties','<?=$data['uni_id'];?>','uni_id','faculty','drawSpec','<?=$data['faculty_id'];?>');",900);
		setTimeout("drawSelect('specialization','<?=$data['faculty_id'];?>','faculty_id','specialization','','<?=$data['specialization_id'];?>');",1200);	
	</script>
	
	<? } ?>
	</div>
<? }
break;
	case 'following':
	case 'followers': //inspect($data);?>
	<div class="wrapp" style="width:687px">
	<h4 class="subhd" style="width:682px"><?=T($do);?></h4>
			<span class="wptxt">
				<? $s = (is_array($data)?sizeof($data):0); echo $s; ?> 
					<?=C('contacts',$s);?> </span>
			<br>
			
	<table class="contacttable" cellpadding=0 cellspacing=0>
	<? if(is_array($data)){ 
		$total = (int)sizeof(@$data); 
		foreach ($data as $row){ if($row['id']=='1') $row['university'] = 'ISMA'; ?>
		<? //if ($i==$total) echo ' class="noborder"'; $i++; ?>
			
			<td width="55px">
			<a href="<?=BASE_PATH;?>id<?=$row['id'];?>">
				<? if (file_exists("up/photossml/{$row['id']}.jpg")){ ?>
				<img src="<?=BASE_PATH;?>up/photossml/<?=$row['id'];?>.jpg">
				<? }else{ ?>
				<img src="<?=PUB;?>img/defaultavatarsml.png">
				<? } ?>
				</a>
			<td width="450px">
				<a href="<?=BASE_PATH;?>id<?=$row['id'];?>"><?=$row['name'];?> <?=$row['surname'];?></a><br>
				<p><a href="<?=BASE_PATH;?>users/uni/<?=$row['uni_id'];?>"><?=$row['university'];?></a></p>
			</td>
			<td width="141px">		
				<? if ( (@$id == $_SESSION['user']['id'] ) || (@$id<1 && @$_SESSION['user']['id'] !='') ){ ?>
				<p>	<a href="<?=BASE_PATH;?>mail/compose/<?=$row['id'];?>">
					<?=T('write mail');?>
				 </a></p>
				<p> 
				 <a href="<?=BASE_PATH;?>users/delcontact/<?=$row['id'];?>">
					<?=T('delcontact');?>
				 </a>
				 </p>
				 <? } ?>
			</td>
		</tr>	
	<?  } }?>
	</table>
	<? $s = (is_array($data)?sizeof($data):0); 
	if ($s==0)
		{?>
		<table>
			<td width=687px><center class="big"><?=T('no_friends');?></center></td>
		</table>
	<?} ?>
	</div>
	<?
	break;
	
	case 'editcontacts': ?>
	<div class="wrapp">
	 <? $id = $_SESSION['user']['id']; $data = $_SESSION['user'];?>
	 <form  method="POST" action="<?=BASE_PATH;?>users/savecontact" id="contactform">
	<input type="hidden" name="id" value="<?=$id;?>">
	<div class="leftmenu" style="width:208px; float:left;border-right:1px lightgray solid;">
		<a href="<?=BASE_PATH;?>settings" class="b"><?=T('startsettings');?></a>
		<a href="<?=BASE_PATH;?>users/education" class="b"><?=T('education');?></a>
		<a href="<?=BASE_PATH;?>contactinfo" class="b"><?=T('contactsettings');?></a>
		<p style="height:25px"> </p>
	</div>
			<table class="wrp" cellpadding=0 cellspacing=0>
				 <tr>
				 <td colspan=3>
					<h4>	<a href="javascript:void(0)"><?=T('Change contacts');?></a> 
					</h4>
				 </td>

			 </tr>
				<tr>
					<tr>
					<td class="tbleft">
						<?=T('phone');?>:
					</td>
					<td>
						<input name="form[phone]" value="<?=$data['phone'];?>">
					</td>
				</tr>
				<tr>
					<td class="tbleft">
						<?=T('Skype');?>:
					</td>
					<td>
						<input name="form[skype]" value="<?=$data['skype'];?>">
					</td>
				</tr>
				<tr>
					<td class="tbleft">
						<?=T('vkontakte');?>:
					</td>
					<td>
						<input name="form[vkontakte]" value="<?=$data['vkontakte'];?>">
					</td>
				</tr>
				<tr>
					<td>
				
					</td>
					<td>
						<a href="javascript:void(0)" onclick="$('contactform').submit()">
							<div class="button" style="width:80px"><?=T('save');?></div>
						</a>
					</td>
				 </tr>
			</table>
		 </td>
	 </form>
	 </div>
	<?
	break;
	
	
	
	
	
	case 'settings': $_err = $data;?>
	<div class="wrapp">
	 <? $id = $_SESSION['user']['id']; $data = $_SESSION['user'];?>
	 <form  method="POST" action="<?=BASE_PATH;?>settings" id="userform">
	<input type="hidden" name="id" value="<?=$id;?>">
	<input type="hidden" name="part" value="name">
	<div class="leftmenu" style="width:208px; float:left;border-right:1px lightgray solid;">
		<a href="<?=BASE_PATH;?>settings" class="b"><?=T('startsettings');?></a>
		<a href="<?=BASE_PATH;?>users/education" class="b"><?=T('education');?></a>
		<a href="<?=BASE_PATH;?>contactinfo" class="b"><?=T('contactsettings');?></a>
		<p style="height:25px"> </p>
	</div>
			<table class="wrp" cellspacing=0>
				<tr>
					<td colspan=3>
						<h4><a href="javascript:void(0)"><?=T('changename');?></a></h4>
					</td>
				</tr>
				<tr>
					<tr>
					<td class="tbleft">
						<?=T('first name');?>:
					</td>
					<td>
						<input name="form[name]" value="<?=$data['name'];?>">
					</td>
				</tr>
				<tr>
					<td class="tbleft">
						<?=T('second name');?>:
					</td>
					<td>
						<input name="form[surname]" value="<?=$data['surname'];?>">
					</td>
					<td> </td>
				</tr>
				<tr>
					<td></td>
					<td>
						<a href="javascript:void(0)" onclick="$('userform').submit()">
							<div class="button insBtn"><?=T('changename');?></div>
						</a>
					</td>
				</tr>
				<? if(isset($_err['nameerror'])){ ?>
				<tr>
					<td></td>
					<td class="errors" id>
						<div><?=T($_err['nameerror']);?></div>	
					</td>
				</tr>
				<? } ?>
			</form>
			
			<form  method="POST" action="<?=BASE_PATH;?>settings" id="mailform">	
			<input type="hidden" name="part" value="mail">
				<tr>
					<td colspan=3>
						<h4><a href="javascript:void(0)"><?=T('changemail');?></a></h4>
					</td>
				</tr>				
				<tr>
					<td class="tbleft">
						<?=T('currentemail');?>:
					</td>
					<td>
						<input name="form[mail]" value="<?=$data['mail'];?>">
					</td>
					<td style="width:350px"> </td>
				</tr>
				<tr>
					<td class="tbleft">
						<?=T('newmail');?>:
					</td>
					<td>
						<input name="newmail">
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<a href="javascript:void(0)" onclick="$('mailform').submit()">
							<div class="button insBtn"><?=T('changeemail');?></div>
						</a>
					</td>
				</tr>
				<? if(isset($_err['mailerror'])){ ?>
				<tr>
					<td></td>
					<td class="errors" id>
						<div><?=T($_err['mailerror']);?></div>	
					</td>
				</tr>
				<? } ?>

			</form>
			
			<form  method="POST" action="<?=BASE_PATH;?>settings" id="passform">
			<input type="hidden" name="part" value="pass">
				<tr>
					<td colspan=3>
						<h4><a href="javascript:void(0)"><?=T('changepass');?></a></h4>
					</td>
				</tr>
				<tr>
					<td class="tbleft">
						<?=T('old pass');?>:
					</td>
					<td>
						<input name="oldpass" type="password">
					</td>
					<td>
					
					</td>
				</tr>
				<tr>
					<td class="tbleft">
						<?=T('new pass');?>:
					</td>
					<td>
						<input name="form[pass]" type="password">
					</td>
					<td>
					
					</td>
				</tr>
				<tr>
					<td class="tbleft">
						<?=T('repeat pass');?>:
					</td>
					<td>
						<input name="newpass" type="password">
					</td>
					<td>
					
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<a href="javascript:void(0)" onclick="$('passform').submit()">
							<div class="button insBtn"><?=T('changepass');?></div>
						</a>
					</td>
				</tr>
				<? if(isset($_err['passerror'])){ ?>
				<tr>
					<td></td>
					<td class="errors" id>
						<div><?=T($_err['passerror']);?></div>	
					</td>
				</tr>
				<? } ?>
			</table>
		 </td>
	 </form>
	 </div>
	<?
	break;
	
	case 'seminars' :// inspect($data);
	?>
	
	<div class="wrapp" style="width:687px">
		<p>
			<h4 class="subhd" style="width:682px"><?=T('My Seminars');?></h4>
			<span class="wptxt"><? $s = sizeof($data); echo $s; ?> <?=C('tasks',$s);?> <? /*T('seminares'); */?></span>
			<? if($s>0){ 
			foreach ($data as $seminar){ ?>
			<p class="wpp"><img src="<?=PUB;?>img/iconoy.jpg" align="absmiddle"> <a href="<?=$pre;?>seminars/question/<?=$seminar['id'];?>"><?=$seminar['question'];?></a> 
			<a href="<?=$pre;?>seminars/rm/<?=$seminar['id'];?>"><img src="<?=PUB;?>img/cross.png" class="px1" title="<?=T('del');?>" alt="<?=T('del');?>" text="<?=T('del');?>" align="absmiddle"></a></p>
			<? }} else{ ?>
			<p class="wpp"><img src="<?=PUB;?>img/iconoy.jpg" align="absmiddle"> <?=T('no seminars'); ?></p>
			<? } ?>
		</p>
	</div>		
	<? break;

	
	case 'mylectures' : //inspect($data);
	?>	
		<p>
			<h4 class="subhd" style="width:682px"><span><?=T('My Lectures');?></span></h4>
			<span class="wptxt"><? $l = sizeof($data); echo $l; ?> <?=C('lectures',$l);?></span>				
			<? if($l>0){ foreach ($data as $lecture){ ?>
			<p class="wpp"><img src="<?=PUB;?>img/iconoy.jpg" align="absmiddle"> <a href="<?=$pre;?>lectures/view/<?=$lecture['id'];?>"><?=$lecture['name'];?></a> 
			<a href="<?=$pre;?>lectures/rm/<?=$lecture['id'];?>"><img src="<?=PUB;?>img/cross.png" class="px1" align="absmiddle"></a></p>
			<? }} else{ ?>
			<p class="wpp"><img src="<?=PUB;?>img/iconoy.jpg" align="absmiddle"> <?=T('no lectures'); ?></p>
			<? } ?>
		</p>
	<? break;
	
	case 'mysummaries' : //inspect($data);
	?>
	<div class="wrapp" style="width:687px">
		<p>
			<h4 class="subhd" style="width:682px"><?=T('My summaries');?></h4>
			<span class="wptxt"><? $r = sizeof($data); echo $r;?> <?=C('summaries',$r);?></span>
			<? if($r>0) { foreach ($data as $referat){ ?>
			<p class="wpp"><img src="<?=PUB;?>img/iconoy.jpg" align="absmiddle"> <a href="<?=$pre;?>summaries/view/<?=$referat['id'];?>"><?=$referat['name'];?></a> 
			<a href="<?=$pre;?>summaries/rm/<?=$referat['id'];?>"><img src="<?=PUB;?>img/cross.png" class="px1" align="absmiddle"></a></p>
			<? }} else{ ?>
			<p class="wpp"><img src="<?=PUB;?>img/iconoy.jpg" align="absmiddle"> <?=T('no summaries'); ?></p>
			<? } ?>
		</p>
	</div>		
	<? break;
	
    case 'dontexist':	
	default : include('halepa.tpl.php'); break;

	/*case 'upphoto': ?>
		<h1><?=T('upload photo');?></h1><br>
		<form method="post"  enctype="multipart/form-data" action="<?=BASE_PATH;?>users/upphoto">
			<input type="file" name="avatar">
			<input type="submit">
		</form>
	
	<?
	break; */
/*default:
		include('default.html');
	break;*/
} ?>	