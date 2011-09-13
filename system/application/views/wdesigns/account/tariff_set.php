<div id="yui-main">
<div class="yui-b">

<h1><a href="/account/tariffs_set">Виртуальный статус</a></h1>
<p class="subtitle">Описание</p>
<?=validation_errors()?>
<form action="" method="post" />
<table class="offers">
<tr>
<th class="txtl" style="width:25px;"></th>
<th class="txtl"><strong>Тарифный план</strong></th>
<th>Стоимость в месяц</th>
<th>Стоимость в год</th>
<th>Комиссия</th>
<th>Минимальная сумма для вывода</th>
</tr>

<? foreach($data as $row): ?>
<tr<? if( $this->user_tariff == $row['id'] ): ?> style="background-color:#00a2e8; color:#FFF"<? endif; ?>>
<td><input name="tariff" type="radio" value="<?=$row['id']?>"<? if( $this->user_tariff == $row['id'] ): ?> checked="checked"<? endif; ?> /></td>
<td class="title"><strong><?=$row['name']?></strong></td>
<td class="budget txtc"><?=$row['price_of_month']?> рублей</td>
<td class="budget txtc"><?=$row['price_of_year']?> рублей</td>
<td class="owner txtc"><?=$row['commission']?>%</td>
<td class="owner txtc"><?=$row['minimum_w_a']?> рублей</td>
</tr>
<? endforeach; ?>
<tr>

</table>

<select name="period">
<option value="1"<? if( 1 == 1 ): ?> selected="selected"<? endif; ?>>Месяц</option>
<option value="2"<? if( 1 == 2 ): ?> selected="selected"<? endif; ?>>Год</option>
</select>

<input type="submit" value="Установить">
</form>
</div>
</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>