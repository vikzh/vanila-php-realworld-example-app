<?php

namespace App\Template;

class Renderer implements RendererInterface
{
    private $renderer;

    public function __construct($renderer)
    {
        $this->renderer = $renderer;
    }

    public function render($template, $parameters = [])
    {
        return $this->renderer->render($template, $parameters);
    }
}
