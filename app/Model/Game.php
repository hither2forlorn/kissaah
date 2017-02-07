<?php 
class Game extends AppModel{
	public $useTable  = 'answers';

	public $actsAs = array(
			'Uploader.Attachment' => array(
				'upload' => array(
					'uploadDir' 	=> '/files/img/large/',
					'dbColumn'  	=> 'filename',    // The database column name to save the path to
					'maxNameLength' => 50,          // Max file name length
					'overwrite' 	=> false,       // Overwrite file with same name if it exists
					'stopSave'  	=> true,        // Stop the model save() if upload fails
					'allowEmpty'	=> true,        // Allow an empty file upload to continue
					)
				),
			'Uploader.FileValidation' => array(
				'upload' => array(
				/*'required' => array(
					'value' => true,
					'error' => 'file selected.'
				),*/
				'extension' => array(
					'value'=>array('gif', 'jpg', 'png', 'jpeg'),
					'error'=>'Invalid File Format. Allowed Type [gif, jpg, png, jpeg]'
					),
				'filesize' => array(
					'value' => 5242880,
					'error' => 'File Size limit upto 5 Mb.'
				)
			)
		),
		'Containable'
	);
	
	public $belongsTo = array(
		'Configuration'=> array(
			'className'		=> 'Configuration',
			'foreignKey'	=> 'configuration_id'
		),
		'User'=> array(
			'className'		=> 'User',
			'foreignKey'	=> 'user_id'
		),
	);
	
	public $hasMany = array(
		'Challenge' => array(
			'className' => 'Challenge',
			'foreignKey' => 'goal_id',
			'dependent' => false,
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

	public function beforeFind($queryData) {
		$query_all = CakeSession::read('Game.query_all');
		if($query_all == 0) {
			$queryData['conditions'][$this->alias.'.user_id'] = CakeSession::read('ActiveGame.user_id'); //AuthComponent::user('id');
			$queryData['conditions']['OR'][$this->alias.'.user_game_status_id'] = CakeSession::read('ActiveGame.id');
			$queryData['conditions']['OR'][][$this->alias.'.user_game_status_id'] = null;
		}
		return $queryData;
	}
	
	function beforeSave($options = Array()) {
		$this->data['Game']['user_id'] = CakeSession::read('ActiveGame.user_id');
		$this->data['Game']['user_game_status_id'] = CakeSession::read('ActiveGame.id');
		return true;
	}
}
?>