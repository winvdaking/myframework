<?php

namespace winv\app\view;

use winv\mf\view\AbstractView;

class HomeView extends AbstractView {

    public function makeBody(): string{
        return '<h1>Welcome !</h1>';
    }
}