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


<h1><a href="/account/transfer">������� �������</a></h1>
<p class="subtitle">������� ��������������� ������� �����
��������������.</p>




<?=validation_errors()?>
<form action="" method="post" />
<div class="rnd">
<div>
<div>
<div style="overflow: hidden;">
<table class="order-form">
	<tr>
		<td class="caption">��� �������:</td>
		<td><input type="radio" name="type" value="1" checked="checked" />
		������ ������&nbsp &nbsp <input type="radio" name="type" value="2" />
		� ����������</td>
	</tr>

	<tr class="event2" style="display: none;">
		<td class="caption">���� ���������:</td>
		<td><select name="time" class="text">
			<option value="1" <?=set_select('time', '1'); ?>>�������</option>
			<option value="2" <?=set_select('time', '2'); ?>>������</option>
			<option value="3" <?=set_select('time', '3'); ?>>3 ���</option>
			<option value="7" <?=set_select('time', '7'); ?>>������</option>
			<option value="30" <?=set_select('time', '30'); ?>>�����</option>
		</select></td>
	</tr>

	<tr>
		<td class="caption">����������:</td>
		<td><input type="text" name="recipient"
			value="<?=set_value('recipient')?>" size="15" maxlength="15" /></td>
	</tr>

	<tr>
		<td class="caption">�����:</td>
		<td><input type="text" name="amount" value="<?=set_value('amount')?>"
			size="6" maxlength="6" /> ������</td>
	</tr>

	<tr>
		<td class="caption">�����������:(�������� 1000 ��������):</td>
		<td class="frnt"><textarea name="text" rows="10" cols="49"><?=set_value('text')?></textarea></td>
	</tr>

</table>
</div>
</div>
</div>
</div>
<input type="submit" value="���������">
</form>


</div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>