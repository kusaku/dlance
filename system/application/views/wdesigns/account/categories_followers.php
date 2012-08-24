<? $this->load->view('wdesigns/account/block'); ?>
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
			<? if (! empty($categories)): ?>
			<? foreach ($categories as $row): ?>
			<? if ($row['parent_id'] == 0): ?>
			<h4><?= $row['name']?></h4>
			<? endif; ?>
			<ul class="line">
				<? foreach ($categories as $row2): ?>
				<? if ($row['id'] == $row2['parent_id']): ?>
				<li>
					<span class="niceCheck"><input type="checkbox" name="category[]" value="<?=$row2['id']?>"<? if (! empty($select)): if (in_array($row2['id'], $select)): ?> checked="checked"<? endif; endif; ?> /></span>
					<label for="agree">
						<a href="#"><?= $row2['name']?></a>
					</label>
				</li>
				<? endif; ?>
				<? endforeach; ?>
			</ul>
			<? endforeach; ?>
			<? else : ?>
			<p>Ничего не найдено.</p>
			<? endif; ?>
			<input name="submit" type="submit" value="Сохранить"></form>
	</div>
</div>