<div>Расстановка кораблей</div>

<?php
	$this->addCss('create_field.css');
	$this->addScript('createfield.js');
?>

<?php
	echo PlainPhpView::loadBlock( 'createField/field.php', array(
	));
?>

<div id='create_field_controls'>
	<input id='make_field' type="button" value="Расставить" />
	
	<form method="post">
		<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('createField', 'saveField') ?>" />
		<?php Form::createAjaxSubmit( 'Сохранить', '', 'createField.dataPrepare', 'createField.success' ); ?>
	</form>

	<form id='save_field_redirect' method="post">
		<input type="hidden" name="field" value="" />
		<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('rooms') ?>" />
	</form>
</div>
