
<!-- Content -->
<article class="container_12">

<section class="grid_4">
<!--<div class="block-border"><div class="block-content">-->
<h1>���������</h1>

<ul class="favorites no-margin with-tip" title="���������">

	<li><img src="/templates/admin/images/icons/web-app/48/Pie-Chart.png"
		width="48" height="48"> <a href="/administrator/">����������<br>
	<small>���������� &gt; ���������� �������</small></a></li>

	<li><img src="/templates/admin/images/icons/web-app/48/Info.png"
		width="48" height="48"> <a href="/administrator/settings/">���������<br>
	<small>���������</small></a></li>

	<li><img src="/templates/admin/images/icons/web-app/48/Picture.png"
		width="48" height="48"> <a href="/administrator/designs/">�������<br>
	<small>������� &gt; ������</small></a></li>

	<li><img src="/templates/admin/images/icons/web-app/48/Modify.png"
		width="48" height="48"> <a href="/administrator/pages_add/">��������
	��������<br>
	<small>�������� &gt; ��������</small></a></li>

</ul>
<!--</div></div>-->
</section>

<section class="grid_8">
<div class="block-border">
<div class="block-content"><!-- We could put the menu inside a H1, but to get valid syntax we'll use a wrapper -->
<div class="h1 with-menu">
<h1>���������� �������</h1>
</div>

<div class="block-controls">

<ul class="controls-tabs js-tabs same-height with-children-tip">
	<li><a href="#tab-stats" title="������"><img
		src="/templates/admin/images/icons/web-app/24/Bar-Chart.png"
		width="24" height="24"></a></li>
	<li><a href="#tab-medias" title="�������"><img
		src="/templates/admin/images/icons/web-app/24/Picture.png" width="24"
		height="24"></a></li>
	<li><a href="#tab-users" title="������������"><img
		src="/templates/admin/images/icons/web-app/24/Profile.png" width="24"
		height="24"></a></li>
</ul>

</div>

<form class="form" id="tab-stats" method="post" action="">

<fieldset class="grey-bg"><legend><a href="#">���������</a></legend>

<div class="float-left gutter-right"><label for="stats-period">���</label>

<span class="input-type-text"> <select name="year"
	onchange="document.location.href = '/administrator/index/?year=' + this.value">
	<? foreach($years as $row => $value): ?>
	<option value="<?=$value?>" <? if( $input['year'] == $value ): ?>
		selected="selected" <? endif; ?>><?=$value?></option>
		<? endforeach; ?>
	>
</select> <img
	src="/templates/admin/images/icons/fugue/calendar-month.png" width="16"
	height="16"></span></div>
</fieldset>

<script type="text/javascript">
						
						// Add listener for tab
						$('#tab-stats').onTabShow(function() { drawVisitorsChart(); }, true);
						
						// Handle viewport resizing
						var previousWidth = $(window).width();
						$(window).resize(function()
						{
							if (previousWidth != $(window).width())
							{
								drawVisitorsChart();
								previousWidth = $(window).width();
							}
						});
						
						// Demo chart
						function drawVisitorsChart() {

							// Create our data table.
							var data = new google.visualization.DataTable();
							var raw_data = [['���������', <?=$products[1]?>, <?=$products[2]?>, <?=$products[3]?>, <?=$products[4]?>, <?=$products[5]?>, <?=$products[6]?>, <?=$products[7]?>, <?=$products[8]?>, <?=$products[9]?>, <?=$products[10]?>, <?=$products[11]?>, <?=$products[12]?>],
											['�������', <?=$purchased[1]?>, <?=$purchased[2]?>, <?=$purchased[3]?>, <?=$purchased[4]?>, <?=$purchased[5]?>, <?=$purchased[6]?>, <?=$purchased[7]?>, <?=$purchased[8]?>, <?=$purchased[9]?>, <?=$purchased[10]?>, <?=$purchased[11]?>, <?=$purchased[12]?>],
											['���������', <?=$purchased_2[1]?>, <?=$purchased_2[2]?>, <?=$purchased_2[3]?>, <?=$purchased_2[4]?>, <?=$purchased_2[5]?>, <?=$purchased_2[6]?>, <?=$purchased_2[7]?>, <?=$purchased_2[8]?>, <?=$purchased_2[9]?>, <?=$purchased_2[10]?>, <?=$purchased_2[11]?>, <?=$purchased_2[12]?>],
											['������������', <?=$users[1]?>, <?=$users[2]?>, <?=$users[3]?>, <?=$users[4]?>, <?=$users[5]?>, <?=$users[6]?>, <?=$users[7]?>, <?=$users[8]?>, <?=$users[9]?>, <?=$users[10]?>, <?=$users[11]?>, <?=$users[12]?>]];
							
							var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
							
							data.addColumn('string', 'Month');
							for (var i = 0; i < raw_data.length; ++i)
							{
								data.addColumn('number', raw_data[i][0]);	
							}
							
							data.addRows(months.length);
							
							for (var j = 0; j < months.length; ++j)
							{	
								data.setValue(j, 0, months[j]);	
							}
							for (var i = 0; i < raw_data.length; ++i)
							{
								for (var j = 1; j < raw_data[i].length; ++j)
								{
									data.setValue(j-1, i+1, raw_data[i][j]);	
								}
							}
							
							// Create and draw the visualization.
							var div = $('#chart_div');
							new google.visualization.ColumnChart(div.get(0)).draw(data, {
								title: '����������� ���������� �������',
								width: div.width(),
								height: 330,
								legend: 'right',
								yAxis: {title: '(thousands)'}
							});
							
							// Message
							notify('������ ��������');
						};
						
					</script> <a href="/administrator/info">����������� ����������
�������</a>
<div id="chart_div" style="height: 330px;"></div>

</form>

<div id="tab-medias" class="with-margin">
<p>����� �� �������: <?=$designs_day?></p>
<p>����� �� ������: <?=$designs_week?></p>
<p>����� �� �����: <?=$designs_month?></p>
<p>����� �� ���: <?=$designs_year?></p>
</div>

<div id="tab-users" class="with-margin">
<p>����� �� �������: <?=$users_day?></p>
<p>����� �� ������: <?=$users_week?></p>
<p>����� �� �����: <?=$users_month?></p>
<p>����� �� ���: <?=$users_year?></p>
</div>

<ul class="message no-margin">
	<li><strong>����� ���������� �������</strong></li>
</ul>

</div>
</div>
</section>

<div class="clear"></div>

</article>

<!-- End content -->
