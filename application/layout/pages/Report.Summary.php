<?php
$title_addition = '';
if ($this->account['id'] > 0) {
	$title_addition = ' по кошельку «<font style="color: #'.$this->account['color'].'">'.$this->account['name'].'</font>»';
}
$this->__set('title', 'Сводный отчёт');
?>
<h3 class="page-header">Сводный отчёт<?php echo $title_addition?></h3>
<div class="row">
	<div class="span12 content">
		<div id="line_chart"></div>
		<hr>
		<h3 class="page-header">За последние 30 дней</h3>
		<div class="row">
			<div class="span6">
				<h3>Расходы</h3>
				<div id="bar_chart_1"></div>
			</div>
			<div class="span6">
				<h3>Доходы</h3>
				<div id="bar_chart_2"></div>
			</div>
		</div>
	</div>
</div>

<!--
Графики формируются на PHP
https://google-developers.appspot.com/chart/interactive/docs/gallery/barchart
http://paradigm.ru/google-chart
-->
<script>
	$(document).ready(function() {
		var chart_1;
		var chart_2;
		var data_1;
		var data_2;
	});

	google.load("visualization", "1", {
		packages: ["corechart"]
	});
	google.setOnLoadCallback(drawPieChart);

	function drawPieChart() {
		data_1 = google.visualization.arrayToDataTable([
			['Тег', 'Сумма'],
<?php
foreach ($this->lastExpData as $entry) {
echo "\t\t\t['".$entry['name']."', ".$entry['sum']."],\n";
}
?>
		]);
		data_2 = google.visualization.arrayToDataTable([
			['Тег', 'Сумма'],
<?php
foreach ($this->lastIncData as $entry) {
echo "\t\t\t['".$entry['name']."', ".$entry['sum']."],\n";
}
?>
		]);
		var options_1 = {
			backgroundColor: {
				fill: 'transparent'
			},
			chartArea: {
				width: '95%',
				height: '95%'
			},
			height: 500
		};
		var options_2 = {
			backgroundColor: {
				fill: 'transparent'
			},
			chartArea: {
				width: '95%',
				height: '95%'
			},
			height: 500
		};
		chart_1 = new google.visualization.PieChart(document.getElementById('bar_chart_1'));
		chart_1.draw(data_1, options_1);
		google.visualization.events.addListener(chart_1, 'select', select1Handler);
		chart_2 = new google.visualization.PieChart(document.getElementById('bar_chart_2'));
		chart_2.draw(data_2, options_2);
		google.visualization.events.addListener(chart_2, 'select', select2Handler);
	}
	google.load("visualization", "1", {
		packages: ["corechart"]
	});
	google.setOnLoadCallback(drawLineChart);

  function select1Handler() {
    var selection = chart_1.getSelection();
    var i = selection[0];
		if (i.row != null) {
			var str = data_1.getFormattedValue(i.row, 0);
			location = '/report/tag/?tag=' + str;
		}
  }

  function select2Handler() {
    var selection = chart_2.getSelection();
    var i = selection[0];
		if (i.row != null) {
			var str = data_2.getFormattedValue(i.row, 0);
			location = '/report/tag/?tag=' + str;
		}
  }

	function drawLineChart() {
		var data = google.visualization.arrayToDataTable([
			['Месяц', 'Доходы', 'Расходы'],
<?php
foreach ($this->monthData as $entry) {
echo "\t\t\t['".$entry['name']."', ".$entry['data'][2]['value'].", ".$entry['data'][1]['value']."],\n";
}
?>
		]);
		var options = {
			title: 'Баланс',
			backgroundColor: {
				fill: 'transparent'
			},
			colors: ['#53944e', '#ad242a'],
			vAxis: {
				minValue: 0
			},
		};
		var formatter = new google.visualization.NumberFormat({
			suffix: ' RUB'
		});
		formatter.format(data, 1);
		formatter.format(data, 2);
		var chart = new google.visualization.ColumnChart(document.getElementById('line_chart'));
		chart.draw(data, options);
	}
</script>
