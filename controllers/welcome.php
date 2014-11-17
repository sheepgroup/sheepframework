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

	public function formGenerator()
	{
		$this->helper->load('forms');
		$this->helper->forms->open('#go', 'POST');
		$this->helper->forms->generateFrom('configuration');
		$this->helper->forms->submit('Enviar');
		$this->helper->forms->close();
		$this->helper->forms->save('welcome');
	}

	public function formGeneratorWithConfig()
	{
		$this->helper->load('forms');
		$this->helper->forms->config(array(
				'table' => 'configuration',
				'action' => '#go2',
				'method' => 'POST',
				'submit' => 'Salvar'
			)
		);
		$this->helper->forms->save('welcome');
	}
}