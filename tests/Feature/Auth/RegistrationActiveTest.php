<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class RegistrationActiveTest extends TestCase
{
    use DatabaseMigrations,WithFaker,MakesHttpRequests;

    public function testUserRegistrationWithValidData()
    {
        [$first_name, $last_name, $email, $response] = $this->createUser();

        $response->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJson([
                'success' => true,
                'data' => [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'role_id' => Role::where('name', \App\Enums\RoleEnum::UNVERIFIED_USER->value)->first()->id,
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);
    }

    public function testUserRegistrationWithInvalidData()
    {
        $response = $this->postJson('/api/register', [
            'first_name' => '',
            'last_name' => $this->faker->lastName,
            'email' => 'invalid-email',
            'password' => 'pass',
        ]);

        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors([
            'first_name', 'email', 'password',
        ]);
    }

    public function createUser(): array
    {
        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        $email = $this->faker->safeEmail;
        $password = $this->faker->password;

        $response = $this->postJson('/api/register', [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        return [$first_name, $last_name, $email, $response];
    }

    public function testUserRegistrationWithDuplicateEmail()
    {
        [$first_name, $last_name, $email, $response] = $this->createUser();

        $response = $this->postJson('/api/register', [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['email']);
    }
}
