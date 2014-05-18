<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>Login</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	</head>
	<body class="login">
	<center>
		<table class="zoom" style="">
			<tr>
				<td id="content" align="center" style="vertical-align:middle !important">
					
					<form method="post" id="loginForm" action="<?=BASE_PATH;?>adm">
						<input type="hidden" name="action" value="login">					
						<table id="cmsTable" border="1">
							<thead>
								<tr align="center">
									<td colspan="2">
										Login
									</td>
								</tr>
							</thead>
							<tbody>
								<tr class="even">
									<td>
										Mail:
									</td>
									<td>
										<input type="text" name="mail">
									</td>	
								</tr>
								<tr class="even">
									<td>
										Pass:
									</td>
									<td>
										<input type="password" name="pass">
									</td>	
								</tr>
								<tr class="odd">
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