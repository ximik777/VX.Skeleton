<?php

namespace bundle;

use VX\Core\Cookie;
use VX\Core\Lang;
use VX\Core\Router\RouteParam;
use VX\Core\MySQLi\MySQLiStatic AS db;
use VX\Core\Server;
use VX\Core\Session;
use VX\Core\MC;

class General
{

    public static function load(RouteParam $param)
    {
        //var_dump($param);
//        db::init('db');
//        MC::init('mc');
//        Cookie::init('cookie');
//        Session::start('session');

//        if (!Session::get('user_id')) {
//            UserSession::restore();
//        }

        if (!Server::is_ajax()) {

            //Lang::init('lang');
            //Lang::load('main', 'ru');
        }
    }

}