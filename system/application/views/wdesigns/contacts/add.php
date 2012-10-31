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
								<select name="group_id" onchange="document.location.href = '/contacts/index/?group_id=' + this.value"<?php foreach ($groups as $row): ?>
									<option value="<?=$row['id']?>"><?= $row['name']?>(<?= $row['count_contacts']?>)</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?= validation_errors()?>
		<div class="rnd">
			<div>
				<div>
					<div>
						<div id="msearch">
							<form action="" method="post">
								Название группы:
								<div>
									<input type="text" name="name" class="mtext"></div>
								<div>
									<input type="submit" value="Добавить"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>