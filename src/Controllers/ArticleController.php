<?php

namespace App\Controllers;

use App\Template\Renderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController
{
    private $request;
    private $response;
    private $renderer;

    public function __construct(Request $request, Response $response, Renderer $renderer)
    {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
    }

    public  function index()
    {
        $this->response->setContent($this->renderer->render('articles.twg', ['text' => __METHOD__]));

        return $this->response;
    }

    public function show()
    {
        $this->response->setContent($this->renderer->render('articles.twg', ['text' => __METHOD__]));

        return $this->response;
    }
}
