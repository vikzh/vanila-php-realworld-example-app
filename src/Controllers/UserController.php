<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class UserController
{
    private $request;
    private $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
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
        $user = User::where('email', $this->request->get('email'))->first();
        if(password_verify($this->request->get('password'), $user->password))
        {
            $this->response->setData($user);
        } else {
            $this->response->setData('Password is incorrect');
        }
        
        return $this->response;
    }
}
