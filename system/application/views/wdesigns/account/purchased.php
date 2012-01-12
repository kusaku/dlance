<? $this->load->view('wdesigns/account/block'); ?>
<div class="content">
	<div class="cartResults">
		<div class="userBasketHeader">
			<h3>Купленные:</h3>
		</div>
		<div class="contentWrapperBorderLeft">
			<div class="searchResultsList">
				<? if( !empty($data) ): ?>
				<ul class="designsList">
					<? foreach($data as $row): ?>
					<li> 
						<a href="<?=$row['full_image']?>" class="zoom" title="<?=$row['title']?>"><img src="<?=$row['small_image']?>" alt="<?=$row['title']?>"/></a>
						<p><a href="/designs/<?=$row['id']?>.html"><?=$row['title']?></a></p>
						<!-- Это откуда берется? -->
						<p><?=$row['category']?><br/>
						Исходник: <?=$row['source']?></p>
						<p>Рейтинг: <span><?=$row['rating']?></span><br/>
						Скачиваний: <span><?=$row['sales']?></span><br/>
						Цена: <span><?=$row['price_1']?> руб.</span></p>
						<p class="details"><a href="/account/create_download/<?=$row['design_id']?>">Перейти к скачке</a></p>
					</li>
					<? endforeach; ?>
				</ul>
				<div class="paginationControl">
					<?=$page_links?>
				</div>
				<!--
				<div class="itemsOnPage">
					<p>кол-во дизайнов на страницу:</p>
					<ul class="pageList">
					<? $results = array(10,20,50,100);
						foreach ($results as $items){
							if($items==$input['result']){
								echo "<li class=\"active\">".$items."</li>";
							}
							else {
								if (mb_strpos($_SERVER['QUERY_STRING'],"&result=")) {
									echo "<li><a href=\"".mb_substr($_SERVER['QUERY_STRING'],0,(mb_strpos($_SERVER['QUERY_STRING'],"&result=")))."&result=".$items."\">".$items."</a></li>";
								}
								else {
									echo "<li><a href=\"".$_SERVER['QUERY_STRING']."&result=".$items."\">".$items."</a></li>";
								}
							}
						}
					?>
					</ul>
				</div>
				-->
				<? else: ?>
					<p>Дизайны отсутствуют.</p>
				<? endif; ?>
			</div>
		</div>
	</div>
</div>