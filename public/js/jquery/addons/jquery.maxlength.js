// ������ ������ maxlength
jQuery.fn.maxlength = function(options) {
  // ���������� ��������� �� ��������� � ����������� ��������� ��� ���������
  var settings = jQuery.extend({
    maxChars: 5000, // ������������ ����������� ��������
    leftChars: "character left" // ����� � ����� ������ ���������
  }, options);
  // ��������� ������ ��� ������� �������
  return this.each(function() {
    // ���������� ������
    var me = $(this);
    // ���������� ������������ ���������� ����������� ���������� ��� ����� ��������
    var l = settings.maxChars;
    // ���������� ������� �� ������� ����� �����������
    me.bind('keydown keypress keyup',function(e) {
      // ���� ������ ������ maxChars ������� �
      if(me.val().length>settings.maxChars) me.val(me.val().substr(0,settings.maxChars));
      // ���������� ����������� ���������� ��� ����� �������
      l = settings.maxChars - me.val().length;
      // ���������� �������� � ���������
      //me.next('div').html(l + ' ' + settings.leftChars);
    });
    // ������� ��������� ����� �������
    // me.after('<div class="maxlen">' + settings.maxChars + ' ' + settings.leftChars + '</div>');
  });
};