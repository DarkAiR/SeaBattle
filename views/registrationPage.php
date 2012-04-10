<?php
$err = $this->getVar( 'errors' );
if( is_array($err) && count($err)>0 )
	var_dump( $err );
?>

<?= $this->getVar( 'registrationBlock' ) ?>