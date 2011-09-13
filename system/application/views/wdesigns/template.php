<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta name="google-site-verification" content="GZ6LEudcMoq7OAIcz-ywUZjW9pM6jROZqY4Rn0y_Ei8" />
<meta name='yandex-verification' content='51dcabbe6fb5f2d8' />
<title><?=$title?></title>
<? if( isset($description) ): ?>
<?=$description?>

<? endif; ?>
<? if( isset($keywords) ): ?>
<?=$keywords?>

<? endif; ?>
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="/templates/wdesigns/css/styles.css">
<link rel="alternate" type="application/rss+xml" href="<?=base_url()?>rss/designs" title="Дизайны сайтов (RSS 2.0)">
<script type="text/javascript" src="/templates/js/jquery.js"></script>
<script type="text/javascript" src="/templates/js/jquery.cookie.js"></script>
<?=$script?>
</head>
<body>
<div id="custom-doc" class="yui-t5">

<div id="top" class="yui-gd">
<div class="yui-u first logo"><a href="<?=base_url()?>" title="<?=$this->config->item('title')?>"><span></span></a> </div>
<div class="yui-u premium">


</div>
</div>
<div id="pathway"><a href="<?=base_url()?>"><?=$this->config->item('site')?></a> &raquo; </div>

<div id="topnav">
	<div>
		<div>
			<div style="position:relative;">
<ul>
<li class="first"><a href="<?=base_url()?>">Главная</a></li>
<li><a href="/news">Новости проекта</a></li>
<li><a href="/designs">Дизайны</a></li>
<li><a href="/designs/search">Поиск дизайнов</a></li>
<li><a href="/users/all">Каталог дизайнеров</a></li>
<li><a href="/blogs">Блоги</a></li>
<li><a href="/help">Помощь</a></li>
<li><a href="/users/support">Обратная связь</a></li>
</ul>
			</div>
		</div>
	</div>
</div>

<?=$login?>
<div id="bd">

<?=$content?>

<br clear="all">
<div style="font-size:11px;" class="mt20 clearfix"></div>
</div>

<div id="ft">
	<div id="ft-inner" class="yui-gf">
		<div id="copyright" class="yui-u first"> 

		</div>
	<div id="bottomnav" class="yui-u"><ul>
<li><a href="<?=base_url()?>">Главная</a></li>
<li><a href="/news">Новости проекта</a></li>
<li><a href="/designs">Дизайны</a></li>
<li><a href="/users/all">Каталог дизайнеров</a></li>
<li><a href="/blogs">Блоги</a></li>
<li><a href="/help">Помощь</a></li>
<li><a href="/users/support">Обратная связь</a></li>
</ul>

<ul></ul></div>
	</div>
</div>



</div>
<br>
<span style="font-size:85%;">&copy; <a href="<?=base_url()?>" title="<?=$this->config->item('title')?>"><?=$this->config->item('site')?></a> 2010.</span>
</body>
</html>