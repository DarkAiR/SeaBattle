<?php
	$this->addScript('rooms.js');
?>

<h3>Список комнат</h3>

<div class='rooms_list' id='rooms_list'>
<?php
	$rooms = $this->getVar('rooms');
	foreach( $rooms as $room )
	{
		$this->loadBlock( 'rooms/roomListItem.php', array(
			'room' => $room,
		));
	}
?>
</div>

<form method="post">
	<input type="hidden" name="field" value="<?= $this->getVar('field') ?>" />
	<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('rooms', 'index') ?>" />
	<!--input type="submit" name="submit" value="Обновить" /-->
	<?php Form::createAjaxSubmit( 'Обновить', 'rooms_list' ) ?>
</form>

<form method="post">
	<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('rooms', 'createRoom') ?>" />
	<input type="submit" name="submit" value="Создать комнату" />
</form>
