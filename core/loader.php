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
 * @package     SheepFramework
 * @author      SheepGroup
 * @copyright   Copyright (c) 2014, SheepGroup (http://thesheepgroup.com/)
 * @license     http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link        http://thesheepgroup.com/
 * @since       Version 0.1
 * @filesource
 */

//require the main config file
require_once getcwd() . '/config/config.php';
require_once getcwd() . '/config/autoloader.php';

class Loader
{

    public static $loader;

    private static $autoloader;

    private static $dirs = array(
        'config',
        'core',
    );

    private function __construct()
    {

        if (function_exists('__autoload')) {
            spl_autoload_register('__autoload');
        }

        self::language();

        self::$autoloader = explode(',', LOADER_DIRS);
        
        foreach ((array)self::$autoloader as $location) {
            if (!empty($location))
                if (glob(BASEPATH.$location))
                    self::$dirs[] = $location;
        }
        spl_autoload_register(array($this, 'addClass'));
    }

    private function language()
    {
        if (empty(LANGUAGE)) {
            array_push(self::$dirs, 'languages/pt-BR');
        } else {
            array_push(self::$dirs, 'languages/'.LANGUAGE);
        }
    }

    public static function init()
    {
        if (!function_exists('spl_autoload_register')) {
            throw new Exception("Standard PHP Library (SPL) is required.");
        }
        if (self::$loader == null) {
            self::$loader = new Loader();
        }
        return self::$loader;
    }

    private function addClass($class)
    {
        foreach (self::$dirs as $key => $dir) {

            $dir = BASEPATH . $dir;
            foreach (scandir($dir) as $filename) {
                $file = $dir . '/' . $filename;
                if (file_exists($file) && is_file($file)) {
                    require_once $file;
                }
            }
        }
    }
}

Loader::init();


