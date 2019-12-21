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
        $newUserData = json_decode($this->request->getContent(), true)['user'];
        $newUser->username = $newUserData['username'];
        $newUser->email = $newUserData['email'];
        $newUser->password = password_hash($newUserData['password'], PASSWORD_DEFAULT);
        $newUser->bio = $newUserData['bio'] ?? null;
        $newUser->image = $newUserData['image'] ?? null;
        $newUser->save();

        $newUser->token = $this->jwtHelper->generateToken($newUser);
        return $this->response->setData([
            'user' => $newUser,
        ]);
    }

    public function login()
    {
        if($this->request->get('jwt')){
            $user = $this->jwtHelper->validateToken($this->request->get('jwt'))->data;
            $this->response->setData([
                'user' => $user,
                'jwt' => $this->jwtHelper->generateToken($user)
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
