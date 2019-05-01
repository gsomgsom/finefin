<?php
	include('Operations.Archive.Common.php');
?>
<!-- Add form -->
<div id="addFormWindow" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addFormLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3 id="addFormLabel">Добавить запись</h3>
</div>
<div class="modal-body" style="min-height: 430px;">
<form name="addForm" id="addForm" method="post" action="/operations/">
<input type="hidden" id="operation" name="operation" value="add">
<input type="hidden" id="id" name="id" value="0">
<input type="hidden" id="tagsContainer" name="tagsContainer" value="">

<div>

<div style="float: left; width: 50%;">
<h5>Дата</h5>
<div data-date-viewmode="years" data-date-format="dd.mm.yyyy" id="dt" class="input-append date">
<input type="text" readonly="readonly" value="<?php echo date('d.m.Y'); ?>" size="16" class="span2" name="dt" id="dt-text">
<span class="add-on"><i class="icon-calendar"></i></span>
</div>

<h5>Кошелёк</h5>
<select id="account" name="account">
<?php
foreach ($this->accounts as $account) {
?>
<option value="<?php echo $account['id']; ?>" style="color: #<?php echo $account['color']; ?>;"><?php echo $account['name']; ?></option>
<?php
}
?>
</select>
<div id="acc2_div" style="display: none;">
<h5>Кошелёк, куда</h5>
<select id="account2" name="account2">
<?php
foreach ($this->accounts as $account) {
?>
<option value="<?php echo $account['id']; ?>" style="color: #<?php echo $account['color']; ?>;"><?php echo $account['name']; ?></option>
<?php
}
?>
</select>
</div>
<h5>Операция</h5>
<select id="op_type" name="op_type">
<option value="1" selected="selected" style="color: #800;">Расход</option>
<option value="2" style="color: #080;">Доход</option>
<option value="3" style="color: #008;">Перевод</option>
</select>
</div>

<div style="float: right; width: 50%;">
<h5>Сумма</h5>
<input type="text" id="sum" name="sum" value="0.00">
<h5>Описание</h5>
<input type="text" id="description" name="description" value="">
<h5>Тэги</h5>
<select id="tags" name="tags" data-placeholder="Выберите тэги" class="chzn-select" multiple="multiple">
<?php
foreach ($this->tags as $tag) {
?>
<option value="<?php echo $tag['id']; ?>"><?php echo $tag['name']; ?></option>
<?php
}
?>
</select>
<h5>Опции</h5>
<label for="planned"><p><input type="checkbox" name="planned" id="planned" checked="checked"> Запланированный</p></label>
<label for="required"><p><input type="checkbox" name="required" id="required" checked="checked"> Необходимый</p></label>
</div>

</div>

</form>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
<button class="btn btn-primary" id="saveAddForm">Сохранить</button>
</div>
</div>

<script type="text/javascript" src="/public/js/controller/operations/common.js"></script>
<script type="text/javascript" src="/public/js/controller/operations/desktop.js.php"></script>
