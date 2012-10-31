<?php $this->load->view('wdesigns/account/block'); ?>
<div id="yui-main">
	<div class="yui-b">
		<h1><a href="/account/password">Пароль</a></h1>
		<p class="subtitle"> Пароль </p>
		<?= validation_errors()?>
		<?= show_validation()?>
		<form action="" method="post" />
		<div class="ttl">
			<div class="ttr"></div>
		</div>
		<div class="bbd">
			<p class="subtitle">
				<b>Пароль</b>
			</p>
			<table class="profile">
				<tr>
					<td class="caption">Действующий пароль:</td>
					<td>
						<input type="password" class="validate[required,length[6,24]] text-input" name="old_password" size="56" maxlength="24" />
					</td>
				</tr>
				<tr>
					<td class="caption">Новый пароль:</td>
					<td>
						<input id="password1" type="password" class="validate[required,length[6,24]] text-input" name="password1" size="56" maxlength="24" />
					</td>
				</tr>
				<tr>
					<td class="caption">Повтор пароля:</td>
					<td>
						<input type="password" class="validate[required,confirm[password1]] text-input" name="password2" size="56" maxlength="24" />
					</td>
				</tr>
			</table>
		</div>
		<div class="bbl">
			<div class="bbr"></div>
		</div>
		<br/>
		<input type="submit" value="Редактировать"></form>
	</div>
</div><!--/yui-main-->