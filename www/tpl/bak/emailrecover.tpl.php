<html>
<head>
</head>
<body>


<? switch($lang){
	case "ru":
	?>
		<p>Здравствуйте, <?=$username;?></p>
		
		<p>Недавно вы сделали запрос, чтобы изменить свой пароль Bookster. Ваш новый пароль: 
		<?=$pass;?></p>

	<p>Спасибо,<br>
	Команда Bookster</p>
                 	
					 <p><i style="font-size:10px !important;color:gray !important;"> Не делали запрос? Пожалуйста, <a href="<?=BASE_PATH;?>confirmemail">дайте нам знать</a>. Сообщение было создано для <?=$usermail;?>.  Если вы не хотите в дальнейшем получать такие сообщения от Bookster, пожалуйста нажмите <a href="<?=BASE_PATH;?>unsubscribe">отказаться от подписки</a>.</p>
					
					<?
	break;
	
	case "ua":
	?>
						<p>Вітаємо, <?=$username;?></p>
		
		<p>Нещодавно ви зробили запит, щоб змінити свій пароль Bookster. Ваш новий пароль:
		<?=$pass;?></p>

	<p>Дякуємо,<br>
	Команда Bookster</p>
                 	
					 <p><i style="font-size:10px !important;color:gray !important;"> Не робили запит? Будь ласка, <a href="<?=BASE_PATH;?>confirmemail">повідомте нас</a>. Це повідомлення було створене для <?=$usermail;?>. Якщо Ви не бажаєте в майбутньому отримувати такі повідомлення від Bookster, клацніть <a href="<?=BASE_PATH;?>unsubscribe">тут</a>, щоб відмовитись.</p>
					
	<?
	break;
	
	case "en":
	?>
				
					<p>Hi, <?=$username;?></p>
		
		<p>You have made a request recently for a Bookster password change. Your new password:
		<?=$pass;?></p>

	<p>Thanks,<br>
	Bookster team</p>
			 <p><i style="font-size:10px !important;color:gray !important;"> Didn't make a request? Please <a href="<?=BASE_PATH;?>confirmemail">let us know</a>. The message was sent to <?=$usermail;?>. If you don’t want to receive these emails from Bookster in the future, you can <a href="<?=BASE_PATH;?>unsubscribe">unsubsribe</a></p>
                 <?	
	break;


} ?>
</body>
</html>