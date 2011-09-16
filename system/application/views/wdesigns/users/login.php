<?=validation_errors()?>
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
