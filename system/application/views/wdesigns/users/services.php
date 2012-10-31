<?php $this->load->view('wdesigns/users/block'); ?>
<div class="content">
	<div class="userResponseHeader">
		<?php if ($this->username == $username): ?>
		<div class="addResponse">
			<div class="addResponseRightBrdr">
				<span>+</span>
				<a href="/account/services">редактировать</a>
			</div>
		</div>
		<?php endif; ?>
		<h3>Услуги:</h3>
	</div>
	<div style="height:580px;" class="contentWrapperBorderLeft">
		<?php if (! empty($services)): ?>
		<table class="services">
			<tbody>
				<?php foreach ($categories as $row): ?><?php if ($row['parent_id'] == 0): ?>
				<?php 
				//Выбранные разделы
				if (in_array($row['id'], $select_parent)):
					
				?>
				<tr>
					<th class="txtl">
						<h5><?= $row['name']?></h5>
					</th>
				</tr>
				<?php endif; ?><?php endif; ?><?php foreach ($categories as $row2): ?>
				<?php 
				//Выбранные категории
				if ($row['id'] == $row2['parent_id']):
					
				?>
				<?php if (in_array($row2['id'], $select)): ?>
				<tr>
					<td>
						<?= $row2['name']?>
					</td>
				</tr>
				<?php endif; ?><?php endif; ?><?php endforeach; ?><?php endforeach; ?>
			</tbody>
		</table>
		<?php else : ?>
		<p>Услуги не предоставляются.</p>
		<?php endif; ?>
	</div>
</div>
