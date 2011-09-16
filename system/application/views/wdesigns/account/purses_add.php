<div id="yui-main">
<div class="yui-b">

<h1><a href="/account/purses_add">Добавить кошелек</a></h1>
<p class="subtitle">Добавление кошелька, используется для подачи заявок на вывод средств.</p>

<?=validation_errors()?>

<div class="rnd">
 <div>
  <div>
   <div>
    <div id="msearch">
<form action="" method="post" /> 
Номер кошелька:
<div><input name="purse" type="text" maxlength="13">&nbsp &nbsp Пример: R123456789012</div>
<div><input type="submit" value="Добавить"></div>
</form>
     </div>
   </div>
  </div>
 </div>
</div>

  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>