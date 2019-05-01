<h2>Управление личными финансами</h2>
<h3>Домашняя бухгалтерия</h3>

<div class="row-fluid">
	<ul class="thumbnails">
		<li class="span4">
			<div class="thumbnail">
				<div class="caption">
					<img src="/public/images/icons/basic-set/wallet_64.png" alt="" align="left" vspace="5" hspace="5">
					<h4>Контролируйте ваши личные финансы</h4>
					<p>Попробуйте сложить все затраты, которые вы делаете постоянно - кофе, перекусы, дозаправка и т. д. Узнайте, сколько и на что вы тратите. Просматривайте отчеты о ваших расходах и доходах. Согласитесь, что удобно знать, сколько и на что вы тратите, где можно немного съэкономить.</p>
				</div>
			</div>
		</li>
		<li class="span4">
			<div class="thumbnail">
				<div class="caption">
					<img src="/public/images/icons/basic-set/statistics_64.png" alt="" align="left" vspace="5" hspace="5">
					<h4>Создайте план расходов</h4>
					<p>Создайте бюджет, который будет напоминать вам, что зарпалата не вечная. Это позволит вам сэкономить деньги в конце месяца. Вы можете создавать бюджет на определенные тэги, например, на питание.</p>
				</div>
			</div>
		</li>
		<li class="span4">
			<div class="thumbnail">
				<div class="caption">
					<img src="/public/images/icons/basic-set/diagram_64.png" alt="" align="left" vspace="5" hspace="5">
					<h4>Достигайте свои цели!</h4>
					<p>Создавайте цели и следите за их прогрессом. Мы подскажем вам, как быстрее достигнуть поставленные цели. Вы всегда сможете посмотреть, сколько вы уже накопили и сколько еще осталось.</p>
				</div>
			</div>
		</li>
	</ul>
</div>

<?php
if (!User::loggedUserID()) {
?>
<div id="row-fluid">
	<div class="actions">
		<div class="left">
			<a class="btn btn-primary btn-large" href="/user/register/">Регистрация <i class="icon-arrow-right icon-white"></i></a>
			<div class="pull-right">
				<a class="btn btn-primary btn-large" href="/user/forgot/"><i class="icon-warning-sign icon-white"></i> Я забыл пароль</a>
			</div>
		</div>
		<br/>
		<br/>
	</div>
</div>
<?php
}
?>

<div class="row-fluid">
	<ul class="thumbnails">
		<li class="span6">
			<div class="thumbnail">
				<div class="caption">
					<a class="twitter-timeline" data-dnt=true href="https://twitter.com/finefin_ru" data-widget-id="296593625737994243">Твиты пользователя @finefin_ru</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
			</div>
		</li>
		<li class="span6">
			<div class="thumbnail">
				<div class="caption">
					<h4>Список to do:</h4>
					<ul>
						<li>Конструктор отчётов</li>
						<li>Бюджеты</li>
						<li>Связанные аккаунты (например, супруги)</li>
						<li>Экспорт (поправить, дополнить) и импорт данных</li>
						<li>Удобная регистрация (не только через соц. сети)</li>
						<li>Доработать вывод списка операций (сейчас всё в кучу)</li>
						<li>Привести в порядок исходный код</li>
					</ul>
				</div>
			</div>
		</li>
	</ul>
</div>
