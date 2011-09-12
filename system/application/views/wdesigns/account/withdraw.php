<script type="text/javascript">
function commission(amount)
{
	var amount = $('#amount').val(), commission = '';
	  
	/*����� ��������*/
	commission = amount / 100;

	commission = commission * <?=$commission?>;

	commission = commission.toFixed();/*����������*/

	$('#commission').html(commission);


	/*����� ������� ��� ������*/
	amount = amount - commission;

	amount = amount.toFixed();/*����������*/

	$('#result').html(amount);
}
</script>
<div id="yui-main">
<div class="yui-b">

<h1><a href="/account/withdraw">����� �������</a></h1>
<p class="subtitle">������ �������������� � ������� ���� �����.</p>
<?=validation_errors()?>
<div class="rnd">
<div>
<div>
<div>
<div id="msearch">
<form action="" method="post">����� ��������:
<div><? if( !empty($purses) ): ?> <select name="purse">
<? foreach($purses as $row): ?>
	<option value="<?=$row['purse']?>"
	<?=set_select('purse', ''.$row['purse'].''); ?>><?=$row['purse']?></option>
	<? endforeach; ?>
</select> <? else: ?> ����� ������� ���������� <a
	href="/account/purses_add">�������</a> �������. <? endif; ?></div>
<script type="text/javascript" src="/templates/js/commission.js"></script>
�����:
<div><input id="amount" name="amount" maxlength="6" type="text"
	onkeyup="commission()" /></div>

<div>�����: <b id="result">0</b> ������</div>

<div>��������: <b id="commission">0</b> ������</div>

<div><input value="���������" type="submit"></div>
</form>
</div>
</div>
</div>
</div>
</div>



	<? if( !empty($data) ): ?>
<table class="portfolio">
	<tr>
		<th class="txtl" style="width: 100px;">����</th>
		<th style="width: 100px;">�����</th>
		<th style="width: 100px;">������</th>
		<th style="width: 60px;">������</th>
		<th></th>
	</tr>
	<? foreach($data as $row): ?>
	<tr>
		<td class="title"><?=$row['date']?></td>
		<td class="budget txtc"><strong><?=$row['amount']?></strong> ������</td>
		<td class="owner txtc"><?=$row['purse']?></td>
		<td class="state txtc"><?=$row['status']?></td>
		<td><span class="fr"><a href="/account/withdraw_del/<?=$row['id']?>">��������</a></span></td>
	</tr>
	<? endforeach; ?>
</table>
<?=$page_links?> <? endif; ?></div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>