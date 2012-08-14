<div id="yui-main">
<div class="yui-b">

<h1> <a href="/account/categories_followers">Подписки на рубрики</a> </h1>

<p class="subtitle"> Подписки на рубрики </p>

<?=validation_errors()?>





<form action="" method="post" />
<? if( !empty($categories) ): ?>
<table class="services">
<tbody>

<? foreach($categories as $row): ?>

<? if( $row['parent_id'] == 0): ?>
<tr>
<th style="width: 5px;"></th>
<th class="txtl"><h4><?=$row['name']?></h4></th>
</tr>
<? endif; ?>

	<? foreach($categories as $row2): ?>

			<? if( $row['id'] == $row2['parent_id'] ): ?>
<tr>
<td>
<input type="checkbox" name="category[]" value="<?=$row2['id']?>"<? if( !empty($select) ): if( in_array($row2['id'], $select) ): ?> checked="checked" <? endif; endif; ?> />
</td>
<td><?=$row2['name']?></td>
</tr>
			<? endif; ?>

	<? endforeach; ?>

<? endforeach; ?>

</tbody>
</table>
<? else: ?>
<p>Услуги не найдены.</p>
<? endif; ?>
<input name="submit" type="submit" value="Сохранить">
</form>



  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>