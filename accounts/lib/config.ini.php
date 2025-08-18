<?php 
	/** 
	* Configuration

	* @package Wojo Framework
	* @author wojoscripts.com
	* @copyright 2020
	* @version Id: config.ini.php, v1.00 2020-07-29 02:57:10 gewa Exp $
	*/
 
	 if (!defined("_WOJO")) 
     die('Direct access to this location is not allowed.');
 
	/** 
	* Database Constants - these constants refer to 
	* the database configuration settings. 
	*/
	 define('DB_SERVER', 'localhost'); 
	 define('DB_USER', 'root'); 
	 define('DB_PASS', ''); 
	 define('DB_DATABASE', 'adublisher');
	 define('DB_DRIVER', 'mysql');
	 define('INSTALL_KEY', 'sEpf6dxarHHshfpO'); 
	/** 
	* Show Debugger Console. 
	* Display errors in console view. Not recomended for live site. true/false 
	*/
	 define('DEBUG', false);

?>
