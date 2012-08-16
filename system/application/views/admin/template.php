<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en"><head>

	<title><?=$title?></title>
	<meta charset="utf-8">
	
	<!-- Global stylesheets -->
	<link href="/templates/admin/css/reset.css" rel="stylesheet" type="text/css">
	<link href="/templates/admin/css/common.css" rel="stylesheet" type="text/css">
	<link href="/templates/admin/css/form.css" rel="stylesheet" type="text/css">
	<link href="/templates/admin/css/standard.css" rel="stylesheet" type="text/css">
	
	<!-- Comment/uncomment one of these files to toggle between fixed and fluid layout -->
	<!--<link href="css/960.gs.css" rel="stylesheet" type="text/css">-->
	<link href="/templates/admin/css/960.gs.fluid.css" rel="stylesheet" type="text/css">
	
	<!-- Custom styles -->
	<link href="/templates/admin/css/simple-lists.css" rel="stylesheet" type="text/css">
	<link href="/templates/admin/css/block-lists.css" rel="stylesheet" type="text/css">
	<link href="/templates/admin/css/planning.css" rel="stylesheet" type="text/css">
	<link href="/templates/admin/css/table.css" rel="stylesheet" type="text/css">
	<link href="/templates/admin/css/calendars.css" rel="stylesheet" type="text/css">
	<link href="/templates/admin/css/wizard.css" rel="stylesheet" type="text/css">
	<link href="/templates/admin/css/gallery.css" rel="stylesheet" type="text/css">
	
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<link rel="icon" type="image/png" href="favicon-large.png">

	<!-- Generic libs -->
	<script type="text/javascript" src="/templates/admin/js/html5.js"></script>				<!-- this has to be loaded before anything else -->
	<script type="text/javascript" src="/templates/admin/js/jquery-1.4.2.min.js"></script>
	
	<!-- Template libs -->
	<script type="text/javascript" src="/templates/admin/js/jquery.accessibleList.js"></script>
	<script type="text/javascript" src="/templates/admin/js/searchField.js"></script>
	<script type="text/javascript" src="/templates/admin/js/common.js"></script>
	<script type="text/javascript" src="/templates/admin/js/standard.js"></script>
	<!--[if lte IE 8]><script type="text/javascript" src="js/standard.ie.js"></script><![endif]-->
	<script type="text/javascript" src="/templates/admin/js/jquery.tip.js"></script>
	<script type="text/javascript" src="/templates/admin/js/jquery.hashchange.js"></script>
	<script type="text/javascript" src="/templates/admin/js/jquery.contextMenu.js"></script>
	<script type="text/javascript" src="/templates/admin/js/jquery.modal.js"></script>
	
	<!-- Custom styles lib -->
	<script type="text/javascript" src="/templates/admin/js/list.js"></script>
	
	<!-- Plugins -->
	<script  type="text/javascript" src="/templates/admin/js/jquery.dataTables.min.js"></script>
	<script  type="text/javascript" src="/templates/admin/js/jquery.datepick/jquery.datepick.min.js"></script>
	
	<!-- Charts library -->
	<!--Load the AJAX API-->
	<script type="text/javascript" src="/templates/admin/js/jsapi.js"></script>
	<script type="text/javascript">
	
		// Load the Visualization API and the piechart package.
		google.load('visualization', '1', {'packages':['corechart']});
		
	</script>
	
	<script type="text/javascript">
		
		$(document).ready(function()
		{
			/**
			 * Example context menu
			 */
			
			// Context menu for all favorites
			$('.favorites li').bind('contextMenu', function(event, list)
			{
				var li = $(this);
				
				// Add links to the menu
				if (li.prev().length > 0)
				{
					list.push({ text: 'Move up', link:'#', icon:'up' });
				}
				if (li.next().length > 0)
				{
					list.push({ text: 'Move down', link:'#', icon:'down' });
				}
				list.push(false);	// Separator
			});
			
			// Extra options for the first one
			$('.favorites li:first').bind('contextMenu', function(event, list)
			{
				list.push(false);	// Separator
				list.push({ text: 'Статистика', icon:'terminal', link:'#', subs:[
					{ text: 'Статистика сервиса', link: '/administrator/', icon: 'blog' },
					{ text: 'Статистика операций', link: '/administrator/transaction/', icon: 'blog' }
				] });
			});
			
			/**
			 * Table sorting
			 */
			
			// A small classes setup...
			$.fn.dataTableExt.oStdClasses.sWrapper = 'no-margin last-child';
			$.fn.dataTableExt.oStdClasses.sInfo = 'message no-margin';
			$.fn.dataTableExt.oStdClasses.sLength = 'float-left';
			$.fn.dataTableExt.oStdClasses.sFilter = 'float-right';
			$.fn.dataTableExt.oStdClasses.sPaging = 'sub-hover paging_';
			$.fn.dataTableExt.oStdClasses.sPagePrevEnabled = 'control-prev';
			$.fn.dataTableExt.oStdClasses.sPagePrevDisabled = 'control-prev disabled';
			$.fn.dataTableExt.oStdClasses.sPageNextEnabled = 'control-next';
			$.fn.dataTableExt.oStdClasses.sPageNextDisabled = 'control-next disabled';
			$.fn.dataTableExt.oStdClasses.sPageFirst = 'control-first';
			$.fn.dataTableExt.oStdClasses.sPagePrevious = 'control-prev';
			$.fn.dataTableExt.oStdClasses.sPageNext = 'control-next';
			$.fn.dataTableExt.oStdClasses.sPageLast = 'control-last';
			
			// Apply to table
			$('.sortable').each(function(i)
			{
				// DataTable config
				var table = $(this),
					oTable = table.dataTable({
						/**
						 * We set specific options for each columns here. Some columns contain raw data to enable correct sorting, so we convert it for display
						 * @url http://www.datatables.net/usage/columns
						 */
						aoColumns: [
							{ bSortable: false },	// No sorting for this columns, as it only contains checkboxes
							{ sType: 'string' },
							{ bSortable: false },
							{ sType: 'numeric', bUseRendered: false, fnRender: function(obj) // Append unit and add icon
								{
									return '<small><img src="images/icons/fugue/image.png" width="16" height="16" class="picto"> '+obj.aData[obj.iDataColumn]+' Ko</small>';
								}
							},
							{ sType: 'date' },
							{ sType: 'numeric', bUseRendered: false, fnRender: function(obj) // Size is given as float for sorting, convert to format 000 x 000
								{
									return obj.aData[obj.iDataColumn].split('.').join(' x ');
								}
							},
							{ bSortable: false }	// No sorting for actions column
						],
						
						/**
						 * Set DOM structure for table controls
						 * @url http://www.datatables.net/examples/basic_init/dom.html
						 */
						sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
						
						/**
						 * Callback to apply template setup
						 */
						fnDrawCallback: function()
						{
							this.parent().applyTemplateSetup();
						},
						fnInitComplete: function()
						{
							this.parent().applyTemplateSetup();
						}
					});
				
				// Sorting arrows behaviour
				table.find('thead .sort-up').click(function(event)
				{
					// Stop link behaviour
					event.preventDefault();
					
					// Find column index
					var column = $(this).closest('th'),
						columnIndex = column.parent().children().index(column.get(0));
					
					// Send command
					oTable.fnSort([[columnIndex, 'asc']]);
					
					// Prevent bubbling
					return false;
				});
				table.find('thead .sort-down').click(function(event)
				{
					// Stop link behaviour
					event.preventDefault();
					
					// Find column index
					var column = $(this).closest('th'),
						columnIndex = column.parent().children().index(column.get(0));
					
					// Send command
					oTable.fnSort([[columnIndex, 'desc']]);
					
					// Prevent bubbling
					return false;
				});
			});
			
			/**
			 * Datepicker
			 * Thanks to sbkyle! http://themeforest.net/user/sbkyle
			 */
			$('.datepicker').datepick({
				alignment: 'bottom',
				showOtherMonths: true,
				selectOtherMonths: true,
				renderer: {
					picker: '<div class="datepick block-border clearfix form"><div class="mini-calendar clearfix">' +
							'{months}</div></div>',
					monthRow: '{months}', 
					month: '<div class="calendar-controls" style="white-space: nowrap">' +
								'{monthHeader:M yyyy}' +
							'</div>' +
							'<table cellspacing="0">' +
								'<thead>{weekHeader}</thead>' +
								'<tbody>{weeks}</tbody></table>', 
					weekHeader: '<tr>{days}</tr>', 
					dayHeader: '<th>{day}</th>', 
					week: '<tr>{days}</tr>', 
					day: '<td>{day}</td>', 
					monthSelector: '.month', 
					daySelector: 'td', 
					rtlClass: 'rtl', 
					multiClass: 'multi', 
					defaultClass: 'default', 
					selectedClass: 'selected', 
					highlightedClass: 'highlight', 
					todayClass: 'today', 
					otherMonthClass: 'other-month', 
					weekendClass: 'week-end', 
					commandClass: 'calendar', 
					commandLinkClass: 'button',
					disabledClass: 'unavailable'
				}
			});
		});
		
		// Demo modal
		function close_report(id)
		{
			var dataString = 'id='+ id;

			$.ajax({
				type: "POST",
				url: "/administrator/reports_close/",
				data: dataString,
				cache: false,
				success: function(html)//   
				{

				}
			});

			return false;
		}

		function openModal(id)
		{
			var dataString = 'id='+ id;

			$.ajax({
				type: "POST",
				url: "/administrator/reports_view/",
				data: dataString,
				cache: false,
				success: function(html)//   
				{
					text = html;


					$.modal({//  
						content:  '<p>' + text + '</p>',
						title: 'Дизайн с ID ' + id,
						maxWidth: 500,
						buttons: {
							'Закрыть': function(win) 
							{
								close_report(id);
								win.closeModal(); 
							}
						}
					});

				}
			});


		}
		
		<? if( $count_new_reports ): ?>
			notify('Новые жалобы');
		<? endif; ?>
	</script>
	
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>

<body>
<!-- The template uses conditional comments to add wrappers div for ie8 and ie7 - just add .ie or .ie7 prefix to your css selectors when needed -->
<!--[if lt IE 9]><div class="ie"><![endif]-->
<!--[if lt IE 8]><div class="ie7"><![endif]-->
	
	<!-- Header -->

	<!-- Server status -->
	<header><div class="container_12">
		
		<p id="skin-name"><small>dlance<br> .ru</small> <strong>2.0</strong></p>
		<div class="server-info">Server: <strong>Apache 2.2.14</strong></div>
		<div class="server-info">Php: <strong>5.3.1</strong></div>
		
	</div></header>
	<!-- End server status -->
	
	<!-- Main nav -->
	<nav id="main-nav">

		<ul class="container_12">
			<li class="home<? if( $view == 'index' or $view == 'applications' or $view == 'mailer' ): ?> current<? endif; ?>" onClick="location.href='/administrator/'"><a href="#" title="Главная">Главная</a>
				<ul>
<li<? if( $view == 'index' ): ?> class="current"<? endif; ?>><a href="/administrator/" title="Статистика">Статистика</a></li>
<li<? if( $view == 'applications' ): ?> class="current"<? endif; ?>><a href="/administrator/applications/" title="Заявки">Заявки</a></li>
<li<? if( $view == 'mailer' ): ?> class="current"<? endif; ?>><a href="/administrator/mailer/" title="Рассылка">Рассылка</a></li>
				</ul>
			</li>
			<li class="write<? if( $view == 'blogs' ): ?> current<? endif; ?>" onClick="location.href='/administrator/blogs/'"><a href="#" title="Блоги">Блоги</a>
				<ul>
<li<? if( $view == 'blogs' ): ?> class="current"<? endif; ?>><a href="/administrator/blogs/" title="Записи">Записи</a></li>
				</ul>
			</li>
			<li class="write<? if( $view == 'pages' or $view == 'pages_add' ): ?> current<? endif; ?>" onClick="location.href='/administrator/pages/'"><a href="#" title="Страницы">Страницы</a>
				<ul>
<li<? if( $view == 'pages' ): ?> class="current"<? endif; ?>><a href="/administrator/pages/" title="Список">Список</a></li>
<li<? if( $view == 'pages_add' ): ?> class="current"<? endif; ?>><a href="/administrator/pages_add/" title="Добавить">Добавить</a></li>
				</ul>
			</li>
			<li class="write<? if( $view == 'help_pages' or $view == 'help_pages_add' or $view == 'help_categories' or $view == 'help_categories_add' ): ?> current<? endif; ?>" onClick="location.href='/administrator/help_pages/'"><a href="#" title="Помощь">Помощь</a>
				<ul>
<li<? if( $view == 'help_pages' ): ?> class="current"<? endif; ?>><a href="/administrator/help_pages/" title="Страницы">Страницы</a></li>
<li<? if( $view == 'help_pages_add' ): ?> class="current"<? endif; ?>><a href="/administrator/help_pages_add/" title="Добавить страницу">Добавить страницу</a></li>
<li<? if( $view == 'help_categories' ): ?> class="current"<? endif; ?>><a href="/administrator/help_categories/" title="Категории">Категории</a></li>
<li<? if( $view == 'help_categories_add' ): ?> class="current"<? endif; ?>><a href="/administrator/help_categories_add/" title="Добавить категорию">Добавить категорию</a></li>
				</ul>
			</li>
			<li class="write<? if( $view == 'news' or $view == 'news_add' ): ?> current<? endif; ?>" onClick="location.href='/administrator/news/'"><a href="#" title="Новости">Новости</a>
				<ul>
<li<? if( $view == 'news' ): ?> class="current"<? endif; ?>><a href="/administrator/news/" title="Список">Список</a></li>
<li<? if( $view == 'news_add' ): ?> class="current"<? endif; ?>><a href="/administrator/news_add/" title="Добавить">Добавить</a></li>
				</ul>
			</li>
			<li class="write<? if( $view == 'reports' ): ?> current<? endif; ?>" onClick="location.href='/administrator/reports/'"><a href="#" title="Жалобы">Жалобы</a>
				<ul>
<li<? if( $view == 'reports' ): ?> class="current"<? endif; ?>><a href="/administrator/reports/" title="Список">Список</a></li>
				</ul>
			</li>
			<li class="comments<? if( $view == 'categories' or $view == 'categories_add' ): ?> current<? endif; ?>" onClick="location.href='/administrator/categories/'"><a href="#" title="Категории">Категории</a>
				<ul>
<li<? if( $view == 'categories' ): ?> class="current"<? endif; ?>><a href="/administrator/categories/" title="Список">Список</a></li>
<li<? if( $view == 'categories_add' ): ?> class="current"<? endif; ?>><a href="/administrator/categories_add/" title="Добавить">Добавить</a></li>
				</ul>
			</li>
			<li class="medias<? if( $view == 'designs' or $view == 'designs_categories' or $view == 'designs_categories_add' ): ?> current<? endif; ?>" onClick="location.href='/administrator/designs/'"><a href="#" title="Дизайны">Дизайны</a>
				<ul>
<li<? if( $view == 'designs' ): ?> class="current"<? endif; ?>><a href="/administrator/designs/" title="Список">Список</a></li>
<li<? if( $view == 'designs_categories' ): ?> class="current"<? endif; ?>><a href="/administrator/designs_categories/" title="Категории">Категории</a></li>
<li<? if( $view == 'designs_categories_add' ): ?> class="current"<? endif; ?>><a href="/administrator/designs_categories_add/" title="Добавить категорию">Добавить категорию</a></li>
				</ul>
			</li>
			<li class="users<? if( $view == 'users' or $view == 'tariffs' or $view == 'tariffs_add' ): ?> current<? endif; ?>" onClick="location.href='/administrator/users/'"><a href="#" title="Пользователи">Пользователи</a>
				<ul>
<li<? if( $view == 'users' ): ?> class="current"<? endif; ?>><a href="/administrator/users/" title="Список">Список</a></li>
<li<? if( $view == 'tariffs' ): ?> class="current"<? endif; ?>><a href="/administrator/tariffs/" title="Тарифы">Тарифы</a></li>
<li<? if( $view == 'tariffs_add' ): ?> class="current"<? endif; ?>><a href="/administrator/tariffs_add/" title="Добавить тариф">Добавить тариф</a></li>
				</ul>
			</li>
			<li class="stats<? if( $view == 'transaction' or $view == 'purchased' ): ?> current<? endif; ?>" onClick="location.href='/administrator/transaction/'"><a href="#" title="Статистика">Статистика</a>
				<ul>
<li<? if( $view == 'transaction' ): ?> class="current"<? endif; ?>><a href="/administrator/transaction/" title="История операций">История операций</a></li>
<li<? if( $view == 'purchased' ): ?> class="current"<? endif; ?>><a href="/administrator/purchased/" title="Покупки дизайнов">Покупки дизайнов</a></li>
				</ul>
			</li>
			<li class="settings<? if( $view == 'settings' or $view == 'rating' or $view == 'profile' ): ?> current<? endif; ?>" onClick="location.href='/administrator/settings/'"><a href="#" title="Настройки">Настройки</a>
				<ul>
<li<? if( $view == 'settings' ): ?> class="current"<? endif; ?>><a href="/administrator/settings/" title="Общии настройки">Общии настройки</a></li>
<li<? if( $view == 'rating' ): ?> class="current"<? endif; ?>><a href="/administrator/rating/" title="Настройка рейтинга">Настройка рейтинга</a></li>
<li<? if( $view == 'profile' ): ?> class="current"<? endif; ?>><a href="/administrator/profile/" title="Профиль">Профиль</a></li>
				</ul>
			</li>
		</ul>
	</nav>
	<!-- End main nav -->
	
	<!-- Sub nav -->
	<div id="sub-nav"><div class="container_12">
		

	
	</div></div>
	<!-- End sub nav -->
	
	<!-- Status bar -->
	<div id="status-bar"><div class="container_12">
	
		<ul id="status-infos">
	<!-- 
			<li>
				<a href="#" class="button" title="5 "><img src="/templates/admin/images/icons/fugue/mail.png" width="16" height="16"> <strong>5</strong></a>
				<div id="messages-list" class="result-block">
					<span class="arrow"><span></span></span>
					
					<ul class="small-files-list icon-mail">
						<li>
							<a href="#"><strong>10:15</strong> Please update...<br>
							<small>From: System</small></a>
						</li>
						<li>
							<a href="#"><strong>Yest.</strong> Hi<br>
							<small>From: Jane</small></a>
						</li>
						<li>
							<a href="#"><strong>Yest.</strong> System update<br>
							<small>From: System</small></a>
						</li>
						<li>
							<a href="#"><strong>2 days</strong> Database backup<br>
							<small>From: System</small></a>
						</li>
						<li>
							<a href="#"><strong>2 days</strong> Re: bug report<br>
							<small>From: Max</small></a>
						</li>
					</ul>
					
					<p id="messages-info" class="result-info"><a href="#">Смотреть все &raquo;</a></p>
				</div>
			</li>
 -->
			<li>
				<a href="#" class="button" title="<?=$count_new_reports?> comments"><img src="/templates/admin/images/icons/fugue/balloon.png" width="16" height="16"> <strong><?=$count_new_reports?></strong></a>
				<div id="comments-list" class="result-block">
					<span class="arrow"><span></span></span>

					<ul class="small-files-list icon-comment">
<? if( !empty($new_reports) ): ?>
<? foreach($new_reports as $row): ?>
						<li>
							<a href="#" onClick="openModal(<?=$row['id']?>); return false;"><strong><?=$row['username']?></strong>: <?=$row['text']?><br>
							<small><strong><?=$row['title']?></strong></small></a>
						</li>
<? endforeach; ?>
<? endif; ?>
					</ul>

					<p id="comments-info" class="result-info"><a href="/administrator/reports/">Смотреть все &raquo;</a></p>
				</div>
			</li>
			<li><a href="/administrator/logout" class="button red" title="ВЫХОД"><span class="smaller">ВЫХОД</span></a></li>
		</ul>
		
		<ul id="breadcrumb">
			<li><a href="/administrator/" title="Главная">Главная</a></li>
			<li><a href="#" title="<?=$title?>"><?=$title?></a></li>
		</ul>
	
	</div></div>
	<!-- End status bar -->
	
	<div id="header-shadow"></div>
	<!-- End header -->
	
	<!-- Always visible control bar -->
	<!-- End control bar -->
<?=$content?>
	
	<footer>
		
		<div class="float-left">
			<a href="/" class="button" target="_new">Перейти на сайт</a></div>
		
		<div class="float-right">
			<a href="#top" class="button"><img src="/templates/admin/images/icons/fugue/navigation-090.png" width="16" height="16">Перейти в самый верх</a></div>
		
</footer>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>