// создаём плагин maxlength
jQuery.fn.maxlength = function(options) {
  // определяем параметры по умолчанию и прописываем указанные при обращении
  var settings = jQuery.extend({
    maxChars: 5000, // максимальное колличество символов
    leftChars: "character left" // текст в конце строки информера
  }, options);
  // выполняем плагин для каждого объекта
  return this.each(function() {
    // определяем объект
    var me = $(this);
    // определяем динамическую переменную колличества оставшихся для ввода символов
    var l = settings.maxChars;
    // определяем события на которые нужно реагировать
    me.bind('keydown keypress keyup',function(e) {
      // если строка больше maxChars урезаем её
      if(me.val().length>settings.maxChars) me.val(me.val().substr(0,settings.maxChars));
      // определяем колличество оставшихся для ввода сиволов
      l = settings.maxChars - me.val().length;
      // отображаем значение в информере
      //me.next('div').html(l + ' ' + settings.leftChars);
    });
    // вставка информера после объекта
    // me.after('<div class="maxlen">' + settings.maxChars + ' ' + settings.leftChars + '</div>');
  });
};