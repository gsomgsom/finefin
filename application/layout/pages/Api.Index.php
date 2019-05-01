<?php $this->__set('title', 'API');?>
<h2>Управление личными финансами - API</h2>
<div class="hero-unit">
	<h3>Версия 1.0</h3>
	<div>В данный момент API находится в стадии разработки. Доступно только два метода:</div>
	<h4>Auth</h4>
	<div>Авторизация. На входе параметры email, pass. На выходе JSON с токеном, необходимым для обращений к API или ошибка.</div>
	<div><pre>http://beta.finefin.ru/api/auth/?email=demo@finefin.ru&pass=demo</pre></div>
	<div><pre>{"result":"success","token":"c3217b1f7a6e6fcac1edf653c80b2421"}</pre></div>
	<h4>Operations</h4>
	<div>Вывод списка операций. На входе token авторизованного юзера, на выходе JSON - портянка.</div>
	<div><pre>http://beta.finefin.ru/api/operations/?token=c3217b1f7a6e6fcac1edf653c80b2421</pre></div>
	<div><pre>{"operationsData":[{"id":"505","dt":"2013-04-24 00:00:00","sum":"100.00","op_type":"1","currency":"3","description":"\u0422\u0435\u0441\u0442\u043e\u0432\u044b\u0439 \u043f\u043b\u0430\u0442\u0451\u0436","account_id":"30","account2_id":null,"required":"1","planned":"1","account_name":"\u0422\u0435\u0441\u0442\u043e\u0432\u044b\u0439 \u0441\u0447\u0451\u0442","account_color":"000000","account_icon":null,"tags":["\u043f\u0440\u043e\u0447\u0435\u0435"],"tag_ids":["8"]}]}</pre></div>
</div>
