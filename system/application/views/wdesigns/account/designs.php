<?php $this->load->view('wdesigns/account/block'); ?>
<div class="content">
	<div class="addItem">
		<div class="addItemRightBrdr">
			<span>+</span>
			<a href="/designs/add/">добавить работу</a>
		</div>
	</div>
	<?php if (! empty($data)): ?>
	<?php foreach ($data as $cat_name_path=>$designs): ?>
	<div class="userPortfolioHeader top">
		<h3><?= $cat_name_path?>:</h3>
		<ul class="userPortfolioCategory">
		<?php 
		/*
		 <li>
		 <a href="#" class="active">сайты:</a>
		 <span>99</span>
		 </li>
		 <li>
		 <a href="#">баннеры:</a>
		 <span>99</span>
		 </li>
		 <li>
		 <a href="#">flash анимация:</a>
		 <span>99</span>
		 </li>
		 <li>
		 */
		?>
		<a href="#">все работы</a>
		</li>
	</ul>
</div>
<div class="userPortfolioList">
	<ul class="worksList">
		<?php foreach ($designs as $row): ?>
		<li>
			<a href="<?=$row['full_image']?>" class="zoom" title="zoom prewiev"><img src="<?=$row['small_image']?>" title="<?=$row['title']?>" /></a><a href="#" class="sign"><?= $row['status']?></a>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endforeach; ?>
<div class="contentWrapperBorderLeft" style="height:200px;"></div>
<?php else : ?>
<p>Дизайны отсутствуют.</p>
<?php endif; ?>
</div>