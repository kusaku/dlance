<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$('form :radio[name=type]').click(function()
	{
		var value = $("input[type='radio']:checked").val();

		if( value == 2 )
		{
			$('.event2').css({display: ""});
		}
		else
		{
			$('.event2').css({display: "none"});
		}

	
	});
});
</script>
<div id="yui-main">
<div class="yui-b">


<h1><a href="/account/transfer">Перевод средств</a></h1>
<p class="subtitle">Перевод внутрисервисных средств между пользователями.</p>




<?=validation_errors()?>
<form action="" method="post" />
  <div class="rnd">
    <div>
      <div>
        <div style="overflow:hidden;">
<table class="order-form">
<tr>
<td class="caption">Тип платежа:</td>
<td>
<input type="radio" name="type" value="1" checked="checked" /> Прямой платеж&nbsp &nbsp
<input type="radio" name="type" value="2" /> С протекцией 
</td>
</tr>

            <tr class="event2" style="display: none;">
              <td class="caption">Срок протекции:</td>
              <td>
<select name="time" class="text">
<option value="1"<?=set_select('time', '1'); ?>>Сегодня</option>
<option value="2"<?=set_select('time', '2'); ?>>Завтра</option>
<option value="3"<?=set_select('time', '3'); ?>>3 дня</option>
<option value="7"<?=set_select('time', '7'); ?>>Неделя</option>
<option value="30"<?=set_select('time', '30'); ?>>Месяц</option>
</select>
              </td>
            </tr>
            
<tr>
<td class="caption">Получатель:</td>
<td><input type="text" name="recipient" value="<?=set_value('recipient')?>" size="15" maxlength="15" /></td>
</tr>

<tr>
<td class="caption">Сумма:</td>
<td><input type="text" name="amount" value="<?=set_value('amount')?>" size="6" maxlength="6" /> рублей</td>
</tr>

<tr>
<td class="caption">Комментарий:(максимум 1000 символов):</td>
<td class="frnt"><textarea name="text" rows="10" cols="49"><?=set_value('text')?></textarea></td>
</tr>

</table>
        </div>
      </div>
    </div>
  </div>
<input type="submit" value="Отправить">
</form>


  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>