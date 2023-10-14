<?php

namespace Excore\App\Controllers;

use Excore\App\Controllers\Controller;
use Excore\Core\Helpers\Path;


class MainController extends Controller
{
    public function index()
    {
        $this->view->title('Главная страница');
        $this->view->render('main/home');
    }

}
