<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanRepaymentResources extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'loan_id'   => $this->loan_id,
            'amount'    => $this->amount,
            'note'      => $this->note,
            'create_at' => $this->created_at->format('d-m-y H:i:s')
        ];
    }
}