<div id="yui-main">
<div class="yui-b">

<h1> <a href="/account/contact_data">Контактные данные</a> </h1>

<p class="subtitle"> Ваши контактные данные </p>

<?=validation_errors()?>
<?=show_validation()?>
<form action="" method="post" />
<div class="ttl">
<div class="ttr"></div>
</div>
<div class="bbd">
<p class="subtitle"><b>Контактные данные</b></p>
<table class="profile">
<tr>
<td class="caption">Email:</td>
<td><input type="text" class="validate[required,custom[email]]] text-input" name="email" value="<?=$email?>" size="56" maxlength="48" /></td>
</tr>

<tr>
<td class="caption">ICQ:</td>
<td><input type="text" class="validate[custom[Number]] text-input" name="icq" value="<?=$icq?>" size="56" maxlength="16" /></td>
</tr>

<tr>
<td class="caption">Skype:</td>
<td><input type="text" class="validate[custom[skype]] text-input" name="skype" value="<?=$skype?>" size="56" maxlength="16" /></td>
</tr>

<tr>
<td class="caption">Телефон:</td>
<td><input type="text" class="validate[custom[telephone]] text-input" name="telephone" value="<?=$telephone?>" size="56" maxlength="16" /></td>
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