<?php $this->load->view('wdesigns/account/block'); ?>
<div class="content">
	<div class="userResponseHeader">
		<div class="addResponse">
			<div class="addResponseRightBrdr">
				<a href="#">отменить все</a>
				&nbsp;&nbsp;&nbsp;<a href="#">снять отметки</a>
			</div>
		</div>
		<h3>Рассылка по рубрикам:</h3>
	</div>
	<div class="contentWrapperBorderLeft" style="min-height:580px;">
		<?= validation_errors()?>
		<form action="" method="post" class="subscribeSettings">
			<?php if (! empty($categories)): ?>
			<?php foreach ($categories as $row): ?>
			<?php if ($row['parent_id'] == 0): ?>
			<h4><?= $row['name']?></h4>
			<?php endif; ?>
			<ul class="line">
				<?php foreach ($categories as $row2): ?>
				<?php if ($row['id'] == $row2['parent_id']): ?>
				<li>
					<span class="niceCheck"><input type="checkbox" name="category[]" value="<?=$row2['id']?>"<?php if (! empty($select)): if (in_array($row2['id'], $select)): ?> checked="checked"<?php endif; endif; ?> /></span>
					<label for="agree">
						<a href="#"><?= $row2['name']?></a>
					</label>
				</li>
				<?php endif; ?>
				<?php endforeach; ?>
			</ul>
			<?php endforeach; ?>
			<?php else : ?>
			<p>Ничего не найдено.</p>
			<?php endif; ?>
			<input name="submit" type="submit" value="Сохранить"></form>
	</div>
</div>