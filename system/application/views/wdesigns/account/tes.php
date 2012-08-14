<script type='text/javascript' src='/templates/js/thickbox/thickbox.js'></script>
<link rel="stylesheet" type="text/css" href="/templates/js/thickbox/thickbox.css" />

<script type="text/javascript">

$(document).ready(function(){
$('.thickbox').trigger('click');
});

</script>

<?=validation_errors()?>
<a href="#TB_inline?height=250&width=500&inlineId=modalWindow" class="thickbox" style="display:none"><strong>Оставить жалобу
</strong></a>
<div id="authform" class="yui-g">
<h1>Вход в систему</h1>
<form name="login" action="/login" method="post">
    <div class="rnd">
      <div>
        <div>
          <div>

            <ul>
              <li>
                <label for="rusername">Имя пользователя</label>
                <input type="text" class="text" name="username" value="<?=set_value('username')?>" size="16" maxlength="15" /></li>
              <li>
                <label for="ruserpassword">Пароль</label>
                <input type="password" class="password" name="password" size="16" maxlength="32" /></li>
              <li><input type="checkbox" class="authcheckbox" name="rcookiettl"  value="86400" /> Запомнить</li>

            </ul>
          </div>
        </div>
      </div>
    </div>
<input name="submit" type="submit" value="Вход">
 </form>
</div>

<div id="modalWindow" style="display: none;">
<div>

<div align="center" style="margin:10px;">Выбранные товары оплачены и высланы вам на электронный адрес, также купленные вами товары вы можете скачать в системе после входа в ваш аккаунт!</div>

Данные для входа в систему:<br /><br />

Логин: <?=$username?><br />
Пароль: <?=$password?>

</div>

</div>