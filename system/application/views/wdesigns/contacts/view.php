<?php $this->load->view('wdesigns/account/block'); ?>
<div id="yui-main">
	<div class="yui-b">
		<h1><a href="">Контакты / Сообщения</a></h1>
		<p class="subtitle"> Ваши контакты </p>
		<div class="rnd">
			<div>
				<div>
					<div>
						<div align="right">
							<a href="/contacts/add">Создать группу</a>
						</div>
						<h1 class="market-title">Группы</h1>
						<div id="msearch">
							<div>
								<select name="group_id" onchange="document.location.href = '/contacts/index/?group_id=' + this.value">
									<?php foreach ($groups as $row): ?>
									<option value="<?=$row['id']?>"<?php if ($active['id'] == $row['id']): ?>selected="selected"<?php endif; ?>><?= $row['name']?> (<?= $row['count_contacts']?>)</option>
									<?php endforeach; ?>
								</select>
							</div>
							<?php if ($active['user_id'] != 0): ?>
							<a href="/contacts/edit/<?=$active['id']?>">Редактировать</a>
							| <a href="/contacts/del/<?=$active['id']?>">Удалить</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?= $contactlist; ?>
		<br/>
		<div class="rnd">
			<div>
				<div>
					<div>
						<div id="msearch">
							Переместить отмеченные в: 
							<div>
								<select name="group_id">
									<?php foreach ($groups as $row): ?>
									<option value="<?=$row['id']?>"><?= $row['name']?>(<?= $row['count_contacts']?>)</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div>
								<input type="submit" value="Переместить"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>