$('#filterQuery').keyup(function(event) {
	// Если нажат Escape или ничего не введено
	if (event.keyCode == 27 || $(this).val() == '') {
		// Если нажат Escape, нужно очистить строку поиска
		$(this).val('');
		filterSearchTable('#operationsTable tbody tr', '');

		// Отобразим все строки, так как если
		// ничего не введено, все строки должны быть видны
		$('#oparationsTable tbody tr').css('display', 'table-row');
		updateTableStyles();
		}

		// Если введён текст, будем фильтровать
		else {
			filterSearchTable('#operationsTable tbody tr', $(this).val());
		}
});

/**
 * Фильтрация таблички
 * @return
 */
function filterSearchTable(selector, query) {
	query = $.trim(query); // Обрезать пробелы
	// Добавим ИЛИ к регулярному выражению
	//query = query.replace(/ /gi, '|');

	$(selector).each(function() {
		// Если надо искать по всем столбцам, то просто this, иначе ($('.class', this).text()...
		($(this).text().search(new RegExp(query, "i")) < 0) ? $(this).css('display', 'none'): $(this).css('display', 'table-row');
	});
}
