<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Helpers\JwtHelper;

class UserController
{
    private $request;
    private $response;
    private $jwtHelper;

    public function __construct(Request $request, Response $response, JwtHelper $jwtHelper)
    {
        $this->request = $request;
        $this->response = $response;
        $this->jwtHelper = $jwtHelper;
    }

    public function store()
    {
        $newUser = new User();
        $newUser->username = $this->request->get('username');
        $newUser->email = $this->request->get('email');
        $newUser->password = password_hash($this->request->get('password'), PASSWORD_DEFAULT);
        $newUser->bio = $this->request->get('bio');
        $newUser->image = $this->request->get('image');

        $newUser->save();
        return $this->response->setData($newUser);
    }

    public function login()
    {
        if($this->request->get('jwt')){
            $user = $this->jwtHelper->validateToken($this->request->get('jwt'))->data;
            $this->response->setData([
                'user' => $user
            ]);
            return $this->response;
        }

        $user = User::where('email', $this->request->get('email'))->first();
        if(password_verify($this->request->get('password'), $user->password))
        {
            $this->response->setData([
                'jwt' => $this->jwtHelper->generateToken($user),
                'user' => $user
            ]);
        } else {
            $this->response->setData('Password is incorrect');
        }

        return $this->response;
    }
}
