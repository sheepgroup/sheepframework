<?php
/**
 * SheepFramework
 *
 * An open source application development MVC Simple framework.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@thesheepgroup.com so we can send you a copy immediately.
 *
 * @package		SheepFW
 * @author		SheepDev
 * @copyright	Copyright (c) 2014, SheepGroup (http://thesheepgroup.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://thesheepgroup.com/
 * @since		Version 0.1
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Databases extends PDO {
	
	/**
	 * @var String
	 */
	private $where;
	/**
	 * @var String
	 */
	private $limit;
	/**
	 * @var String
	 */
	private $order;
	/**
	 * @var Transact-SQL
	 */
	private $query;
	
	public function __construct()
	{
		
		try {
			
			$dsn = DB_DRIVER.':host='.DB_HOST.':'.DB_PORT.';dbname='.DB_DATABASE;
			parent::__construct($dsn, DB_USERNAME, DB_PASSWORD);

		} catch (Exception $e) {
			
			//TODO: Exception for PDO Connect
			echo $e->getMessage();
		}		
	}
	
	/**
	 * Call function to get a stardant class with the table rows
	 * 
	 * @param string $table
	 * @param string $columns
	 * @return StdClass
	 */
	public function get($table, $columns = '*')
	{
		return $this->_select($table, $columns);
	}
	
	/**
	 * Call function to get a stardant class with the table rows
	 * 
	 * @param string $table
	 * @param string $columns
	 * @return StdClass
	 */
	public function select($table, $columns = '*')
	{
		
		return $this->_select($table, $columns);
	}
	
	/**
	 * WHERE Statment
	 * 
	 * @param string $key
	 * @param string or int $val
	 */
	public function where($key, $val)
	{
		
		$this->where = " WHERE ".$key." = ".$val;
	}
	
	/**
	 * OR WHERE Statment
	 * 
	 * @param string $key
	 * @param string or int $val
	 */
	public function or_where($key, $val)
	{
		
		$this->where .= " OR ".$key." = ".$val;
	}
	
	/**
	 * @param unknown $key
	 * @param unknown $val
	 */
	public function and_where($key, $val)
	{
		
		$this->where .= " AND ".$key." = ".$val;
	}
	
	/**
	 * LIMIT Statment
	 * 
	 * @param integer $val
	 */
	public function limit($val)
	{
		
		$this->limit = " LIMIT " . $val;
	}
	
	/**
	 * ORDER BY Statment
	 * 
	 * @param string $key
	 * @param string or int $val
	 */
	public function orderBy($key, $val)
	{
		
		$this->order = " ORDER BY " . $key . " " . $val; 
	}

	/**
	 * 
	 * Call function for insert a row 
	 * 
	 * @param string $table
	 * @param array $array
	 */
	public function insert($table, $array) 
	{
		$this->_insert($table, $array);
	}
	
	/**
	 * 
	 * Call function for update a row 
	 * 
	 * @param string $table
	 * @param array $array
	 */
	public function update($table, $array) 
	{
		$this->_update($table, $array);
	}
	
	/**
	 * 
	 * Call function for delete a row
	 * 
	 * @param string $table
	 * @param array $array
	 */
	public function delete($table, $array) 
	{
		$this->_delete($table, $array);
	}
	
	/**
	 * PDOStatament for select all 
	 * 
	 * @param string $table
	 * @param string $columns
	 * @return StdClass
	 */
	protected function _select($table, $columns)
	{
		
		$stmt = $this->prepare("SELECT ".$columns." FROM `".$table."` " . $this->where . $this->order . $this->limit);
		$stmt->execute();
		return (object)$stmt->fetchAll();
	}
	
	/**
	 * PDOStatament for insert
	 * 
	 * @param string $table
	 * @param array $array
	 */
	protected function _insert($table, $array)
	{
		$keys = array_keys($array);
		$values = array_values($array);
		$stmt = $this->prepare("INSERT INTO ".$table." (".implode(', ', $keys).") VALUES ('".implode("', '", $values)."')");
		$stmt->execute();
	}
	
	/**
	 * PDOStatament for update
	 * 
	 * @param string $table
	 * @param array $array
	 */
	protected function _update($table, $array)
	{
		
		foreach ($array as $key => $val)
		{
			$update[] = $key.' = '.$val;
		}
	
		$stmt = $this->db->prepare("UPDATE `".$table."` SET ".implode(', ', $update)." WHERE id = :identifier");
		$stmt->execute(array(
				'identifier' => $array['id']
		));
	}
	
	/**
	 * PDOStatament for delete
	 * 
	 * @param string $table
	 * @param array $array
	 */
	protected function _delete($table, $array)
	{

		$stmt = $this->prepare( "DELETE FROM `".$table."` WHERE id = :id" );
		$stmt->execute(array(
			'id' => $array['id'],
		));
	}
}

/*
 * remove strict error if those exists.
 */
if(defined('E_STRICT')){
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
}