<?php

use App\Models\User;

class UserFactory
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function run()
    {
        $params = [
            'firstname' => self::getRandomString(random_int(4, 30)),
            'lastname' => self::getRandomString(random_int(5, 30)),
        ];
        $this->user->store($params['firstname'], $params['lastname']);
    }

    protected static function getRandomString(int $length = 16): string
    {
        $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringLength = strlen($stringSpace);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString = $randomString . $stringSpace[rand(0, $stringLength - 1)];
        }

        return $randomString;
    }

}

