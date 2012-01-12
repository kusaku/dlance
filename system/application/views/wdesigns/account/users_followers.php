<? $this->load->view('wdesigns/account/block'); ?>

<div class="content">
	<div class="userResponseHeader">
		<div class="addResponse">
			<div class="addResponseRightBrdr">
				<a href="#">удалить всех</a>
			</div>
		</div>
		<h3>Рассылка по пользователям:</h3>
	</div>
	<div class="contentWrapperBorderLeft" style="min-height:580px;">
		<? if( !empty($data) ): ?>
		<ul class="subscribersList">
			<? foreach($data as $row): ?>
			<li>
				<div class="userInfo">
					<div class="avatar lite">
						<a href="/user/<?=$row['username']?>" title="перейти к портфолио <?=$row['username']?>"></a>
						<img src="<?=$row['userpic']?>" alt="<?=$row['username']?> avi" />
					</div>
					<div class="tooltip"><p><span><a href="/user/<?=$row['username']?>" title="перейти к портфолио <?=$row['username']?>"><?=$row['username']?></a> <a href="/account/subscribe_del/<?=$row['follows']?>" class="delete">x</a></span></p></div>
				</div>
			</li>
			<? endforeach; ?>
		</ul>
		<div class="paginationControl">
			<?=$page_links?>
		</div>
		<? else: ?>
			<p>Подписчики отсутствуют.</p>
		<? endif; ?>
	</div>
</div>