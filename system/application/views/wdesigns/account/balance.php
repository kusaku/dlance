<div id="yui-main">
<div class="yui-b">


<h1><a href="/account/applications">������</a></h1>
<p class="subtitle">���������� �������.</p>




<div class="rnd">
<div>
<div>
<div>
<div id="msearch">
<form id="pay" name="pay" method="POST"
	action="https://merchant.webmoney.ru/lmi/payment.asp"><input
	type="hidden" name="LMI_PAYEE_PURSE" value="<?=$purse?>"> <input
	type="hidden" name="user_id" value="<?=$this->user_id?>"> �����:
<div><input name="LMI_PAYMENT_AMOUNT" type="text" maxlength="6"></div>
<div><input type="submit" value="���������"></div>
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