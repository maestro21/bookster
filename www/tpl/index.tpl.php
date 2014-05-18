<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="keywords" content="<?=T('meta_keywords');?>" />	<meta property="fb:app_id" content="" />	
		<?php if($title !='') $title .= ' - '; ?>
		<meta property="og:title" content="<?php echo $title;?> Bookster" />	
		<meta property="og:type" content="website" />		
		<meta property="og:url" content="http://bookster.com.ua/">
		<title><?php echo $title;?> Bookster</title>
		<link rel="icon" href="<?=PUB;?>img/icon.png" />
		<link rel="stylesheet" type="text/css" href="<?=PUB;?>style.css" />	
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>
		<script language="javascript" src="<?=BASE_PATH;?>ajax.js"></script>
		<script language="javascript" src="<?=BASE_PATH;?>ckeditor/ckeditor.js"></script>
		<script language="javascript"><?=stpl('functions.js');?>
		CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
		CKEDITOR.config.width ='750px';
		CKEDITOR.config.height='300px';
		</script>
		<script language="javascript">jQuery.noConflict();</script>
	</head>	
	<body>
		<center>
		<div class="wrap">
			<div class="header inside">
				<?php $_p = '';include('menu.tpl.php'); ?>				
			</div>

	
	
			<div class="content">
				<div class="wrapper">
					<?=$content;?>
				</div>
			</div>
			
			<div class="footer">
				<?=tpl('footer');?>
			</div>	
		</div>
		<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29509274-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	</body>
</html>