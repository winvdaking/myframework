<?php

namespace winv\config;

use winv\mf\router\Router;

class Load
{
    public static function init(array $config = []): void
    {
        /**
         * Connexion at the DB
         */
        $db = new \Illuminate\Database\Capsule\Manager();
        $db->addConnection($config);
        $db->setAsGlobal();
        $db->bootEloquent();
        
        /**
         * Router
         */
        $router = new Router();
        $router->addRoute('home', 'home_page', '\winv\app\controller\HomeController', \winv\mf\auth\AbstractAuthentification::ACCESS_LEVEL_NONE);
        $router->setDefaultRoute('home_page');
        $router->run();
    }
}
