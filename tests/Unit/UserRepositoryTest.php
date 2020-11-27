<?php

namespace Tests\Unit;

use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itCanGetUsers()
    {
        $users = $this->createUsers();

        $repository = app()->make(UserRepository::class);
        $all = $repository->all();

        $this->assertModelsInArray($all, $users);
    }
}