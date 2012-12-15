<link rel="stylesheet" type="text/css" href="/templates/js/thickbox/thickbox.css" />
<script type='text/javascript' src='/templates/js/thickbox/thickbox.js'></script>
<script type="text/javascript">
function vote(id, type){
	var dataString = 'id=' + id + '&type=' + type;
	
	$('#rating').fadeOut(300);
	
	$.ajax({
		type: "POST",
		url: "/designs/vote",
		data: dataString,
		cache: false,
		//Получаем текст со страницы
		success: function(html){
			$('#rating').html(html);
			$('#rating').fadeIn(300);
		}
	});
	
	return false;
}

function send_report(id){
	var text = $('#report').val();
	
	var dataString = 'id=' + id + '&text=' + text;
	
	if (text.length > 256) {
		alert('Текст сообщения не должно содержать больше 256 символов');
		
		return false;
	}
	
	$.ajax({
		type: "POST",
		url: "/designs/send_report",
		data: dataString,
		//Получаем текст со страницы
		success: function(html){
			alert('Жалоба отправлена');
		}
	});
	
	tb_remove()
	
	return false;
}

//
//<?php if( $this->team == 2 ): ?>
//

function ban(id){
	var text = $('#cause').val();
	
	var dataString = 'id=' + id + '&text=' + text;
	
	if (text.length > 256) {
		alert('Текст сообщения не должно содержать больше 256 символов');
		
		return false;
	}
	
	$.ajax({
		type: "POST",
		url: "/designs/send_ban",
		data: dataString,
		//Получаем текст со страницы
		success: function(html){
			alert('Продукт забанен');
		}
	});
	
	tb_remove();
	
	return false;
}

//
//<?php endif; ?>
//

function addcart(id, kind){
	var dataString = 'id=' + id + '&kind=' + kind;
	
	jQuery.post('/account/cart_add', {
		id: id,
		kind: kind
	}, function(data, textStatus, jqXHR){
		if (data.success) {
			$('.cart_count').text(1 + parseInt($('.cart_count').text()))
			
			$('<span/>').html(data.message).dialog({
				buttons: [{
					text: 'Закрыть',
					click: function(){
						$(this).dialog('close');
					}
				}],
				title: 'Сообщение'
			});
		}
		else {
			$('<span/>').html(data.message).dialog({
				buttons: [{
					text: 'Закрыть',
					click: function(){
						$(this).dialog('close');
					}
				}],
				title: 'Ошибка'
			});
		}
	}, 'json');
	
	return false;
}

</script>

<div class="sideBar">
	<div class="userInfo">
		<h3>Дизайнер:</h3>
		<div class="avatar <?=$tariff?>">
			<a href="/contacts/send/<?=$username?>" title="Личное сообщение"></a>
			<img src="<?=$userpic?>" alt="<?=$username?> avi" />
		</div>
		<p class="contacts">
			<a href="/user/<?=$username?>" class="name"><?= $username?></a>
		</p>
		<p>
			<?= "{$name} {$surname}"?>
		</p>
		<p>
			<a href="/contacts/send/<?=$username?>" title="Личное сообщение">Личное сообщение</a>
		</p>
	</div>
	<div class="tagsCloud slideBox">
		<h3>Теги дизайна:</h3>
		<ul id="slider1">
			<!-- Облако тегов, вывод надо рассчитать -->
			<?= $tagcloud?>
		</ul>
	</div>
	<div class="designsCategories">
		<h3><a href="/designs">Дизайны:</a></h3>
		<?php 
		if (! empty($category_id)) {
			$active = $category_id;
			foreach ($categories as $row):
				if ($active == $row['id']):
					//Если у активной категории имеется раздел, присваиваем раздел
					if ($row['parent_id'] != 0):
						$active = $row['parent_id'];
					endif;
				endif;
			endforeach;
		}
		?>
		<ul>
			<?php foreach ($categories as $row): ?>
			<?php if ($row['parent_id'] == 0): ?>
			<li class="<?php if( !empty($active) and $row['id'] == $active ): ?>active<?php endif ?>">
				<a href="/designs/search/?category=<?=$row['id']?>"><?= $row['name']?></a>
				<?php endif; ?>
				<?php if (! empty($active) and $active == $row['id']): ?>
				<ul>
					<?php foreach ($categories as $row2): ?>
					<?php if ($row['id'] == $row2['parent_id']): ?>
					<li class="lvl-2">
						<a href="/designs/search/?category=<?=$row2['id']?>"><?= $row2['name']?></a>
						<span>(<?= $row2['number']?>)</span>
					</li>
					<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</li>
			<?php else : ?>
			<?php if ($row['parent_id'] == 0) { echo "</li>"; } ?>
			<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="content">
	<div class="templateCard">
		<div class="templateCardHeader">
			<div class="rating" id="rating">
				<p>Оценка дизайна:</p>
				<a href="#" onclick="vote(<?=$id?>, 1)" class="plus">+</a>
				<span><?= $rating?></span>
				<a href="#" onclick="vote(<?=$id?>, 2)" class="minus">-</a>
			</div>
			<h3><?= $title?></h3>
		</div>
		<div class="templateDesription">
			<?php if ($user_id == $this->user_id): ?>
				<a href="/designs/edit/<?=$id?>">изменить</a>
			<?php endif; ?>
			<p>
				<span>Рейтинг:</span>
				<?= $rating?>
			</p>			
			<p>
				<span>Тип:</span>
				<?= $category?>
			</p>
			<p>
				<span>Исходник:</span>
				<?= $source?>
			</p>
			<p>
				<span>Описание:</span>
				<?= $descr?>
			</p>
			<p>
				<span>Подробно:</span>
				<?= $text?>
			</p>
			<p>
				<span>Цвета:</span>
				<?php foreach ($colors as $row): ?>
				<a href="/designs/search/?color=<?= $row['color']; ?>" class="colorBar" style="margin:2px 2px;height:14px;width:14px;display:inline-block;border:1px solid silver;background: #<?= $row['color']; ?>"></a>
				<?php endforeach; ?>
			</p>
			<p>
				<span>Дополнительная информация:</span>
				<?=implode(', ', $properties)?>
			</p>
			<div class="statistica">
				<?php if ($status_id == 1): ?>
				<p>
					<?php if ($price_1 > 0): ?>
					<span>Цена:</span>
					<strong>
						<?= $price_1?>
						руб.</strong>
					<?php endif; ?>
					<?php if (!$user_is_owner): ?>
						<a href="#" onclick="addcart(<?=$id?>, 1)" class="buy"><span>Заказать</span></a>
					<?php endif; ?>
				</p>
				<?php endif; ?>
			</div>
		</div>
		<div class="templatePreview">
			<script type="text/javascript" src="/design/js/jquery.bxSlider.min.js"></script>
			<script type="text/javascript">
				(function($){
					$(function(){
						$("#featurelist").bxSlider({
							auto: true,
							mode: 'fade',
							infiniteLoop: true,
							controls: false,
							pager: true,
							buildPager: function(slideIndex){
								switch (slideIndex) {
									case 0:
										return '<a href="<?=$mid_image1?>"><img src="<?=$small_image1?>" /></a>';
									case 1:
										return '<a href="<?=$mid_image2?>"><img src="<?=$small_image2?>" /></a>';
									case 2:
										return '<a href="<?=$mid_image3?>"><img src="<?=$small_image3?>" /></a>';
								}
							}
						});
					});
				}(jQuery))
			</script>
			<ul id="featurelist">
				<?php if(!empty($full_image1)): ?>
				<li>
					<a href="<?=$full_image1?>" class="zoom" title="zoom preview"><img src="<?= $mid_image1; ?>" alt="template"/></a>
				</li>
				<?php endif; ?>
				<?php if(!empty($full_image2)): ?>
				<li>
					<a href="<?=$full_image2?>" class="zoom" title="zoom preview"><img src="<?= $mid_image2; ?>" alt="template"/></a>
				</li>
				<?php endif; ?>
				<?php if(!empty($full_image3)): ?>
				<li>
					<a href="<?=$full_image3?>" class="zoom" title="zoom preview"><img src="<?= $mid_image3; ?>" alt="template"/></a>
				</li>
				<?php endif; ?>
			</ul>
		</div>
		<div class="moreInfo comments">
		<?= $comments?>
	</div>
</div>
