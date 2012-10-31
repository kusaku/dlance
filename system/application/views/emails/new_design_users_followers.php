<!DOCTYPE html>
<html>
	<head></head>
	<body>
		<p>
			Здравствуйте, <?= $username?>.
		</p>
		<p>
			На подписанного вами пользователя - <?= $follows_username?>, была опубликована работа: <a href="<?=base_url().'designs/'.$design_id?>.html"><?= base_url().'designs/'.$design_id?>.html</a>
		</p>
	</body>
</html>
