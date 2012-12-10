<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="google-site-verification" content="GZ6LEudcMoq7OAIcz-ywUZjW9pM6jROZqY4Rn0y_Ei8" />
		<meta name="yandex-verification" content="51dcabbe6fb5f2d8" />
		<title><?= $title; ?></title>
		<?= isset($description) ? $description : ''; ?>
		<?= isset($keywords) ? $keywords : ''; ?>
		<link rel="alternate" type="application/rss+xml" href="<?=base_url()?>rss/designs" title="Дизайны сайтов (RSS 2.0)" />
		<link type="text/css" href="/design/css/base.css" rel="stylesheet"/>
		<link type="text/css" href="/design/css/style.css" rel="stylesheet"/>
		<link type="text/css" href="/design/css/cusel.css" rel="stylesheet" />
		<link type="text/css" href="/design/css/jquery.fancybox-1.3.4.css" rel="stylesheet" />
		<link type="text/css" href="/design/js/smoothness/jquery-ui-1.9.1.custom.min.css" rel="stylesheet" />
		<script type="text/javascript" src="/design/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/design/js/jquery-ui-1.9.1.custom.min.js"></script>
		<script type="text/javascript" src="/design/js/jquery.bxSlider.min.js"></script>
		<script type="text/javascript" src="/design/js/jquery.fancybox-1.3.4.pack.js"></script>
		<script type="text/javascript" src="/design/js/jquery.placeholder.min.js"></script>
		<script type="text/javascript" src="/design/js/cusel-min-2.4.1.js"></script>
		<script type="text/javascript" src="/design/js/main.js"></script>
	</head>
	<body>
		<div class="wrapper">
			<div class="header">
				<div class="logoFd">
					<a href="<?=base_url()?>" title="<?=$this->config->item('title')?>"><img src="/design/images/logo_fd.png" alt="Ф.дизайн" /></a>
				</div>
				<div class="bannerPlace">
					
				</div>
				<div class="authBlock">
					<?= $login?>
				</div>
			</div>
			<div class="navBlock">
				<form class="fastSearch" action="/designs/search/" method="get">
					<input placeholder="Введите запрос" class="inputFastSearch" name="tags" type="text" value="<?=$input['tags']?>" id="tagsTop"/><button type="submit" class="submitFastSearch">Поиск</button>
				</form>
				<ul class="leftMenu">
					<li>
						<a href="<?=base_url()?>"><span>Главная</span></a>
					</li>
					<li>
						<a href="/news"><span>Новости</span></a>
					</li>
					<li>
						<a href="/designs"><span>Дизайны</span></a>
					</li>
					<li>
						<a href="/users"><span>Дизайнеры</span></a>
					</li>
					<li>
						<a href="/account/cart"><span>Корзина (<b id="cart_count"><?= "$cart_count" ?></b>)</span></a>
					</li>
				</ul>
				<ul class="rightMenu">
					<li>
						<a href="/users/support"><span>Обратная связь</span></a>
					</li>
					<li>
						<a href="/faq"><span>ЧаВо</span></a>
					</li>
					<li>
						<a href="/help"><span>Помощь</span></a>
					</li>
				</ul>
			</div>
			<div class="main">
				<!-- Основной контент выводим -->
				<?= $content?>
			</div>
			<div class="pushBlock"></div>
		</div>
		<div class="navBlock">
			<form class="fastSearch" action="/designs/search/" method="get">
				<input placeholder="Введите запрос" class="inputFastSearch" name="tags" type="text" value="<?=$input['tags']?>" id="tagsBottom"/><input name="fastbtn" type="submit" value="Поиск" class="submitFastSearch"/>
			</form>
			<ul class="leftMenu">
				<li>
					<a href="<?=base_url()?>"><span>Главная</span></a>
				</li>
				<li>
					<a href="/news"><span>Новости</span></a>
				</li>
				<li>
					<a href="/designs"><span>Дизайны</span></a>
				</li>
				<li>
					<a href="/designs"><span>Дизайнеры</span></a>
				</li>
				<li>
					<a href="/blogs"><span>Блоги</span></a>
				</li>
			</ul>
			<ul class="rightMenu">
				<li>
					<a href="/users/support"><span>Обратная связь</span></a>
				</li>
				<li>
					<a href="/faq"><span>ЧаВо</span></a>
				</li>
				<li>
					<a href="/help"><span>Помощь</span></a>
				</li>
			</ul>
		</div>
		<div class="footer">
			<div class="rightCopy">
				<p>
					&copy; 2011 Все права защищены.
					<br/>
					Проект компании <a href="http://fabricasaitov.ru" target="_blank">“Фабрика сайтов”</a>.
				</p>
			</div>
			<div class="fabricaLogo">
				<a href="http://fabricasaitov.ru" target="_blank"><img src="/design/images/cop.png" alt="Фабрика сайтов"/></a>
			</div>
		</div>
	</body>
</html>
