<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createUser(array $attributes = [])
    {
        $user = User::factory()->create($attributes);

        return $user;
    }

    protected function createUsers($numberToCreate = 5)
    {
        $users = [];

        for ($counter = 0; $counter < $numberToCreate; $counter++) {
            $user = $this->createUser();
            array_push($users, $user);
        }

        return $users;
    }

    protected function createAdminUser(array $attributes = [])
    {
        $permissions = $this->createPermissions([
            'create users',
            'create roles',
            'update roles',
            'delete roles',
            'view users',
        ]);

        $role = $this->createRole(['name' => 'admin']);
        $user = $this->createUser($attributes);

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        $user->assignRole($role);

        return $user;
    }

    protected function createRole(array $attributes = [])
    {
        $role = Role::factory()->create($attributes);

        return $role;
    }

    protected function createPermission(array $attributes = [])
    {
        $permission = Permission::factory()->create($attributes);

        return $permission;
    }

    protected function createPermissions(array $permissionNames = [])
    {
        $permissions = [];
        foreach ($permissionNames as $permissionName) {
            $permission = $this->createPermission(['name' => $permissionName]);
            array_push($permissions, $permission);
        }

        return $permissions;
    }

    protected function assertModelsInArray($array, $models)
    {
        foreach ($array as $element) {
            $matched = false;
            foreach ($models as $model) {
                if (isset($element->id)) {
                    if ($element->id == $model->id) {
                        $matched = true;
                        break;
                    }
                }
            }
            $this->assertTrue($matched);
        }
    }
}
