<div class="sideBar">
				<div class="tagsCloud slideBox">
					<ul id="slider1">
						<!-- Облако тегов, вывод надо рассчитать -->
						<?=$tagcloud?>
					</ul>
				</div>
				<div class="topDesigners">
					<!-- ТОП дизайнеров -->
					<h3>TOP 10 пользователей:</h3>
					<ul class="designersList">
					<? foreach($top_users as $row): ?>
						<li>
							<a href="/user/<?=$row['username']?>" title="перейти к портфолио" class="avatar">
								<!-- Нужна маленькая аватарка -->
								<img src="<?=$row['userpic']?>" alt="<?=$row['username']?> avi"/>
							</a>
							<p><a href="/user/<?=$row['username']?>" title="перейти к портфолио"><?=$row['username']?></a></p>
							<p><?=$row['name']?> <?=$row['surname']?></p>
							<!-- Не уверен, что это рейтинг -->
							<div class="rating"><?=$row['views']?></div>
						</li>
					<? endforeach; ?>
					</ul>
					<a href="/users/all">посмотреть всех</a>
				</div>
			</div>
			<div class="content">
				<p>Ресурс <a href="/">Ф.дизайн</a> представляет собой биржу дизайнеров интернет сайтов, которые готовы выполнить ваш заказ в кратчайшие сроки и за умеренную плату. Сегодня работа фрилансом приобрела особенную популярность по многим причинам. Во-первых, это отсутствие необходимости снимать специальное помещение под офис для сотрудников. Во-вторых, пропадает необходимость набирать сотрудников в штат. Можно просто заказать оформление сайта одному из пользователей нашего ресурса. Подобный вид работы будет выполнен быстро и качественно, а также не потребует от вас дополнительных затрат. В том случает, если вы являетесь фрилансером и способны предоставить услуги качественного дизайна интернет сайтов, то у вас есть возможность найти себе задание, которое будет интересно именно вам. Вы сможете выполнить за обусловленное время и незамедлительно получить оплату, не опасаясь за оплату своего труда. Качественный фирменный стиль вашего сайта и отличные условия работы для фрилансеров – именно это делает ресурс Ф.дизайн прекрасным выбором как для фрилансеров, так и для работодателей.</p>
				<div class="freshDesigns">
					<h3>Свежие дизайны:</h3>
					<ul class="freshDesignsList">
					<? if( !empty($data) ): ?>
					<!-- ?=show_highslide()? -->
						<? foreach($data as $row): ?>
						<li>
							<!-- Здесь нужна серая превьюшка -->
							<a href="<?=$row['full_image']?>" class="zoom grey" title="<?=$row['title']?>"><img src="<?=$row['small_image']?>" alt="<?=$row['title']?>"/></a>
							<div class="moreInfo">
								<a href="<?=$row['full_image']?>" class="zoom" title="<?=$row['title']?>"><img src="<?=$row['small_image']?>" alt="<?=$row['title']?>"/></a>
								<!-- Здесь ID или рейтинг? -->
								<div class="designID"><?=$row['id']?></div>
								<div class="price">
									<a href="/designs/<?=$row['id']?>.html">подробно</a>
									<!-- И цена какая выводится должна? -->
									<?=$row['price_2']?> руб.
								</div>
							</div>
						</li>
						<? $i++; if($i>9) {break;} ?> 
						<? endforeach; ?>
					</ul>
					<? else: ?>
						<p>Ничего не найдено.</p>
					<? endif; ?>
				</div>
				<div class="popularDesigns">
					<h3><a href="/designs">посмотреть все работы</a> Популярные дизайны: </h3>
					<ul class="popularDesignsList">
					<? foreach($top_designs as $row): ?>
						<li>
							<!-- Здесь нужна серая превьюшка -->
							<a href="<?=$row['full_image']?>" class="zoom grey" title="<?=$row['title']?>"><img src="<?=$row['small_image']?>" alt="<?=$row['title']?>"/></a>
							<div class="moreInfo">
								<a href="<?=$row['full_image']?>" class="zoom" title="<?=$row['title']?>"><img src="<?=$row['small_image']?>" alt="<?=$row['title']?>"/></a>
								<!-- Здесь ID или рейтинг? -->
								<div class="designID"><?=$row['id']?></div>
								<div class="price">
									<a href="/designs/<?=$row['id']?>.html">подробно</a>
									<!-- И цена какая выводится должна? -->
									<? if( $row['sales'] > 0 ): ?> <?=$row['price_2']?> <? else: ?> <?=$row['price_1']?> <? endif; ?> руб.
								</div>
							</div>
						</li>
						<? $i++; if($i>14) {break;} ?> 
					<? endforeach; ?>
					</ul>
				</div>
			</div>