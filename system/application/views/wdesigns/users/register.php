<?=validation_errors()?>
<?=show_validation()?>
<script type="text/javascript" language="javascript">
$(document).ready(
  function()
  {
	$('#country_id').val(<?=$this->input->post('country_id')?>).change();
	$('#city_id').val(<?=$this->input->post('city_id')?>).change();
  }
);
</script>
<div id="authform" class="yui-g">
<form action="" method="post">
<div>
<div>
<div>
<h3>������� ������</h3>
<ul class="clearfix">
	<li class="line"><label for="username">��� ������������ *</label> <input
		type="text"
		class="validate[required,custom[username],length[3,15]] text-input"
		name="username" value="<?=set_value('username')?>" size="24"
		maxlength="15" /></li>
	<li class="hint">�� A-z � ���� 0-9.<br>
	������������ ���������� �������� 15.<br>
	����������� ���������� �������� 3.<br>
	</li>
	<li class="line"><label for="email">��� email: *</label> <input
		type="text" class="validate[required,custom[email]] text-input"
		name="email" value="<?=set_value('email')?>" size="24" maxlength="48" /></li>
	<li class="hint">������ ���� �� ����� ������ � ���� ����������.</li>
	<li class="line psswrd"><label for="password1">������ *</label> <input
		type="password" class="validate[required,length[6,24]] text-input"
		name="password1" id="password1" size="24" maxlength="24" /></li>
	<li class="line psswrd"><label for="password2">������ ������ *</label>
	<input type="password"
		class="validate[required,confirm[password1]] text-input"
		name="password2" size="24" maxlength="24" /></li>
	<li class="hint" style="clear: left;">����������� ���������� ��������
	6. ������������ ���������� �������� 24.</li>
</ul>
</div>
</div>
</div>

<div>
<div>
<div>
<h3>������������ ������</h3>
<ul class="clearfix">
	<li class="hint">����������� �� ����� �������� � �������. ����������
	��������� ������ ����������� ����������.</li>
	<li class="line fullname"><label for="surname">������� *</label> <input
		type="text"
		class="validate[required,custom[onlyLetter],length[1,24]] text-input"
		name="surname" value="<?=set_value('surname')?>" size="24"
		maxlength="24" /></li>
	<li class="line fullname"><label for="name">��� *</label> <input
		type="text"
		class="validate[required,custom[onlyLetter],length[1,24]] text-input"
		name="name" value="<?=set_value('name')?>" size="24" maxlength="24" /></li>
	<li class="hint" style="clear: left;">������ ��� �� ������� �����.</li>
	<li class="clear"></li>
	<li class="line sex"><label for="name">��� *</label> <label> <input
		type="radio" name="sex" value="1" checked="checked"
		<?=set_checkbox('sex', '1'); ?> /> �������</label> <label> <input
		type="radio" name="sex" value="2" <?=set_checkbox('sex', '2'); ?> />
	�������</label></li>
	<li class="clear"></li>

	<script type="text/javascript" src="/templates/js/location.min.js"></script>
	<script type="text/javascript" src="/templates/js/location_data.js"></script>
	<li class="line fullname"><label for="surname">������ *</label> <select
		id="country_id" name="country_id" class="text"
		OnChange="list_cities(this.value)">
		<option value=""></option>
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
	</select></li>
	<li class="line fullname"><label for="surname">����� *</label> <select
		id="city_id" name="city_id" class="text" disabled>
		<option value=""></option>
	</select></li>

	<li class="clear"></li>

	<li class="line"><label for="surname">���� �������� *</label> <select
		name="dob_day">
		<option value="">---</option>
		<option value="1" <?=set_select('dob_day', '1')?>>1</option>
		<option value="2" <?=set_select('dob_day', '2')?>>2</option>
		<option value="3" <?=set_select('dob_day', '3')?>>3</option>

		<option value="4" <?=set_select('dob_day', '4')?>>4</option>
		<option value="5" <?=set_select('dob_day', '5')?>>5</option>

		<option value="6" <?=set_select('dob_day', '6')?>>6</option>
		<option value="7" <?=set_select('dob_day', '7')?>>7</option>
		<option value="8" <?=set_select('dob_day', '8')?>>8</option>
		<option value="9" <?=set_select('dob_day', '9')?>>9</option>
		<option value="10" <?=set_select('dob_day', '10')?>>10</option>
		<option value="11" <?=set_select('dob_day', '11')?>>11</option>
		<option value="12" <?=set_select('dob_day', '12')?>>12</option>

		<option value="13" <?=set_select('dob_day', '13')?>>13</option>

		<option value="14" <?=set_select('dob_day', '14')?>>14</option>
		<option value="15" <?=set_select('dob_day', '15')?>>15</option>
		<option value="16" <?=set_select('dob_day', '16')?>>16</option>
		<option value="17" <?=set_select('dob_day', '17')?>>17</option>
		<option value="18" <?=set_select('dob_day', '18')?>>18</option>
		<option value="19" <?=set_select('dob_day', '19')?>>19</option>
		<option value="20" <?=set_select('dob_day', '20')?>>20</option>
		<option value="21" <?=set_select('dob_day', '21')?>>21</option>

		<option value="22" <?=set_select('dob_day', '22')?>>22</option>
		<option value="23" <?=set_select('dob_day', '23')?>>23</option>
		<option value="24" <?=set_select('dob_day', '24')?>>24</option>
		<option value="25" <?=set_select('dob_day', '25')?>>25</option>
		<option value="26" <?=set_select('dob_day', '26')?>>26</option>
		<option value="27" <?=set_select('dob_day', '27')?>>27</option>
		<option value="28" <?=set_select('dob_day', '28')?>>28</option>
		<option value="29" <?=set_select('dob_day', '29')?>>29</option>
		<option value="30" <?=set_select('dob_day', '30')?>>30</option>

		<option value="31" <?=set_select('dob_day', '31')?>>31</option>
	</select> <select name="dob_month">
		<option value="">---</option>
		<option value="1" <?=set_select('dob_month', '1')?>>������</option>
		<option value="2" <?=set_select('dob_month', '2')?>>�������</option>
		<option value="3" <?=set_select('dob_month', '3')?>>����</option>
		<option value="4" <?=set_select('dob_month', '4')?>>������</option>
		<option value="5" <?=set_select('dob_month', '5')?>>���</option>

		<option value="6" <?=set_select('dob_month', '6')?>>����</option>
		<option value="7" <?=set_select('dob_month', '7')?>>����</option>
		<option value="8" <?=set_select('dob_month', '8')?>>������</option>
		<option value="9" <?=set_select('dob_month', '9')?>>��������</option>
		<option value="10" <?=set_select('dob_month', '10')?>>�������</option>
		<option value="11" <?=set_select('dob_month', '11')?>>������</option>
		<option value="12" <?=set_select('dob_month', '12')?>>�������</option>
	</select> <select name="dob_year">
		<option value="">---</option>
		<option value="1994" <?=set_select('dob_year', '1994')?>>1994</option>
		<option value="1993" <?=set_select('dob_year', '1993')?>>1993</option>
		<option value="1992" <?=set_select('dob_year', '1992')?>>1992</option>
		<option value="1991" <?=set_select('dob_year', '1991')?>>1991</option>
		<option value="1990" <?=set_select('dob_year', '1990')?>>1990</option>
		<option value="1989" <?=set_select('dob_year', '1989')?>>1989</option>
		<option value="1988" <?=set_select('dob_year', '1988')?>>1988</option>

		<option value="1987" <?=set_select('dob_year', '1987')?>>1987</option>
		<option value="1986" <?=set_select('dob_year', '1986')?>>1986</option>
		<option value="1985" <?=set_select('dob_year', '1985')?>>1985</option>
		<option value="1984" <?=set_select('dob_year', '1984')?>>1984</option>
		<option value="1983" <?=set_select('dob_year', '1983')?>>1983</option>
		<option value="1982" <?=set_select('dob_year', '1982')?>>1982</option>
		<option value="1981" <?=set_select('dob_year', '1981')?>>1981</option>
		<option value="1980" <?=set_select('dob_year', '1980')?>>1980</option>

		<option value="1979" <?=set_select('dob_year', '1979')?>>1979</option>

		<option value="1978" <?=set_select('dob_year', '1978')?>>1978</option>
		<option value="1977" <?=set_select('dob_year', '1977')?>>1977</option>
		<option value="1976" <?=set_select('dob_year', '1976')?>>1976</option>
		<option value="1975" <?=set_select('dob_year', '1975')?>>1975</option>
		<option value="1974" <?=set_select('dob_year', '1974')?>>1974</option>
		<option value="1973" <?=set_select('dob_year', '1973')?>>1973</option>
		<option value="1972" <?=set_select('dob_year', '1972')?>>1972</option>

		<option value="1971" <?=set_select('dob_year', '1971')?>>1971</option>
		<option value="1970" <?=set_select('dob_year', '1970')?>>1970</option>

		<option value="1969" <?=set_select('dob_year', '1969')?>>1969</option>
		<option value="1968" <?=set_select('dob_year', '1968')?>>1968</option>
		<option value="1967" <?=set_select('dob_year', '1967')?>>1967</option>
		<option value="1966" <?=set_select('dob_year', '1966')?>>1966</option>
		<option value="1965" <?=set_select('dob_year', '1965')?>>1965</option>
		<option value="1964" <?=set_select('dob_year', '1964')?>>1964</option>

		<option value="1963" <?=set_select('dob_year', '1963')?>>1963</option>
		<option value="1962" <?=set_select('dob_year', '1962')?>>1962</option>
		<option value="1961" <?=set_select('dob_year', '1961')?>>1961</option>

		<option value="1960" <?=set_select('dob_year', '1960')?>>1960</option>
		<option value="1959" <?=set_select('dob_year', '1959')?>>1959</option>
		<option value="1958" <?=set_select('dob_year', '1958')?>>1958</option>
		<option value="1957" <?=set_select('dob_year', '1957')?>>1957</option>
		<option value="1956" <?=set_select('dob_year', '1956')?>>1956</option>

		<option value="1955" <?=set_select('dob_year', '1955')?>>1955</option>
		<option value="1954" <?=set_select('dob_year', '1954')?>>1954</option>
		<option value="1953" <?=set_select('dob_year', '1953')?>>1953</option>
		<option value="1952" <?=set_select('dob_year', '1952')?>>1952</option>

		<option value="1951" <?=set_select('dob_year', '1951')?>>1951</option>
		<option value="1950" <?=set_select('dob_year', '1950')?>>1950</option>
	</select></li>
	<li class="clear"></li>
</ul>
</div>
</div>
</div>
<div>
<div>
<div>
<h3>�������������</h3>
<ul class="clearfix">
	<li class="line"><label for="ruserlastname">������� ��� *</label>
	<div class="answer"><?=$imgcode?></div>
	<input class="validate[required]" name="code" type="text" size="10"
		maxlength="10" /></li>
	<li class="hint">����������, ������� ��������� �������.</li>
	<li class="line"><input type="checkbox"
		class="validate[required] checkbox" name="agree" /> �������� ������� <a
		href="/pages/agreement.html" target="_blank">�����������������
	����������</a></li>
</ul>
</div>
</div>
</div>
<input type="submit" value="�����������"></form>
</div>
