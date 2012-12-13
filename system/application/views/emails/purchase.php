<!DOCTYPE html>
<html>
	<head></head>
	<body>
		<p>
			Здравствуйте, <?= "{$name} {$surname}"?>.
		</p>
		<p>Пользователь с контактными данными:</p>
		<ul>
			<li>
				<?= "{$thisuser_name} {$thisuser_surname}"?> (<a href="<?=base_url()?><?= "users/{$my_name}"?>"><?= $my_name?></a>)
			</li>
			<li>
				<a href="mailto:<?=$thisuser_email?>"><?= $thisuser_email?></a>
			</li>
			<li>
				<?= $thisuser_telephone?>
			</li>
		</ul>
		<p>
			желает приобрести Ваш товар: <a href="<?=base_url()?><?= "designs/{$id}.html"?>"><?= $title?></a>
		</p>
		<p>Свяжитесь с покупателем для уточнения деталей.</p>
		<p>
			С уважением,
			<br/>
			Компания Фабрика сайтов
			<br/>
			Проект Ф.Дизайн
			<br/>
			design.fabricasaitov.ru
		</p>
	</body>
</html>
