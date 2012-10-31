<!DOCTYPE html>
<html>
	<head></head>
	<body>
		<p>
			Здравствуйте, <?= $recipient_username?>.
		</p>
		<p>
			Пользователь <?= $name?> <?= $surname?> [<?= $username?>] создал для вас платеж <a href="<?= base_url()?>/account/payments/<?= $payment_id?>.html"><?= base_url()?>/account/payments/<?= $payment_id?>.html</a>
		</p>
	</body>
</html>
