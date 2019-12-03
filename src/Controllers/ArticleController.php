<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController
{
    private $request;
    private $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public  function index()
    {
        $this->response->setContent('Article Controller index method');

        return $this->response;
    }

    public function show()
    {
        $this->response->setContent('Article Controller show method');

        return $this->response;
    }
}
