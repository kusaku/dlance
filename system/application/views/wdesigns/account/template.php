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
	<script type="text/javascript" src="/templates/admin/js/old-browsers.js"></script>		<!-- remove if you do not need older browsers detection -->
	
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
	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
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
				// Separator
				list.push(false);	
			});
			
		// Extra options for the first one
			$('.favorites li:first').bind('contextMenu', function(event, list)
			{
				// Separator
				list.push(false);	
				list.push({ text: '', icon:'terminal', link:'#', subs:[
					{ text: ' ', link: '/administrator/', icon: 'blog' },
					{ text: ' ', link: '/administrator/transaction/', icon: 'blog' }
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
							// No sorting for this columns, as it only contains checkboxes
							{ bSortable: false },	
							{ sType: 'string' },
							{ bSortable: false },
							// Append unit and add icon
							{ sType: 'numeric', bUseRendered: false, fnRender: function(obj) 
								{
									return '<small><img src="images/icons/fugue/image.png" width="16" height="16" class="picto"> '+obj.aData[obj.iDataColumn]+' Ko</small>';
								}
							},
							{ sType: 'date' },
							// Size is given as float for sorting, convert to format 000 x 000
							{ sType: 'numeric', bUseRendered: false, fnRender: function(obj) 
								{
									return obj.aData[obj.iDataColumn].split('.').join(' x ');
								}
							},
							// No sorting for actions column
							{ bSortable: false }	
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
		function openModal()
		{
			$.modal({
				content: '<p>This is an example of modal window. You can open several at the same time (click button below!), move them and resize them.</p>'+
						  '<p>The plugin provides several other functions to control them, try below:</p>'+
						  '<ul class="simple-list with-icon">'+
						  '    <li><a href="javascript:void(0)" onclick="$(this).getModalWindow().setModalTitle(\'\')">Remove title</a></li>'+
						  '    <li><a href="javascript:void(0)" onclick="$(this).getModalWindow().setModalTitle(\'New title\')">Change title</a></li>'+
						  '    <li><a href="javascript:void(0)" onclick="$(this).getModalWindow().loadModalContent(\'ajax-modal.html\')">Load Ajax content</a></li>'+
						  '</ul>',
				title: 'Example modal window',
				maxWidth: 500,
				buttons: {
					'Open new modal': function(win) { openModal(); },
					'Close': function(win) { win.closeModal(); }
				}
			});
		}
	
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
			<li class="home"><a href="#" title="">Главная</a>
				<ul>
					<li><a href="/administrator/" title=""></a></li>
					<li><a href="/administrator/profile/" title=""></a></li>
					<li><a href="/administrator/applications/" title="  ">  </a></li>
				</ul>
			</li>
			<li class="write"><a href="#" title=""></a>
				<ul>
					<li><a href="/administrator/blogs/" title=""></a></li>
					<li><a href="#" title=" "> </a></li>
					<li><a href="#" title=""></a></li>
					<li><a href="#" title=" "> </a></li>
				</ul>
			</li>
			<li class="write"><a href="#" title=""></a>
				<ul>
					<li><a href="/administrator/pages/" title=""></a></li>
					<li><a href="/administrator/pages_add/" title=""></a></li>
				</ul>
			</li>
			<li class="write"><a href="#" title=""></a>
				<ul>
					<li><a href="/administrator/help_pages/" title=""></a></li>
					<li><a href="/administrator/help_pages_add/" title=""></a></li>
					<li><a href="/administrator/help_categories/" title=""></a></li>
					<li><a href="/administrator/help_categories_add/" title=" "> </a></li>
				</ul>
			</li>
			<li class="write"><a href="#" title=""></a>
				<ul>
					<li><a href="/administrator/news/" title=""></a></li>
					<li><a href="/administrator/news_add/" title=""></a></li>
				</ul>
			</li>
			<li class="comments"><a href="#" title=""></a>
				<ul>
					<li><a href="/administrator/categories/" title=""></a></li>
					<li><a href="/administrator/categories_add/" title=""></a></li>
				</ul>
			</li>
			<li class="medias"><a href="#" title=""></a>
				<ul>
					<li><a href="/administrator/designs/" title=""></a></li>
					<li><a href="#" title=""></a></li>
					<li><a href="#" title=" "> </a></li>
				</ul>
			</li>
			<li class="users"><a href="#" title=""></a>
				<ul>
					<li><a href="/administrator/users/" title=""></a></li>
					<li><a href="/administrator/tariffs/" title=""></a></li>
					<li><a href="/administrator/tariffs_add/" title=" "> </a></li>
				</ul>
			</li>
			<li class="stats"><a href="#" title=""></a>
				<ul>
					<li><a href="/administrator/" title=" "> </a></li>
					<li><a href="/administrator/transaction/" title=" "> </a></li>
				</ul>
			</li>
			<li class="settings"><a href="/administrator/settings" title=""></a></li>
			<li class="backup"><a href="#" title=" "> </a></li>
		</ul>
	</nav>
	<!-- End main nav -->
	
	<!-- Sub nav -->
	<div id="sub-nav"><div class="container_12">
		
		<a href="#" title="Help" class="nav-button"><b>Help</b></a>
	
		<form id="search-form" name="search-form" method="post" action="search.html">
			<input type="text" name="s" id="s" value="" title="Search admin..." autocomplete="off">
		</form>
	
	</div></div>
	<!-- End sub nav -->
	
	<!-- Status bar -->
	<div id="status-bar"><div class="container_12">
	
		<ul id="status-infos">
			<li class="spaced">  : <strong>Admin</strong></li>
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
					
					<p id="messages-info" class="result-info"><a href="#">  &raquo;</a></p>
				</div>
			</li>
			<li>
				<a href="#" class="button" title="25 comments"><img src="/templates/admin/images/icons/fugue/balloon.png" width="16" height="16"> <strong>25</strong></a>
				<div id="comments-list" class="result-block">
					<span class="arrow"><span></span></span>
					
					<ul class="small-files-list icon-comment">
						<li>
							<a href="#"><strong>Dlance</strong>: I don't think so<br>
							<small>On <strong>Post title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Ken_54</strong>: What about using a different...<br>
							<small>On <strong>Post title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Jane</strong> Sure, but no more.<br>
							<small>On <strong>Another post</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Max</strong>: Have you seen that...<br>
							<small>On <strong>Post title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Anonymous</strong>: Good luck!<br>
							<small>On <strong>My first post</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Sebastien</strong>: This sure rocks!<br>
							<small>On <strong>Another post title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>John</strong>: Me too!<br>
							<small>On <strong>Third post title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>John</strong> This can be solved by...<br>
							<small>On <strong>Another post</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Jane</strong>: No prob.<br>
							<small>On <strong>Post title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Anonymous</strong>: I had the following...<br>
							<small>On <strong>My first post</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Anonymous</strong>: Yes<br>
							<small>On <strong>Post title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Lian</strong>: Please make sure that...<br>
							<small>On <strong>Last post title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Ann</strong> Thanks!<br>
							<small>On <strong>Last post</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Max</strong>: Don't tell me what...<br>
							<small>On <strong>Post title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Gordon</strong>: Here is an article about...<br>
							<small>On <strong>My another post</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Lee</strong>: Try to reset the value first<br>
							<small>On <strong>Last title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Lee</strong>: Sure!<br>
							<small>On <strong>Second post title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Many</strong> Great job, keep on!<br>
							<small>On <strong>Third post</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>John</strong>: I really like this<br>
							<small>On <strong>First title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Paul</strong>: Hello, I have an issue with...<br>
							<small>On <strong>My first post</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>June</strong>: Yuck.<br>
							<small>On <strong>Another title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Jane</strong>: Wow, sounds amazing, do...<br>
							<small>On <strong>Another title</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Esther</strong>: Man, this is the best...<br>
							<small>On <strong>Another post</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Max</strong>: Thanks!<br>
							<small>On <strong>Post title</strong></small></a>
				    </li>
						<li>
							<a href="#"><strong>John</strong>: I'd say it is not safe...<br>
							<small>On <strong>My first post</strong></small></a>
						</li>
					</ul>
					
					<p id="comments-info" class="result-info"><a href="#">Manage comments &raquo;</a></p>
				</div>
			</li>
			<li><a href="login.html" class="button red" title=""><span class="smaller"></span></a></li>
		</ul>
		
		<ul id="breadcrumb">
			<li><a href="#" title=""></a></li>
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
			<a href="#" class="button"></a>
			<a href="#" class="button"> </a>		</div>
		
		<div class="float-right">
			<a href="#top" class="button"><img src="/templates/admin/images/icons/fugue/navigation-090.png" width="16" height="16">   </a>		</div>
		
</footer>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>