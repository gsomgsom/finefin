<?php $this->__set('title', 'Ошибка 404');?>
<div class="hero-unit">
	<h2>Ошибка 404</h2>
	<p>Такой страницы нет</p>
	<p><?php echo $this->view->getParam('errMessage');?></p>
</div>