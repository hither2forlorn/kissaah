<?php
class DATABASE_CONFIG {

	public $default = array(
			'datasource' => 'Database/Mysql',
			'persistent' => false,
			'host' 		 => 'localhost',
			'login' 	 => 'root',
			'password' 	 => 'HimalTech',
			'database' 	 => 'kissaah_game',
			'prefix' 	 => 'dev_',
	);

	public $word_press = array(
			'datasource' => 'Database/Mysql',
			'persistent' => false,
			'host' 		 => 'localhost',
			'login' 	 => 'root',
			'password' 	 => 'HimalTech',
			'database' 	 => 'kissaah_game',
			'prefix' 	 => 'org_',
	);

}
