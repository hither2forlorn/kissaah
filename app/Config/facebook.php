<?php
/*$config = array(
			'Facebook' => array(
				'appId'  => '438174379606928',
				'apiKey' => '438174379606928',
				'secret' => '366271dba4cc817322cc39b6976a608d',
				'cookie' => true,
				'locale' => 'en_US',
			)
		);*/
/*$config = array(
			'Facebook' => array(
				'appId'  => '610039362389454',
				'apiKey' => '610039362389454',
				'secret' => 'e52f3277ee09e55df725503ae917271c',
				'cookie' => true,
				'locale' => 'en_US',
			)
		);*/
if(strpos(Router::url('/', true), 'kissaah.com') !== false || strpos(Router::url('/', true), 'kissaah.com') !== false) {
	$config = array(
			'Facebook' => array(
					'appId'  => '274229039422559',
					'apiKey' => '274229039422559',
					'secret' => '08ab6f3d5aa1535f5d318c35b595a2e7',
					'cookie' => true,
					'locale' => 'en_US',
			)
	);
}else{
	$config = array(
			'Facebook' => array(
					'appId'  => '1460023040899261',
					'apiKey' => '1460023040899261',
					'secret' => 'fd6bc68713c25fd2e34d3f103e1a1bc4',
					'cookie' => true,
					'locale' => 'en_US',
			)
	);
}
