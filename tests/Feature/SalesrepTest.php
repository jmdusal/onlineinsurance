<?php

namespace Tests\Feature;

use App\User;
use App\Salesrep;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class SalesrepTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    protected $user;
    protected $salesrep;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanViewSalesrepIndex()
    {
        $faker = Factory::create();
        $password = bcrypt($faker->unique()->password);

        $this->user = User::create([
            'name' => $faker->unique()->name,
            'username' => $faker->unique()->username,
            'password' => $password,
            '_token' => \Session::token(),
        ]);
        $response = $this->actingAs($this->user)->get('/salesrep/profiles');
        $response->assertSuccessful();
    }

    public function testUserCanCreateSalesrep()
    {
        $faker = Factory::create();
        $password = bcrypt($faker->unique()->password);

        $this->user = User::create([
            'name' => $faker->unique()->name,
            'username' => $faker->unique()->username,
            'password' => $password,
            '_token' => \Session::token(),
        ]);
        $response = $this->actingAs($this->user);


        $response = $this->call('post', 'salesrep/store', [
            'salesrep_name' => 'test test',
            'salesrep_num' => rand(100000, 999999),
            'commission_percent' => 30,
            'tax_rate' => 10,
            'bonus' => 0.00,
        ]);

        $response->assertStatus(200);
    }

    public function testUserCanUpdateSalesrep()
    {
        $faker = Factory::create();
        $password = bcrypt($faker->unique()->password);

        $this->user = User::create([
            'name' => $faker->unique()->name,
            'username' => $faker->unique()->username,
            'password' => $password,
            '_token' => \Session::token(),
        ]);

        $this->salesrep = Salesrep::create([
            'salesrep_name' => 'test test',
            'salesrep_num' => rand(100000, 999999),
            'commission_percent' => 30,
            'tax_rate' => 10,
            'bonus' => 0.00,
        ]);

        Salesrep::where('salesrep_id', $this->salesrep->salesrep_id)->update([
            'salesrep_name' => 'update test',
            'salesrep_num' => $this->salesrep->salesrep_num,
            'commission_percent' => 40,
            'tax_rate' => 15,
            'bonus' => 0.00,
        ]);

        $response = $this->actingAs($this->user);
        $response = $this->patch('/salesrep/update/' . $this->salesrep->salesrep_id);
        $response->assertStatus(200);
    }

    public function testUserCanDeleteSalesrep()
    {
        $this->withoutExceptionHandling();
        $faker = Factory::create();
        $password = bcrypt($faker->unique()->password);

        $this->user = User::create([
            'name' => $faker->unique()->name,
            'username' => $faker->unique()->username,
            'password' => $password,
            '_token' => \Session::token(),
        ]);

        $this->salesrep = Salesrep::create([
            'salesrep_name' => 'test test',
            'salesrep_num' => rand(100000, 999999),
            'commission_percent' => 30,
            'tax_rate' => 10,
            'bonus' => 0.00,
        ]);

        $response = $this->actingAs($this->user);
        $response = $this->delete('/salesrep/destroy/' . $this->salesrep->salesrep_id);
        $response->assertStatus(200);
    }
}
