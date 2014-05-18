<html>
<head>
</head>
<body>


<? switch($lang){
	case "ru":
	?>
		<p>Здравствуйте, <?=$username;?></p>
		
		<p>Ваша учетная запись была создана</p>
		
		<p><b>Теперь вы можете получить новые, доступные для вас возможности:</b></p>
		
		<p>Найти необходимые материалы</p>
		
		<p>Делиться информацией с друзьями</p>
		
		<p>Редактировать свой профиль</p>
		
		<p>Если у Вас есть какие-нибудь вопросы или предложения, обратитесь в <a href="http://bookster.com.ua/help">наш центр помощи</a>
		</p>
		
		<p>Спасибо,<br>
		Команда Bookster</p>
		
               <p><i style="font-size:10px !important;color:gray !important;"> Не регистрировались на Bookster?  Пожалуйста, <a href="<?=BASE_PATH;?>confirmemail">дайте нам знать</a>. Сообщение было создано для  <?=$usermail;?>. Если вы не хотите в дальнейшем получать такие сообщения от Bookster, пожалуйста нажмите <a href="<?=BASE_PATH;?>unsubscribe">отказаться от подписки</a>.</p>
					
                 	<?
	break;
	
	case "ua":
	?>
				<p>Вітаємо, <?=$username;?></p>
		
		<p>Ваш обліковий запис був створений.</p>
		
		<p><b>Тепер ви зможете отримати максимум можливостей з цього:</b></p>
		
		<p>Знайти необхідні матеріли</p>
		
		<p>Обмінятися інформацією з друзями</p>
		
		<p>Редагувати свій профіль</p>
		
		<p>Якщо ви маєте будь-які питання чи пропозиції, зверніться до нашого <a href="http://bookster.com.ua/help">центру допомоги</a>
		</p>
		
		<p>Дякуємо,<br>
		Команда Bookster</p>
		
              <p><i style="font-size:10px !important;color:gray !important;"> Не робили запит? Будь ласка, <a href="<?=BASE_PATH;?>confirmemail">повідомте нас</a>. Це повідомлення було створене для <?=$usermail;?>. Якщо Ви не бажаєте в майбутньому отримувати такі повідомлення від Bookster, клацніть <a href="<?=BASE_PATH;?>unsubscribe">тут</a>, щоб відмовитись.</p>
						
	<?
	break;
	
	case "en":
	?>
				
				<p>Hi <?=$username;?></p>
		
		<p>Your account has been created</p>
		
		<p><b>Now you can have an access to the new opportunities:</b></p>
		
		<p>To find necessary information</p>
		
		<p>Share information with friends</p>
		
		<p>Edit your profile</p>
		
		<p>If you have any questions, reference our <a href="http://bookster.com.ua/help">help center</a>
		</p>
		
		<p>
Thanks,<br>
		Bookster team</p>
		
              <p><i style="font-size:10px !important;color:gray !important;"> Didn’t sign up for Bookster? Please <a href="<?=BASE_PATH;?>confirmemail">let us know</a>. The message was sent to <?=$usermail;?>. If you don’t want to receive these emails from Bookster in the future, you can <a href="<?=BASE_PATH;?>unsubscribe">unsubsribe</a>.</p>
					
                 <?	
	break;


} ?>
</body>
</html>