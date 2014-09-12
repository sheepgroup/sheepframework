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

//Init and Config Use
require_once('config/loader.php');
require_once('core/bootstrap.php');
require_once('core/controllers.php');
require_once('core/databases.php');
require_once('core/models.php');
require_once('core/views.php');

$init = new Bootstrap();