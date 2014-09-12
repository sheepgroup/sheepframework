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
 * @package		SheepFramework
 * @author		SheepGroup
 * @copyright	Copyright (c) 2014, SheepGroup (http://thesheepgroup.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://thesheepgroup.com/
 * @since		Version 0.1
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Bootstrap{
	
	public function __construct(){

		if ($this->gUrl()) {
			
			try {
				
				$url  = $this->renderUrl();
				$file = "/controllers/" . $url[0] . ".php";
				
				if (file_exists(BASEPATH.$file)) {
					
					require_once $file;
					$controller = new $url[0];
					
					if (!isset($url[1]))
						$controller->indexAction();
					
					if (isset($url[2])) {
						
						$controller->$url[1]($url[2]);
					} else {
						
						if (isset($url[1])) {
							if (array_search($url[1], get_class_methods($controller)))
								$controller->$url[1]();
							else
								throw new Exception("Can't load " . $url[1] ." action.");
						}
					}	
				} else {
					//TODO: Throw new Exception
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
				
			
		} else {
			
			if (file_exists(BASEPATH.'/controllers/'.INITCONTROLLER.'.php')) {
				
				require_once(BASEPATH.'/controllers/'.INITCONTROLLER.'.php');
				$controller = INITCONTROLLER;
				$controller = new $controller();
				$controller->indexAction();
			} else {
				//TODO: Throw new Exception
			}
		}
	}
	
	/**
	 * verify if exists a url path
	 * 
	 * @return boolean
	 */
	private function gUrl(){
		
		if (isset($_GET['url']))
			return true;
		else
			return false;
	}
	
	/**
	 * get the full url and explode into a url array.
	 * 
	 * @return urlArray;
	 */
	private function renderUrl()
	{
		
		$url = $_GET['url'];
		$url = rtrim($url, '/');
		$url = explode('/', $url);
		
		return $url;
	}

}