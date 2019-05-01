// Add form
$("#button-add").click(function() {
	document.location = "/operations/addform/";
});

// Show edit form
$(".action-edit").click(function() {
});

// Delete entry
$('.action-delete').click(function() {
	// Init
	var id = $(this).attr('data');
	if (confirm("Удалить запись #"+id+"?")) {
		document.location = "/operations/?operation=delete&id="+id;
	}
});

// Document onLoad
$(document).ready(function() {
});
