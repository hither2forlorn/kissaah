<?php
if (strpos ( Router::url ( '/', true ), 'kissaah.com' ) !== false || strpos ( Router::url ( '/', true ), 'kissaah.com' ) !== false) {
	$config = array (
			'LinkedIn' => array (
					'clientID' => '812hnia75jnlcl',
					'clientSecret' => '3degyFZkwk5TI5CD' 
			) 
	);
} else {
	$config = array (
			'LinkedIn' => array (
					'clientID' => '812hnia75jnlcl',
					'clientSecret' => '3degyFZkwk5TI5CD',
					'state' => '57e0c6ac-4b0c-4a26-ab01-2a146d43a845'
			) 
	);
}
