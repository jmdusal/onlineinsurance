<?php

namespace Tests\Feature;

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testUserCanViewLoginPage()
    {
        $response = $this->get('/login');
        $response->assertSuccessful();
    }

    public function testUserCanLoginWithValidCredentials()
    {
        $faker = Factory::create();
        $password = bcrypt($faker->unique()->password);

        $this->user = User::create([
            'name' => $faker->unique()->name,
            'username' => $faker->unique()->username,
            'password' => $password,
            '_token' => \Session::token(),
        ]);

        $response = $this->post('/login', [
            'username' => $this->user->username,
            'password' => $password,
        ]);
        $response->assertStatus(302);
    }
}
