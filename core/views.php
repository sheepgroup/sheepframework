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

class Views {

	public function __construct(){}

	/**
	 * Load views
	 * 
	 * @param string $page
	 * @param string $params
	 * @param string $headers
	 * @throws Error Load Exception
	 */
	public function load($page, $params = false, $headers = true)
	{
	
			//create a new standard define class (stdClass) and Sets header, page and footer.
			$view = new stdClass();
			$view->header = BASEPATH.'views/header.php';
		    $view->page   = BASEPATH.'views/'.$page.'.php';
		    $view->footer = BASEPATH.'views/footer.php';
		  	
		  	try {
				
		  		//if header equals true then load header and footer too, else, just one page.
				if ($headers) {
					
					//verify if exists all views.
					if (file_exists($view->header) && file_exists($view->page) && file_exists($view->footer)) {
							
						//call the render function to load the view and parameters
						$this->render($page, $params);
				
					} else {
						
						//ini_set('xdebug.max_nesting_level', 100);
						throw new Exception("Can't load ".$page." view.");
					}
				
				} else {
					
					//verify if exist the one page view
					if (file_exists($view->page)) {
								
						//call the render single page function to load the view and parameters
						$this->renderSingle($page, $params);
					} else {
						
						//ini_set('xdebug.max_nesting_level', 100);
						throw new Exception("Can't load ".$page." view.");
					}
				}
				

			} catch (Exception $e) {
				//Get err and load a default error view
				$data['err'] = $e->getMessage();
				$this->load('err/views/loader', $data, false);
			}
			unset($view);
	}
	
	/**
	 * Render a page view with header and footer
	 * 
	 * @param string $view
	 * @param string $params
	 */
	private function render($view, $params)
	{
		//if exists one or more parameter export they with the array key name.
		if ($params) {
			foreach($params as $key => $value) {
				$$key = $value;
			}
			unset($params);
		}
		
		//require the views
		require_once BASEPATH.'/views/header.php';
		require_once BASEPATH.'/views/'.$view.'.php';
		require_once BASEPATH.'/views/footer.php';
	}
	
	/**
	 * Render one page view without header and footer
	 *
	 * @param string $view
	 * @param string $params
	 */
	private function renderSingle($view, $params)
	{
		//if exists one or more parameter export they with the array key name.
		if ($params) {
			foreach($params as $key => $value) {
				$$key = $value;
			}
			unset($params);
		}
		
		//require the one page view
		require_once  BASEPATH.'/views/'.$view.'.php';
	}
	
}