<?php


namespace App\Repositories\LoanRepayment;


use App\Models\LoanRepayment;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanRepaymentRepository extends BaseRepository
{

    /**
     * LoanRepaymentRepository constructor.
     * @param LoanRepayment $loanRepaymentModel
     */
    public function __construct(LoanRepayment $loanRepaymentModel)
    {
        parent::__construct($loanRepaymentModel);
    }


    /**
     * @param $loan
     * @param array $attributes
     * @return mixed
     */
    public function createLoanRepayment($loan, array $attributes)
    {
        DB::beginTransaction();
        try {
            $loanRepayment = $this->model->create($attributes);
            $loan->update(['remaining_amount' => $attributes['remaining_amount']]);
            DB::commit();
            return $loanRepayment;
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}