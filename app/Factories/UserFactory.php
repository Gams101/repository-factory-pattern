<?php

namespace App\Factories;

class UserFactory extends Factory
{
    public function create(array $attributes)
    {
        $password = $this->encryptPassword($attributes['password']);
        $attributes['password'] = $password;

        return parent::create($attributes);
    }

    public function encryptPassword($password)
    {
        $password = bcrypt($password);

        return $password;
    }
}