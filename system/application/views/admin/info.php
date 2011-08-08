<script type="text/javascript" src="/templates/js/jquery.js"></script>
<script type="text/javascript" src="/templates/js/datepicker/ui.datepicker.js"></script>
<script type="text/javascript" src="/templates/js/datepicker/datepicker.translate.js"></script>
<style type="text/css">
* {
    margin:0;
    padding:0;
}

html, body {
    /*background-color:#E2F2E2;*/
}


/* Стили для jQuery UI Datepicker */
#datepicker_div, .datepicker_inline {
	font-family: "Trebuchet MS", Tahoma, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	padding: 0;
	margin: 0;
	background: #DDD;
	width: 185px;
}
#datepicker_div {
	display: none;
	border: 1px solid #FF9900;
	z-index: 10;
}
.datepicker_inline {
	float: left;
	display: block;
	border: 0;
}
.datepicker_dialog {
	padding: 5px !important;
	border: 4px ridge #DDD !important;
}
button.datepicker_trigger {
	width: 25px;
}
img.datepicker_trigger {
	margin: 2px;
	vertical-align: middle;
}
.datepicker_prompt {
	float: left;
	padding: 2px;
	background: #DDD;
	color: #000;
}
*html .datepicker_prompt {
	width: 185px;
}
.datepicker_control, .datepicker_links, .datepicker_header, .datepicker {
	clear: both;
	float: left;
	width: 100%;
	color: #FFF;
}
.datepicker_control {
	background: #FF9900;
	padding: 2px 0px;
}
.datepicker_links {
	background: #E0F4D7;
	padding: 2px 0px;
}
.datepicker_control, .datepicker_links {
	font-weight: bold;
	font-size: 80%;
	letter-spacing: 1px;
}
.datepicker_links label {
	padding: 2px 5px;
	color: #888;
}
.datepicker_clear, .datepicker_prev {
	float: left;
	width: 34%;
}
.datepicker_current {
	float: left;
	width: 30%;
	text-align: center;
}
.datepicker_close, .datepicker_next {
	float: right;
	width: 34%;
	text-align: right;
}
.datepicker_header {
	padding: 1px 0 3px;
	background: #83C948;
	text-align: center;
	font-weight: bold;
	height: 1.3em;
}
.datepicker_header select {
	background: #83C948;
	color: #000;
	border: 0px;
	font-weight: bold;
}
.datepicker {
	background: #CCC;
	text-align: center;
	font-size: 100%;
}
.datepicker a {
	display: block;
	width: 100%;
}
.datepicker .datepicker_titleRow {
	background: #B1DB87;
	color: #000;
}
.datepicker .datepicker_daysRow {
	background: #FFF;
	color: #666;
}
.datepicker_weekCol {
	background: #B1DB87;
	color: #000;
}
.datepicker .datepicker_daysCell {
	color: #000;
	border: 1px solid #DDD;
}
#datepicker .datepicker_daysCell a {
	display: block;
}
.datepicker .datepicker_weekEndCell {
	background: #E0F4D7;
}
.datepicker .datepicker_daysCellOver {
	background: #FFF;
	border: 1px solid #777;
}
.datepicker .datepicker_unselectable {
	color: #888;
}
.datepicker_today {
	background: #B1DB87 !important;
}
.datepicker_currentDay {
	background: #83C948 !important;
}
#datepicker_div a, .datepicker_inline a {
	cursor: pointer;
	margin: 0;
	padding: 0;
	background: none;
	color: #000;
}
.datepicker_inline .datepicker_links a {
	padding: 0 5px !important;
}
.datepicker_control a, .datepicker_links a {
	padding: 2px 5px !important;
	color: #000 !important;
}
.datepicker_titleRow a {
	color: #000 !important;
}
.datepicker_control a:hover {
	background: #FDD !important;
	color: #333 !important;
}
.datepicker_links a:hover, .datepicker_titleRow a:hover {
	background: #FFF !important;
	color: #333 !important;
}
.datepicker_multi .datepicker {
	border: 1px solid #83C948;
}
.datepicker_oneMonth {
	float: left;
	width: 185px;
}
.datepicker_newRow {
	clear: left;
}
.datepicker_cover {
	display: none;
	display/**/: block;
	position: absolute;
	z-index: -1;
	filter: mask();
	top: -4px;
	left: -4px;
	width: 193px;
	height: 200px;
}
/* Стили для jQuery UI Datepicker */

ol
{
margin:0;
padding: 0 1.5em;
}
table #info
{
color:#FFF;
background:#00a2e8;
border-collapse:collapse;
width:100%;
border:5px solid #0972b5;
}
thead
{
}
thead th
{
padding:1em 1em .5em;
border-bottom:1px dotted #FFF;
font-size:120%;
text-align:left;
}
thead tr
{
}
table #info td
{
height:30px;
padding:.5em 1em;
}
#middle
{
background-color:#0972b5;
}
</style>

	<!-- Content -->
	<article class="container_12">

		<section class="grid_12">
			<div class="block-border"><div class="block-content">
				<!-- We could put the menu inside a H1, but to get valid syntax we'll use a wrapper -->
				<div class="h1 with-menu">
					<h1>Статистика сервиса</h1>
				</div>
			
				<div class="block-controls">
					
					<ul class="controls-tabs js-tabs same-height with-children-tip">
						<li><a href="#tab-stats" title="График"><img src="/templates/admin/images/icons/web-app/24/Bar-Chart.png" width="24" height="24"></a></li>
						<li><a href="#tab-medias" title="Дизайны"><img src="/templates/admin/images/icons/web-app/24/Picture.png" width="24" height="24"></a></li>
						<li><a href="#tab-users" title="Пользователи"><img src="/templates/admin/images/icons/web-app/24/Profile.png" width="24" height="24"></a></li>
					</ul>
					
				</div>
				
				<form class="form" id="tab-stats" method="post" action="">
					
					<fieldset class="grey-bg">
						<legend><a href="#">Настройки</a></legend>
						<div class="float-left gutter-right">
							<label for="stats-period">Период</label>
							<span class="input-type-text"><input type="text" name="range" id="range" value="<?=$input['range']?>"><img src="/templates/admin/images/icons/fugue/calendar-month.png" width="16" height="16"></span>
							<button type="submit" class="small">Поиск</button></div>
					</fieldset>

<a href="/administrator/info/?range=<?=$day?>+-+<?=$today?>">вчера</a> | 
<a href="/administrator/info/?range=<?=$today?>+-+<?=$today?>">сегодня</a> | 
<a href="/administrator/info/?range=<?=$week?>+-+<?=$today?>">неделя</a> | 
<a href="/administrator/info/?range=<?=$month?>+-+<?=$today?>">месяц</a> | 
<a href="/administrator/info/?range=<?=$year?>+-+<?=$today?>">год</a> | 
<a href="/administrator/info/">за весь период</a>

					<div id="chart_div" style="height:330px; margin-top:20px;">
                    
<p>Пользователей: <strong><?=$users?></strong></p>

<p>Дизайнов: <strong><?=$designs?></strong></p>

<p>Куплено дизайнов: <strong><?=$designs_purchased?></strong></p>

<p>Средств пополнено: <strong><?=$addition?> рублей</strong></p>

<p>Средств выведено: <strong><?=$output?> рублей</strong></p>

<hr />

<p>Сумма средств на счетах всех Пользователей: <strong><?=$resources?> рублей</strong></p>

<p>Общая сумма готовых к выводу средств: <strong><?=$resources_2?> рублей</strong></p>
                    </div>
				</form>
				
				<ul class="message no-margin">
					<li><strong>Развёрнутая статистика сервиса</strong></li>
				</ul>
				
			</div></div>
		</section>
		
		<div class="clear"></div>
		
	</article>
	
	<!-- End content -->
<script type="text/javascript">
$(document).ready(function(){
  // ---- Календарь -----
  $('#range').attachDatepicker({
  	rangeSelect: true,
  	yearRange: '2000:2010',
  	firstDay: 1
  });
  // ---- Календарь -----
});
</script>


