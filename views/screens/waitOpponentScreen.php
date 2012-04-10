Waiting opponent...

<?php
	$this->addScript('rooms.js');
?>





<h3>Список комнат</h3>

<div class='rooms_list'>
<?php
$rooms = $this->getVar('rooms');
foreach( $rooms as $room )
{
	echo "<a roomId='".$room->getId()."' href=''>";
	echo 'id:'.$room->getId().' user1:'.$room->getUserId1().' user2:'.$room->getUserId2().' state:'.$room->getState().' time:'.$room->getTimeStamp();
	echo '</a><br/>';
}
?>
</div>

<form id="form_enter_room" method="post" style="display:none">
	<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('rooms', 'enterRoom') ?>" />
	<input type="hidden" name="roomId" value="<?= $this->getVar('roomId') ?>" />
</form>

<form method="post">
	<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('rooms', 'createRoom') ?>" />
	<input type="submit" name="submit" value="Создать комнату" />
</form>
