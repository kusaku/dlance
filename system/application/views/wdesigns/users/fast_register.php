<form method="POST" action="#" id="register">
<script src="/templates/js/register.js" type="text/javascript"></script>
<div style="text-align:center ">
<table border="0" cellpadding="3" cellspacing="3" style="margin:0 auto;" >
  <tr>
    <td><label>Логин</label>
      :</td>
    <td><input name="username" type="text" size="20" id="username" /><span class="error"><span id="username_err"></span></span></td>
  </tr>
  <tr>
    <td><label>Ваш email</label>

      :</td>
    <td><input name="email" type="text" size="20" id="email" /><span class="error"><span id="email_err"></span></span></td>
  </tr>
  <tr align="right">
    <td colspan="2"><input type="button" id="sendbtn" value="Отправить" onclick="send()" />&nbsp;<input type="submit" id="Login" value="Отмена" onclick="tb_remove()"></td>
    </tr>
</table>

</div>
</form>