<?php

namespace App\Template;

interface RendererInterface
{
    public function render($template, $parameters);
}
