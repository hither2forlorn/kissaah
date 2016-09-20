<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 * @property PaginatorComponent $Paginator
 */
class PostsController extends AppController {
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow(array('view', 'page_content'));
	}

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->set('id', $id);
	}
	
	public function page_content($id = null) {
		if (!$this->Post->exists($id)) {
			throw new NotFoundException(__('Invalid org post'));
		}
			
		$page_content=$this->Post->find('all',
				array('conditions' => array('Post.id' => $id)));
		$page_content=($page_content[0]['Post']['post_content']);
		return($this->__autop($page_content, true));
	} 
	
	//2014-6-11 Badri,For Tour FUnction
	public function tour($post_id = null){
		$this->layout = null;
		if($post_id) {
			$data = $this->Post->find('first', array('conditions' => array('Post.ID' => $post_id)));
			$this->autoRender = false;
			return $data['Post']['post_content'];
		} else {
			//$options['fields'] = array('Post.id', 'Post.post_title');
			$options['conditions'] = array('Post.post_title LIKE' => 'Tour-Step%', 'Post.post_type' => 'post');
			$options['order'] = array('Post.post_title ASC');
			$data = $this->Post->find('all', $options);
			return($data);
		}
	}
}
