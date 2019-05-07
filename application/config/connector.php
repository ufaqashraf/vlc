<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 2/27/2019
 * Time: 6:56 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


defined('DS') OR define('DS', DIRECTORY_SEPARATOR);
defined('EXT') OR define('EXT', '.php');
defined('ENVIRONMENT') OR define('ENVIRONMENT', 'development');

$dir_path = dirname(__FILE__) . DS;
defined('BASEPATH') OR define('BASEPATH', $dir_path . 'system' . DS);
defined('APPPATH') OR define('APPPATH', $dir_path . 'application' . DS);

function getDBConnector(){
	include_once(BASEPATH . "core/Common.php");
	include_once(BASEPATH . "core/Exceptions.php");
	require_once(BASEPATH . 'database/DB' . EXT);
	$conn = & DB();
	return $conn;
}

