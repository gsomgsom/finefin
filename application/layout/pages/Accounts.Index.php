<?php $this->__set('title', 'Кошельки');?>
<div class="hero-unit">
<div style="float: right">
<a class="btn btn-primary action-add" id="button-add"><i class="icon-plus icon-white"></i> Добавить</a>
</div>
	<h2>Кошельки</h2>
<?php if ($this->alertAddSuccess) { ?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">&times;</button>
Кошелёк успешно добавлен.
</div>
<?php } ?>
<?php if ($this->alertAddError) { ?>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">&times;</button>
При добавлении кошелька произошла ошибка.
</div>
<?php } ?>
<?php if ($this->alertEditSuccess) { ?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">&times;</button>
Кошелёк успешно изменён.
</div>
<?php } ?>
	<div>
<?php if (!sizeof($this->accounts)) { ?>
У вас нет кошельков.<br/>
<?php } ?>
Кошельки — это, например «<font color="#006600"><b>Наличные</b>»</font>, «<font color="#990000"><b>Карта Альфа-банка</b>»</font> или «<font color="#000066"><b>Зарплатная карта</b>»</font>.<br/>
Им можно указать цвет и тогда они будут выделяться в списках операций.<br/><br/>
<?php
foreach ($this->accounts as $account) {
?>
<p data="<?php echo $account['id']; ?>" style="color: #<?php echo $account['color']; ?>;"><?php echo $account['name']; ?>
<a style="margin-left: 10px;" class="btn btn-small btn-primary" id="button-report-<?php echo $account['id'];?>" href="/report/summary/?account_id=<?php echo $account['id']; ?>"><i class="icon-signal icon-white"></i></a>
<a style="margin-left: 10px;" class="btn btn-small btn-primary action-edit" id="button-edit-<?php echo $account['id'];?>" data="<?php echo $account['id'];?>"><i class="icon-pencil icon-white"></i></a>
</p>
<div data="<?php echo $account['name']; ?>" id="acc_<?php echo $account['id']; ?>_description"></div>
<div data="#<?php echo $account['color']; ?>" id="acc_<?php echo $account['id']; ?>_color"></div>
<?php
}
?>
	</div>
</div>

<!-- Add form -->
<div id="addFormWindow" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addFormLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3 id="addFormLabel">Добавить кошелёк</h3>
</div>
<div class="modal-body">
<form name="addForm" id="addForm" method="post" action="/accounts/">
<input type="hidden" id="operation" name="operation" value="add">
<input type="hidden" id="id" name="id" value="0">

<h4>Описание (например «Наличные» или «Кредитка ВТБ24»)</h4>
<input type="text" id="description" name="description" value="">

<h4>Цвет</h4>
<input type="text" id="color" name="color" value="#000000">

</form>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
<button class="btn btn-primary" id="saveAddForm">Сохранить</button>
</div>
</div>

<script>
// Add form
$("#button-add").click(function() {
	// Init form
	$("#addFormWindow #addFormLabel").text("Добавить кошелёк");
	$('#addForm #id').val(0);
	$('#addForm #operation').val('add');
	$('#addForm #description').val('Новый кошелёк');
	$('#addForm #color').val('#000000');

	// Show
	$('#addFormWindow').modal();
});

// Show edit form
$(".action-edit").click(function() {
	// Init form
	var id = $(this).attr('data');
	$("#addFormWindow #addFormLabel").text("Изменить кошелёк");
	$('#addForm #operation').val('edit');
	$('#addForm #id').val(id);
	$('#addForm #description').val(
		$('#acc_'+id+'_description').attr('data')
	);
	$('#addForm #color').val(
		$('#acc_'+id+'_color').attr('data')
	);

	// Show
	$('#addFormWindow').modal();
});

// Submit add form
$('#saveAddForm').click(function() {
	$('#addFormWindow').modal('hide');
	$('#addForm').submit();
});

// Document onLoad
$(document).ready(function() { 
	$('#addForm #color').colorpicker();
});

</script>
