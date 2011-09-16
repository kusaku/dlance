<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Системное сообщение | Dlance.ru</title>
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="/templates/wdesigns/css/styles.css">
<link rel="alternate" type="application/rss+xml" href="http://ci.ru/rss/projects" title="Проекты (RSS 2.0)">
</head>
<body>
<div id="custom-doc" class="yui-t5">

<div id="top" class="yui-gd">
<div class="yui-u first logo"><a href="/"><span></span></a> </div>
<div class="yui-u premium"> &nbsp; </div>
</div>


<div id="topnav">
	<div>
		<div>
			<div style="position:relative;">
<ul>
<li class="first"><a href="/">Главная</a></li>
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



<div id="bd">

		<h1>Системное сообщение</h1>
<?=$message?>


<? if( isset($_SERVER['HTTP_REFERER']) ): ?>
<br />
<a href="<?=$_SERVER['HTTP_REFERER']?>">Вернуться назад</a>
<? endif ?>
<br clear="all">
<div style="font-size:11px;" class="mt20 clearfix"></div>
</div>

<div id="ft">
	<div id="ft-inner" class="yui-gf">
		<div id="copyright" class="yui-u first"> 

		</div>
	<div id="bottomnav" class="yui-u"><ul>
<li><a href="/">Главная</a></li>
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
</body>
</html>