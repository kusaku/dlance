<?php $this->load->view('wdesigns/account/block'); ?>
<p><a href="/account/portfolio/add/">Добавить работу</a></p>
<?php if (! empty($portfolio)): ?>
<?php foreach ($portfolio as $row): ?>
<div class="ptf-block">
	<ul>
		<li>
			<a href="/account/portfolio/down/<?=$row['id']?>" title="Переместить вниз"><img src="/templates/wdesigns/css/img/down.gif" alt="Переместить вниз"></a>
		</li>
		<li>
			<a href="/account/portfolio/up/<?=$row['id']?>" title="Переместить вниз"><img src="/templates/wdesigns/css/img/up.gif" alt="Переместить вверх"></a>
		</li>
		<li>
			<a href="/account/portfolio/edit/<?=$row['id']?>">Редактировать</a>
		</li>
		<li>
			<a href="/account/portfolio/del/<?=$row['id']?>">Удалить</a>
		</li>
	</ul>
	<div class="ptf-image brdrl">
		<a href="<?=$row['full_image']?>" onclick="return hs.expand(this)"><img src="<?=$row['small_image']?>" title="<?=$row['title']?>"></a>
		<div class="caption">
			<?= $row['descr']?>
		</div>
	</div>
	<div class="ptf-text">
		<?= $row['title']?>
	</div>
</div>
<?php endforeach; ?>
<?php else : ?>
<p>Работы отсутствуют.</p>
<?php endif; ?>