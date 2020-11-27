<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserFactoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itCanCreateUser()
    {
        $factory = app()->make(UserFactory::class);

        $user = $factory->create([
            'name'=> 'John Doe',
            'email'=> 'jdoe@gmail.com',
            'password'=> 'mypassword',
        ]);

        $hashedPassword = $user->password;

        $this->assertEquals('jdoe@gmail.com', $user->email);
        $this->assertDatabaseHas('users', [
            'name'=> 'John Doe',
            'email'=> 'jdoe@gmail.com',
        ]);

        $this->assertTrue(Hash::check('mypassword', $hashedPassword));

    }
}
