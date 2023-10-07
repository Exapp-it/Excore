<?php

namespace Excore\App\Controllers\Auth;

use Exception;
use Excore\App\Controllers\Controller;
use Excore\Core\Modules\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        $this->view->title('Авторизация');
        return $this->view->render('auth/login', ['name' => 'Sam']);
    }

    public function handler(Request $request)
    {
        // Получите POST-данные
        $postData = $request->post();

        // Проверьте, что данные были успешно получены
        if (!empty($postData)) {
            // Здесь проводите проверку авторизации
            // Предположим, что авторизация всегда успешна в этом примере
            $response = ['message' => 'Авторизация успешна'];
        } else {
            $response = ['message' => 'Ошибка: Нет данных POST',];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
