<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="<?=T('meta_description');?>" />
		<meta name="keywords" content="<?=T('meta_keywords');?>" />
		<meta property="fb:app_id" content="" />	
		<meta property="og:title" content="Education done simple - Bookster" />	
		<meta property="og:type" content="website" />		
		<meta property="og:url" content="http://bookster.com.ua/">
		<meta property="og:description" content="<?=T('meta_description');?>" />
		<title><?=t('slogan');?> - Bookster</title>
		<link rel="icon" href="<?=PUB;?>img/icon.png" />
		<link rel="stylesheet" type="text/css" href="<?=PUB;?>style.css" /> 
		<script language="javascript" src="<?=BASE_PATH;?>www/js/ajax.js"></script>
		<script language="javascript" src="<?=BASE_PATH;?>www/js/jquery.js"></script>	
		<script language="javascript"> <?=stpl('js/functions.js');?> </script>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<!--<script src="http://vk.com/js/api/openapi.js" type="text/javascript"></script>-->
	</head>	
	<body class="welcome">	
		<div class="welcome_bg">
			<div class="header">
				<div class="wrap table sub">	
					<div class="modal mdmotion" id="modal-reg">
						<div class="modalwindow">
							<?php /**/ echo tpl('users',array('do'=>'register')); /**/ ?>
						</div>
					</div>
					<?php include('header.tpl.php'); ?>
				</div>
			</div>
		
		<div class="welcome_row_1">
			<h1><?=T('slogan');?></h1>
			<p><?=T('description');?></p>			
			<div>
				<button class="click click_reg" data-modal="modal-reg"><?=T('signup');?></button>
			</div>
		</div>	
			
		</div>
		<div class="welcome_row_2">
				<div id="one"><?=T('Use everywhere');?></div>
				<div id="two"><img src="<?=BASE_PATH;?>www/img/vdiv3.jpg"></div>
				<div id="three"> <img src="<?=BASE_PATH;?>www/img/listen-everywhere-device-icons.png"></div>
				<div id="four"> </div>
		</div>
		
		<div class="welcome_row_3">
			<div class="wrap">			
				<div>
					<h2><?=t('first_h_1');?></h2>
					<?=t('first_desc_1');?>		
				</div>

				<div>
					<h2><?=t('first_h_2');?></h2>
					<?=t('first_desc_2');?>			
				</div>
				
				<div>
					<h2><?=t('first_h_3');?></h2>
					<?=t('first_desc_3');?>	
				</div>				
			</div>
		</div>
				
		<div class="footer">
			<div class="wrap">
				<?php include('footer.tpl.php'); ?>	
				<a href="<?=BASE_PATH;?>sitemap"><h1 style="width: 0px;
height: 0px;"><b style="color:white;font-size:0px">Sitemap</b></h1></a>
			</div>
		</div>
			

				<!-- Modal -->
		<div id="formModal" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer"></div>
		</div>		
		<?php echo tpl('analytics');?>	

		<script language="javascript" src="<?=BASE_PATH;?>www/js/classie.js"></script>
		<script language="javascript" src="<?=BASE_PATH;?>www/js/modalEffects.js"></script>
		<?php echo tpl('yandex'); /**/ ?>
	</body>
</html>