<div id="yui-main">
<div class="yui-b">
<div class="infoblock">

<h1>Загрузка файла</h1>
<p>
Загрузка была успешно создана<br />
Файл будет доступен в течении 1 часа, с Вашего Ip адреса.
</p>

<form action="/account/download/<?=$code?>" method="post">
<input type="submit" value="Скачать">
</form>

  </div>
  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>