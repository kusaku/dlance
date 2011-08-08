<div class="yui-g">
  <ul class="usernav">
    <li><a href="/user/<?=$username?>">Информация</a></li>
    <li><a href="/users/designs/<?=$username?>">Дизайны</a></li>
    <li><a href="/users/portfolio/<?=$username?>">Портфолио</a></li>
    <li><a href="/users/services/<?=$username?>">Услуги</a></li>
    <li class="active"><a href="/users/reviews/<?=$username?>">Отзывы</a></li>
    <li><a href="/users/followers/<?=$username?>">Подписчики</a></li>
 </ul>
</div>

<div class="yui-g usertitle">
<h1><?=$surname?> <?=$name?> (<?=$username?>)</h1>

<? if( $this->username != $username ) :?>
<p><a href="/users/reviews_add/<?=$username?>">Добавить отзыв</a></p>
<? endif; ?>
<p class="desc"><?=$short_descr?></p>
</div>


<div id="yui-main">
<div id="usermain" class="yui-b">

<? if( !empty($reviews) ): ?>
<div id="reviews" class="clearfix">
<table class="reviews">
<tr>
<th class="txtl">Пользователь / Рейтинг</th>
<th style="width:70px;">Оценка</th>
</tr>

<? foreach($reviews as $row): ?>
<tr>
<td class="review-card"> <img src="<?=$row['userpic']?>" alt="" class="avatar" />
<ul class="rcard">
<li class="black">
<a href="/user/<?=$row['username']?>"><?=$row['surname']?> <?=$row['name']?> (<?=$row['username']?>)</a>
</li>
<li>Дата регистрации: <?=$row['created']?></li>
<li>Последний визит: <?=$row['last_login']?></li>
<li><a href="/contacts/send/<?=$row['username']?>">Личное сообщение</a></li>
</ul>
<? if( $this->team == 2 ) :?>
<a href="/users/reviews_edit/<?=$row['id']?>">Редактировать</a> |
<a href="/users/reviews_del/<?=$row['id']?>">Удалить</a>
<? endif; ?>
</td>
<td class="txtc review-mark"><?=$row['rating']?></td>
</tr>


    <tr>
      <td colspan="3" class="review-target">

	<? if( $row['rating'] == 1 ): ?>
		<img class="revtype" src="/templates/wdesigns/css/img/rev1.png">
	<? else: ?>
		<img class="revtype" src="/templates/wdesigns/css/img/rev0.png">
	<? endif; ?>



       </td>
    </tr>



<tr>
<td colspan="3" class="review-text">
<p><?=nl2br($row['text'])?></p>

<span class="review-date">Размещено: <?=$row['date']?></span>
<? if( !empty($row['moder_date']) ): ?>
<br />
<span class="review-date">Модерация: <a href="/user/<?=$row['moder_user_id']?>"><?=$row['moder_user_id']?></a>: <?=$row['moder_date']?></span>
<? endif; ?>
</td>
</tr>
<? endforeach; ?>
<tr>
<td colspan="3" class="sep txtr">&nbsp;</td>
</tr>
</table>
</div>
<?=$page_links?>
<? else: ?>
<p>Отзывы отсутствуют.</p>
<? endif; ?>



</div>
</div>




<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div id="usercard" class="bd clearfix">
<div class="clearfix"> <img src="<?=$userpic?>" alt="" class="avatar" />
<ul class="ucard">

<li class="age">
Возраст: <?=$age?>
</li>

<li>
Пол: <?=$sex?>
</li>

</ul>
</div>
<div class="sendpm"><a href="/contacts/send/<?=$username?>">Личное сообщение</a></div>

    <table class="userstats">
      <tr>
        <td>Дата регистрации:</td>
        <td><?=$created?></td>
      </tr>
      <tr>
        <td>Последний визит:</td>
        <td><?=$last_login?></td>
      </tr>
     <tr>


<? if( $positive or $negative ): ?>
      <tr>
        <td>Отзывы:</td>
        <td>
<a class="rev-positive" href="/users/reviews/<?=$username?>/?type=positive"><?=$positive?></a>
<? if( $negative ): ?>| <a class="rev-negative" href="/users/reviews/<?=$username?>/?type=negative"><?=$negative?></a><? endif; ?>
        </td>
      </tr>
<? endif; ?>



      <tr>
        <td>Просмотров:</td>
        <td><?=$views?></td>
      </tr>
      <tr>
      <tr>
        <td>Местоположение:</td>
        <td><?=$country_id?> / <?=$city_id?></td>
      </tr>
      <tr>
        <td colspan="2" class="noborder green">
        </td>
     </tr>
    </table>

<? if( !empty($website) ):?><b><noindex><a href="<?=$website?>" target="_blank" rel="nofollow"><?=$website?></a></noindex></b><? endif; ?>

    </div>
<div class="ft"></div>
</div>