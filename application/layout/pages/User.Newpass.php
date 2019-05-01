<?php $this->__set('title', 'Восстановление доступа');?>
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

<div class="hero-unit">
	<div><a href="/">Перейти на главную страницу</a>.</div>
</div>
