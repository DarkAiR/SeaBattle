<?php
$err = $this->getVar( 'errors' );
if( is_array($err) && count($err)>0 )
	var_dump( $err );
?>

<?php
$user = App::instance()->getUser();
$this->loadBlock( 'login/logoutBlock.php', array(
	'userName' => $user->getLogin(),
));
?>

<div>
	<?php
	$content = $this->getVar( 'roomsList' );
	if( $content !== false )
		echo $content;
	?>
</div>
<div>
	<?php
	$content = $this->getVar( 'field' );
	if( $content !== false )
		echo $content;
	?>
</div>