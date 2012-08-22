<script type="text/javascript">
function commission(amount)
{
	var amount = $('#amount').val(), commission = '';
	  
	/*Узнаём комиссию*/
	commission = amount / 100;

	commission = commission * <?=$commission?>;

	commission = commission.toFixed();/*Округление*/

	$('#commission').html(commission);

	/*Узнаём остаток для вывода*/
	amount = amount - commission;

	amount = amount.toFixed();/*Округление*/

	$('#result').html(amount);
}
</script>
<div id="yui-main">
<div class="yui-b">

<h1><a href="/account/withdraw">Вывод средств</a></h1>
<p class="subtitle">Заявки обрабатываются в течение двух суток.</p>
<?=validation_errors()?>
<div class="rnd">
 <div>
  <div>
   <div>
    <div id="msearch">
<form action="" method="post">
Номер кошелька:
<div>

<? if( !empty($purses) ): ?>

<select name="purse">
<? foreach($purses as $row): ?> 
<option value="<?=$row['purse']?>"<?=set_select('purse', ''.$row['purse'].''); ?>><?=$row['purse']?></option>
<? endforeach; ?>
</select>

<? else: ?>
Перед выводом необходимо <a href="/account/purses_add">указать</a> кошелек.
<? endif; ?>

</div>
<script type="text/javascript" src="/templates/js/commission.js"></script>
Сумма:
<div><input id="amount" name="amount" maxlength="6" type="text" onkeyup="commission()"  /></div>

<div>Вывод: <b id="result">0</b> рублей</div>

<div>Комиссия: <b id="commission">0</b> рублей</div>

<div><input value="Отправить" type="submit"></div>
</form>
     </div>
   </div>
  </div>
 </div>
</div>

<? if( !empty($data) ): ?>
<table class="portfolio">
<tr>
<th class="txtl" style="width: 100px;">Дата</th>
<th style="width: 100px;">Сумма</th>
<th style="width: 100px;">Кошелёк</th>
<th style="width: 60px;">Статус</th>
<th></th>
</tr>
<? foreach($data as $row): ?>
<tr>
<td class="title"><?=$row['date']?></td>
<td class="budget txtc"><strong><?=$row['amount']?></strong> рублей</td>
<td class="owner txtc"><?=$row['purse']?></td>
<td class="state txtc"><?=$row['status']?></td>
<td><span class="fr"><a href="/account/withdraw_del/<?=$row['id']?>">Отменить</a></span></td>
</tr>
<? endforeach; ?>
    </table>
<?=$page_links?>
<? endif; ?>

  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>