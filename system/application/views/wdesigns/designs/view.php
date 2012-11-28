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
	
	$('#addcart').fadeOut(300);
	
	$.ajax({
		type: "POST",
		url: "/account/cart_add",
		data: dataString,
		cache: false,
		//Получаем текст со страницы
		success: function(html){
			$('#addcart').html(html);
			$('#addcart').fadeIn(300);
		}
	});
	
	return false;
}

</script>

<div class="sideBar">
	<div class="tagsCloud slideBox">
		<ul id="slider1">
			<!-- Облако тегов, вывод надо рассчитать -->
			<?= $tagclou;?>
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
					<span class="colorBar" style="margin:2px 2px;height:10px;width:10px;display:inline-block;background: #<?= $row['color']; ?>" rel="<?= $row['color']; ?>" href="#"></span>
				<?php endforeach; ?>
			</p>
			<div class="statistica">
				<p>
					<span>Скачиваний:</span>
					<?= $sales?>
					<!--
					<?php if ($sales == 0 and !$user_is_owner): ?>
					<a href="#" onclick="addcart(<?=$id?>, 2)" class="buyout"><span>Выкупить за <strong> <?= $price_2?> руб.</strong></span></a>
					<?php endif; ?>
					-->
				</p>
				<?php if ($status_id == 1): ?>
				<p>
					<span>Цена:</span>
					<strong>
						<?= $price_1?>
						руб.</strong>
					<?php if (!$user_is_owner): ?>
						<a href="#" onclick="addcart(<?=$id?>, 1)" class="buy"><span>Купить</span></a>
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
		<div class="moreInfo">
			<p class="moreInfo">
				<a href="#">Дополнительная информация:</a>
			</p>
			<fieldset>
				<label>
					<label>Сопутствующие товары:</label>
					это не предусмотрено в модели, но я выведу, чтобы обратить внимание.
				</label>
			</fieldset>
			<fieldset>
				<label>
					Флеш:
					<?= $flash; ?>
				</label>
			</fieldset>
			<fieldset>
				<label>
					Стретч:
					<?= $stretch; ?>
				</label>
			</fieldset>
			<fieldset>
				<label>
					Тип:
					<?= $type; ?>
				</label>
			</fieldset>
			<fieldset>
				<label>
					Количество колонок: 
					<?= $columns; ?>
				</label>
			</fieldset>
			<fieldset>
				<label>
					Тех. качество:
					<?= $quality; ?>
				</label>
			</fieldset>
			<fieldset>
				<label>
					Тема:
					<?= $theme?>
				</label>
			</fieldset>
			<fieldset>
				<label>
					Тон:
					<?= $tone?>
				</label>
			</fieldset>
			<fieldset>
				<label>
					Яркость:
					<?= $bright?>
				</label>
			</fieldset>
			<fieldset>
				<label>
					Стиль:
					<?= $style?>
				</label>
			</fieldset>
			<fieldset>
				<label>
					&laquo;Для взрослых&raquo;:
					<?= $adult?>
				</label>
			</fieldset>
		</div>
		<?= $comments?>
	</div>
</div>
