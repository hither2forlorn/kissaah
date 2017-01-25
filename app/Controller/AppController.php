<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 */
class AppController extends Controller {

	var $uses = array('User');
	
	var $components = array(
		'Auth' => array(
			'loginAction' => array(
				'controller' => 'users',
				'action' => 'login',
				'admin' => false,
				'plugin' => false),
			'logoutAction' => array(
				'controller' => 'users',
				'action' => 'logout',
				'admin' => false,
				'plugin' => false),
			'authError' => 'Need login before you access this page.',
			'loginError' => 'Username/Password do not match.',
			'authenticate' => array('Form' => array('fields' => array('username' => 'email', 'password' => 'password'),
													'scope' => array('User.verified' => 1)))),
		'SuperAdmin.Cpanel',
		'Email', 'Session', 'RequestHandler', 'Cookie', 'Acl'
		//'Facebook.Connect' => array('model' => 'User')
	);

	public $helpers = array('Form', 'Html', 'Js', 'Session', 'Text', 'Paginator'); //, 'Facebook.Facebook');
	
	function beforeFilter() {
		parent::beforeFilter();
		if(!$this->Auth->user()){
			$cookie = $this->Cookie->read('Auth.User');
			if (!is_null($cookie) && isset($cookie['remember_me']) && $cookie['remember_me'] == 1) {
				$this->request->data['User'] = $cookie;
				if($this->Auth->login()) {
					$this->User->id = $this->Auth->user('id');
					$this->request->data['User']['last_login'] = Date('Y-m-d h:i:s');
					$this->request->data['User']['login_ip'] = $this->_getRealIpAddr();
					$this->User->save($this->request->data);
					$this->redirect(array('controller' => 'users', 'action' => 'afterLogin'));
				}
			}
		} else {
			if(!($this->User->exists($this->Auth->user('id')))){
				$this->Session->setFlash('Your account is currently unaccessible. Please contact System Administrator', 'default', 
										 array('class' => 'flashError'));
				$this->Auth->logout();
				$this->redirect(array('controller' => 'users'));
			}
		}
		
		if(strpos(Router::url('/', true), 'kissaah.com') !== false || strpos(Router::url('/', true), 'humancatalyst') !== false) {
			Configure::write('debug', 0);
		} else {
			Configure::write('debug', 1);
		}
		
		if(strpos(Router::url('/', true), 'kissaah.org') !== false && $this->action != 'master_login' && $this->action != 'verify') {
			if(!$this->Session->check('MasterLogin')) {
				//$this->redirect(array('controller' => 'users', 'action' => 'master_login'));
			}
		}
		
		if(strpos(Router::url('/', true), 'humancatalyst') !== false) {
			$this->Session->write('Company.name', 'Human Catalyst');
			$this->Session->write('Company.link', 'humancatalyst.co');
		} else {
			$this->Session->write('Company.name', 'Kissaah');
			$this->Session->write('Company.link', 'kissaah.com');
		}
		
		debug($this->Session->read());
	}
	
	function beforeRender() {
		parent::beforeRender();
		if (isset($this->request->params['admin'])) { 
			$this->theme = 'Admin'; 
		} else { 
			$this->theme = 'Default'; 
		}
		
		if ($this->name === 'CakeError') {
			$this->layout = 'error';
		} elseif (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			$this->theme = 'Admin';
		}
	}
	
	function _getRealIpAddr() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	protected function _getMailInstance() {
		App::uses('CakeEmail', 'Network/Email');
		if(strpos(Router::url('/', true), 'localhost') !== false) {
			return new CakeEmail('localhost');
		} else {
			return new CakeEmail('default');
		}
	}
	
	protected function _sendEmail($options = array(), $data = array()){
		if(isset($options['template'])) {
			$defaults['from'] 		= Configure::read('App.defaultEmail');
			$defaults['subject'] 	= $this->Session->read('Company.name') . ' Communication';
			$defaults['layout'] 	= 'default';
				
			$options = array_merge($defaults, $options);
			
			$email = $this->_getMailInstance();
			
			if(isset($options['to'])) {
				$email->to($options['to']);
			}
			if(isset($options['cc'])) {
				$email->to($options['cc']);
			}
			if(isset($options['bcc'])) {
				$email->to($options['bcc']);
			}
			$email->subject($options['subject']);
			$email->from($options['from']);
			$email->template($options['template']);
			
			if(isset($options['attachment']) && $options['attachment']){
				$email->attachments($data['attachment']);
			}
			
			$email->viewVars(array('data' => $data));

			if($email->send()) {
				if(isset($options['setFlash']) && $options['setFlash']) {
					$this->Session->setFlash(__("Email Sent", true), 'default', array('class' => 'flashError'));
				}
				return true;
				
			} else {
				if(isset($options['setFlash']) && $options['setFlash']) {
					$this->Session->setFlash(__("Email could not be sent ,Please try later", true), 'default', array('class' => 'flashError'));
				}
				return false;
			}
		}
	}
	
	/**
	 * Replaces double line-breaks with paragraph elements.
	 *
	 * A group of regex replaces used to identify text formatted with newlines and
	 * replace double line-breaks with HTML paragraph tags. The remaining
	 * line-breaks after conversion become <<br />> tags, unless $br is set to '0'
	 * or 'false'.
	 *
	 * @since 0.71
	 *
	 * @param string $pee The text which has to be formatted.
	 * @param bool $br Optional. If set, this will convert all remaining line-breaks after paragraphing. Default true.
	 * @return string Text which has been converted into correct paragraph tags.
	 */
	function __autop($pee, $br = true) {
		$pre_tags = array();
	
		if ( trim($pee) === '' )
			return '';
	
		$pee = $pee . "\n"; // just to make things a little easier, pad the end
	
		if ( strpos($pee, '<pre') !== false ) {
			$pee_parts = explode( '</pre>', $pee );
			$last_pee = array_pop($pee_parts);
			$pee = '';
			$i = 0;
	
			foreach ( $pee_parts as $pee_part ) {
				$start = strpos($pee_part, '<pre');
	
				// Malformed html?
				if ( $start === false ) {
					$pee .= $pee_part;
					continue;
				}
	
				$name = "<pre wp-pre-tag-$i></pre>";
				$pre_tags[$name] = substr( $pee_part, $start ) . '</pre>';
	
				$pee .= substr( $pee_part, 0, $start ) . $name;
				$i++;
			}
	
			$pee .= $last_pee;
		}
	
		$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
		// Space things out a little
		$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|noscript|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
		$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
		$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
		$pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
		if ( strpos($pee, '<object') !== false ) {
			$pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
			$pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
		}
		$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
		// make paragraphs, including one at the end
		$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
		$pee = '';
		foreach ( $pees as $tinkle )
			$pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
		$pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
		$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
		$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
		$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
		$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
		if ( $br ) {
			//$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', $this->_autop_newline_preservation_helper, $pee);
			$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
			$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
		}
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
		$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
		$pee = preg_replace( "|\n</p>$|", '</p>', $pee );
	
		if ( !empty($pre_tags) )
			$pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);
	
		return $pee;
	}
	
	function beforeFacebookSave(){
		
		$fb_id = $this->Connect->user('id');
		
		if(!empty($fb_id)) {
			//$this->Connect->authUser[$this->Connect->model]['username'] = $this->Connect->user('email');
			$this->Connect->authUser[$this->Connect->model]['role_id'] = 2;
			$this->Connect->authUser[$this->Connect->model]['verified'] = 1;
			$this->Connect->authUser[$this->Connect->model]['email'] = $this->Connect->user('email');
			$this->Connect->authUser[$this->Connect->model]['last_login'] = date('Y-m-d h:i:s');
			$this->Connect->authUser[$this->Connect->model]['login_ip'] = $this->_getRealIpAddr();
			$this->Connect->authUser[$this->Connect->model]['facebook_warning'] = 0;
			
		} else {
			return false;
		}
		return true; //Must return true or will not save.
	}
	
	function afterFacebookLogin(){
		$this->Session->write('Facebook', 1);
		$this->redirect(array('controller' => 'users', 'action' => 'afterLogin'));
	}
	
	protected function _reset_roadmap($user_game_status_id) {
		$this->Session->write('Game.query_all', 1);
		$this->loadModel('Game');
		$this->loadModel('Feedback');
		
		$options['conditions'] = array('Configuration.type' => 1, 'Game.configuration_id NOT' => 36,
									   'Game.user_id' => $this->Session->read('ActiveGame.user_id'),
									   'Game.user_game_status_id' => $user_game_status_id);
		$files = $this->Game->find('all', $options);
			
		foreach($files as $filename){
			$filename = $filename['Game']['answer'];
			$path	  = WWW_ROOT . 'files' . DS . 'img' . DS;
			if (file_exists($path . 'large'  . DS . $filename)) {unlink($path . 'large'  . DS . $filename);}
			if (file_exists($path . 'medium' . DS . $filename)) {unlink($path . 'medium' . DS . $filename);}
			if (file_exists($path . 'small'  . DS . $filename)) {unlink($path . 'small'  . DS . $filename);}
		}
			
		$this->Feedback->deleteAll(array('Feedback.user_game_status_id' => $this->Session->read('ActiveGame.id')));

		$this->Game->deleteAll(array('Game.user_id' => $this->Session->read('ActiveGame.user_id'),
									 'Game.user_game_status_id' => $user_game_status_id));
		
		$this->Session->delete('Game.query_all');
	}
}
