<div id='error' class="error">
	<?php
	$err = $this->getVar( 'errors' );
	if( is_array($err) && count($err)>0 )
		var_dump( $err );
	?>
</div>

<?php
$user = App::instance()->getUser();
echo PlainPhpView::loadBlock( 'login/logoutBlock.php', array(
	'userName' => $user->getLogin(),
));
?>

<?php
$content = $this->getVar( 'content' );
if( $content !== false )
	echo $content;
?>