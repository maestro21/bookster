<?php if(isset($_POST['pass'])){
	$login = parseString(@$_POST['login']);
	$pass = parseString(@$_POST['pass']);
	if(isset($_POST['new'])){  //register;
		$sql  ="SELECT 1 FROM admins WHERE login='$login'";
		if(DBfield($sql)){
			$message = str_replace("{bro}",$login,T('reg_false'));
		}else{
			$sql = "INSERT INTO admins SET login='$login', pass='".md5($pass)."' , isadmin=0";
			DBquery($sql); // mkdir("logs/$login");
			$message = T('reg_ok');
		}
	}else{ //try to login
		$sql  ="SELECT * FROM admins WHERE login='$login' and pass='".md5($pass)."' and isadmin";		echo $sql;
		$id = DBrow($sql);
		if($id){		
			$_SESSION['engineAdmin'] = $id;
			?>
				<script>window.location=''</script>;
			<?php
		}else{
			$message = T('login_false');
		}
	}
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>Login</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
	<center>
		<table class="zoom" style="">
			<tr>
				<td align="center" style="vertical-align:middle !important">
					<div class="langs"><a href="?lang=ru">RU</a> <a href="?lang=en">EN</a></div>
					<form method="post">
						<input type="hidden" name="action" value="login">					
						<table class="form">
							<thead>
								<tr align="center">
									<td colspan="2">
										<h2><?=T('comein');?></h2>
										<i style="color:red;"><?=@$message;?></i>		
									</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align=right>
										<?=T('login');?>
									</td>
									<td>
										<input type="text" name="login">
									</td>	
								</tr>
								<tr>
									<td align=right>
										<?=T('pass');?>
									</td>
									<td>
										<input type="password" name="pass">
									</td>	
								</tr>
								<tr>
									<td align=right>
										<?=T('imnewhere');?>
									</td>
									<td>
										<input type="checkbox" name="new">
									</td>	
								</tr>
								<tr>
									<td colspan="2" align="center">
										<input type="submit" value="send">
									</td>
								</tr>
							</tbody>	
							</table>						
						</form>
					
				</td>	
			</tr>
		</table>
	</body>
</html>	