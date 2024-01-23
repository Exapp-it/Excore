<?php

use Excore\Core\Helpers\Hash;
use Excore\Core\Core\Container;

function app()
{
    return Container::getInstance();
}

function auth()
{
    return app()->resolve('Auth');
}

function request()
{
    return app()->resolve('Request');
}

function response()
{
    return app()->resolve('Response');
}

function session()
{
    return app()->resolve('Session');
}

function view()
{
    return app()->resolve('View');
}

function redirect($url)
{
    return response()->redirect($url);
}


function csrf()
{
    return Hash::generateCsrfToken();
}

