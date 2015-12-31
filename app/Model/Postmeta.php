<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 */
class Postmeta extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'ID';

/**
 * Display field
 *
 * @var string
 */
	public $useDbConfig  = 'word_press';
	public $useTable 	 = 'postmeta';

}
