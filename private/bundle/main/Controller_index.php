<?php

namespace bundle\main;

//use JT\Core\Config; //todo uncomment for build langs
//use JT\Core\Lang;

class Controller_index extends Controller
{
    var $auth = false;

    function Action_index()
    {
        $this->setResponse('title', 'Главная');
        $this->setResponse('h1', 'Главная');

//        Lang::init(Config::get('lang')); //todo uncomment for build langs
//        Lang::generate('main', 'ru', Config::get('ru'));

        return $this->render();
    }


}