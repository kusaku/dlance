<div id="yui-main">
<div class="yui-b">

<h1><a href="/account/profile">�������</a></h1>

<p class="subtitle">���� ������� ������</p>

<?=validation_errors()?>
<?=show_validation()?>
<script type="text/javascript" language="javascript">
$(document).ready(
  function()
  {
	$('#country_id').val(<?=$country_id?>).change();
	$('#city_id').val(<?=$city_id?>).change();
  }
);
</script>
<form action="" method="post" />
<div class="ttl">
<div class="ttr"></div>
</div>
<div class="bbd">
<p class="subtitle"><b>������������ ������</b></p>
<table class="profile">
<tr>
<td class="caption">��� ������������:</td>
<td><?=$username?></td>
</tr>

<tr>
<td class="caption">���������������:</td>
<td><?=$created?></td>
</tr>

<tr>
<td class="caption">�������:</td>
<td><input type="text" class="validate[required,custom[onlyLetter],length[1,24]] text-input" name="surname" value="<?=$surname?>" size="56" maxlength="24" /></td>
</tr>

<tr>
<td class="caption">���:</td>
<td><input type="text" class="validate[required,custom[onlyLetter],length[1,24]] text-input" name="name" value="<?=$name?>" size="56" maxlength="24" /></td>
</tr>
<tr>

<tr>
<td class="caption">���� ��������:</td>
<td>
<select name="dob_day">
<option value="">---</option>
<option value="1"<? if( $day == 1 ): ?> selected="selected"<? endif; ?>>1</option>
<option value="2"<? if( $day == 2 ): ?> selected="selected"<? endif; ?>>2</option>
<option value="3"<? if( $day == 3 ): ?> selected="selected"<? endif; ?>>3</option>

<option value="4"<? if( $day == 4 ): ?> selected="selected"<? endif; ?>>4</option>
<option value="5"<? if( $day == 5 ): ?> selected="selected"<? endif; ?>>5</option>

<option value="6"<? if( $day == 6 ): ?> selected="selected"<? endif; ?>>6</option>
<option value="7"<? if( $day == 7 ): ?> selected="selected"<? endif; ?>>7</option>
<option value="8"<? if( $day == 8 ): ?> selected="selected"<? endif; ?>>8</option>
<option value="9"<? if( $day == 9 ): ?> selected="selected"<? endif; ?>>9</option>
<option value="10"<? if( $day == 10 ): ?> selected="selected"<? endif; ?>>10</option>
<option value="11"<? if( $day == 11 ): ?> selected="selected"<? endif; ?>>11</option>
<option value="12"<? if( $day == 12 ): ?> selected="selected"<? endif; ?>>12</option>

<option value="13"<? if( $day == 13 ): ?> selected="selected"<? endif; ?>>13</option>

<option value="14"<? if( $day == 14 ): ?> selected="selected"<? endif; ?>>14</option>
<option value="15"<? if( $day == 15 ): ?> selected="selected"<? endif; ?>>15</option>
<option value="16"<? if( $day == 16 ): ?> selected="selected"<? endif; ?>>16</option>
<option value="17"<? if( $day == 17 ): ?> selected="selected"<? endif; ?>>17</option>
<option value="18"<? if( $day == 18 ): ?> selected="selected"<? endif; ?>>18</option>
<option value="19"<? if( $day == 19 ): ?> selected="selected"<? endif; ?>>19</option>
<option value="20"<? if( $day == 20 ): ?> selected="selected"<? endif; ?>>20</option>
<option value="21"<? if( $day == 21 ): ?> selected="selected"<? endif; ?>>21</option>

<option value="22"<? if( $day == 22 ): ?> selected="selected"<? endif; ?>>22</option>
<option value="23"<? if( $day == 23 ): ?> selected="selected"<? endif; ?>>23</option>
<option value="24"<? if( $day == 24 ): ?> selected="selected"<? endif; ?>>24</option>
<option value="25"<? if( $day == 25 ): ?> selected="selected"<? endif; ?>>25</option>
<option value="26"<? if( $day == 26 ): ?> selected="selected"<? endif; ?>>26</option>
<option value="27"<? if( $day == 28 ): ?> selected="selected"<? endif; ?>>27</option>
<option value="28"<? if( $day == 28 ): ?> selected="selected"<? endif; ?>>28</option>
<option value="29"<? if( $day == 29 ): ?> selected="selected"<? endif; ?>>29</option>
<option value="30"<? if( $day == 30 ): ?> selected="selected"<? endif; ?>>30</option>

<option value="31"<? if( $day == 31 ): ?> selected="selected"<? endif; ?>>31</option>
</select>

<select name="dob_month">
<option value="">---</option>
<option value="1"<? if( $month == 1 ): ?> selected="selected"<? endif; ?>>������</option>
<option value="2"<? if( $month == 2 ): ?> selected="selected"<? endif; ?>>�������</option>
<option value="3"<? if( $month == 3 ): ?> selected="selected"<? endif; ?>>����</option>
<option value="4"<? if( $month == 4 ): ?> selected="selected"<? endif; ?>>������</option>
<option value="5"<? if( $month == 5 ): ?> selected="selected"<? endif; ?>>���</option>

<option value="6"<? if( $month == 6 ): ?> selected="selected"<? endif; ?>>����</option>
<option value="7"<? if( $month == 7 ): ?> selected="selected"<? endif; ?>>����</option>
<option value="8"<? if( $month == 8 ): ?> selected="selected"<? endif; ?>>������</option>
<option value="9"<? if( $month == 9 ): ?> selected="selected"<? endif; ?>>��������</option>
<option value="10"<? if( $month == 10 ): ?> selected="selected"<? endif; ?>>�������</option>
<option value="11"<? if( $month == 11 ): ?> selected="selected"<? endif; ?>>������</option>
<option value="12"<? if( $month == 12 ): ?> selected="selected"<? endif; ?>>�������</option>
</select>

<select name="dob_year">
<option value="">---</option>
<option value="1994"<? if( $year == 1994 ): ?> selected="selected"<? endif; ?>>1994</option>
<option value="1993"<? if( $year == 1993 ): ?> selected="selected"<? endif; ?>>1993</option>
<option value="1992"<? if( $year == 1992 ): ?> selected="selected"<? endif; ?>>1992</option>
<option value="1991"<? if( $year == 1991 ): ?> selected="selected"<? endif; ?>>1991</option>
<option value="1990"<? if( $year == 1990 ): ?> selected="selected"<? endif; ?>>1990</option>
<option value="1989"<? if( $year == 1989 ): ?> selected="selected"<? endif; ?>>1989</option>
<option value="1988"<? if( $year == 1988 ): ?> selected="selected"<? endif; ?>>1988</option>

<option value="1987"<? if( $year == 1987 ): ?> selected="selected"<? endif; ?>>1987</option>
<option value="1986"<? if( $year == 1986 ): ?> selected="selected"<? endif; ?>>1986</option>
<option value="1985"<? if( $year == 1985 ): ?> selected="selected"<? endif; ?>>1985</option>
<option value="1984"<? if( $year == 1984 ): ?> selected="selected"<? endif; ?>>1984</option>
<option value="1983"<? if( $year == 1983 ): ?> selected="selected"<? endif; ?>>1983</option>
<option value="1982"<? if( $year == 1982 ): ?> selected="selected"<? endif; ?>>1982</option>
<option value="1981"<? if( $year == 1981 ): ?> selected="selected"<? endif; ?>>1981</option>
<option value="1980"<? if( $year == 1980 ): ?> selected="selected"<? endif; ?>>1980</option>

<option value="1979"<? if( $year == 1979 ): ?> selected="selected"<? endif; ?>>1979</option>

<option value="1978"<? if( $year == 1978 ): ?> selected="selected"<? endif; ?>>1978</option>
<option value="1977"<? if( $year == 1977 ): ?> selected="selected"<? endif; ?>>1977</option>
<option value="1976"<? if( $year == 1976 ): ?> selected="selected"<? endif; ?>>1976</option>
<option value="1975"<? if( $year == 1975 ): ?> selected="selected"<? endif; ?>>1975</option>
<option value="1974"<? if( $year == 1974 ): ?> selected="selected"<? endif; ?>>1974</option>
<option value="1973"<? if( $year == 1973 ): ?> selected="selected"<? endif; ?>>1973</option>
<option value="1972"<? if( $year == 1972 ): ?> selected="selected"<? endif; ?>>1972</option>

<option value="1971"<? if( $year == 1971 ): ?> selected="selected"<? endif; ?>>1971</option>
<option value="1970"<? if( $year == 1970 ): ?> selected="selected"<? endif; ?>>1970</option>

<option value="1969"<? if( $year == 1969 ): ?> selected="selected"<? endif; ?>>1969</option>
<option value="1968"<? if( $year == 1968 ): ?> selected="selected"<? endif; ?>>1968</option>
<option value="1967"<? if( $year == 1967 ): ?> selected="selected"<? endif; ?>>1967</option>
<option value="1966"<? if( $year == 1966 ): ?> selected="selected"<? endif; ?>>1966</option>
<option value="1965"<? if( $year == 1965 ): ?> selected="selected"<? endif; ?>>1965</option>
<option value="1964"<? if( $year == 1964 ): ?> selected="selected"<? endif; ?>>1964</option>

<option value="1963"<? if( $year == 1963 ): ?> selected="selected"<? endif; ?>>1963</option>
<option value="1962"<? if( $year == 1962 ): ?> selected="selected"<? endif; ?>>1962</option>
<option value="1961"<? if( $year == 1961 ): ?> selected="selected"<? endif; ?>>1961</option>

<option value="1960"<? if( $year == 1960 ): ?> selected="selected"<? endif; ?>>1960</option>
<option value="1959"<? if( $year == 1959 ): ?> selected="selected"<? endif; ?>>1959</option>
<option value="1958"<? if( $year == 1958 ): ?> selected="selected"<? endif; ?>>1958</option>
<option value="1957"<? if( $year == 1957 ): ?> selected="selected"<? endif; ?>>1957</option>
<option value="1956"<? if( $year == 1956 ): ?> selected="selected"<? endif; ?>>1956</option>

<option value="1955"<? if( $year == 1955 ): ?> selected="selected"<? endif; ?>>1955</option>
<option value="1954"<? if( $year == 1954 ): ?> selected="selected"<? endif; ?>>1954</option>
<option value="1953"<? if( $year == 1953 ): ?> selected="selected"<? endif; ?>>1953</option>
<option value="1952"<? if( $year == 1952 ): ?> selected="selected"<? endif; ?>>1952</option>

<option value="1951"<? if( $year == 1951 ): ?> selected="selected"<? endif; ?>>1951</option>
<option value="1950"<? if( $year == 1950 ): ?> selected="selected"<? endif; ?>>1950</option>
</select>
 </td>
</tr>

<tr>
<td>���:</td>
<td>
<input type="radio" name="sex" value="1"<? if( $sex == 1 ): ?> checked="checked"<? endif; ?> />�������
<input type="radio" name="sex" value="2"<? if( $sex == 2 ): ?> checked="checked"<? endif; ?> />�������
</td>
</tr>


<tr>
<td class="caption">������:</td>
<td>
<script type="text/javascript" src="/templates/js/location.min.js"></script>
<script type="text/javascript" src="/templates/js/location_data.js"></script>
<select id="country_id" name="country_id" class="text" OnChange="list_cities(this.value)">
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
</select>
</td>
</tr>
<tr>

<tr>
<td class="caption">�����:</td>
<td>
<select id="city_id" name="city_id" class="text" disabled>
<option value=""></option>
</select>
</td>
</tr>

<tr>
<td class="caption">Web-����:</td>
<td><input type="text" name="website" value="<?=$website?>" size="56" maxlength="24" /></td>
</tr>

</table>
</div>
<div class="bbl">
<div class="bbr"></div>
</div>


<br />


<div class="ttl">
<div class="ttr"></div>
</div>
<div class="bbd">
<p class="subtitle"><b>�������������� ����������</b></p>
<table class="profile">

<tr>
<td class="caption">������� ��������(�������� 255 ��������):</td>
<td><input type="text" class="validate[required,custom[noSpecialCaracters2]] text-input" name="short_descr" value="<?=$short_descr?>" size="56" maxlength="255" /></td>
</tr>

<tr>
<td class="caption resume">������:<br>"������� ���� ������"<br>

(HTML-���� �� ��������������, �������� 5000 ��������)</td>
<td class="resume"><div><textarea name="full_descr" rows="12" cols="56"><?=$full_descr?></textarea></div><span id="text" class="red"></span></td>
</tr>
</table>
</div>
<div class="bbl">
<div class="bbr"></div>
</div>

<br />
<input type="submit" value="��������� ���������">
</form>




  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>