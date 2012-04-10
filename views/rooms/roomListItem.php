<?php $this->addCss( 'room.css' ); ?>

<?php
	$room = $this->getVar( 'room' );
?>
<div class='room_list_item'>
	<div class='room_list_timestamp'>Timestamp: <?= $room['Room.TimeStamp'] ?></div>
	<div class='room_list_state'>State: <?= $room['Room.State'] ?></div>
	<div class='room_list_users'>
		<ul>
			<?php
			foreach( $room['users'] as $user )
				echo '<li>'.$user.'</li>';
			?>
		</ul>
	</div>

<?php
	if( in_array( App::instance()->getUserId(), $room['users'] ) )
	{
		?>
		<form id="form_leave_room" method="post">
			<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('rooms', 'leaveRoom') ?>" />
			<input type="hidden" name="roomId" value="<?= $room['Room.Id'] ?>" />
			<input type="submit" name="submit" value="Выйти" />
		</form>
		<?php
	}
	else
	{
		?>
		<form id="form_enter_room" method="post">
			<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('rooms', 'enterRoom') ?>" />
			<input type="hidden" name="roomId" value="<?= $room['Room.Id'] ?>" />
			<input type="submit" name="submit" value="Войти" />
		</form>
		<?php
	}
?>
</div>
