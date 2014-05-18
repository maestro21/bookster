<!DOCTYPE html>
<html>
	<head>
		<title>Bookster</title>
		<LINK REL="SHORTCUT ICON" href="<?=PUB;?>img/icon.png" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="google-site-verification" content="XZVFMF7bF0WRPqxUFzbLjwo7MERj9Spm7sIEJqsFaG8" />		
		<link rel="stylesheet" type="text/css" href="<?=PUB;?>style.css" /> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<script language="javascript" src="<?=BASE_PATH;?>ajax.js"></script>
		<script language="javascript"><?=stpl('functions.js');?></script>
	</head>	
	<body class="first">
		<center>
		<div class="header">
			<div class="wrap table">
				
				<a href="javascript:void(0)" onclick="showHide('login')" class="loginbtn">
					<img src="<?=BASE_PATH;?>www/img/first_login.png" align="absmiddle" height="32"> <?=T('login');?>
				</a>
				
				<a href="<?=BASE_PATH;?>"><img src="<?=BASE_PATH;?>www/img/logo.png" height="27px" style="margin-top:10px"></a>
				
				<div class="dropdownmenu" id="login">	
					<form id="loginForm" method="POST" action="<?=BASE_PATH;?>login">
						<table class="logtbl"  cellpadding=0 cellspacing=0 border=0>
							<tr>
								<td>	
									<input name="form[mail]" class="inp" onfocus="empt(this,'<?=T('email');?>')" onblur="chk(this,'<?=T('email');?>')" value="<?=T('email');?>">&nbsp;
								</td>
								<td>
									<input name="form[pass]" class="inp" type="password" value="<?=T('pass');?>" onfocus="empt(this,'<?=T('pass');?>')" onblur="chk(this,'<?=T('pass');?>')">
								</td>
								<td>
									<a href="javascript:void(0)" onclick="$('loginForm').submit()">
										<div class="button" style="width:80px"><?=T('login');?></div>
									</a>
								</td>
							</tr>
							<tr>
								<td class="gray">
									<input type="checkbox" name="keeplogged" align="left"> <?=T('keep me logged');?>
								</td>
								<td class="gray">
									<a href="<?=BASE_PATH;?>restore"><?=T('forgot pass');?></a><br>
								</td>
								<td id="logError">
								
								</td>
							</tr>
						</table>
					</form>
				</div>	
				
			</div>
		</div>
		
		<div class="firstpage">
			<div class="blackbg">
				<div class="wrap">
					<h1><?=T('slogan');?></h1>
					<p><?=T('description');?></p>

					<a href="javascript:void(0)" class="signup" onclick="showHide('regform')"><div><?=T('join now');?></div></a>
				</div>
			</div>
			
			<div class="dropdownmenu regform" id="regform">
				<div style="float:right;"><a href="javascript:void(0)" onclick="showHide('regform')">X</a></div>
				<form id="regiForm" method="POST" action="<?=BASE_PATH;?>users/register" onsubmit="checkRegForm()">
					<table class="regtable" border=0>
						<tr>
							<td style="text-align:left !important">
								<h3><?=T('register');?></h3>
							</td>
						</tr>	
						<tr>
							<td>
								<input name="form[name]" onfocus="empt(this,'<?=T('first name');?>')" onblur="chk(this,'<?=T('first name');?>')" id="regName" value="<?=T('first name');?>">
							</td>
						</tr>
						<tr>
							<td>
								<input name="form[surname]" onfocus="empt(this,'<?=T('last name');?>')" onblur="chk(this,'<?=T('last name');?>')" id="regSurName" value="<?=T('last name');?>">
							</td>
						</tr>
						<tr>
							<td>
								<input name="form[mail]" onfocus="empt(this,'<?=T('email');?>')" onblur="chk(this,'<?=T('email');?>')" id="regMail" value="<?=T('email');?>">
							</td>
						</tr>
						<tr>
							<td>
								<input name="form[pass]" onfocus="empt(this,'<?=T('pass');?>')" onblur="chk(this,'<?=T('pass');?>')" id="regPass" type="password" value="<?=T('pass');?>">
							</td>
						</tr>
						<tr>
							<td>
								<a href="#" class="signup" onclick="checkRegForm()"><div><?=T('signup');?></div></a>
							</td>
						</tr>
						<tr>
							<td id="regErrors">
								<?=(isset($data['msg'])?'<div>'.T($data['msg']).'</div>':'');?>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>		
		
		<div class="firstpage_row_2">
			<center>
				<div class="one"><?=T('Use everywhere');?></div>
				<div class="two"> <img src="<?=BASE_PATH;?>www/img/listen-everywhere-device-icons.png"></div>
			</center>
		</div>
		
		<div class="firstpage_row_3">
			<div class="wrap">
			
				<div>
					<h2>Share with real friends</h2>
					Photos and updates from the people that matter. It's social the way it was meant to be: real friends sharing real life.			
				</div>

				<div>
					<h2>Real-time messaging</h2>
					Join the millions of people using Tuenti to send free real-time messages. And since it works on your phone and desktop, it goes wherever you do.			
				</div>
				
				<div>
					<h2>Private</h2>
					You want to share with friends, not the World Wide Web. Everything you do on Tuenti is, and will always be, 100% private.		
				</div>			
				
			</div>
		</div>
				
		<div class="footer">
			<div class="wrap">
				<?=tpl('footer');?>
				<a href="<?=BASE_PATH;?>sitemap"><h1><b style="color:white;font-size:0px">Sitemap</b></h1></a>
			</div>
		</div>
	</center>			

		
		
		
		
		
		
		
			
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