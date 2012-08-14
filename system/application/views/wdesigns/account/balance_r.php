<script type="text/javascript">
	$(document).ready(function(){
		$('input[name=payment_type]').change(function(){
			type = $(this).val();
			if(type == "qiwi")
				$('#phone_block').css('display','block');
			else
				$('#phone_block').css('display','none');
		});
	});
</script>

<div id="yui-main">
<div class="yui-b">


<h1><a href="/account/applications">Баланс</a></h1>
<p class="subtitle">Пополнение баланса.</p>

<h2>Выберите способ оплаты</h2>
<form action="">
	<div>
		<input type="radio" name="payment_type" id="payment_type_robox" value="robox" checked />&nbsp;<label for="payment_type_robox">РобоКасса</label>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="payment_type" id="payment_type_qiwi" value="qiwi" />&nbsp;<label for="payment_type_qiwi">Qiwi-кошелек</label>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="payment_type" id="payment_type_wm" value="wm" />&nbsp;<label for="payment_type_wm">WebMoney</label>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="payment_type" id="payment_type_yad" value="yad" />&nbsp;<label for="payment_type_yad">Яндекс.Деньги</label>
	</div>
	<div><label for="payment_sum">Сумма пополения</label>&nbsp;<input type="text" name="payment_sum" id="payment_sum" /> р.</div>
	<div id="phone_block" style="display:none;"><label for="payment_phone">Номер телефона</label>&nbsp;<input type="text" name="payment_phone" id="payment_phone" /></div>
</form>



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