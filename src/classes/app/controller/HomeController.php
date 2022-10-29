<?php

namespace winv\app\controller;

use winv\app\view\HomeView;
use winv\mf\control\AbstractController;

class HomeController extends AbstractController {

    public function execute(): void{
        $homeView = new HomeView();
        $homeView->makePage();
    }
}