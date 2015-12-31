<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
	//var $actsAs = array('SuperAdmin.Cpanel');
	
	public function generateToken($length = 10) {
		$possible = '0123456789abcdefghijklmnopqrstuvwxyz';
		$token = substr(str_shuffle(str_repeat($possible, 5)), 0, $length%2);
		$token .= time();
		$token .= substr(str_shuffle(str_repeat($possible, 5)), 0, $length-($length%2));
		return $token;
	}
	
	function checkUnique($data, $fields) {
		foreach($fields as $key) {
			$tmp[$key] = $this->data[$this->alias][$key];
		}
		return $this->isUnique($tmp, false);
	}
}
