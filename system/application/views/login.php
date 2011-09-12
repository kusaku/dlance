<!DOCTYPE html>
<html
	lang="en">
<head>

<title>����������������� ����</title>
<meta charset="utf-8">

<!-- Global stylesheets -->
<link href="/templates/admin/css/reset.css" rel="stylesheet"
	type="text/css">
<link href="/templates/admin/css/common.css" rel="stylesheet"
	type="text/css">
<link href="/templates/admin/css/form.css" rel="stylesheet"
	type="text/css">
<link href="/templates/admin/css/standard.css" rel="stylesheet"
	type="text/css">
<link href="/templates/admin/css/special-pages.css" rel="stylesheet"
	type="text/css">

<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link rel="icon" type="image/png" href="favicon-large.png">

<!-- Generic libs -->
<script type="text/javascript" src="/templates/admin/js/html5.js"></script>
<!-- this has to be loaded before anything else -->
<script type="text/javascript"
	src="/templates/admin/js/jquery-1.4.2.min.js"></script>

<!-- Template core functions -->
<script type="text/javascript" src="/templates/admin/js/common.js"></script>
<script type="text/javascript" src="/templates/admin/js/standard.js"></script>
<!--[if lte IE 8]><script type="text/javascript" src="js/standard.ie.js"></script><![endif]-->
<script type="text/javascript" src="/templates/admin/js/jquery.tip.js"></script>

<!-- example login script -->
<script type="text/javascript">
	
		$(document).ready(function()
		{
			// We'll catch form submission to do it in AJAX, but this works also with JS disabled
			$('#login-form').submit(function(event)
			{
				// Stop full page load
				event.preventDefault();
				
				// Check fields
				var login = $('#login').val();
				var pass = $('#pass').val();
				
				if (!login || login.length == 0)
				{
					$('#login-block').removeBlockMessages().blockMessage('����������, ������� �����', {type: 'warning'});
				}
				else if (!pass || pass.length == 0)
				{
					$('#login-block').removeBlockMessages().blockMessage('����������, ������� ������', {type: 'warning'});
				}
				else
				{
					var submitBt = $(this).find('button[type=submit]');
					submitBt.disableBt();
					
					// Target url
					var target = $(this).attr('action');
					if (!target || target == '')
					{
						// Page url without hash
						target = document.location.href.match(/^([^#]+)/)[1];
					}
					
					// Request
					var data = {
						a: $('#a').val(),
						login: login,
						pass: pass,
						'keep-logged': $('#keep-logged').attr('checked') ? 1 : 0
					};
					var redirect = $('#redirect');
					if (redirect.length > 0)
					{
						data.redirect = redirect.val();
					}
					
					// Start timer
					var sendTimer = new Date().getTime();


					// Send
					$.ajax({
						url: '/administrator/auth_check',
						type: "POST",
						data: data,
						dataType: "json",
						success: function (json)
						{
							if (json.status == "OK")
							{
								// Small timer to allow the 'cheking login' message to show when server is too fast
								var receiveTimer = new Date().getTime();
								if (receiveTimer-sendTimer < 500)
								{
									setTimeout(function()
									{
										document.location.href = '/administrator/';
										
									}, 500-(receiveTimer-sendTimer));
								}
								else
								{
									document.location.href = '/administrator/';
								}
							}
							else
							{
								// Message
								$('#login-block').removeBlockMessages().blockMessage(data.error || '������� ����� ����� ��� ������', {type: 'error'});
								
								submitBt.enableBt();
							}
						},
						error: function(XMLHttpRequest, textStatus, errorThrown)
						{
							// Message
							$('#login-block').removeBlockMessages().blockMessage('Error while contacting server, please try again', {type: 'error'});
							
							submitBt.enableBt();
						}
					});


					// Message
					$('#login-block').removeBlockMessages().blockMessage('���������� ���������, �������� ������...', {type: 'loading'});
				}
			});
		});
	
	</script>

<meta http-equiv="Content-Type"
	content="text/html; charset=windows-1251">
</head>

<!-- the 'special-page' class is only an identifier for scripts -->
<body class="special-page login-bg dark">
<!-- The template uses conditional comments to add wrappers div for ie8 and ie7 - just add .ie, .ie7 or .ie6 prefix to your css selectors when needed -->
<!--[if lt IE 9]><div class="ie"><![endif]-->
<!--[if lt IE 8]><div class="ie7"><![endif]-->

<section id="login-block">
<div class="block-border">
<div class="block-content"><!--
			IE7 compatibility: if you want to remove the <h1>, 
			add style="zoom:1" to the above .block-content div
			-->
<h1>�����</h1>
<div class="block-header">�����������</div>

<p class="message error no-margin">���� �� ��� �������������</p>

<form class="form with-margin" name="login-form" id="login-form"
	method="post" action=""><input type="hidden" name="a" id="a"
	value="send">
<p class="inline-small-label"><label for="login"><span class="big">�����</span></label>
<input type="text" name="login" id="login" class="full-width" value="">
</p>
<p class="inline-small-label"><label for="pass"><span class="big">������</span></label>
<input type="password" name="pass" id="pass" class="full-width" value="">
</p>

<button type="submit" class="float-right">����</button>
<p class="input-height"><input type="checkbox" name="keep-logged"
	id="keep-logged" value="1" class="mini-switch" checked="checked"> <label
	for="keep-logged" class="inline">���������</label></p>
</form>

<form class="form" id="password-recovery" method="post" action="">
<fieldset class="grey-bg no-margin collapse"><legend><a href="#">������
������?</a></legend>
<p class="input-with-button"><label for="recovery-mail">������� e-mail
�����</label> <input type="text" name="recovery-mail" id="recovery-mail"
	value="">
<button type="button">���������</button>
</p>
</fieldset>
</form>
</div>
</div>
</section>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>
