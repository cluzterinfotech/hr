<?php 
chdir ( dirname ( __DIR__ ) ); 
ini_set('memory_limit', '-1');
date_default_timezone_set('Africa/Nairobi'); 
// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name () === 'cli-server' && is_file ( __DIR__ . parse_url ( $_SERVER ['REQUEST_URI'], PHP_URL_PATH ) )) {
	return false;
}
// Setup autoloading 
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init ( require 'config/application.config.php' )->run ();
