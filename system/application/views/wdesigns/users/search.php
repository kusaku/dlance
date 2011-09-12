<div id="yui-main">
<div class="yui-b clearfix">
<h1>����� ����������</h1>

<div class="rnd">
<div>
<div>
<div>
<div id="msearch">
<form action="/users/search/" method="get">�������� �����:
<div><input name="keywords" type="text" size="100" maxlength="75"
	value="<?=$input['keywords']?>"></div>

�������:
<div><input name="age_start" type="text" size="1" maxlength="2"
	value="<?=$input['age_start']?>"> �� <input name="age_end" type="text"
	size="1" maxlength="2" value="<?=$input['age_end']?>"></div>

���������:
<div><select name="category">
	<option value="">�� �����</option>
	<? foreach($categories as $row): ?>

	<? if( $row['parent_id'] == 0): ?>
	<optgroup label="<?=$row['name']?>">
	<? endif; ?>

	<? foreach($categories as $row2): ?>
	<? if( $row['id'] == $row2['parent_id'] ): ?>
		<option value="<?=$row2['id']?>"
		<? if( $input['category'] == $row2['id']): ?>
			selected="selected<? endif; ?>"><?=$row2['name']?></option>
			<? endif; ?>
			<? endforeach; ?>
			<? endforeach; ?>

</select></div>

<script type="text/javascript" src="/templates/js/location.min.js"></script>
<script type="text/javascript" src="/templates/js/location_data.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(
  function()
  {
	$('#country_id').val(<?=$input['country_id']?>).change();
	$('#city_id').val(<?=$input['city_id']?>).change();
  }
);
</script> ������:
<div><select id="country_id" name="country_id" class="text"
	OnChange="list_cities(this.value)">
	<option value="">�� �����</option>
	<option value="2">������</option>

	<option value="1">�������</option>
	<option value="0" disabled>--------------------------------------------------</option>
	<option value="42">���������</option>
	<option value="3">�������</option>
	<option value="43">�����������</option>
	<option value="4">�������</option>
	<option value="5">�������</option>
	<option value="75">���������</option>
	<option value="44">�������</option>

	<option value="6">��������</option>
	<option value="7">�������</option>
	<option value="8">��������</option>
	<option value="96">��������</option>
	<option value="9">��������������</option>
	<option value="10">�������</option>
	<option value="72">�������</option>
	<option value="11">��������</option>
	<option value="12">������</option>

	<option value="45">������</option>
	<option value="13">�����</option>
	<option value="70">��������</option>
	<option value="100">������������� ����������</option>
	<option value="46">������</option>
	<option value="47">�������</option>
	<option value="83">�����</option>
	<option value="94">���������</option>
	<option value="91">����</option>

	<option value="14">��������</option>
	<option value="15">��������</option>
	<option value="16">�������</option>
	<option value="17">������</option>
	<option value="93">�����</option>
	<option value="18">���������</option>
	<option value="48">������</option>
	<option value="49">����</option>
	<option value="50">����������</option>

	<option value="58">�����</option>
	<option value="59">�����</option>
	<option value="19">������</option>
	<option value="20">�����</option>
	<option value="21">�����������</option>
	<option value="22">����������</option>
	<option value="23">���������</option>
	<option value="24">������</option>
	<option value="57">�������</option>

	<option value="25">�������</option>
	<option value="73">��������</option>
	<option value="95">�����</option>
	<option value="26">����������</option>
	<option value="63">����� ��������</option>
	<option value="27">��������</option>
	<option value="89">���</option>
	<option value="28">������</option>
	<option value="29">����������</option>

	<option value="30">�������</option>
	<option value="97">���������� ������</option>
	<option value="51">������</option>
	<option value="90">��������</option>
	<option value="99">�����</option>
	<option value="31">��������</option>
	<option value="32">��������</option>
	<option value="41">���</option>
	<option value="52">�����������</option>

	<option value="98">�������</option>
	<option value="71">�������</option>
	<option value="53">������������</option>
	<option value="33">������</option>
	<option value="54">����������</option>
	<option value="34">���������</option>
	<option value="35">�������</option>
	<option value="36">��������</option>
	<option value="92">����������</option>

	<option value="37">�����</option>
	<option value="38">���������</option>
	<option value="39">������</option>
	<option value="40">�������</option>
	<option value="55">������</option>
</select></div>
�����:
<div><select id="city_id" name="city_id" class="text" disabled>
	<option value="">��� ������</option>
</select></div>

���� �� ��� ������:
<div><input name="price_1_start" type="text" size="2" maxlength="6"
	value="<?=$input['price_1_start']?>"> �� <input name="price_1_end"
	type="text" size="2" maxlength="6" value="<?=$input['price_1_end']?>">
USD</div>

���� �� ����� ������
<div><input name="price_2_start" type="text" size="2" maxlength="6"
	value="<?=$input['price_2_start']?>"> �� <input name="price_2_end"
	type="text" size="2" maxlength="6" value="<?=$input['price_2_end']?>">
USD</div>

����������� �� ��������:
<div><input name="result" type="text" size="1" maxlength="2"
	value="<?=$input['result']?>"></div>
<div><input type="submit" value="�����"></div>
</form>
</div>
</div>
</div>
</div>
</div>

			<? if( !empty($data) ): $n = 0; ?>
<table class="contractors">
	<tr>
		<td class="topline lft txtl" style="width: 15px;">�</td>
		<td class="topline title">������������</td>
		<td class="topline rht" style="width: 50px;"><? if( $input['order_field'] == 'rating' and  $input['order_type'] == 'desc' ): ?>
		<a
			href="/users/search/?order_field=rating&order_type=asc<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">�������</a>
			<? else: ?> <a
			href="/users/search/?order_field=rating<? if( !empty($url) ): ?>&<?=$url?><? endif;?>">�������</a>
			<? endif; ?></td>
		<td class="topline rht">�����</td>
	</tr>
	<? foreach($data as $row => $value): ?>
	<tr>
		<td class="num"><?=$row+1?></td>
		<td class="text"><img src="<?=$value['userpic']?>" alt=""
			class="avatar" />
		<ul class="ucard">
			<li class="utitle"><a class="black"
				href="/user/<?=$value['username']?>"><?=$value['surname']?> <?=$value['name']?>
			(<?=$value['username']?>)</a></li>
			<li class="exp-pm"><a class="blue"
				href="/contacts/send/<?=$value['username']?>">������ ���������</a></li>
			<li>��������� �����: <?=$value['last_login']?></li>
			<li>���� �����������: <?=$value['created']?></li>
			<li>������: <?=$value['tariff']?></li>
		</ul>
		</td>
		<td class="rating"><?=$value['rating']?></td>
		<td class="rating"><strong><?=$value['tariffname']?></strong></td>
	</tr>
	<? endforeach; ?>
	</tr>
</table>
	<?=$page_links?> <? else: ?> ������������� �� ������� <? endif; ?></div>
</div>

<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div class="bd clearfix">

<ul class="marketnav">
	<h3><a href="/users/search/">��� ���������</a></h3>
	<?
	if( !empty($category) )
	{
		$active = $category;

		foreach($categories as $row):

		if( $active == $row['id'] ):
		if( $row['parent_id'] != 0 )://���� � �������� ��������� ������� ������, ����������� ������
		$active = $row['parent_id'];
		endif;
		endif;

		endforeach;
	}
	?>

	<? foreach($categories as $row): ?>

	<? if( $row['parent_id'] == 0 ) :?>
	<li
		class="lvl-1 <? if( !empty($active) and $row['id'] == $active ): ?>active<? endif ?>"><a
		href="/users/search/?category=<?=$row['id']?>"><?=$row['name']?></a></li>
		<? endif; ?>

		<? if( !empty($active) and $active == $row['id'] ):?>

		<? foreach($categories as $row2): ?>
		<? if( $row['id'] == $row2['parent_id'] ): ?>
	<li class="lvl-2"><a href="/users/search/?category=<?=$row2['id']?>"><?=$row2['name']?></a>
	(<?=$row2['number']?>)</li>
	<? endif; ?>
	<? endforeach; ?>
	<? endif; ?>

	<? endforeach; ?>
</ul>

</div>
<div class="ft"></div>
</div>
