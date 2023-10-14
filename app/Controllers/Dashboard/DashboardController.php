<?php

namespace Excore\App\Controllers\Dashboard;

use Excore\App\Controllers\Controller;



class DashboardController extends Controller
{
    public function index()
    {
        $this->view->title('Личный кабинет');
        return $this->view->render('dashboard/index');
    }
}
