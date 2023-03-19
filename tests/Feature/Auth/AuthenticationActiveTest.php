<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Tests\TestCase;

class AuthenticationActiveTest extends TestCase
{
    use DatabaseMigrations,WithFaker,MakesHttpRequests;

    public function testUserLogin()
    {
        $email=$this->faker->safeEmail;
        $password=$this->faker->password;
        $user=User::factory()->create([
            'email'=>$email,
            'password'=>\Hash::make($password),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $email,
            'password' => $password,
        ]);
        $response->assertStatus(ResponseCode::HTTP_OK);
    }

}
