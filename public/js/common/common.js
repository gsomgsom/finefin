// Аналог trim в PHP
function trim (s) {
	return s.replace(/^(\s*)/,"$`").replace(/(\s*)$/,"$'");
}

// Аналог функции rand в PHP
function rand (min, max) {
	if ( typeof max != 'undefined' ) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	} else {
		return Math.floor(Math.random() * (min + 1));
	}
}

// Функция генерации случайного набора символов
function randString(length, dictionary) {
	// Длина строки
	if (typeof(length)=='undefined' || length==0){
		length = rand(5,20);
	}
	// Из каких символов будет собирать строку
	if (typeof(dictionary)=='undefined' || dictionary==''){
		dictionary = "abcdefghijklmnopqrstuvwxyz1234567890";
	}
	// Переменная для хранения строки
	var string = "";
	// Составляем строку
	while (string.length<length){
		string+= dictionary.substr(rand(0,dictionary.length-1),1);
	}
	return string;
}

/* @desc Функция isValidEmail принимает один или 2 аргумента:
email - электронный адрес для проверки;
strict - необязательный логический параметр (true/false), который
определяет строгую проверку при которой пробелы до и после адреса
считаются ошибкой
В качестве результата функция возвращает либо true, либо false
*/
function isValidEmail (email, strict){
	 if ( !strict ) email = email.replace(/^\s+|\s+$/g, '');
	 var template = /^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z])+$/;
	 result = template.test(email);
	 return result;
}

function implode(glue, pieces) {	// Join array elements with a string
	return ((pieces instanceof Array) ? pieces.join(glue) : pieces);
}

function getDateFromStr(dateStr) {
	alert(dateStr);
	var d=new Date(dateStr);
	return d;
}