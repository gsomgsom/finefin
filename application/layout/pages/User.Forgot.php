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

<div class="row">
	<div class="span12 content">
		<div class="row">

			<div class="span12">
				<h3 class="page-header">Восстановление доступа</h3>
					<form action="/user/forgot/" method="post" enctype="multipart/form-data">
						<div style="display:none">
							<input type="hidden" value="DfLNCfIfq7w8fZy5lkZjCKViCbIwqyYu" name="token">
					</div>

					<legend>Для восстановления доступа введите ваш Email и нажмите на кнопку «Восстановить»</legend>

					<label>E-mail <span class="bind">*</span></label>
					<input class="tooltip_Email span4" rel="tooltip" type="text" placeholder="E-mail" maxlength="100" name="email" value="<?=$this->email?>">

					<br />
	
					<button type="submit" class="btn btn-primary">Восстановить</button>
				</form>

			</div>

		</div>
	</div>
</div>

<script>
$(document).ready(function () {
	$('#div_id_captcha').hide();

	// тултип на ссылку
	$('.tooltip_Email').attr("title", "Введите действующий адрес электронной почты, который вы указали при регистрации.");
	$('.tooltip_Email').tooltip({placement:'right'});
});
</script>
