<?php

use VX\Core\Config;
use VX\Core\Router\Route;
use VX\Core\Error;

{
    define('DR', __DIR__);

    require_once __DIR__ . '/../vendor/autoload.php';

    Error::Register();

    echo (string)new Route(
        isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '', Config::get('router')
    );

}
