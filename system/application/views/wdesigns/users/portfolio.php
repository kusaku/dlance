<?php $this->load->view('wdesigns/users/block'); ?>
<?php if( $this->username == $username ) :?>
<p><a href="/account/portfolio/add/">Добавить работу</a></p>
<?php endif; ?>
<?php if (! empty($portfolio)): ?>
<?php foreach ($portfolio as $row): ?>
<div class="ptf-block">
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