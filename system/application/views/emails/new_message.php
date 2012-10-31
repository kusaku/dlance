<!DOCTYPE html>
<html>
	<head></head>
	<body>
		<p>
			Здравствуйте, <?= $recipient_username?>.
		</p>
		<p>
			<?= $name?> <?= $surname?> [<?= $username?>]
		</p>
		<hr/>
		<p>
			<?= $text?>
		</p>
		<hr/><a href="<?=base_url()?>contacts/"><?= base_url()?>contacts/</a>
		<hr/>
		<p>Данное сообщение является автоматическим уведомлением.</p>
		<p>С уважением, администрация сайта.</p>
		<p>
			<a href="<?=base_url()?>"><?= base_url()?></a>
		</p>
	</body>
</html>
