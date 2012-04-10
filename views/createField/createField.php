<div>Расстановка кораблей</div>

<?php
	$this->addCss('create_field.css');
	$this->addScript('createfield.js');
?>

<div id='error' class="error"></div>

<?php
	$this->loadBlock( 'createField/field.php', array(
	));
?>

<div id='create_field_controls'>
	<input id='make_field' type="button" value="Расставить" />
	
	<form id='save_field_form' method="post">
		<input type="button" name="savefield" value="Сохранить" />
		<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('createField', 'saveField') ?>" />
	</form>

	<form id='save_field_redirect' method="post">
		<input type="hidden" name="field" value="" />
		<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('rooms') ?>" />
	</form>
</div>
