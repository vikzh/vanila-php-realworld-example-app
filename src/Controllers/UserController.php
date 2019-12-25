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

    public function __construct(Request $request, JwtHelper $jwtHelper)
    {
        $this->jwtHelper = $jwtHelper;

        if($request->headers->has('Authorization')){
            [$authorizationKey, $authorizationValue] = explode(' ', $request->headers->get('Authorization'));
            if($authorizationKey === 'Token'){
                $userData = $this->jwtHelper->validateToken($authorizationValue)->data;
                $this->user = User::where('token', $userData->token)->first();
            }
        }
    }

    public function store(Request $request, Response $response)
    {
        $newUser = new User();
        $newUserData = json_decode($request->getContent(), true)['user'];
        $newUser->username = $newUserData['username'];
        $newUser->email = $newUserData['email'];
        $newUser->password = password_hash($newUserData['password'], PASSWORD_DEFAULT);
        $newUser->bio = $newUserData['bio'] ?? null;
        $newUser->image = $newUserData['image'] ?? null;
        $newUser->token = $this->jwtHelper->generateToken($newUser);
        $newUser->save();

        return $response->setData([
            'user' => $newUser,
        ]);
    }

    public function login(Request $request, Response $response)
    {
        $userCredentials = json_decode($request->getContent(), true)['user'];

        $user = User::where('email', $userCredentials['email'])->first();
        if(password_verify($userCredentials['password'], $user->password))
        {
            $user->token = $this->jwtHelper->generateToken($user);
            $response->setData([
                'user' => $user
            ]);
        } else {
            $response->setData('Password is incorrect');
        }

        return $response;
    }

    public function getCurrentUser(Response $response)
    {
        $response->setData([
            'user' => $this->user
        ]);

        return $response;
    }

    public function update(Request $request, Response $response)
    {
        $dataToUpdate = json_decode($request->getContent(), true);
        $this->user->fill($dataToUpdate);
        $this->user->token = $this->jwtHelper->generateToken($this->user);
        $this->user->save();

        $response->setData([
            'user' => $this->user
        ]);

        return $response;
    }
}
