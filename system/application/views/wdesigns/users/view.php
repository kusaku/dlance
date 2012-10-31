<?php $this->load->view('wdesigns/users/block'); ?>
<div id="usercard" class="bd clearfix">
	<img src="images/user.gif" class="grp-icon" />
	<div class="sendpm">
		<a href="/contacts/send/<?=$username?>">Личное сообщение</a>
	</div>
	<table class="userstats">
		<tr>
			<td>Дата регистрации:</td>
			<td>
				<?= $created?>
			</td>
		</tr>
		<tr>
			<td>Последний визит:</td>
			<td>
				<?= $last_login?>
			</td>
		</tr>
		<tr>
			<td>Просмотров:</td>
			<td>
				<?= $views?>
			</td>
		</tr>
		<tr>
			<td>Местоположение:</td>
			<td>
				<?= $country_id?>
				/ 
				<?= $city_id?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="noborder green"></td>
		</tr>
	</table>
	<?php if (! empty($website)): ?>
	<b><a href="<?=$website?>" target="_blank" rel="nofollow">
			<?= $website?>
		</a></b>
	<?php endif; ?>
</div>
<div class="ft"></div>