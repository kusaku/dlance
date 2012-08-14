<script type='text/javascript' src='/templates/js/thickbox/thickbox.js'></script>
<link rel="stylesheet" type="text/css" href="/templates/js/thickbox/thickbox.css" />

<script type="text/javascript">

function update(id){

	var dataString = 'id='+ id;

	$.ajax({
		type: "POST",
		url: "/account/update_event",
		data: dataString,
		cache: false,
		success: function(html)//Тут нужно изменить img
		{
			$('#event_'+ id + '').attr('src', '/templates/wdesigns/css/img/message.gif');
		}
	});

	return false;
}
</script>
<div id="yui-main">
<div class="yui-b">


<h1><a href="/account/events/">События</a></h1>
<p class="subtitle">Список ваших событий, персональные сообщения, поступающие платежи.</p>

<div class="offers-stateline">Статус: 
<span>
<a href="/account/events">все</a> |
<a href="/account/events/?status=1">новые</a> |
<a href="/account/events/?status=2">старые</a>
</span>
</div>

<? if( !empty($data) ): ?>
<table class="offers">
<tr>
<th style="width:16px;"></th>
<th class="txtl">Заголовок</th>
<th style="width:150px;">Дата</th>
</tr>
<? foreach($data as $row): ?>
<tr>
<td>
<? if( $row['status'] == 1 ): ?>
<img src="/templates/wdesigns/css/img/new_message.gif" id="event_<?=$row['id']?>" onclick="update(<?=$row['id']?>)" class="new_event">
<? else: ?>
<img src="/templates/wdesigns/css/img/message.gif" id="event_<?=$row['id']?>">
<? endif; ?>
</td>
<td class="title"><?=$row['title']?></td>
<td class="owner txtc"><?=$row['date']?></td>
</tr>
<? endforeach; ?>
</table>
<?=$page_links?>
<? else: ?>
<p>События отсутствуют.</p>
<? endif; ?>


  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>