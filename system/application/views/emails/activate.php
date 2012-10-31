<!DOCTYPE html>
<html>
	<head></head>
	<body>
		<p>
			Здравствуйте, <?= $username?>.
		</p>
		<p>Активируйте аккаунт! Пройдите по ссылке:</p>
		<p>
			<a href="<?=$code?>"><?= $code?></a>
		</p>
		<p>Спасибо за регистрацию.</p>
	</body>
</html>
