<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div id="usercard" class="bd clearfix"><img src="images/user.gif" alt="<?=$type?>" class="grp-icon" />
<div class="clearfix"> <img src="<?=$userpic?>" alt="" class="avatar" />
<ul class="ucard">

<li class="age">
Возраст: <?=$dob?>
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
      <tr>
        <td colspan="2" class="noborder green"></td>
      </tr>
    </table>
    </div>
<div class="ft"></div>
</div>