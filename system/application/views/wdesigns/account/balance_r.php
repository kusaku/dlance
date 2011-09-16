<div id="yui-main">
<div class="yui-b">


<h1><a href="/account/applications">Баланс</a></h1>
<p class="subtitle">Пополнение баланса.</p>




<div class="rnd">
 <div>
  <div>
   <div>
    <div id="msearch">
<form id="robokassa" name="payment" action="<?=$robokassaUrl?>" method="post" enctype="application/x-www-form-urlencoded" accept-charset="cp1251">
<input type="hidden" name="MrchLogin" value="<?=$rb_mrh_login?>">
<input type="hidden" name="OutSum" value="<?=$rb_payment_amount?>">
<input type="hidden" name="InvId" value="<?=$rb_payment_id?>">
<input type="hidden" name="Desc" value="<?=$rb_payment_desc?>">
<input type="hidden" name="Culture" value="ru">
<input type="hidden" name="SignatureValue" value="<?=$rb_sign?>">
<input value="Пополнить" type="submit">
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