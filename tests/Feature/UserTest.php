<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test login success
     */
    public function testLoginSuccess()
    {
        $user = User::factory()->create([
                        'password' => bcrypt('miniaspire')
                    ]);

        $this->post('api/v1/auth/login',
                    [
                        'email'    => $user->email,
                        'password' => 'miniaspire'
                    ],
                    ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                      'status',
                      'message',
                      'data' => ['access_token', 'token_type', 'expires_at']
                  ]);
    }

    /**
     * Test login failed
     */
    public function testLoginFailed()
    {
        $user = User::factory()->create([
                        'password' => bcrypt('miniaspire')
                    ]);

        $this->post('api/v1/auth/login',
                    [
                        'email' => $user->email,
                        'password' => 'miniaspirezzz'
                    ],
                    ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJsonStructure([
                      'status',
                      'message',
                      'data'
                  ]);
    }

    /**
     * Test register a user success
     */
    public function testRegisterUserSuccess()
    {
        $userInfo = [
            'name'  => 'Quan Van',
            'email' => 'quanvan111@gmail.com',
            'password' => 'miniaspire'
        ];

        $this->post('api/v1/auth/register',
                    $userInfo,
                    ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                      'status',
                      'message',
                      'data'
                  ]);
    }

    /**
     * Test register a user with invalid email
     */
    public function testRegisterUserWithFailedValidation()
    {
        $userInfo = [
            'name'  => 'Quan Van',
            'email' => 'quanvan1112131l.com',
            'password' => 'miniaspire'
        ];

        $this->post('api/v1/auth/register',
                    $userInfo,
                    ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJsonStructure([
                      'status',
                      'message',
                      'data' => ['email']
                  ]);
    }

}
