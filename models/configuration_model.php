<?php

class Configuration_Model extends Models {
	
	
	public function select()
	{
		
		//return $this->db->select("configuration");
		$stmt = $this->db->query("SELECT * FROM configuration");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function insert($array)
	{
		
		$this->db->insert("configuration", $array);
	}
	
	public function update($array)
	{
		
		$this->db->update("configuration", $array);
	}
	
	public function delete($array)
	{
		
		$this->db->delete("configuration", $array);
	}
	
	
}