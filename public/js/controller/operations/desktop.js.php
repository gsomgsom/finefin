// Add form
$("#button-add").click(function() {
	// Init form
	$("#addFormWindow #addFormLabel").text("Добавить запись");
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
	$('#addFormWindow').modal('hide');
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
