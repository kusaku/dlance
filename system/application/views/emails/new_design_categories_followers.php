<!DOCTYPE html>
<html>
	<head></head>
	<body>
		<p>
			Здравствуйте, <?= $username?>.
		</p>
		<p>
			На подписанную вами рубрику, была опубликована работа: <a href="<?=base_url().'designs/'.$design_id?>.html"><?= base_url().'designs/'.$design_id?>.html</a>
		</p>
	</body>
</html>
