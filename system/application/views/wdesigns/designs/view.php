<script type='text/javascript' src='/templates/js/thickbox/thickbox.js'></script>
<link rel="stylesheet" type="text/css" href="/templates/js/thickbox/thickbox.css" />

<script type="text/javascript">

function vote(id, type)
{
	var dataString = 'id='+ id +'&type='+ type;

	$('#rating').fadeOut(300);

	$.ajax({
		type: "POST",
		url: "/designs/vote",
		data: dataString,
		cache: false,
		success: function(html)//Получаем текст со страницы
		{
			$('#rating').html(html);
			$('#rating').fadeIn(300);
		}
	});

	return false;
}

function send_report(id)
{
	var text = $('#report').val();

	var dataString = 'id='+ id +'&text='+ text;

    if(text.length > 256)
	{
        alert('Текст сообщения не должно содержать больше 256 символов');

		return false;
	}

	$.ajax({
		type: "POST",
		url: "/designs/send_report",
		data: dataString,
		success: function(html)//Получаем текст со страницы
		{
			alert('Жалоба отправлена');
		}
	});

	tb_remove()

	return false;
}

<? if( $this->team == 2 ): ?>
function ban(id)
{
	var text = $('#cause').val();

	var dataString = 'id='+ id +'&text='+ text;

	if(text.length > 256)
	{
        alert('Текст сообщения не должно содержать больше 256 символов');

		return false;
	}

	$.ajax({
		type: "POST",
		url: "/designs/send_ban",
		data: dataString,
		success: function(html)//Получаем текст со страницы
		{
			alert('Продукт забанен');
		}
	});

	tb_remove()

	return false;
}
<? endif; ?>

function addcart(id, kind)
{
	var dataString = 'id='+ id +'&kind='+ kind;

	$('#addcart').fadeOut(300);

	$.ajax({
		type: "POST",
		url: "/account/cart_add",
		data: dataString,
		cache: false,
		success: function(html)//Получаем текст со страницы
		{
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
			<?=$tagcloud?>
		</ul>
	</div>
	<div class="designsCategories">
		<h3><a href="/designs">Дизайны:</a></h3>
		<?
		if( !empty($category_id) )
		{
			$active = $category_id;
			foreach($categories as $row):
				if( $active == $row['id'] ):
					if( $row['parent_id'] != 0 )://Если у активной категории имеется раздел, присваиваем раздел
						$active = $row['parent_id'];
					endif;
				endif;
			endforeach;
		}
		?>
		<ul>
		<? foreach($categories as $row): ?> 

			<? if( $row['parent_id'] == 0 ) :?>
				<li class="<? if( !empty($active) and $row['id'] == $active ): ?>active<? endif ?>"><a href="/designs/search/?category=<?=$row['id']?>"><?=$row['name']?></a>
			<? endif; ?>

			<? if( !empty($active) and $active == $row['id'] ):?>
				<ul>
				<? foreach($categories as $row2): ?>
					<? if( $row['id'] == $row2['parent_id'] ): ?>
						<li class="lvl-2"><a href="/designs/search/?category=<?=$row2['id']?>"><?=$row2['name']?></a> <span>(<?=$row2['number']?>)</span></li>
					<? endif; ?>
				<? endforeach; ?>
				</ul> 
			</li>
			<? else: ?>
				<? if ($row['parent_id']==0){ echo "</li>"; }?>
			<? endif; ?>
		<? endforeach; ?>
		</ul>
	</div>
			</div>
			<div class="content">
				<div class="templateCard">
					<div class="templateCardHeader">
						<div class="rating" id="rating">
							<p>Оценка дизайна:</p>
							<a href="#" onclick="vote(<?=$id?>, 1)" class="plus">+</a>
							<span><?=$rating?></span>
							<a href="#" onclick="vote(<?=$id?>, 2)" class="minus">-</a>
						</div>
						<h3><?=$title?></h3>
					</div>
					<div class="templateDesription">
						<p><span>Тип:</span> HTML/CSS/Flash шаблон<br/>
						<span>Исходник:</span> <?=$source?></p>
						<p><span>Описание:</span> JavaScript-Анимированные Полный сайт CSS шаблоны содержат JS основе элементов, которые добавляют Flash-как динамика и анимации, оставляя шаблонов очень легкий.</p>
						<div class="statistica">
							<p><span>Рейтинг:</span> <?=$rating?><br/>
							<? if( $status_id == 1 ): ?>
								<? if( $this->user_id != $user_id ): ?>
									<? if( $sales == 0 ): ?><a href="#"  onclick="addcart(<?=$id?>, 2)" class="buyout"><span>Выкупить за <? if( $sales > 0 ): ?> <? endif; ?><strong><?=$price_2?> руб.</span></a><span>Скачиваний:</span> 0</p><? endif; ?>
									<p><a href="#"  onclick="addcart(<?=$id?>, 1)" class="buy"><span>Купить</span></a><span>Цена:</span> <? if( $status_id == 2 ): ?> <? endif; ?><strong><?=$price_1?> руб.</p><? endif; ?>
									<? endif; ?>
							<p class="moreInfo"><a href="#">Дополнительная информация:</a></p>
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
						switch (slideIndex){
							case 0:
								return '<a href=""><img src="<?=$small_image?>" /></a>';
							case 1:
								return '<a href=""><img src="<?=$small_image?>" /></a>';
						}
					}
				});
			});
		}(jQuery))
		</script>
						<ul id="featurelist">
							<li><a href="<?=$full_image?>" class="zoom" title="zoom prewiev"><img src="<? if (!empty($mid_image)) {echo $mid_image;} else {echo $full_image;} ?>" alt="template"/></a></li>
							<li><a href="<?=$full_image?>" class="zoom" title="zoom prewiev"><img src="<? if (!empty($mid_image)) {echo $mid_image;} else {echo $full_image;} ?>" alt="template"/></a></li>
						</ul>
					</div>
					<div class="moreInfo">
						<form action="#" method="post">
							<fieldset>
								<p>Сопутствующие товары:</p>
								<input name="articuls" type="text" placeholder="вводите ID продуктов через запятую" value=""/>
								<label>вводите ID продуктов через запятую</label>
							</fieldset>
							<fieldset>
								<p>Флеш:</p>
								<? if( $flash!="Нет" ): ?>
									<input name="flash" type="radio" class="niceRadio" value="1" checked />
									<label>да</label>
									<input name="flash" type="radio" class="niceRadio" value="2"/>
									<label>нет</label>
								<? else: ?>
									<input name="flash" type="radio" class="niceRadio" value="1" />
									<label>да</label>
									<input name="flash" type="radio" class="niceRadio" value="2" checked />
									<label>нет</label>
								<? endif; ?>
							</fieldset>
							<fieldset>
								<p>Стретч:</p>
								<? if( $stretch=="Тянущаяся" ): ?>
									<input name="stretch" type="radio" class="niceRadio" value="1" checked />
									<label>резина</label>
									<input name="stretch" type="radio" class="niceRadio" value="2"/>
									<label>фиксированая</label>
								<? else: ?>
									<input name="stretch" type="radio" class="niceRadio" value="1" />
									<label>резина</label>
									<input name="stretch" type="radio" class="niceRadio" value="2" checked />
									<label>фиксированая</label>
								<? endif; ?>
							</fieldset>
							<fieldset>
								<p>Количество колонок:</p>
								<select name="cols" style="width: 40px;" id="selectel">
									<? for($i=1; $i<5; $i++){
										if ($columns==$i){
											echo "<option value=\"$i\" selected>$i</option>";
										}
										else {
											echo "<option value=\"$i\">$i</option>";
										}
									} ?>
								</select>
							</fieldset>
							<fieldset>
								<p>Тех качество:</p>
								<? if($quality=="Только для IE") {
										echo "<input name=\"tehka4estvo\" type=\"radio\" class=\"niceRadio\" value=\"1\" checked />
												<label>только IE</label>";
									}
									else {
										echo "<input name=\"tehka4estvo\" type=\"radio\" class=\"niceRadio\" value=\"1\" />
												<label>только IE</label>";
									}
									if($quality=="Кроссбраузерная верстка") {
										echo "<input name=\"tehka4estvo\" type=\"radio\" class=\"niceRadio\" value=\"2\" checked />
												<label>кроссбраузерная</label>";
									}
									else {
										echo "<input name=\"tehka4estvo\" type=\"radio\" class=\"niceRadio\" value=\"2\" />
												<label>кроссбраузерная</label>";
									}
									if($quality=="Полное соответствие W3C") {
										echo "<input name=\"tehka4estvo\" type=\"radio\" class=\"niceRadio\" value=\"3\" checked />
												<label>соответствие W3C</label>";
									}
									else {
										echo "<input name=\"tehka4estvo\" type=\"radio\" class=\"niceRadio\" value=\"3\" />
												<label>соответствие W3C</label>";
									}
								?>
							</fieldset>
							<fieldset>
								<p>Тема:</p>
								<select name="theme" id="theme">
									<option value="0"><?=$theme?></option>
									<option value="1">Нефритовый</option>
									<option value="2">Тефлоновый</option>
									<option value="3">Непригораемый</option>
									<option value="4">ОЛОЛОЛО</option>
								</select>
							</fieldset>
						</form>
					</div>
					<?=$comments?>
				</div>
			</div>