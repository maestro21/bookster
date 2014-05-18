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
		<?php if($title !='') $title .= ' - '; ?>
		<title><?php echo $title;?> Bookster</title>
		<link rel="icon" href="<?=PUB;?>img/icon.png" />
		<link rel="stylesheet" type="text/css" href="<?=PUB;?>style.css" /> 
		<script language="javascript" src="<?=BASE_PATH;?>www/js/ajax.js"></script>
		<script language="javascript" src="<?=BASE_PATH;?>www/js/jquery.js"></script>
		<script language="javascript" src="<?=BASE_PATH;?>external/ckeditor/ckeditor.js"></script>
		<script language="javascript"> <?=stpl('js/functions.js');?> 
				CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
		CKEDITOR.config.width ='750px';
		CKEDITOR.config.height='300px';		
		</script>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script src="http://vk.com/js/api/openapi.js" type="text/javascript"></script>
		<link href="<?=BASE_PATH;?>external/tagit/css/jquery.tagit.css" rel="stylesheet" type="text/css">
		<link href="<?=BASE_PATH;?>external/tagit/css/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?=BASE_PATH;?>external/tagit/js/tag-it.js" type="text/javascript" charset="utf-8"></script>
	</head>	
	<body class="welcome">	
			<div class="mainwrap">
				<div class="header">
					<div class="wrap table sub">
						<?php include('header.tpl.php'); ?>			
					</div>
				</div>
				

				<div class="wrap left wrapper">
					<?php if($ad) { ?>
					
						<div class="adleft">
							<?php echo tpl('adleft');?>
						</div>
						<div class="adright">
							<?php echo tpl('adright');?>
						</div>
						<div class="adtop">
							<?php echo tpl('adtop');?>
						</div>
						<?php echo $content;?>
						<div class="adbottom">
							<?php echo tpl('adbottom');?>
						</div>
					<?php } else {?>
						<?php echo $content;?>					
					<?php } ?>
				</div>
			</div>				
			<div class="footer">
				<div class="wrap">
					<?php include('footer.tpl.php'); ?>	
				</div>
			</div>
			<?php echo tpl('analytics');?>	
		<script language="javascript" src="<?=BASE_PATH;?>www/js/classie.js"></script>
		<script language="javascript" src="<?=BASE_PATH;?>www/js/modalEffects.js"></script>
		<?php echo tpl('yandex'); /**/ ?>
	</body>
</html>