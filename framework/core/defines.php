<?php
define('DP', DIRECTORY_SEPARATOR);
define('CONT_PATH', $_SERVER['DOCUMENT_ROOT'] . DP . 'application' . DP . 'controllers' . DP . 'home' . DP);
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . DP . 'application' . DP . 'views' . DP . 'home' . DP);
define('MODEL_PATH', $_SERVER['DOCUMENT_ROOT'] . DP . 'application' . DP . 'models' . DP);
define('ADM_CONT_PATH', $_SERVER['DOCUMENT_ROOT'] . DP . 'application' . DP . 'controllers' . DP . 'admin' . DP);
define('ADM_VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . DP . 'application' . DP . 'views' . DP . 'admin' . DP);
define('ALL_CONT_PATHS',array(ADM_CONT_PATH,CONT_PATH));
define('DB_HOST', 'localhost');
define('DB_NAME', 'myDBPDO');
define('PAG_TEMP', VIEW_PATH.'pag_template.php');define('MENU_TEMP', VIEW_PATH.'menu_template.php');
include_once 'secret_data/secret_data.php';
?>