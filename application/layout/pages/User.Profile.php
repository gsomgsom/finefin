<?php $this->__set('title', 'Личный кабинет');?>
<div class="hero-unit">
	<h2>Личный кабинет</h2>

<?php
foreach ($this->messages as $msg) {
?>
<div class="alert <?php
switch ($msg[0]) {
	case Funcs::MSG_NONE:    echo "alert-info"; break;
	case Funcs::MSG_SUCCESS: echo "alert-success"; break;
	case Funcs::MSG_ERROR:   echo "alert-error"; break;
	case Funcs::MSG_INFO:    echo "alert-info"; break;
}
?>">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<?php echo $msg[1]; ?>
</div>
<?php
}
?>

	<div class="row-fluid">
	<div class="span4">
		<p><img src="/public/images/icons/avatar_empty.jpg"></p>
		<p><?php echo($this->userInfo['name']); ?></p>
		<p><?php echo ($this->userInfo['network']!='' ? '<a href="'.$this->userInfo['url'].'">'.$this->userInfo['network'].'</a>' : 'Соц. сеть не указана'); ?></p>
	</div>

	<div class="span4">
		<form action="/user/profile/" method="POST">
		<p>Имя:</p>
		<input type="text" placeholder="Имя" name="name" value="<?php echo($this->userInfo['name']); ?>">
		<p>Email:</p>
		<input type="text" placeholder="Email" name="email"  value="<?php echo($this->userInfo['email']); ?>">
		<p>Пароль:</p>
		<input type="password" name="pass">
		<p>Повторить пароль:</p>
		<input type="password" name="pass2">
		<br/>
		<input class="btn btn-primary" type="submit" value="Сохранить">
		</form>
	</div>
	</div>
</div>
