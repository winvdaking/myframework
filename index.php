<?php

/**
 * Autoloader
 */
require 'vendor/autoload.php';

/**
 * Config file for the database
 */
$configfile = parse_ini_file('conf/config.ini');

/**
 * Set the App title & link stylesheet
 */
use winv\config\Load;
use winv\mf\view\AbstractView;

/**
 * Start your App
 */
try {
    AbstractView::setAppTitle('My FrameWork by Winv');
    AbstractView::addStyleSheet('');
    Load::init($configfile);
} catch (\Throwable $th) {
    die($th);
}
