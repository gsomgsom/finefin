<?php $this->__set('title', 'Долги');?>
<div class="hero-unit">

<div style="float: right">
<a class="btn btn-primary action-add" id="button-add"><i class="icon-plus icon-white"></i> Добавить</a>
</div>
	<h2>Долги</h2>

<?php
if (isset($this->messages)) {
foreach ($this->messages as $msg) {
?>
<div class="alert <?php
switch ($msg[0]) {
	case Funcs::MSG_NONE:    echo "alert-info"; break;
	case Funcs::MSG_SUCCESS: echo "alert-success"; break;
	case Funcs::MSG_ERROR:   echo "alert-error"; break;
	case Funcs::MSG_INFO:    echo "alert-info"; break;
}
?>">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<?php echo $msg[1]; ?>
</div>
<?php
}
}
?>

<?php
if (!sizeof($this->debtsData)) { ?>
Никто вам не должен. И вы никому.
<?php
}
else { ?>
<table class="table table-bordered table-hover" id="debtsTable">
<thead>
<tr>
<th class="span2">Сумма</th>
<th>Описание</th>
<th class="span2">Операции</th>
</tr>
</thead>
<tbody>

<?php
foreach ($this->debtsData as $dataEntry) {
?>
<tr class="debtEntry" name="debt_<?php echo $dataEntry['id'];?>">
<td id="debt_<?php echo $dataEntry['id'];?>_sum" data="<?php echo sprintf("%.2f", $dataEntry['sum']); ?>" style="font-weight: bold;"><?php echo sprintf("%.2f", $dataEntry['sum']); ?></td>
<td id="debt_<?php echo $dataEntry['id'];?>_description" data="<?php echo $dataEntry['description']; ?>"><?php echo $dataEntry['description'];?></td>
<td>
<a class="btn btn-small btn-primary action-edit" id="button-edit-<?php echo $dataEntry['id'];?>" data="<?php echo $dataEntry['id'];?>"><i class="icon-pencil icon-white"></i></a>
<a class="btn btn-small btn-danger action-delete" id="button-delete-<?php echo $dataEntry['id'];?>" data="<?php echo $dataEntry['id'];?>"><i class="icon-remove icon-white"></i></a>
</td>
</tr>
<?php } ?>

</tbody>
</table>

<?php } ?>
</div>

<!-- Add form -->
<div id="addFormWindow" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addFormLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3 id="addFormLabel">Добавить долг</h3>
</div>
<div class="modal-body">
<form name="addForm" id="addForm" method="post" action="/debts/">
<input type="hidden" id="operation" name="operation" value="add">
<input type="hidden" id="id" name="id" value="0">

<h4>Описание (к примеру «Подруге. На курсы пения ртом»)</h4>
<input type="text" id="description" name="description" value="">

<h4>Сумма</h4>
<input type="text" id="sum" name="sum" value="0.00">

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
	$("#addFormWindow #addFormLabel").text("Добавить долг");
	$('#addForm #id').val(0);
	$('#addForm #operation').val('add');
	$('#addForm #description').val('Новый долг');
	$('#addForm #sum').val('0.00');

	// Show
	$('#addFormWindow').modal();
});

// Show edit form
$(".action-edit").click(function() {
	// Init form
	var id = $(this).attr('data');
	$("#addFormWindow #addFormLabel").text("Изменить долг");
	$('#addForm #operation').val('edit');
	$('#addForm #id').val(id);
	$('#addForm #description').val(
		$('#debt_'+id+'_description').attr('data')
	);
	$('#addForm #sum').val(
		$('#debt_'+id+'_sum').attr('data')
	);

	// Show
	$('#addFormWindow').modal();
});

// Delete entry
$('.action-delete').click(function() {
	// Init
	var id = $(this).attr('data');
	if (confirm("Удалить запись #"+id+"?")) {
		document.location = "/debts/?operation=delete&id="+id;
	}
});

// Submit add form
$('#saveAddForm').click(function() {
	$('#addFormWindow').modal('hide');
	$('#addForm').submit();
});

// Document onLoad
$(document).ready(function() {
	// nothing to do... boring... 
});

</script>
