<?php
	$this->addScript('rooms.js');
?>

<h3>Список комнат</h3>

<div class='rooms_list' id='rooms_list'>
<?php
	echo PlainPhpView::loadBlock( 'rooms/roomListBlock.php', array(
		'rooms' => $this->getVar('rooms')
	));
?>
</div>

<form method="post">
	<input type="hidden" name="field" value="<?= $this->getVar('field') ?>" />
	<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('rooms', 'getRooms') ?>" />
	<?php Form::createAjaxSubmit( 'Обновить', 'rooms_list' ) ?>
</form>

<form method="post">
	<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('rooms', 'createRoom') ?>" />
	<input type="submit" name="submit" value="Создать комнату" />
</form>
