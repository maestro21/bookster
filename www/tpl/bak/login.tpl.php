<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css"> 
<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
<script language="javascript" src="ajax.js"></script>
<script language="javascript">
<?=stpl('functions.js');?>
</script>
</head>
<body>
	<div class="head">
		
		&nbsp; <h1><a href="<?=BASE_PATH;?>"><img src="img/logo.png" border=0></h1>
	</div>
	<div class="content">
		<form id="loginForm2" method="POST">
		<table class="wrapper"><tr><td>
		
		<table class="regtable" border=0>
			<tr>
				<td colspan=2>
					<h2><?=T('login');?></h2>
				</td>
			</tr>	
			<tr>
				<td colspan=2 id="regError">
					
				</td>
			</tr>
			<tr>
				<td>
					<?=T('email');?>:
				</td>
				<td>
					<input name="mail" id="regName">
				</td>
			</tr>
			<tr>
				<td>
					<?=T('pass');?>:
				</td>
				<td>
					<input name="pass" id="regSurName">
				</td>
			</tr>
			<tr>
				<td>
				
				</td>
				<td>
					<a href="#" class="login" onclick="$('loginForm2').submit()"><div><?=T('login');?></div></a>
				</td>
			</tr>
		</table>
		</td>
		</tr>
		</table>
		</form>
		<div class="footer">
			<?=tpl('footer');?>
		</div>
	</div>
	
	

</body>
</html>