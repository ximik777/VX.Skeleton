<?php

namespace bundle\main;

use VX\Core\ControllerDefault;
use VX\Core\Lang;
use VX\Core\Server;
use VX\Core\Session;

class Controller extends ControllerDefault
{
    var $auth = true;

    var $user_id = null;
    var $user = null;

    var $is_login = false;

    var $__data = [];

    function setData($key, $value)
    {
        $this->__data[$key] = $value;
    }

    function bundleInit()
    {
        if ($this->auth === false)
            return true;

        if (!$this->user_id = Session::get('user_id')) {
            if (Server::is_ajax()) {
                $this->setResponse('code', -1);
                $this->setFieldError('user-not-auth');
                return false;
            }
            header('Location: /login');
            die();
        }
//
//        $this->is_login = true;
//        $this->user = User::getInfoByID($this->user_id);

        return true;
    }

    function is_render()
    {
        $this->setResponse('full_user_name', $this->user['full_name']);
        $this->setResponse('loaded_lang', Lang::loadedJS());
        $this->setResponse('lang', Lang::getAll());
//        $this->setResponse('__data', [
//            'left_menu' => false
////                [
//                //'items' => $this->leftMenu()
////            ]
//        ]);
        $this->setData('left_menu', false);
        $this->setResponse('is_login', $this->is_login);

        $this->setResponse('__data', $this->__data);


    }


}
