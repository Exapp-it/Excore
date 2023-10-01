<?php

namespace Excore;


use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;


class App
{
    public function __construct(
        protected string $mode

    ) {
        $this->setMode($mode);
    }

    public function init()
    {
        if ($this->getMode() === 'dev') {
            $whoops = new Run;
            $whoops->pushHandler(new PrettyPageHandler);
            $whoops->register();
        } else if ($this->getMode() === 'prod') {
            echo 'Droduction Mode';
        }
    }


    private function getMode(): string
    {
        return $this->mode;
    }

    private function setMode(string $mode): self
    {
        $this->mode = $mode;
        return $this;
    }
}
