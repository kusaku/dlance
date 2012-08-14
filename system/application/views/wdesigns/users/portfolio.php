<div class="yui-g">
  <ul class="usernav">
    <li><a href="/user/<?=$username?>">Информация</a></li>
    <li><a href="/users/designs/<?=$username?>">Дизайны</a></li>
    <li class="active"><a href="/users/portfolio/<?=$username?>">Портфолио</a></li>
    <li><a href="/users/services/<?=$username?>">Услуги</a></li>
    <li><a href="/users/reviews/<?=$username?>">Отзывы</a></li>
    <li><a href="/users/followers/<?=$username?>">Подписчики</a></li>
 </ul>
</div>

<div class="yui-g usertitle">
<h1><?=$surname?> <?=$name?> (<?=$username?>)</h1>

<? if( $this->username == $username ) :?>
<p><a href="/account/images_add/">Добавить работу</a></p>
<? endif; ?>
<p class="desc"><?=$short_descr?></p>
</div>


<div id="yui-main">
  <div id="usermain" class="yui-b">

<? if( !empty($portfolio) ): ?>
<?=show_highslide()?>





<? foreach($portfolio as $row): ?>
<div class="ptf-block">
<? if( $this->user_id == $row['user_id'] ): ?>
<span style="font-size:11px;">
<a href="/account/images_down/<?=$row['id']?>" title="Переместить вниз"><img src="/templates/wdesigns/css/img/down.gif" alt="Переместить вниз"></a>
| 
<a href="/account/images_up/<?=$row['id']?>" title="Переместить вниз"><img src="/templates/wdesigns/css/img/up.gif" alt="Переместить вверх"></a>
| 
<a href="/account/images_edit/<?=$row['id']?>">Редактировать</a> | <a href="/account/images_del/<?=$row['id']?>">Удалить</a>
</span>
<? endif; ?>

<div class="ptf-image brdrl">
<a href="<?=$row['full_image']?>" class="highslide " onclick="return hs.expand(this)">
<img src="<?=$row['small_image']?>" title="<?=$row['title']?>">
</a>
<div class="highslide-caption">
<?=$row['descr']?>
</div>

</div>
<div class="ptf-text"><?=$row['title']?></div>
</div>
<? endforeach; ?>
<? else: ?>
<p>Работы отсутствуют.</p>
<? endif; ?>

<br clear="all" /> 

   
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