<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class LoanResources
 * @package App\Http\Resources
 */
class LoanResources extends JsonResource
{

    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                  => $this->id,
            'amount'              => $this->amount,
            'remaining_amount'    => $this->remaining_amount,
            'interest_rate'       => $this->interest_rate,
            'repayment_frequency' => $this->repayment_frequency,
            'status'              => $this->status,
            'recurring_payment_amount' => $this->recurring_payment_amount,
            'create_at'           => $this->created_at->format('d-m-y H:i:s')
        ];
    }
}