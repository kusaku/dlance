<? $this->load->view('wdesigns/users/block'); ?>

<div class="content">
	<? if( !empty($data) ): ?>
	<? foreach($data as $row): ?>
	<div class="userPortfolioHeader">
		<h3><?=$row['category']?>:</h3>
		<ul class="userPortfolioCategory">
			<li><a href="#" class="active">сайты:</a> <span>99</span></li>
			<li><a href="#">баннеры:</a> <span>99</span></li>
			<li><a href="#">flash анимация:</a> <span>99</span></li>
			<li><a href="#">все работы</a></li>
		</ul>
	</div>
	<div class="userPortfolioList">
		<ul class="worksList">
			<li>
				<a href="<?=$row['full_image']?>" class="zoom" title="zoom prewiev"><img src="<?=$row['small_image']?>" title="<?=$row['title']?>" /></a>
				<a href="/account/cart_add/<?=$row['id']?>" class="sign"><?=$row['status']?></a>
			</li>
		</ul>
	</div>
	<? endforeach; ?>
	<div class="contentWrapperBorderLeft" style="height:200px;">
	</div>
	<? else: ?>
		<p>Дизайны отсутствуют.</p>
	<? endif; ?>
</div>