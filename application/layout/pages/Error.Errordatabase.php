<?php $this->__set('title', 'Ошибка БД');?>
<div class="hero-unit">
	<h2>Ошибка БД</h2>
	<p>Произошла ошибка при работе с базой данных</p>
	<p><?php echo $this->view->getParam('errMessage');?></p>
</div>