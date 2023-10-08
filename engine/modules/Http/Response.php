<?php

namespace Excore\Core\Modules\Http;

use Exception;


class Response
{
    const CSRF_HEADER_NAME = "X-Csrf-Token";


    private $statusCode;
    private $headers = [];
    private $body;
    private $contentType = 'text/html';

    public function __construct($statusCode = 200, $body = '', $contentType = 'text/html')
    {
        $this->setStatus($statusCode);
        $this->setContentType($contentType);
        $this->setBody($body);
    }

    public static function init($statusCode = 200, $body = '', $contentType = 'text/html')
    {
        return new self($statusCode, $body, $contentType);
    }

    public function setStatus($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->setHeader('Content-Type', $contentType);
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function setJsonContent($data)
    {
        $this->setContentType('application/json');
        $this->setBody(json_encode($data));
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('JSON encoding error: ' . json_last_error_msg());
        }
        return $this;
    }

    public function send()
    {
        if (headers_sent()) {
            throw new Exception('Headers already sent');
        }

        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->body;
    }

    public function redirect($url, $statusCode = 302)
    {
        $this->setStatus($statusCode);
        $this->setHeader('Location', $url);
        return $this;
    }

    public function sendJson($data)
    {
        return $this->setJsonContent($data)->send();
    }
}
