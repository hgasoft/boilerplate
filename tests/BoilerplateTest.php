<?php

namespace Sebastienheyd\Boilerplate\Tests;

use DB;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

class BoilerplateTest extends TestCase
{
    public function testBoilerplate()
    {
        $this->register();
        $this->role();
    }

    public function register()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
        $response->assertStatus(302);

        $response = $this->get('/admin/login');
        $response->assertRedirect('/admin/register');
        $response->assertStatus(302);

        Gravatar::shouldReceive('exists')->once()->with($this->email)->andReturn(false);

        $response = $this->post('/admin/register', [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password
        ]);
        $response->assertRedirect('/admin');
        $response->assertStatus(302);

        $user = DB::table('users')->first();
        $this->assertTrue($user->email === $this->email);
    }

    public function role()
    {
        $user = DB::table('users')->first();
        $this->assertTrue($user->email === $this->email);
    }

}
