<?php $version="03062013";?><!DOCTYPE html>
<html lang="en">
<head>
	<title><?php if ((isset($this->_title)) && ($this->_title!='')) echo $this->_title; else { ?>Fine Finances<?php } ?></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="управление финансами, личные финансы, финансы, управление личными финансами, управление деньгами, расходы, управление расходами">
	<meta name="description" content="Управление личными финансами. Управляйте своими расходами и доходами!">
	<meta name="author" content="Zhelnin Evgeniy">
	<link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico?v=<?=$version;?>">
	<link rel="shortcut icon" href="/favicon.ico?v=<?=$version;?>">
	<?php /*<meta property="og:image" content="http://finefin.ru/public/images/app-logo.png">*/ ?>

	<!-- styles -->
	<link href="/public/bootstrap/css/bootstrap.css?v=<?=$version;?>" rel="stylesheet" type="text/css" media="all">
	<!-- <link href="/public/bootstrap/css/bootstrap-united.css?v=<?=$version;?>" rel="stylesheet" type="text/css" media="all"> -->
	<link href="/public/bootstrap/css/bootstrap-responsive.css?v=<?=$version;?>" rel="stylesheet">
	<link href="/public/css/datepicker.css?v=<?=$version;?>" rel="stylesheet" type="text/css" media="all">
	<link href="/public/css/colorpicker.css?v=<?=$version;?>" rel="stylesheet" type="text/css" media="all">
	<link href="/public/css/chosen.css?v=<?=$version;?>" rel="stylesheet" type="text/css" media="all">
	<link href="/public/css/main.css?v=<?=$version;?>" rel="stylesheet" type="text/css" media="all">
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link type="text/css" rel="stylesheet" href="/public/js/jquery/themes/base/jquery.ui.all.css?v=<?=$version;?>">

	<!-- scripts -->
	<script type="text/javascript" src="/public/js/jquery/jq.js?v=<?=$version;?>"></script>
	<script type="text/javascript" src="/public/js/jquery/addons/jquery.charRestriction.js?v=<?=$version;?>"></script>
	<script type="text/javascript" src="/public/js/jquery/addons/chosen.jquery.js?v=<?=$version;?>"></script>
	<script type="text/javascript" src="/public/bootstrap/js/bootstrap.min.js?v=<?=$version;?>"></script>
	<script type="text/javascript" src="/public/js/datapicker/bootstrap-datepicker.js?v=<?=$version;?>"></script>
	<script type="text/javascript" src="/public/js/datapicker/locales/bootstrap-datepicker.ru.js?v=<?=$version;?>"></script>
	<script type="text/javascript" src="/public/js/colorpicker/bootstrap-colorpicker.js?v=<?=$version;?>"></script>
	<script type="text/javascript" src="/public/js/common/common.js?v=<?=$version;?>"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
</head>

<body>
	<!-- navigation bar -->
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="/">Fine Finances</a>
				<div class="nav-collapse collapse">

					<!-- site menu -->
					<ul class="nav">
<?php
if (User::loggedUserID()) {
?>
						<li class="dropdown<?php if(Request::getInstance()->getControllerName()=='operations'){?> active<?php }?>"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Операции <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li<?php if((Request::getInstance()->getControllerName()=='operations') && (Request::getInstance()->getActionName()=='Index')){?> class="active" <?php }?>><a href="/operations/">Список</a></li>
<?php
if (Browser::is_mobile()) {
?>
								<li<?php if((Request::getInstance()->getControllerName()=='operations') && (Request::getInstance()->getActionName()=='addform')){?> class="active"<?php }?>><a href="/operations/addform/">Добавить</a></li>
<?php
}
?>
								<li<?php if((Request::getInstance()->getControllerName()=='operations') && (Request::getInstance()->getActionName()=='archive')){?> class="active" <?php }?>><a href="/operations/archive/">Архив</a></li>
							</ul>
						</li>
						<li<?php if(Request::getInstance()->getControllerName()=='debts'){?> class="active"<?php }?>><a href="/debts/">Долги</a></li>
						<li<?php if(Request::getInstance()->getControllerName()=='tags'){?> class="active"<?php }?>><a href="/tags/">Тэги</a></li>
						<li<?php if(Request::getInstance()->getControllerName()=='accounts'){?> class="active"<?php }?>><a href="/accounts/">Кошельки</a></li>
						<!-- <li<?php if(Request::getInstance()->getControllerName()=='budgets'){?> class="active"<?php }?>><a href="/budgets/">Бюджет</a></li> -->
						<!-- <li<?php if(Request::getInstance()->getControllerName()=='targets'){?> class="active"<?php }?>><a href="/targets/">Цели</a></li> -->
						<li class="<?php if(Request::getInstance()->getControllerName()=='report'){?>active <?php }?>dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Отчёты <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/report/summary/">Сводный отчёт</a></li>
							</ul>
						</li>
<?php
}
?>
					</ul>
					<!-- /site menu -->

<?php
// Auth form
if (User::loggedUserID()) {
	$userdata = User::getUserInfo();
?>
					<form class="navbar-form pull-right">
						<a class="btn" href="/user/logout/">Выйти</a>
					</form>
					<ul class="nav pull-right">
						<li>
							<a href="/user/profile/">Привет, <?=$userdata['name']?> <i class="icon-user icon-white"></i></a>
						</li>
					</ul>						
<?php
}
else {
?>
					<form method="POST" action="/user/login/" class="navbar-form pull-right">
						<input type="text" placeholder="E-mail" class="span2" name="email" id="email">
						<input type="password" placeholder="Пароль" class="span2" name="pass" id="pass">
						<button class="btn" type="submit">Войти</button>
						<script src="http://ulogin.ru/js/ulogin.js"></script>
						<a href="#" class="btn" id="uLogin" x-ulogin-params="display=window;fields=first_name,last_name;redirect_uri=http://beta.finefin.ru/user/ulogin/"><i class="icon-thumbs-up"></i></a>
					</form>
<?php
}
?>
				</div>
			</div>
		</div>
	</div>
	<!-- /navigation bar -->

	<!-- content -->
	<div class="container">
<?php if (isset($this->_pageContent)) echo $this->_pageContent; ?>
	</div>
	<!-- /content -->

	<!-- footer -->
	<div class="container">
		<hr>
		<div class="pull-left muted">
			<p>Copyright <a title="Желнин Евгений" href="http://zhelnin.perm.ru" target="_blank">Желнин Евгений</a> &copy; 2012-<?=date('Y')?></p>
		</div>
		<div class="pull-right muted">
			<p><!--BSD License--></p>
		</div>
	</div>
	<!-- /footer -->
<?php
if (!Browser::is_mobile()) {
?>
<script type="text/javascript">
    var reformalOptions = {
        project_id: 88391,
        project_host: "finefin.reformal.ru",
        force_new_window: true,
        tab_orientation: "right",
        tab_indent: "50%",
        tab_bg_color: "#000000",
        tab_border_color: "#FFFFFF",
        tab_image_url: "http://tab.reformal.ru/T9GC0LfRi9Cy0Ysg0Lgg0L%252FRgNC10LTQu9C%252B0LbQtdC90LjRjw==/FFFFFF/88128dfd6ca0743b5ccc2f8afed9f3b1/right/0/tab.png",
        tab_border_width: 0
    };
    
    (function() {
        var script = document.createElement('script');
        script.type = 'text/javascript'; script.async = true;
        script.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'media.reformal.ru/widgets/v3/reformal.js';
        document.getElementsByTagName('head')[0].appendChild(script);
    })();
</script><noscript><a href="http://reformal.ru"><img src="http://media.reformal.ru/reformal.png" /></a><a href="http://finefin.reformal.ru">Oтзывы и предложения для Fine Finances</a></noscript>
<?php
}
?>

</body>
</html>
