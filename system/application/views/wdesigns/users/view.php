<div class="yui-g">
  <ul class="usernav">
    <li class="active"><a href="/user/<?=$username?>">Информация</a></li>
    <li><a href="/users/designs/<?=$username?>">Дизайны</a></li>
    <li><a href="/users/portfolio/<?=$username?>">Портфолио</a></li>
    <li><a href="/users/services/<?=$username?>">Услуги</a></li>
    <li><a href="/users/reviews/<?=$username?>">Отзывы</a></li>
    <li><a href="/users/followers/<?=$username?>">Подписчики</a></li>
 </ul>
</div>

<div class="yui-g usertitle">
<h1><?=$surname?> <?=$name?> (<?=$username?>)</h1>

<? if( $this->username == $username ) :?>
<p><a href="/account/profile">Редактировать</a></p>
<? endif; ?>

<p class="desc"><?=nl2br($short_descr)?></p>
</div>


<div id="yui-main">
<div id="usermain" class="yui-b">
<p class="infotitle">Контакты</p>

<? if( $logged_in ): ?>
<ul class="info">
<li>E-mail: Скрытый</li>
<? if( !empty($icq) ):?><li>ICQ: <?=$icq?></li><? endif; ?>
<? if( !empty($skype) ):?><li>Skype: <?=$skype?></li><? endif; ?>
<? if( !empty($telephone) ):?><li>Телефон: <?=$telephone?></li><? endif; ?>
</ul>
<? else: ?>
Вам необходимо залогиниться или зарегистрироваться для просмотра контактных данных
<? endif; ?>

<p class="infotitle">Информация</p>
<p class="userdesc"><?=nl2br($full_descr)?></p>



<p class="infotitle">Дополнительные данные</p>
<p class="userdesc">

<ul class="info">
<? if( !empty($profile['price_1']) ):?><li>Цена за час работы: <strong><?=$profile['price_1']?> USD</strong></li><? endif; ?>
<? if( !empty($profile['price_2']) ):?><li>Цена за месяц работы: <strong><?=$profile['price_2']?> USD</strong></li><? endif; ?>
</ul>

</p>

</div>
</div>


<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div id="usercard" class="bd clearfix"><img src="images/user.gif" class="grp-icon" />
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