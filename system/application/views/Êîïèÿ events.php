<? if( !empty($data) ): ?>
<? foreach($data as $row): ?>
<div class="event" id="message-<?=$row['id']?>">
<img id="close_message" style="float:right;cursor:pointer"  src="/templates/wdesigns/css/img/close.png" />
<?=$row['title']?>
</div>
<? endforeach; ?>
<? endif; ?>
<div class="event" id="message-1">
<img id="close_message" style="float:right;cursor:pointer"  src="/templates/wdesigns/css/img/close.png" />
Отправлен положительный отзыв, ваша репутация увеличена на 34<br />
Авторизация в системе, ваша репутация уменьшена на -51<br />
Авторизация в системе, ваша репутация уменьшена на -51
</div>