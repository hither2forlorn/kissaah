<?php 
App::uses('AppController', 'Controller');

class OthersController extends AppController {
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allowedActions = array('clean_specified_folder', 'resize_image', 'rename_image', 'reset_session');
		
		$this->Uploader = new Uploader();
		$this->Uploader->setup(array('tempDir' => TMP));
		$this->Uploader->addMimeType('image', 'gif', 'image/gif');
		$this->Uploader->addMimeType('image', 'jpg', 'image/jpeg');
		$this->Uploader->addMimeType('image', 'jpe', 'image/jpeg');
		$this->Uploader->addMimeType('image', 'jpeg', 'image/jpeg');
		$this->Uploader->addMimeType('image', 'png', array('image/png', 'image/x-png'));
		Configure::write('debug', 2);
	}
	
	public function reset_session() {
		$this->autoRender = false;
		$this->Session->delete('Folder.Images');
	}
	
	public function resize_image($count = 3){
		$this->autoRender = false;
		Configure::write('debug', 2);
		set_time_limit(300);
		ini_set('memory_limit', '512M');

		$a_files = $this->Session->read('Folder.Images');
		
		if(is_null($a_files)) {
			$this->Session->write('Folder.Images', scandir(WWW_ROOT . '/files/img/large/'));
		} elseif (empty($a_files)) {
			echo 'Resize Complete';
			$this->Session->delete('Folder.Images');
			exit;
		}
		
		$a_files = $this->Session->read('Folder.Images');
		
		foreach($a_files as $key => $a_file) {
			if($count-- > 0) {
				if($a_file != '.' && $a_file != '..') {
					if(file_exists(WWW_ROOT . '/files/img/large/' . $a_file)) {
	
						$rlink = 'http://game.kissaah.com/files/img/large/' . $a_file;
						$llink = WWW_ROOT . '/files/img/large/' . $a_file;
						echo $a_file . ' - Image resize started';
						
						if(file_exists(WWW_ROOT.'/files/img/large/' . $a_file)) {
							$this->Uploader->uploadDir = '/files/img/large';
							//$uploadimage = $this->Uploader->importRemote($rlink, array('name' => $a_file, 'overwrite' => true));
							$uploadimage = $this->Uploader->import($llink, array('overwrite' => true, 'delete' => false));
						}
						
						if(!file_exists(WWW_ROOT . '/files/img/medium/' . $a_file)) {
							$this->Uploader->uploadDir = '/files/img/medium';
							$this->Uploader->crop(array('width' => 250,  'height' => 250, 'append' => false, 'overwrite' => true));
							echo ' - Medium Size Created';
						}
	
						if(!file_exists(WWW_ROOT.'/files/img/small/' . $a_file)) {
							$this->Uploader->uploadDir = '/files/img/small';
							$this->Uploader->crop(array('width' => 100,  'height' => 100, 'append' => false, 'overwrite' => true));
							echo ' - Small Size Created';
						}
						if($uploadimage){
							debug($uploadimage);
						}
						
					} else {
						echo $a_file . ' - Image does not exists';
					}
					echo '<br />';
				}
			} else {
				break;
			}
			$this->Session->delete('Folder.Images.' . $key);
		}
		debug($a_files);
		Configure::write('debug', 0);
	}
	
	/*
	 * http://game.kissaah.com/others/clean_specified_folder/medium/500
	 */
	public function clean_specified_folder($clean_folder = 'large', $count = 100) {
		$this->autoRender = false;
		Configure::write('debug', 2);
		set_time_limit(300);
		$this->loadModel('Game');
		$this->Session->write('Game.query_all', 1);
		$a_files = $this->Session->read('Folder.Images');
		
		if(is_null($a_files)) {
			$this->Session->write('Folder.Images', scandir(WWW_ROOT . '/files/img/' . $clean_folder . '/'));
		} elseif (empty($a_files)) {
			echo 'Scanning Complete';
			$this->Session->delete('Folder.Images');
			exit;
		}
		
		$a_files = $this->Session->read('Folder.Images');
		
		foreach($a_files as $key => $a_file) {
			if($count-- > 0) {
				if($a_file != '.' && $a_file != '..') {
					$file_count = $this->Game->find('count', array('contain' => false, 'conditions' => array('Game.answer' => $a_file)));
					if($file_count == 0) {
						echo $a_file . ' - ';
						echo $this->Uploader->delete('files' . DS . 'img' . DS . 'large' . DS . $a_file);
						echo ' - ';
						echo $this->Uploader->delete('files' . DS . 'img' . DS . 'medium' . DS . $a_file);
						echo ' - ';
						echo $this->Uploader->delete('files' . DS . 'img' . DS . 'small' . DS . $a_file);
						echo '<br />';
					}
				}
			} else {
				break;
			}
			$this->Session->delete('Folder.Images.' . $key);
		}
		debug($a_files);
		$this->Session->delete('Game.query_all');
		Configure::write('debug', 0);
	}

	public function clean_image_folder_copy() {
		$this->autoRender = false;
		$this->loadModel('Game');
		$this->Session->write('Game.query_all', 1);
		$a_files = scandir(WWW_ROOT . '/files/img/large/');
		foreach($a_files as $a_file) {
			if($a_file == '.' || $a_file == '..') {
			} else {
				$file_count = $this->Game->find('count', array('contain' => false, 'conditions' => array('Game.answer' => $a_file)));
				if($file_count == 0) {
					rename(WWW_ROOT . '/files/img/large/' . $a_file, WWW_ROOT . '/files/img/delete/' . $a_file);
					echo $a_file . ' - ' . $file_count . ' - file moved.';
					echo '<br />';
				}
			}
		}
		$this->Session->delete('Game.query_all');
	}
	
	public function rename_image() {
		$this->autoRender = false;
		$this->loadModel('Game');
		$this->Session->write('Game.query_all', 1);
		set_time_limit(300);
		
		$files = $this->Game->find('all', array('contain' 		=> array('Configuration'),
									   			'conditions'	=> array('Configuration.type' => 1)));
		echo '<table>';
		foreach($files as $file) {
			$file_name = $file['Game']['answer'];
			$file_name_new = md5(date('Ymdhis') . rand()) . substr($file_name, strrpos($file_name, '.'));
			if(strlen($file_name) != strlen($file_name_new)) {
				echo '<tr>';
				echo '<td>' . $file_name . '</td><td>' . $file_name_new . '</td>';
				echo '<td>' . $this->Game->updateAll(array('Game.answer' => '\'' . $file_name_new . '\''),
													 array('Game.answer' => $file_name)) . '</td>';
				if(file_exists(WWW_ROOT . '/files/img/large/' . $file_name)) {
					echo '<td>' . rename(WWW_ROOT . '/files/img/large/' . $file_name, 
										 WWW_ROOT . '/files/img/large/' . $file_name_new) . '</td>';
				}
				if(file_exists(WWW_ROOT . '/files/img/medium/' . $file_name)) {
					echo '<td>' . rename(WWW_ROOT . '/files/img/medium/' . $file_name, 
										 WWW_ROOT . '/files/img/medium/' . $file_name_new) . '</td>';
				}
				if(file_exists(WWW_ROOT . '/files/img/small/' . $file_name)) {
					echo '<td>' . rename(WWW_ROOT . '/files/img/small/' . $file_name, 
										 WWW_ROOT . '/files/img/small/' . $file_name_new) . '</td>';
				}
				echo '</tr>';
			}
		}
		echo '</table>';
	}
}
?>