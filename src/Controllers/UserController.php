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
    private $user;

    public function __construct(Request $request, Response $response, JwtHelper $jwtHelper)
    {
        $this->request = $request;
        $this->response = $response;
        $this->jwtHelper = $jwtHelper;

        if($this->request->headers->has('Authorization')){
            [$authorizationKey, $authorizationValue] = explode(' ', $this->request->headers->get('Authorization'));
            if($authorizationKey === 'Token'){
                $userData = $this->jwtHelper->validateToken($authorizationValue)->data;
                $this->user = User::where('token', $userData->token)->first();
            }
        }
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
        $newUser->token = $this->jwtHelper->generateToken($newUser);
        $newUser->save();

        return $this->response->setData([
            'user' => $newUser,
        ]);
    }

    public function login()
    {
        $userCredentials = json_decode($this->request->getContent(), true)['user'];

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

    public function getCurrentUser()
    {
        $this->response->setData([
            'user' => $this->user
        ]);

        return $this->response;
    }

    public function update()
    {
        $dataToUpdate = json_decode($this->request->getContent(), true);
        $this->user->fill($dataToUpdate);
        $this->user->token = $this->jwtHelper->generateToken($this->user);
        $this->user->save();

        $this->response->setData([
            'user' => $this->user
        ]);

        return $this->response;
    }
}
