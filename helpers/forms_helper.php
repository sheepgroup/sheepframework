<?php

class Forms_Helper extends Helpers
{

	private $form;

	private $name;

	private $config;

	public function config(array $data)
	{
		if (isset($data['action']) and isset($data['method']))
		{

			$this->open($data['action'], $data['method']);
		} else if (isset($data['action']) 
				   and isset($data['method']) 
			       and isset($data['enctype'])) {

			$this->open($data['action'], $data['method'], $data['enctype']);
		} else {
			throw new Exception(FORM_HELPER_OPEN_ERR, 1);
		}

		if (isset($data['table'])) {
			$this->generateFrom($data['table']);
		} else {
			throw new Exception(FORM_HELPER_TABLE_ERR, 1);
		}

		if (isset($data['submit'])) {
			$this->submit($data['submit']);
		} else {
			throw new Exception(FORM_HELPER_SUBMIT_ERR, 1);
		}
	}

	private function readTable($table)
	{
		$this->name = $table;

		$stmt = $this->db->query('DESCRIBE '. $table);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function open($action, $method, $enctype = null)
	{
    	$form = "<form action='".$action."' method='".$method;
    	if ($enctype)
    		$form .= "' enctype='".$enctype;
    	$form .= "'>\n";
    	$this->form .= $form;
	}

	public function generateFrom($table)
	{
		$form = '';
		foreach ($this->readTable($table) as $key => $column) {
			if (!$column['Extra']) {

				$form .= "    <fieldset id='field_".$column['Field']."'>\n";
				$form .= "        <label id='label_".$column['Field']."'>" . $column['Field'] . "</label>\n";
				$form .= "            <input type='text' name='".$column['Field']."' />\n";
				$form .= "    </fieldset>\n";
			}
		}

		$this->form .= $form;
	}

	public function submit($value)
	{
		$this->form .= "    <input type='submit' value='".$value."' />\n";
	}

	public function close()
	{
    	$form = "</form>";
    	$this->form .= $form;
	}

	public function save($path = null)
	{
		$dir = BASEPATH . 'views/';
		if (!is_null($path)) {
			$file = $dir . $path . DIRECTORY_SEPARATOR . 'form_' . $this->name . ".php";
		} else {
			$file = $dir . 'form_' . $this->name . ".php";
		}

		$fp = fopen($file, 'a+');
		if (file_exists($file)) {
			ftruncate($fp, 0);
		} 
		fwrite($fp, $this->form);
		fclose($fp);
	}
}