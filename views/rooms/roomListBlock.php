<?php
	$rooms = $this->getVar('rooms');
	foreach( $rooms as $room )
	{
		echo PlainPhpView::loadBlock( 'rooms/roomListItem.php', array(
			'room' => $room,
		));
	}
?>