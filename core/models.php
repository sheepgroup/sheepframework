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

class Models extends Databases {
	
	public function __construct() {
		//instances database class
		$this->db = new Databases();
	}
	
	/**
	 * Load a Model
	 * 
	 * @param string $model
	 * @param string $headers
	 * @throws Load model error Exception
	 */
	public function load( $model, $headers = true ) {	

		try {
			//verify if exists the model
			if (file_exists( BASEPATH.'/models/'.$model.'_model.php')) {
				
				//call the render function to load the view and parameters
				$this->render( $model );
				$fullmodel = $model.'_model';
				//instances the Model class
				$this->$model = new $fullmodel(); 
			} else {
				
				throw new Exception( "Can't load this model." );
			}
		} catch ( Exception $e ) {
			//TODO: Exception for Loading Model
		}
		unset ( $model );
	}
	
	/**
	 * Render a model
	 *
	 * @param string $model
	 */
	private function render( $model )
	{
		require_once BASEPATH.'/models/'.$model.'_model.php';
	}
	
}