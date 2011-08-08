<form id="robokassa" name="payment" action="<?=$robokassaUrl?>" method="post" enctype="application/x-www-form-urlencoded" accept-charset="cp1251">

<input type="hidden" name="ShpCart" value="<?=$cart?>">
<input type="hidden" name="ShpCode" value="<?=$code?>">

<input type="hidden" name="MrchLogin" value="<?=$rb_mrh_login?>">
<input type="hidden" name="OutSum" value="<?=$rb_payment_amount?>">
<input type="hidden" name="InvId" value="<?=$rb_payment_id?>">
<input type="hidden" name="Desc" value="<?=$rb_payment_desc?>">
<input type="hidden" name="Culture" value="ru">
<input type="hidden" name="SignatureValue" value="<?=$rb_sign?>">

<input value="Оплатить" id="r" type="submit">

</form>