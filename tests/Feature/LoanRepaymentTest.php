<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoanRepaymentTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateLoanRepaymentWithoutToken()
    {
        $this->post('api/v1/repayments',
                    ["loan_id" => rand(1, 100),
                     "amount"  => rand(100, 500000),
                     "note"    => "Description for loan repayment"],
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

        $this->post('api/v1/loans', ["loan_id" => rand(1, 100),
                                     "amount"  => rand(100, 500000),
                                     "note"    => "Description for loan repayment"], $header)
            ->assertStatus(201)
            ->assertJsonStructure(['status', 'message', 'data']);
    }

    public function testCreateLoanRepaymentWithInvalidAmount()
    {
        $user   = User::factory()->create();
        $token  = $user->createToken('TestToken')->accessToken;
        $header = [
            'Accept'        => 'application/json',
            'Authorization' => "Bearer $token"];

        $this->post('api/v1/loans', ["loan_id" => rand(1, 100),
                                     "amount"  => "invalidAmount",
                                     "note"    => "Description for loan repayment"], $header)
            ->assertStatus(400)
            ->assertJsonStructure(['status', 'message', 'data' => ['amount']]);
    }
}
