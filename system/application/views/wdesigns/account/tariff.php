<div id="yui-main">
<div class="yui-b">
<h1><a href="/account/tariffs">Виртуальный статус</a></h1>
<p class="subtitle">Описание</p>
<?=validation_errors()?>
<div class="ttl">
<div class="ttr"></div>
</div>
<div class="bbd">
<p class="subtitle"><b>Виртуальный статус</b></p>
<table class="profile">
<tr>
<td class="caption">Название:</td>
<td><strong><?=$name?></strong></td>
</tr>

<? if( $id != 1 ): ?>
<tr>
<td class="caption">До окончания:</td>
<td><?=$tariff_period?></td>
</tr>

<tr>
<td class="caption">Цена за месяц:</td>
<td><?=$price_of_month?> рублей</td>
</tr>

<tr>
<td class="caption">Цена за год</td>
<td><?=$price_of_year?> рублей</td>
</tr>
<? endif; ?>
</table>
</div>
<div class="bbl">
<div class="bbr"></div>
</div>

<? if( $id != 1 ): ?>

<br />
<form action="" method="post" />
<input name="tariff" type="hidden" value="<?=$this->user_tariff?>" />

<select name="period">
<option value="1">Месяц</option>
<option value="2">Год</option>
</select>

<input type="submit" value="Продлить">
</form>
<? endif; ?>

</div>
</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>