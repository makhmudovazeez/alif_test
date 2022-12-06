<?php

namespace App;

class View
{
    protected $view;
    protected $params = [];

    public function __construct(
        string $view,
        array $params = []
    ) {
        $this->params = $params;
        $this->view = $view;
    }

    public function render()
    {
        ob_start();

        include APP_ROOT . '/views/' . $this->view . '.php';

        return ob_get_clean();
    }
}