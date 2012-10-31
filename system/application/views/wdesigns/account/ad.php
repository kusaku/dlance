<?php $this->load->view('wdesigns/account/block'); ?>
<div id="yui-main">
	<div class="yui-b">
		<h1><a href="/account/ad">Указатели</a></h1>
		<p class="subtitle">
			Вы можете поместить указатель на любой сайт или блог. Указатель будет ссылаться на ваш аккаунт на сайте <?= $this->config->item('site')?>.		
		</p>
		<?php if (! empty($code)): ?>
		<textarea name="text" rows="5" cols="49" style="width:100%"><?= $code?></textarea>
		<?php endif; ?>
		<?= validation_errors()?>
		<form action="/account/ad/" method="get" /><?php if (! empty($ads)): ?>
		<table class="services">
			<tbody>
				<tr>
					<td width="25px"></td>
					<td></td>
				</tr>
				<?php foreach ($ads as $row): ?>
				<tr>
					<td>
						<input name="ad" type="radio" value="<?=$row['id']?>"<?php if (! empty($ad) and $ad == $row['id']): ?> checked="checked"<?php endif; ?>/>
					</td>
					<td>
						<img src="<?=$row['img']?>" alt=""></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php else : ?>
		<p>Категории не найдены.</p>
		<?php endif; ?>
		<input type="submit" value="Получить код"></form>
	</div>
</div><!--/yui-main-->
