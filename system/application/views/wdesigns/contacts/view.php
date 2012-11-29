<?php $this->load->view('wdesigns/account/block'); ?>
<div class="content">
	<div class="contactList">
		<h3><a href="#">Найти контакт</a>Контакты:</h3>
		<div class="contentWrapperBorderLeftRight">
			<ul>
				<li>
					<div class="avatar pro">
						<a href="#" title="перейти к портфолио"></a>
						<img src="images/avatar5.png" alt="creamsy avi"/>
					</div>
					<p><a href="#" title="перейти к портфолио" class="name">creamsy</a></p>
					<p>Богданова Екатерина</p>
					<a href="#" class="mailes"><span>19</span></a>
				</li>
				<li class="active">
					<div class="avatar lite">
						<a href="#" title="перейти к портфолио"></a>
						<img src="images/avatar3.png" alt="damboJunior avi"/>
					</div>
					<p><a href="#" title="перейти к портфолио" class="name">damboJunior</a></p>
					<p>Владимирский Илья</p>
					<a href="#" class="mailes"><span>1</span></a>
				</li>
				<li>
					<div class="avatar pro">
						<a href="#" title="перейти к портфолио"></a>
						<img src="images/avatar9.png" alt="Pitricio avi"/>
					</div>
					<p><a href="#" title="перейти к портфолио" class="name">Pitricio</a></p>
					<p>Павел Шевченко</p>
				</li>
				<li>
					<div class="avatar pro">
						<a href="#" title="перейти к портфолио"></a>
						<img src="images/avatar1.png" alt="nabux avi"/>
					</div>
					<p><a href="#" title="перейти к портфолио" class="name">nabux</a></p>
					<p>Васильев Евгений</p>
					<a href="#" class="mailes"><span>3</span></a>
				</li>
			</ul>
			<h3 class="blackList"><a href="#">добавить</a>Черный список:</h3>
			<ul>
				<li>
					<div class="avatar">
						<a href="#" title="перейти к портфолио"></a>
						<img src="images/avatar6.png" alt="emo4ka avi"/>
					</div>
					<p><a href="#" title="перейти к портфолио" class="name">emo4ka</a></p>
					<p>Кирсанова Александра</p>
				</li>
				<li>
					<div class="avatar lite">
						<a href="#" title="перейти к портфолио"></a>
						<img src="images/avatar7.png" alt="spoungeBoby avi"/>
					</div>
					<p><a href="#" title="перейти к портфолио" class="name">spoungeBoby</a></p>
					<p>Желтаковский Валерий</p>
				</li>
			</ul>
		</div>
	</div>
	<div class="messagesBlock">
		<div class="newMessage">
			<div class="newMessageHeader">
				<div class="addContactTo">
					<p>Добавить в: <a href="#">группу</a> <a href="#" class="black">черный список</a></p>
				</div>
				<h3>Написать сообщение:</h3>
			</div>
			<form action="#" method="post">
				<textarea id="text" name="text" placeholder="Ваш ответ"></textarea>
				<input type="submit" name="newcomment" value="Отправить" class="commentBtn" />
			</form>
		</div>
		<div class="messagesLog">
			<h3><a href="#">Очистить историю</a>История сообщений:</h3>
			<ul>
				<li class="unread">
					<div class="avatar">
						<a href="#" title="перейти к портфолио"></a>
						<img src="images/avatar3.png" alt="damboJunior avi"/>
					</div>
					<div class="messageText">
						<p class="date">20.06.11</p>
						<p>Ты самый яркий лучик света, Цветок ты райский краше нет, И я люблю тебя за это, Такой любимой больше нет!</p>
					</div>
				</li>
				<li>
					<div class="avatar">
						<a href="#" title="Перейти к портфолио"></a>
						<img src="images/avatar8.png" alt="AnnaSelesta avi" />
					</div>
					<div class="messageText">
						<p class="date">20.06.11</p>
						<p>Весь день тебе надоедаю, шлю смс-ки и звоню! Ну, как же ты не понимаешь, ведь я, Люблю тебя! Люблю!</p>
					</div>
				</li>
				<li>
					<div class="avatar">
						<a href="#" title="перейти к портфолио"></a>
						<img src="images/avatar3.png" alt="damboJunior avi"/>
					</div>
					<div class="messageText">
						<p class="date">19.06.11</p>
						<p>Шимпанзе спрашивает у мамы:<br/>
						- "Почему все говорят, что мы страшные"?<br/>
						- "Да ерунда все это, ты бы видел того, кто сейчас читает это сообщение."</p>
					</div>
				</li>
				<li>
					<div class="avatar">
						<a href="#" title="Перейти к портфолио"></a>
						<img src="images/avatar8.png" alt="AnnaSelesta avi" />
					</div>
					<div class="messageText">
						<p class="date">15.06.11</p>
						<p>в очень очень? :))))))</p>
						<p>ну давай... и смотри если рождение произойдет зимой... то к лету.. малыш уже будит такой клёвый и взросленький, что ему можно покупать прикольные шмотки летнии... чепчики, футболочки ...гулять на ручках.. а не тупо в коляске завернутый в тулупы :))))))) </p>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>
<div id="yui-main">
	<div class="yui-b">
		<h1><a href="">Контакты / Сообщения</a></h1>
		<p class="subtitle"> Ваши контакты </p>
		<div class="rnd">
			<div>
				<div>
					<div>
						<div align="right">
							<a href="/contacts/add">Создать группу</a>
						</div>
						<h1 class="market-title">Группы</h1>
						<div id="msearch">
							<div>
								<select name="group_id" onchange="document.location.href = '/contacts/index/?group_id=' + this.value">
									<?php foreach ($groups as $row): ?>
									<option value="<?=$row['id']?>"<?php if ($active['id'] == $row['id']): ?>selected="selected"<?php endif; ?>><?= $row['name']?> (<?= $row['count_contacts']?>)</option>
									<?php endforeach; ?>
								</select>
							</div>
							<?php if ($active['user_id'] != 0): ?>
							<a href="/contacts/edit/<?=$active['id']?>">Редактировать</a>
							| <a href="/contacts/del/<?=$active['id']?>">Удалить</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?= $contactlist; ?>
		<br/>
		<div class="rnd">
			<div>
				<div>
					<div>
						<div id="msearch">
							Переместить отмеченные в: 
							<div>
								<select name="group_id">
									<?php foreach ($groups as $row): ?>
									<option value="<?=$row['id']?>"><?= $row['name']?>(<?= $row['count_contacts']?>)</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div>
								<input type="submit" value="Переместить"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>