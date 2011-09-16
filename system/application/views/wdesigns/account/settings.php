<div id="yui-main">
<div class="yui-b">


<h1> <a href="/account/settings">Настройки</a> </h1>

<p class="subtitle"> Настройки </p>

<form action="" method="post" />
<div class="ttl">
<div class="ttr"></div>
</div>
<div class="bbd">
<p class="subtitle"><b>Настройки</b></p>
<table class="profile">

<tr>
<td class="caption">Получать рассылку:</td>
<td><input name="mailer" type="checkbox" value="1"<? if( !empty($mailer) ): ?> checked="checked"<? endif; ?> /></td>
</tr>

<tr>
<td class="caption">Получать уведомления:</td>
<td><input name="notice" type="checkbox" value="1"<? if( !empty($notice) ): ?> checked="checked"<? endif; ?> /></td>
</tr>

<tr>
<td class="caption">Показывать всплывающие подсказки:</td>
<td><input name="hint" type="checkbox" value="1"<? if( !empty($hint) ): ?> checked="checked"<? endif; ?> /></td>
</tr>

<tr>
<td class="caption">Показывать контент "только для взрослых":</td>
<td><input name="adult" type="checkbox" value="1"<? if( !empty($adult) ): ?> checked="checked"<? endif; ?><? if( $age < 19 ): ?> disabled="disabled"<? endif; ?> /> Пользователяем с возрастом менее 18 не доступна данная опция</td>
</tr>

</table>
</div>
<div class="bbl">
<div class="bbr"></div>
</div>


<br />
<input name="submit" type="submit" value="Сохранить изменения">
</form>
  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>