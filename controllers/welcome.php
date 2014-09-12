<?php

class Welcome extends Controllers{
	
	public function __construct()
	{
		parent::__construct();
		
		//Load configuration model
		$this->model->load('configuration');
	}
	
	public function indexAction()
	{

		//$this->model->configuration->insert($data);
		
		$data['query'] = $this->model->configuration->select();
		
		//$data = array('id' => 5);
		//$this->model->configuration->delete($data);
		
		$this->view->load('welcome/index', $data);
	}
}