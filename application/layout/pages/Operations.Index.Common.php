<?php $this->__set('title', 'Операции');?>
<div class="hero-unit">
<div style="float: right">
<?php if (sizeof($this->accounts)) { ?>
<a class="btn btn-primary action-add" id="button-add"><i class="icon-plus icon-white"></i> Добавить</a>
<a class="btn btn-success action-export" id="button-export" href="/operations/export/"><i class="icon-th-list icon-white"></i> Экспорт</a>
<?php } ?>
</div>
<h2>Журнал операций</h2>
<?php if ($this->alertAddSuccess) { ?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">&times;</button>
Запись успешно добавлена.
</div>
<?php } ?>
<?php if ($this->alertEditSuccess) { ?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">&times;</button>
Запись успешно изменена.
</div>
<?php } ?>
<?php if ($this->alertDeleteSuccess) { ?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">&times;</button>
Запись удалена.
</div>
<div>
<?php } ?>
<?php
if (sizeof($this->operationsData)) {
?>
<!-- Форма фильтра -->
<div id="filterForm">
	<div class="input-append">
		<input type="text" name="filterQuery" id="filterQuery" placeholder="Фильтр">
		<span class="add-on"><i class="icon-search"></i></span>
	</div>
</div>

<table class="table table-bordered table-hover" id="operationsTable">
<thead>
<tr>
<th class="span1">Дата</th>
<th class="span2">Сумма</th>
<th class="span2">Кошелёк</th>
<th>Описание</th>
<th class="span2">Тэги</th>
<th class="span2">Операции</th>
</tr>
</thead>
<tbody>
<?php
$day1_shown = false;
$day2_shown = false;
$day7_shown = false;
$day30_shown = false;
foreach ($this->operationsData as $dataEntry) {
$timeDelta = time() - strtotime($dataEntry['dt']);
if ((!$day1_shown) && ($timeDelta <= 1 * 24*60*60)) {
	$day1_shown = true;
	?>
		<tr class="info"><td colspan="6" class="operationSubHeader"><i class="icon-calendar"></i> Сегодня</td></tr>
	<?php
}
if ((!$day2_shown) && ($timeDelta > 1 * 24*60*60) && ($timeDelta <= 2 * 24*60*60)) {
	$day2_shown = true;
	?>
		<tr class="info"><td colspan="6" class="operationSubHeader"><i class="icon-calendar"></i> Вчера</td></tr>
	<?php
}
if ((!$day7_shown) && ($timeDelta > 2 * 24*60*60) && ($timeDelta <= 7 * 24*60*60)) {
	$day7_shown = true;
	?>
		<tr class="info"><td colspan="6" class="operationSubHeader"><i class="icon-calendar"></i> В течении 7 дней</td></tr>
	<?php
}
if ((!$day30_shown) && ($timeDelta > 7 * 24*60*60) && ($timeDelta <= 30 * 24*60*60)) {
	$day30_shown = true;
	?>
		<tr class="info"><td colspan="6" class="operationSubHeader"><i class="icon-calendar"></i> В течении 30 дней</td></tr>
	<?php
}
else {
	if ($timeDelta > 30 * 24*60*60) {
		break;
	}
}
?>
<tr class="<?php if (!$dataEntry['required']) echo "error "; ?>operationEntry" name="op_<?php echo $dataEntry['id'];?>">
<td id="op_<?php echo $dataEntry['id'];?>_dt" data="<?php echo date('d.m.Y', strtotime($dataEntry['dt']));?>">
<div id="op_<?php echo $dataEntry['id'];?>_required" data="<?php echo $dataEntry['required']; ?>"></div>
<div id="op_<?php echo $dataEntry['id'];?>_planned" data="<?php echo $dataEntry['planned']; ?>"></div>
<div id="op_<?php echo $dataEntry['id'];?>_op_type" data="<?php echo $dataEntry['op_type']; ?>"></div>
<div id="op_<?php echo $dataEntry['id'];?>_account2_id" data="<?php echo $dataEntry['account2_id']; ?>"></div>
<?php echo date('d.m.Y', strtotime($dataEntry['dt']));?></td>
<td id="op_<?php echo $dataEntry['id'];?>_sum" data="<?php echo sprintf("%.2f", $dataEntry['sum']); ?>" style="color: #<?php echo $dataEntry['account_color'];?>; font-weight: bold;"><?php if ($dataEntry['op_type'] == Money::OP_EXPENSE) echo "-"; echo sprintf("%.2f", $dataEntry['sum']); if (!$dataEntry['planned']) {echo " <strong>(!)</strong>";} ?></td>
<td id="op_<?php echo $dataEntry['id'];?>_account_id" data="<?php echo $dataEntry['account_id']; ?>" style="color: #<?php echo $dataEntry['account_color'];?>;"><a href="/report/summary/?account_id=<?php echo $dataEntry['account_id']; ?>" style="color: #<?php echo $dataEntry['account_color'];?>;"><?php echo $dataEntry['account_name'];?></a></td>
<td id="op_<?php echo $dataEntry['id'];?>_description" data="<?php echo $dataEntry['description']; ?>"><?php echo $dataEntry['description'];?></td>
<td id="op_<?php echo $dataEntry['id'];?>_tags" data="[<?php echo implode(',', $dataEntry['tag_ids']); ?>]"><?php
foreach ($dataEntry['tags'] as &$entry) {
$entry = '<a href="/report/tag/?tag='.$entry.'">'.$entry.'</a>';
}
echo implode(', ', $dataEntry['tags']);
?></td>
<td>
<a class="btn btn-small btn-primary action-edit" id="button-edit-<?php echo $dataEntry['id'];?>" data="<?php echo $dataEntry['id'];?>"><i class="icon-pencil icon-white"></i></a>
<a class="btn btn-small btn-danger action-delete" id="button-delete-<?php echo $dataEntry['id'];?>" data="<?php echo $dataEntry['id'];?>"><i class="icon-remove icon-white"></i></a>
</td>
</tr>
<?php
}
?>
</tbody>
</table>
<?php
}
else {
?>
Вы не завели ни одной операции.<br/>
<?php if (!sizeof($this->accounts)) { ?>У вас не создано ни одного кошелька. Для начала <a href="/accounts/">создайте кошелёк</a>.<?php } ?>
<?php
}
?>
</div>
