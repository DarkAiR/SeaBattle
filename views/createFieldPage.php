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

<?php
$content = $this->getVar( 'content' );
if( $content !== false )
	echo $content;
?>