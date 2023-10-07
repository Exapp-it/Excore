<?php

namespace Excore\Core\Modules\Http;

class Request
{
    public function __construct(
        private array $get,
        private array $post,
        private array $files = [],
        private array $cookies = [],
        private array $server = [],
        private array $headers = []
    ) {
    }

    public static function init(): self
    {
        return new self(
            $_GET,
            $_POST,
            $_FILES,
            $_COOKIE,
            $_SERVER,
            getallheaders()
        );
    }

    public function server($value = null)
    {
        if ($value === null) {
            return $this->server;
        }
        return $this->server[$value];
    }

    public function uri(): string
    {
        $requestUri = strtok($this->server['REQUEST_URI'], '?');
        if ($requestUri !== '/') {
            $requestUri = trim($requestUri, '/');
        }
        return $requestUri;
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function post(): array
    {
        return $this->post ?? [];
    }

    public function get(): array
    {
        return $this->get ?? [];
    }

    public function input($key, $default = null)
    {
        if (isset($this->post[$key])) {
            return $this->post[$key];
        }

        if (isset($this->get[$key])) {
            return $this->get[$key];
        }

        return $default;
    }


    public function cookies(): array
    {
        return $this->cookies ?? [];
    }

    public function files(): array
    {
        return $this->files ?? [];
    }

    public function headers(): array
    {
        return $this->headers ?? [];
    }

    public function fullUrl()
    {
        $protocol = isset($this->server['HTTPS']) && $this->server['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $this->server['HTTP_HOST'];
        return $protocol . '://' . $host . '/';
    }

    public function realIp()
    {
        $ip = $this->server['REMOTE_ADDR'];

        if (isset($this->server['HTTP_X_FORWARDED_FOR'])) {
            $ip = $this->server['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($this->server['HTTP_CLIENT_IP'])) {
            $ip = $this->server['HTTP_CLIENT_IP'];
        }

        $ip = explode(',', $ip);
        $ip = trim($ip[0]);

        return $ip;
    }

    public function isAjax()
    {
        if (
            !empty($this->server['HTTP_X_REQUESTED_WITH']) &&
            strtolower($this->server['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        ) {
            return true;
        }

        if (
            isset($this->server['HTTP_ACCEPT']) &&
            strpos($this->server['HTTP_ACCEPT'], 'application/json') !== false
        ) {
            return true;
        }

        return false;
    }
}
