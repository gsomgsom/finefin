<?php $this->__set('title', 'Отчёт по тэгу «'.$this->tag_name.'»');?>
<h3 class="page-header">Отчёт по тэгу «<?=$this->tag_name;?>»</h3>
<div class="row">
	<div class="span12 content">
		<div id="line_chart"></div>
	</div>
</div>

<!-- Графики формируются на PHP -->
<script>
	$(document).ready(function() {
	});

	google.load("visualization", "1", {
		packages: ["corechart"]
	});
	google.setOnLoadCallback(drawLineChart);

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
			colors: ['#53944e', '#ad242a']
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
