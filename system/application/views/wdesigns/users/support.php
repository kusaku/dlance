<div class="standaloneForm">
	<h3>Обратная связь</h3>
	<div class="error">
		<?=validation_errors()?>
	</div>
	<form action="" method="post">
		<fieldset>
			<label>Тема:</label><br/>
			<select name="subject" id="feedback">
				<option value="0"<?=set_select('subject', '0')?>>Вопрос по работе системы</option>
				<option value="1"<?=set_select('subject', '1')?>>Предложение сотрудничества</option>
				<option value="2"<?=set_select('subject', '2')?>>Сообщение об ошибке</option>
				<option value="3"<?=set_select('subject', '3')?>>Размещение рекламы на dlance.ru</option>
			</select>
		</fieldset>
		<fieldset>
			<label>Ваш email:</label><br/>
			<input type="text" class="text" name="email" value="<?=set_value('email')?>" size="32" maxlength="64" />
		</fieldset>
		<fieldset>
			<label>Cообщение:</label><br/>
			<textarea cols="48" rows="8" name="message"><?=set_value('message')?></textarea>
		</fieldset>
		<fieldset>
			<label>Введите код:</label><br />
			<?=$imgcode?><br />
			<input name="code" type="text" size="10" maxlength="10" style="width:102px;margin: 4px 0 0 0;" />
		</fieldset>
		<fieldset>
			<input class="form-submit" type="submit" value="Отправить сообщение">
		</fieldset>
	</form>
</div>