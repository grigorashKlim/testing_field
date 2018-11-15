<?php
define ('DP', DIRECTORY_SEPARATOR);
define( 'CONT_PATH',$_SERVER['DOCUMENT_ROOT'].DP.'application'.DP.'controllers'.DP.'home'.DP);
define( 'VIEW_PATH',$_SERVER['DOCUMENT_ROOT'].DP.'application'.DP.'views'.DP.'home'.DP);
define( 'MODEL_PATH', $_SERVER['DOCUMENT_ROOT'].DP.'application'.DP.'models'.DP);
define( 'ADM_CONT_PATH',$_SERVER['DOCUMENT_ROOT'].DP.'application'.DP.'controllers'.DP.'admin'.DP);
define( 'ADM_VIEW_PATH',$_SERVER['DOCUMENT_ROOT'].DP.'application'.DP.'views'.DP.'admin'.DP);
define('DB_HOST', 'localhost');
define('DB_NAME', 'myDBPDO');
include_once'secret_data/secret_data.php';
?>