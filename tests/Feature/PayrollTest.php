<?php

namespace Tests\Feature;

use App\User;
use App\Salesrep;
use App\Payroll;
use App\Client;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use DB;

class PayrollTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    protected $user;
    protected $salesrep;
    protected $payroll;
    protected $client;
    protected $attributes;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanViewPayrollPDFIndex()
    {
        $faker = Factory::create();
        $password = bcrypt($faker->unique()->password);

        $this->user = User::create([
            'name' => $faker->unique()->name,
            'username' => $faker->unique()->username,
            'password' => $password,
            '_token' => \Session::token(),
        ]);
        $response = $this->actingAs($this->user)->get('/payroll/index');
        $response->assertSuccessful();
    }

    public function testUserCanCreatePayroll()
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
            'salesrep_name' => 'testtest',
            'salesrep_num' => rand(100000, 999999),
            'commission_percent' => 30,
            'tax_rate' => 10,
            'bonus' => 0.00,
        ]);

        $this->client = array([
            'client_name' => 'test client 1',
            'client_email' => 'test@test.com',
            'client_commission' => 100.00,
            'payroll_id' => 1,
        ]);

        $response = $this->actingAs($this->user);
        $response = $this->call(
            'post',
            'payroll/store',
            [
                'salesrep_id' => $this->salesrep->salesrep_id,
                'date_period' => '2/12/2023 - 2/18/2023',
                'payroll_bonus' => 100.00,
                'client' =>  $this->client
            ]
        );
        $response->assertStatus(200);
    }

    public function testUserCanUpdatePayroll()
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
            'salesrep_name' => 'testtest',
            'salesrep_num' => rand(100000, 999999),
            'commission_percent' => 30,
            'tax_rate' => 10,
            'bonus' => 0.00,
        ]);

        $this->client = array([
            'client_name' => 'test client 1',
            'client_email' => 'test1@test1.com',
            'client_commission' => 100.00,
            'payroll_id' => 1,
        ]);

        $client_update = array([
            'client_name' => 'test client 2',
            'client_email' => 'test2@test2.com',
            'client_commission' => 100.00,
            'payroll_id' => 1,
        ]);

        $this->payroll = Payroll::create([
            'salesrep_id' => $this->salesrep->salesrep_id,
            'date_period' => '5/12/2023 - 5/18/2023',
            'payroll_bonus' => 100.00,
            'client' => $this->client
        ]);

        Payroll::where('payroll_id', $this->payroll->payroll_id)->update([
            'salesrep_id' => $this->salesrep->salesrep_id,
            'date_period' => '4/12/2023 - 4/18/2023',
            'payroll_bonus' => 200.00,
        ]);

        $response = $this->actingAs($this->user);
        $response = $this->patch('/payroll/update/' . $this->payroll->payroll_id . '', [
            'client' => $client_update
        ]);
        $response->assertStatus(200);
    }

    public function testUserCanViewGeneratePDF()
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
            'salesrep_name' => 'testtest',
            'salesrep_num' => rand(100000, 999999),
            'commission_percent' => 30,
            'tax_rate' => 10,
            'bonus' => 0.00,
        ]);

        $this->client = array([
            'client_name' => 'test client 1',
            'client_email' => 'test@test.com',
            'client_commission' => 100.00,
            'payroll_id' => 1,
        ]);

        $this->payroll = Payroll::create([
            'salesrep_id' => $this->salesrep->salesrep_id,
            'date_period' => '2/12/2023 - 2/18/2023',
            'payroll_bonus' => 100.00,
            'client' =>  $this->client
        ]);

        $response = $this->actingAs($this->user);
        $response = $this->actingAs($this->user)->get('/payroll/pdf/' . $this->payroll->payroll_id);
        $response->assertStatus(200);
    }

    public function testUserCanDeletePayroll()
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

        $this->client = array([
            'client_name' => 'test client 1',
            'client_email' => 'test@test.com',
            'client_commission' => 100.00,
            'payroll_id' => 1,
        ]);

        $this->payroll = Payroll::create([
            'salesrep_id' => $this->salesrep->salesrep_id,
            'date_period' => '2/12/2023 - 2/18/2023',
            'payroll_bonus' => 100.00,
            'client' => $this->client
        ]);

        $response = $this->actingAs($this->user);
        $response = $this->delete('/payroll/destroy/' . $this->payroll->payroll_id);
        $response->assertStatus(200);
    }
}
