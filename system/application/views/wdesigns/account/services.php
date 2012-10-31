<?php $this->load->view('wdesigns/account/block'); ?>
<div id="yui-main">
	<div class="yui-b">
		<h1><a href="/account/services">Услуги</a></h1>
		<p class="subtitle"> Услуги предоставляемые вами </p>
		<?= validation_errors()?>
		<form action="" method="post" /><?php if (! empty($categories)): ?>
		<table class="services">
			<tbody>
				<?php foreach ($categories as $row): ?>
				<?php if ($row['parent_id'] == 0): ?>
				<tr>
					<th style="width: 5px;"></th>
					<th class="txtl">
						<h4><?= $row['name']?></h4>
					</th>
				</tr>
				<?php endif; ?>
				<?php foreach ($categories as $row2): ?>
				<?php if ($row['id'] == $row2['parent_id']): ?>
				<tr>
					<td>
						<input type="checkbox" name="category[]" value="<?=$row2['id']?>"<?php if (! empty($select)): if (in_array($row2['id'], $select)): ?> checked="checked"<?php endif; endif; ?>	/>
					</td>
					<td>
						<?= $row2['name']?>
					</td>
				</tr>
				<?php endif; ?>
				<?php endforeach; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php else : ?>
		<p>Услуги не найдены.</p>
		<?php endif; ?>
		<input name="submit" type="submit" value="Сохранить"></form>
	</div>
</div><!--/yui-main-->
