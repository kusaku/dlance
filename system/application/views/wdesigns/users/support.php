<div class="yui-g">
<h1 class="title"><a href="/users/support">Обратная связь</a></h1>
<div class="subtitle"></div>
<div class="content">
<?=validation_errors()?>
<form action="" method="post">
<div class="contactus rnd">
<div>
<div>
<div>
<ul>
<li>
</li>
<li>
<label>Тема:</label>
<select name="subject">
<option value="0"<?=set_select('subject', '0')?>>Вопрос по работе системы</option>
<option value="1"<?=set_select('subject', '1')?>>Предложение сотрудничества</option>
<option value="2"<?=set_select('subject', '2')?>>Сообщение об ошибке</option>
<option value="3"<?=set_select('subject', '3')?>>Размещение рекламы на dlance.ru</option>
</select>
</li>
<li>
<label>Ваш email:</label>
<input type="text" class="text" name="email" value="<?=set_value('email')?>" size="32" maxlength="64" />
</li>
<li>
<label>Cообщение:</label>
<textarea cols="48" rows="8" name="message"><?=set_value('message')?></textarea>
</li>
<li>
Введите код:<br />
<?=$imgcode?><br />
 <input name="code" type="text" size="10" maxlength="10" style="width:75px;" /></li></ul></div></div></div></div>
 <div class="form-submit">
<input type="submit" value="Отправить сообщение">
 </div>
</form>
</div>
</div>
<br clear="all">
<div style="font-size:11px;" class="mt20 clearfix">
</div>