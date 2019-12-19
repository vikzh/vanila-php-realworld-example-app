<?php

namespace  App\Helpers;

use Firebase\JWT\JWT;

class JwtHelper
{
    const TOKEN = [
        'iss' => 'http://localhost:8000',
        'aud' => 'http://localhost:8000',
        "iat" => 1356999524,
        "nbf" => 1357000000
    ];
    const KEY = 'AGCeZI9JqETwY9O1hF';
    private $data;
    private $token;
    private $key;

    public function __construct(array $token = [], string $key = null)
    {
        $this->token = array_merge(self::TOKEN, $token);
        $this->key = $key ?? self::KEY;
    }

    public function generateToken($data)
    {
        $this->token['data'] = $data;
        return JWT::encode($this->token, $this->key);
    }

    public function validateToken(string $jwt)
    {
        return JWT::decode($jwt, $this->key, ['HS256']);
    }
}
