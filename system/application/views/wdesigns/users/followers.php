<? $this->load->view('wdesigns/users/block'); ?>

<div class="content">
	<? if( !empty($followers) ): ?>
<div class="following">
<? foreach($followers as $row): ?>
<div>
<img src="<?=$row['userpic']?>" alt="" class="avatar" width="60px"/><a href="/user/<?=$row['username']?>" rel="follows"><?=$row['username']?></a>
</div>
<? endforeach; ?>
</div>
<?=$page_links?>
<? else: ?>
<p>Подписчики отсутствуют.</p>
<? endif; ?>
</div>