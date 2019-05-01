<?php $this->__set('title', 'Тэги');?>
<div class="hero-unit">

<div style="float: right">
<a class="btn btn-primary action-add" id="button-add"><i class="icon-plus icon-white"></i> Добавить</a>
</div>
	<h2>Тэги</h2>

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
if (!sizeof($this->tagsData)) { ?>
У вас нет тэгов. Добавьте основные тэги, например "еда", "зарплата", "алкоголь", "квартплата".
При добавлении операций можно указать тэги и смотреть за движением средств в отчётах. Без них всё работает, но совсем не так, как задумано. 
<?php
}
else { ?>
При добавлении операций можно указать тэги и смотреть за движением средств в отчётах. Без них всё работает, но совсем не так, как задумано. 
<table class="table table-bordered table-hover" id="tagsTable">
<thead>
<tr>
<th class="span2">Тэг</th>
<th class="span2">Операции</th>
</tr>
</thead>
<tbody>

<?php
foreach ($this->tagsData as $dataEntry) {
?>
<tr class="debtEntry" name="debt_<?php echo $dataEntry['id'];?>">
<td id="debt_<?php echo $dataEntry['id'];?>_name" data="<?php echo $dataEntry['name']; ?>"><?php echo $dataEntry['name'];?></td>
<td>
<a class="btn btn-small btn-primary action-edit" id="button-edit-<?php echo $dataEntry['id'];?>" data="<?php echo $dataEntry['id'];?>"><i class="icon-pencil icon-white"></i></a>
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
<form name="addForm" id="addForm" method="post" action="/tags/">
<input type="hidden" id="operation" name="operation" value="add">
<input type="hidden" id="id" name="id" value="0">

<h4>Название (к примеру «хобби»)</h4>
<input type="text" id="name" name="name" value="">

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
	$("#addFormWindow #addFormLabel").text("Добавить тэг");
	$('#addForm #id').val(0);
	$('#addForm #operation').val('add');
	$('#addForm #name').val('Название');

	// Show
	$('#addFormWindow').modal();
});

// Show edit form
$(".action-edit").click(function() {
	// Init form
	var id = $(this).attr('data');
	$("#addFormWindow #addFormLabel").text("Изменить тэг");
	$('#addForm #operation').val('edit');
	$('#addForm #id').val(id);
	$('#addForm #name').val(
		$('#debt_'+id+'_name').attr('data')
	);
	$('#addForm #sum').val(
		$('#debt_'+id+'_sum').attr('data')
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
	// nothing to do... boring... 
});

</script>
