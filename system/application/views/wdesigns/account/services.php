<?php $this->load->view('wdesigns/account/block'); ?>
<div id="yui-main" class="content">
	<div class="yui-b services">
		<h1><a href="/account/services">Услуги</a></h1>
		<p class="subtitle"> Услуги предоставляемые вами </p>
		<?= validation_errors()?>
		<form action="" method="post" /><?php if (! empty($categories)): ?>
		<table>
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
						<span class="niceCheck"><input type="checkbox" name="category[]" value="<?=$row2['id']?>"<?php if (! empty($select)): if (in_array($row2['id'], $select)): ?> checked="checked"<?php endif; endif; ?>	/></span>
					</td>
					<td>
						<label><?= $row2['name']?></label>
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
		<br/>
		<button name="submit" type="submit" value="Сохранить" class="orangeBtn80">Сохранить</button></form>
	</div>
</div><!--/yui-main-->
