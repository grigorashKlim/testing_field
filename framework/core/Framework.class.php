<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/framework/model_core/model_core.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/framework/view_core/view_core.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/framework/controller_core/controller_core.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/framework/route_core/route.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/framework/registry/registry.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/framework/core/autoload.php';
$ld = new Autoloader;
$ld->putter();
$output = new Router;
$output->init();
echo "";