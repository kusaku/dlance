<div id="yui-main">
<div class="yui-b">

<h1> <a href="/account/additional_data">Дополнительные данные</a> </h1>

<p class="subtitle"> Ваши Дополнительные данные </p>

<?=validation_errors()?>
<?=show_validation()?>
<form action="" method="post" />
<div class="ttl">
<div class="ttr"></div>
</div>
<div class="bbd">
<p class="subtitle"><b>Дополнительные данные</b></p>
<table class="profile">

<tr>
<td class="caption">Цена за час работы:</td>
<td><input type="text" class="validate[custom[Number]] text-input" name="price_1" value="<?=$price_1?>" size="56" maxlength="12" /></td>
</tr>

<tr>
<td class="caption">Цена за месяц вашей работы:</td>
<td><input type="text" class="validate[custom[Number]] text-input" name="price_2" value="<?=$price_2?>" size="56" maxlength="12" /></td>
</tr>

</table>
</div>
<div class="bbl">
<div class="bbr"></div>
</div>
<br />
<input type="submit" value="Редактировать">
</form>


  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>