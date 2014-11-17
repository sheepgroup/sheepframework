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

class Helpers extends Controllers {
	
	public function __construct()
	{
		$this->db = new Databases();
	}	
	
	/**
	 * Load a helper
	 * 
	 * @param string $helper
	 * @param string $headers
	 * @throws Load helper error Exception
	 */
	public function load($helper, $headers = true ) {	

		try {
			//verify if exists the helper
			if (file_exists( BASEPATH.'/helpers/'.$helper.'_helper.php')) {
				
				//call the render function to load the view and parameters
				$this->render( $helper );
				$fullhelper = $helper.'_helper';
				//instances the helper class
				$this->$helper = new $fullhelper(); 
			} else {
				
				throw new Exception( "Can't load this helper." );
			}
		} catch ( Exception $e ) {
			//TODO: Exception for Loading helper
		}
		unset ( $helper );
	}
	
	/**
	 * Render a helper
	 *
	 * @param string $helper
	 */
	private function render( $helper )
	{
		require_once BASEPATH.'/helpers/'.$helper.'_helper.php';
	}
	
}