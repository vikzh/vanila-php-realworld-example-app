<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class ArticleController
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public  function index()
    {
        $this->response->setContent('Article Controller index method');
    }

    public function show()
    {
        $this->response->setContent('Article Controller show method');
    }
}
