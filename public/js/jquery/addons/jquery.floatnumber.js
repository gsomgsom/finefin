/*
 * Дописывал этот модуль
 * Строку: input.val(s); заменил на: if (input.val()!="") {input.val(s);}
 * было такое повдение: после того как юзер тыкнет на пустой инпут, а затем куда-нибудь еще
 * в этот инпут ставился ноль. Сейчас инпут остается пустым
 * 
 * еще вставил: 
 *  else
        {
        	input.val("");	
        }
 * чтобы если значение не валидное - оно чистилось
 * 
 * Copyright (c) 2007 Tulio Faria (http://www.tuliofaria.net - http://www.iwtech.com.br)
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Version 1.0
 * Demo: http://www.tuliofaria.net/jquery-floatnumber/
 *
 * $LastChangedDate$
 * $Rev$
 */
(function($) {
		
	//Main Method
	$.fn.floatnumber = function(separator,precision) {	
		return this.each(function(){		
			var input=$(this);				
			var valid=false;   					
			function blur(){
		        var re = new RegExp(",", "g");
		        s = input.val();
		        s = s.replace(re, ".");
		
		        if (s=="")
		            s = "0";

		        if (!isNaN(s)){
		          n = parseFloat(s);
		
		          s = n.toFixed(precision);
		
		          re2 = new RegExp("\\.", "g");
		          s = s.replace(re2, separator);
		
		          if (input.val()!="") {input.val(s);}
          
		        }else{
		        	input.val("");	
		        }
			}
			function focus(){
				var re = new RegExp(",", "g");
		        s = input.val();
		        s = s.replace(re, ".");
		        s = s.replace(/\.00$/, "");
		        if (!isNaN(s)) input.val(s);
			}
			input.bind("blur", blur);
			input.bind("focus", focus);
		});
	};
})(jQuery);
