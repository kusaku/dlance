<div class="sideBar">
	<div class="designsCategories">
		<h3><a href="/users/all/">Все дизайнеры</a></h3>
		<?
		if( !empty($category) )
		{
			$active = $category;
			foreach($categories as $row):
				if( $active == $row['id'] ):
					//Если у активной категории имеется раздел, присваиваем раздел
					if( $row['parent_id'] != 0 ):
						$active = $row['parent_id'];
					endif;
				endif;
			endforeach;
		}
		?>
		<ul>
		<? foreach($categories as $row): ?> 

			<? if( $row['parent_id'] == 0 ) :?>
				<li class="<? if( !empty($active) and $row['id'] == $active ): ?>active<? endif ?>"><a href="/users/all/?category=<?=$row['id']?>"><?=$row['name']?></a>
			<? endif; ?>

			<? if( !empty($active) and $active == $row['id'] ):?>
				<ul>
				<? foreach($categories as $row2): ?>
					<? if( $row['id'] == $row2['parent_id'] ): ?>
						<li class="lvl-2"><a href="/users/all/?category=<?=$row2['id']?>"><?=$row2['name']?></a> <span>(<?=$row2['number']?>)</span></li>
					<? endif; ?>
				<? endforeach; ?>
				</ul>
			</li>
			<? else: ?>
				<? if ($row['parent_id']==0){ echo "</li>"; }?>
			<? endif; ?>
		<? endforeach; ?>
		</ul>
		<? if( !empty($users_descr) ): ?>
			<div class="sideblock nomargin">
				<p class="freetext"><?=$users_descr?></p>
			</div>  
		<? endif; ?>
	</div>
</div>
<div class="content">
	<div class="searchResults">
		<div class="searchResultsHeader">
			<div class="sortBy">
				<a href="/users/search/">Расширенный поиск</a>
			</div>
			<h3>Дизайнеры<? if( !empty($title) ): ?> / <?=$title?><? endif; ?></h3>
		</div>
		<div class="searchResultsList">
			<? if( !empty($data) ): $n = 0; ?>
			<ul class="designersList">
			<? foreach($data as $row => $value): ?>
				<li>
					<p class="number"><?=$row+1?></p>
					<a href="/user/<?=$value['username']?>" title="перейти к портфолио" class="avatar <?=$value['tariffname']?>">
						<!-- Нужна маленькая аватарка -->
						<img src="<?=$value['userpic']?>" alt="<?=$value['username']?> avi"/>
					</a>
					<div class="infoblock">
						<p><a class="username" href="/user/<?=$value['username']?>" title="перейти к портфолио"><?=$value['username']?></a></p>
						<p><?=$value['name']?> <?=$value['surname']?></p>
						<p><a class="message" href="/contacts/send/<?=$value['username']?>">Личное сообщение</a></p>
					</div>
					<div class="infoblock">
						<p>&nbsp;</p>
						<p>Последний визит: <?=$value['last_login']?></p>
						<p>Дата регистрации: <?=$value['created']?></p>
					</div>
					<!-- Не уверен, что это рейтинг -->
					<div class="rating"><?=$value['rating']?></div>
				</li>
			<? endforeach; ?>
			</ul>
			<div class="paginationControl">
				<?=$page_links?>
			</div>
			<? else: ?>
				Дизайнеров не найдено
			<? endif; ?>
		</div>
	</div>
</div>