<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Article;

class ArticleController
{
    private $request;
    private $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function index()
    {
        $this->response->setData(['text' => __METHOD__]);

        return $this->response;
    }

    public function show($parameters)
    {
        $article = Article::find(1);
        $this->response->setData($article);

        return $this->response;
    }
}
