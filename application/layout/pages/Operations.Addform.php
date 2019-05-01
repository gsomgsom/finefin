<?php $this->__set('title', 'Добавить операцию');?>
<div class="hero-unit">
<h2>Добавить операцию</h2>

<!-- Add form -->
<div id="addFormWindow">
<div style="min-height: 430px;">
<form name="addForm" id="addForm" method="post" action="/operations/">
<input type="hidden" id="operation" name="operation" value="add">
<input type="hidden" id="id" name="id" value="0">
<input type="hidden" id="tagsContainer" name="tagsContainer" value="">

<div>

<div style="float: left; width: 50%;">
<h5>Дата</h5>
<div data-date-viewmode="years" data-date-format="dd.mm.yyyy" id="dt" class="input-append date">
<input type="text" readonly="readonly" value="<?php echo date('d.m.Y'); ?>" size="16" class="span2" name="dt" id="dt-text">
<span class="add-on"><i class="icon-calendar"></i></span>
</div>

<h5>Кошелёк</h5>
<select id="account" name="account">
<?php
foreach ($this->accounts as $account) {
?>
<option value="<?php echo $account['id']; ?>" style="color: #<?php echo $account['color']; ?>;"><?php echo $account['name']; ?></option>
<?php
}
?>
</select>
<div id="acc2_div" style="display: none;">
<h5>Кошелёк, куда</h5>
<select id="account2" name="account2">
<?php
foreach ($this->accounts as $account) {
?>
<option value="<?php echo $account['id']; ?>" style="color: #<?php echo $account['color']; ?>;"><?php echo $account['name']; ?></option>
<?php
}
?>
</select>
</div>
<h5>Операция</h5>
<select id="op_type" name="op_type">
<option value="1" selected="selected" style="color: #800;">Расход</option>
<option value="2" style="color: #080;">Доход</option>
<option value="3" style="color: #008;">Перевод</option>
</select>
</div>

<div style="float: right; width: 50%;">
<h5>Сумма</h5>
<input type="text" id="sum" name="sum" value="0.00">
<h5>Описание</h5>
<input type="text" id="description" name="description" value="">
<h5>Тэги</h5>
<select id="tags" name="tags" data-placeholder="Выберите тэги" class="chzn-select" multiple="multiple">
<?php
foreach ($this->tags as $tag) {
?>
<option value="<?php echo $tag['id']; ?>"><?php echo $tag['name']; ?></option>
<?php
}
?>
</select>
<h5>Опции</h5>
<label for="planned"><p><input type="checkbox" name="planned" id="planned" checked="checked"> Запланированный</p></label>
<label for="required"><p><input type="checkbox" name="required" id="required" checked="checked"> Необходимый</p></label>
<button class="btn btn-primary" id="saveAddForm">Сохранить</button>
</div>

</div>

</form>

</div>
</div>

<script>
// Add form
$("#button-add").click(function() {
	// Init form
	$('#addForm #id').val(0);
	$('#addForm #operation').val('add');
	var dtValue = '<?php echo date('d.m.Y'); ?>';
	$('#addForm #dt').data('date', dtValue);
	$('#addForm #dt-text').val(dtValue);
	$('#addForm #dt').datepicker('destroy');
	$('#addForm #dt').datepicker({
		format: 'dd.mm.yyyy',
		language: 'ru',
		weekStart: 1,
		autoclose: true
	});
	$('#addForm #dt').datepicker('setValue', dtValue);
	$('#addForm #sum').val(0);
	$('#addForm #tagsContainer').val();
	$('#addForm #description').val('');
	$('#addForm #account').val(1); // @todo: use user default account
	$('#addForm #required').prop('checked', true);
	$('#addForm #planned').prop('checked', true);
	$('#addForm #op_type').val(1);
	$(".chzn-select").chosen().val([]);
	$(".chzn-select").trigger("liszt:updated");

	// Show
	$('#addFormWindow').modal();
});

// Show edit form
$(".action-edit").click(function() {
	// Init form
	var id = $(this).attr('data');
	$("#addFormWindow #addFormLabel").text("Изменить запись");
	$('#addForm #operation').val('edit');
	$('#addForm #id').val(id);
	var dtValue = $('#op_'+id+'_dt').attr('data');
	$('#addForm #dt').data('date', dtValue);
	$('#addForm #dt-text').val(dtValue);
	$('#addForm #dt').datepicker('destroy');
	$('#addForm #dt').datepicker({
		format: 'dd.mm.yyyy',
		language: 'ru',
		weekStart: 1,
		autoclose: true
	});
	$('#addForm #dt').datepicker('setValue', dtValue);
	$('#addForm #sum').val(
		$('#op_'+id+'_sum').attr('data')
	);
	$('#addForm #description').val(
		$('#op_'+id+'_description').attr('data')
	);
	$('#addForm #account').val(
		$('#op_'+id+'_account_id').attr('data')
	);
  $('#addForm #account2').val(
  	$('#op_'+id+'_account2_id').attr('data')
  );

	if ($('#op_'+id+'_required').attr('data') > 0) {
		$('#addForm #required').prop('checked', true);
	}
	else {
		$('#addForm #required').prop('checked', false);
	}

	if ($('#op_'+id+'_planned').attr('data') > 0) {
		$('#addForm #planned').prop('checked', true);
	}
	else {
		$('#addForm #planned').prop('checked', false);
	}

	$('#addForm #op_type').val(
		$('#op_'+id+'_op_type').attr('data')
	);
	if ($('#op_type').val() == 3) {
		$('#acc2_div').show();
	}
	else {
		$('#acc2_div').hide();
	}

	$(".chzn-select").chosen().val(eval($('#op_'+id+'_tags').attr('data')));
	$(".chzn-select").trigger("liszt:updated");

	// Show
	$('#addFormWindow').modal();
});

// Delete entry
$('.action-delete').click(function() {
	// Init
	var id = $(this).attr('data');
	if (confirm("Удалить запись #"+id+"?")) {
		document.location = "/operations/?operation=delete&id="+id;
	}
});

// Submit add form
$('#saveAddForm').click(function() {
	$('#addFormWindow #tagsContainer').val(implode(';', $(".chzn-select").chosen().val()));
	$('#addForm').submit();
});

// Exchange operation, account 2 toggle
$('#op_type').change(function() {
	if ($(this).val() == 3) {
		$('#acc2_div').show();
	}
	else {
		$('#acc2_div').hide();
	}
});

// Document onLoad
$(document).ready(function() {
	$('#addForm #dt').datepicker({
		format: 'dd.mm.yyyy',
		language: 'ru',
		weekStart: 1,
		autoclose: true
	});
	$("#addForm #sum").charRestriction({limit_to:"numeric", allow:"."});
	$(".chzn-select").chosen({no_results_text: "Не найдено"});
	$(".chzn-select").chosen().val([]);
	$(".chzn-select").trigger("liszt:updated");
});

</script>
