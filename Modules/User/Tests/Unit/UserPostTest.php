<?php

namespace Modules\User\Tests\Unit;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Modules\User\Entities\User;
use Modules\User\Helpers\RoleHelper;
use Modules\User\Helpers\UserHelper;
use Modules\User\Http\Controllers\Admin\UsersController;
use Modules\User\Http\Requests\Admin\User\UserCreateRequest;
use Modules\User\Http\Requests\Admin\User\UserDeleteRequest;
use Modules\User\Http\Requests\Admin\User\UserUpdateRequest;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

$faker = Factory::create();

function createFakeImage()
{
    $file = UploadedFile::fake()->image('fake-image.jpg');

    return Storage::disk('elegant')->putFile('users', $file);
}

beforeEach(function () {
    $this->user = User::find(1);
    $this->actingAs($this->user);
});

it('creates a user', function () use ($faker) {
    $userHelper = mock(UserHelper::class);
    $roleHelper = mock(RoleHelper::class);
    $request = UserCreateRequest::create('/admin/user/create', 'POST', [
        'name' => $faker->name,
        'email' => $faker->email,
        'role_id' => '2',
        'password' => $faker->password,
        'password_confirm' => $faker->password,
        'profile_picture' => createFakeImage(),
    ]);

    DB::shouldReceive('beginTransaction');
    DB::shouldReceive('commit');

    $savedUser = new User(['id' => 1]);
    $userHelper->shouldReceive('save')->andReturn($savedUser);

    $controller = new UsersController($userHelper, $roleHelper);
    $response = $controller->createUser($request);

    expect($response)->toBeInstanceOf(\Illuminate\Http\RedirectResponse::class);
    expect($response->getSession()->get('success'))->toBe('User added successfully');
});

it('updates a user', function () use ($faker) {
    $userHelper = Mockery::mock(UserHelper::class);
    $roleHelper = mock(RoleHelper::class);

    $user = User::create([
        'name' => $faker->name,
        'email' => $faker->email,
        'role_id' => '2',
        'password' => $faker->password,
        'password_confirm' => $faker->password,
        'profile_picture' => createFakeImage(),
    ]);

    $userHelper = Mockery::mock(UserHelper::class);
    $userHelper->shouldReceive('update')->andReturn($user);

    $requestData = [
        'id' => $user->id,
        'name' => $faker->name,
    ];
    $request = UserUpdateRequest::create('/admin/user/update', 'POST', $requestData);

    DB::shouldReceive('beginTransaction');
    DB::shouldReceive('commit');

    $controller = new UsersController($userHelper, Mockery::mock(RoleHelper::class));

    $response = $controller->updateUser($request);

    $this->assertEquals(302, $response->getStatusCode());
});

it('deletes a user', function () {
    $userHelper = mock(UserHelper::class);
    $roleHelper = mock(RoleHelper::class);

    $request = new UserDeleteRequest(['id' => 1]);

    $user = new User();
    $user->id = 1;

    $userHelper->shouldReceive('getUser')->with(1)->andReturn($user);
    $userHelper->shouldReceive('delete')->with(1)->andReturn(true);

    $user = new User();
    $user->name = 'Test User';
    auth()->login($user);

    $controller = new UsersController($userHelper, $roleHelper);

    $response = $controller->deleteUser($request);

    expect($response->getStatusCode())->toEqual(302);
});

it('returns user list data in DataTables format', function () use ($faker) {
    $userHelperMock = Mockery::mock('App\Helpers\UserHelper');
    $this->instance('App\Helpers\UserHelper', $userHelperMock);

    $users = [];

    for ($i = 0; $i < 4; $i++) {
        $users[] = User::create([
            'name' => $faker->name,
            'email' => $faker->email,
            'role_id' => '2',
            'password' => $faker->password,
            'password_confirm' => $faker->password,
            'profile_picture' => createFakeImage(),
        ]);
    }

    $requestMock = Mockery::mock('Modules\User\Http\Requests\Admin\User\UserListDataRequest');
    $requestMock->shouldReceive('all')->andReturn([]);

    $response = $this->call('POST', 'admin/user/table', [], [], [], [], $requestMock);

    $response->assertJson([]);
});
