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
        $userCredentials = json_decode($this->request->getContent(), true)['user'];
        /*if($userCredentials['token']){
            $user = $this->jwtHelper->validateToken($userCredentials['token'])->data;
            $this->response->setData([
                'user' => $user,
                'jwt' => $this->jwtHelper->generateToken($user)
            ]);
            return $this->response;
        }*/

        $user = User::where('email', $userCredentials['email'])->first();
        if(password_verify($userCredentials['password'], $user->password))
        {
            $user->token = $this->jwtHelper->generateToken($user);
            $this->response->setData([
                'user' => $user
            ]);
        } else {
            $this->response->setData('Password is incorrect');
        }

        return $this->response;
    }
}
