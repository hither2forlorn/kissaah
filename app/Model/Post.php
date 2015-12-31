<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 */
class Post extends AppModel {

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
	public $displayField = 'post_title';
	public $useDbConfig  = 'word_press';

	public $hasMany = array(
			'Postmeta' => array(
					'className'  => 'Postmeta',
					'foreignKey' => 'post_id',
					'dependent' => true,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => ''
			)
	);
}
