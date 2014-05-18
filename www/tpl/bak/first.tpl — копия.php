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
		<link rel="stylesheet" type="text/css" href="<?=PUB;?>bootstrap/css/bootstrap.css" /> 
		<script language="javascript" src="<?=BASE_PATH;?>jquery.js"></script>
		<script language="javascript" src="<?=PUB;?>bootstrap/js/bootstrap.js"></script>		
		<script language="javascript"> <?=stpl('functions.js');?> </script>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script src="http://vk.com/js/api/openapi.js" type="text/javascript"></script>
	</head>	
	<body class="welcome">	
		<div class="welcome_bg">
			<div class="header">
				<div class="wrap table">	
					<a href="#formModal"  data-target="#formModal" class="loginbtn t2" href="#formModal" data-load-remote="<?=BASE_PATH;?>login" data-remote-target="#formModal .modal-body"  data-target="#formModal" role="button"  data-toggle="modal">
						<img src="<?=BASE_PATH;?>www/img/first_login.png" align="absmiddle" height="32"> <?=T('login');?>
					</a>
					<a href="<?=BASE_PATH;?>">
						<img src="<?=BASE_PATH;?>www/img/logo.png" height="27px" style="height:27px !important">
					</a>
				</div>
			</div>
		
			<div class="welcome_row_1">
					<h1><?=T('slogan');?></h1>
					<p><?=T('description');?></p>
					<a href="#formModal" data-load-remote="<?=BASE_PATH;?>register" data-remote-target="#formModal .modal-body"  data-target="#formModal" class="bigGreenButton" role="button"  data-toggle="modal"><div><?=T('join now');?></div></a>
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
				<table width="100%" cellpadding="0">
					<tr>
						<td width="800">
							<div>
								<a href="<?=BASE_PATH;?>help"><b><?=T('help');?></b></a>	

							<? $pages = DBall("SELECT * FROM pages WHERE lang='".getVar('lang','ua')."'"); $i=0; // inspect($pages);
								foreach ($pages as $page){ echo " &middot; ";  ?>

								<a href="<?=BASE_PATH;?><?=$page['url'];?>"><?=$page['title'];?></a><? /*$i++; if(sizeof($pages) != $i) */ }?> 
							</div>
							
							<div class="sharing">
								<a href="http://vk.com/bookster" target="_blank" class="vk"></a>
								<a href="http://www.facebook.com/bookstercom" target="_blank" class="fb"></a>
							</div>
						 </td>
						<td width="100">
							<? $countries = array (
								'ru' => 'Русский',
								'en' => 'English',
								'ua' => 'Українська',
								); 
							$lang = getVar('lang','ua');
							?>
							<div class="langselect">	
								<a href="javascript:void(0)" onclick="$('#langdropdown').toggle()">
									<img src="<?=PUB;?>img/<?=$lang;?>.png"> &nbsp;
									<b><?=$countries[$lang];?></b>
								</a>
								<? unset($countries[$lang]); ?>
								<div id="langdropdown">
									<? foreach ($countries as $k=>$v){ ?>
										<a href="<?=BASE_PATH;?>filter/lang/<?=$k;?>">
											<img src="<?=PUB;?>img/<?=$k;?>.png"> &nbsp;<b><?=$v;?></b>
										</a>
									<? } ?> 
								</div>
							</div>
							<div align="left" class="copy">&copy; <?=date('Y');?> Bookster</div>
						</td>
					</tr>
				</table>
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
			
		<script type="text/javascript">
			
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-29509274-1']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		
		
		$('[data-load-remote]').on('click',function(e) {
			e.preventDefault();
			var $this = $(this);
			var remote = $this.data('load-remote');
			if(remote) {
				$($this.data('remote-target')).load(remote, function() {
					$('.modal').css({
						position:'fixed',
						left: ($(window).width() - $('.modal').outerWidth())/2,
						top: ($(window).height() - $('.modal').outerHeight())/2
					});
					$($this.data('remote-target')).show();
				});
			}
		});
	
		
		
		</script>
	</body>
</html>