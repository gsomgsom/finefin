<?php $this->__set('title', 'Регистрация');?>
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
				<h3 class="page-header">Обычная регистрация</h3>
					<form action="/user/register/" method="post" enctype="multipart/form-data">
						<div style="display:none">
							<input type="hidden" value="DfLNCfIfq7w8fZy5lkZjCKViCbIwqyYu" name="token">
					</div>

					<legend>Для регистрации в системе заполните следующие поля и нажмите на кнопку «Завершить регистрацию»</legend>

					<label>Имя <span class="bind">*</span></label>
					<input class="tooltip_FirstName span4" type="text" placeholder="Имя" maxlength="100" name="first_name" value="<?=$this->first_name?>">

					<label>E-mail <span class="bind">*</span></label>
					<input class="tooltip_Email span4" rel="tooltip" type="text" placeholder="E-mail" maxlength="100" name="email" value="<?=$this->email?>">

					<label>Пароль <span class="bind">*</span></label>
					<input class="tooltip_Password span4" rel="tooltip" type="password" placeholder="Пароль" maxlength="100" name="password1" value="">

					<br />
	
					<button type="submit" class="btn btn-primary">Завершить регистрацию</button>
				</form>

			</div>

		</div>
	</div>
</div>

<script>
$(document).ready(function () {
	$('#div_id_captcha').hide();

	// тултип на ссылку
	$('.tooltip_FirstName').attr("title", "Имя, ник, прозвище. Можно будет поменять потом.");
	$('.tooltip_FirstName').tooltip({placement:'right'});
	
	$('.tooltip_Email').attr("title", "Введите действующий адрес электронной почты. Для связи и вместо логина.");
	$('.tooltip_Email').tooltip({placement:'right'});
	
	$('.tooltip_Password').attr("title", "Введите желаемый пароль.");
	$('.tooltip_Password').tooltip({placement:'right'});
	
});
</script>
