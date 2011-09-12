<? if( !empty($data) ): ?>

<div class="events" id="message-all"><img id="close_message"
	style="float: right; cursor: pointer"
	src="/templates/wdesigns/css/img/close.png" /> <? foreach($data as $row): ?>
<?=$row['title']?><br />
<? endforeach; ?></div>

<? endif; ?>
