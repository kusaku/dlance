<div id="yui-main">
<div class="yui-b">

<h1><a href="/account/users_followers">Подписки на пользовательские работы</a></h1>
<p class="subtitle"> Список пользователей, на работы которых вы подписаны.</p>

<? if( !empty($data) ): ?>
<div class="following">
<? foreach($data as $row): ?>
<div>
<img src="<?=$row['userpic']?>" alt="" class="avatar" width="60px"/><a href="/user/<?=$row['username']?>" rel="follows"><?=$row['username']?></a>
[<a href="/account/subscribe_del/<?=$row['follows']?>">x</a>]

</div>
<? endforeach; ?>
</div>
<?=$page_links?>
<? else: ?>
<p>Подписчики отсутствуют.</p>
<? endif; ?>

</div>
</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>