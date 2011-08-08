<div class="yui-g">
  <ul class="usernav">
    <li><a href="/user/<?=$username?>">Информация</a></li>
    <li class="active"><a href="/users/designs/<?=$username?>">Дизайны</a></li>
    <li><a href="/users/portfolio/<?=$username?>">Портфолио</a></li>
    <li><a href="/users/services/<?=$username?>">Услуги</a></li>
    <li><a href="/users/reviews/<?=$username?>">Отзывы</a></li>
    <li><a href="/users/followers/<?=$username?>">Подписчики</a></li>
 </ul>
</div>

<div class="yui-g usertitle">
<h1><?=$surname?> <?=$name?> (<?=$username?>)</h1>

<? if( $this->username != $username ) :?>
<p><a href="/account/subscribe/<?=$id?>">Подписаться на работы</a></p>
<? endif; ?>
<p class="desc"><?=$short_descr?></p>
</div>


<div id="yui-main">
<div id="usermain" class="yui-b">

<? if( !empty($data) ): ?>
<?=show_highslide()?>
<table class="listorder">
<tr>
<td class="topline lft txtl">Заголовок</td>
<td class="topline rht" style="width:70px;">Статус</td>
</tr>
<? foreach($data as $row): ?>
<tr>
<td class="ordertitle"><a href="/designs/<?=$row['id']?>.html"><?=$row['title']?></a><br>

<a href="<?=$row['full_image']?>" class="highslide" onclick="return hs.expand(this)">
<img src="<?=$row['small_image']?>" />
</a>

<div class="inf"><?=$row['section']?> / <?=$row['category']?> | <?=$row['date']?></div>
</td>
<td class="budget"><?=$row['status']?></td>
</tr>
<? endforeach; ?>
    </table>
<?=$page_links?>
<? else: ?>
<p>Дизайны отсутствуют.</p>
<? endif; ?>



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