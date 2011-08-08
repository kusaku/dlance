<div id="yui-main">
<div class="yui-b">

<h1> <a href="">Контакты / Сообщения</a> </h1>

<img src="<?=$userpic?>" alt="" class="avatar" />
<ul class="ucard">
<li class="utitle"><a class="black" href="/user/<?=$username?>"><?=$username?></a></li>
<li>Последний визит: <?=$last_login?></li>
<li>Дата регистрации: <?=$created?></li>
<li><a href="#send">Написать сообщение</a></li>
</ul>

<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />



<div class="message">
<? if( !empty($messages) ): ?>


<? foreach($messages as $row): ?>


<? if( $row['reading'] ): ?><div align="right">Прочитано: <?=$row['reading']?></div><? endif;?>



<strong><?=$row['sender_id']?></strong> <?=date_smart($row['date'])?>:<br />

<?=nl2br($row['text'])?>
<hr />
<? endforeach; ?>
<?=$page_links?>
<? else: ?>
Сообщения не найдено.
<? endif; ?>
</div>


<? if( $black_list ): ?>
Переписка отключена
<? else: ?>
<?=validation_errors()?>
<div id="send">
<form action="" method="post">
<div><textarea cols="10" rows="10" name="text" style="width:100%"><?=set_value('text')?></textarea></div>
<div><input type="submit" value="Отправить"></div>
</form>
</div>
<? endif; ?>
</div>
</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>