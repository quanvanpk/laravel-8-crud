<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateLoanWithoutToken()
    {
        $this->post('api/v1/loans',
                    ["amount"              => 2000,
                     "repayment_frequency" => "Week"],
                    ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(["type" => "authentication_error", "message" => "Bad credentials"]);
    }

    public function testCreateLoanSuccess()
    {
        $user   = User::factory()->create();
        $token  = $user->createToken('token')->accessToken;
        $header = [
            'Accept'        => 'application/json',
            'Authorization' => "Bearer $token"];

        $this->post('api/v1/loans', ["amount" => 2000, "repayment_frequency" => "Week"], $header)
             ->assertStatus(201)
            ->assertJsonStructure(['status', 'message', 'data']);
    }

    public function testCreateLoanWithInvalidAmount()
    {
        $user   = User::factory()->create();
        $token  = $user->createToken('token')->accessToken;
        $header = [
            'Accept'        => 'application/json',
            'Authorization' => "Bearer $token"];

        $this->post('api/v1/loans', ["amount" => "invalidAmount", "repayment_frequency" => "Week"], $header)
            ->assertStatus(400)
            ->assertJsonStructure(['status', 'message', 'data' => ['amount']]);
    }
}
