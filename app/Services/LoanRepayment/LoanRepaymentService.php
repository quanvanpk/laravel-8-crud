<?php
namespace App\Services\LoanRepayment;


use App\Repositories\Loan\LoanRepository;
use App\Repositories\LoanRepayment\LoanRepaymentRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class LoanRepaymentService extends BaseService
{
    /** @var LoanRepository */
    protected $loanRepository;
    /** @var LoanRepaymentRepository */
    protected $loanRepaymentRepository;

    /**
     * LoanRepaymentController constructor.
     * @param LoanRepository $loanRepository
     * @param LoanRepaymentRepository $loanRepaymentRepository
     */
    public function __construct(LoanRepository $loanRepository, LoanRepaymentRepository $loanRepaymentRepository)
    {
        $this->loanRepository = $loanRepository;
        $this->loanRepaymentRepository = $loanRepaymentRepository;
    }

    /**
     * @param $user
     * @param $data
     * @return Model|string[]|void
     */
    public function create($user, $data)
    {
        $loan = $this->loanRepository->find($data['loan_id']);
        if (!$loan) {
            return $this->responseServiceError(Config::get('constants.message.resource_not_found'));
        }

        $remainingAmount = $loan->remaining_amount;
        if ($remainingAmount < $data['amount']) {
            return $this->responseServiceError('Repayment amount is bigger than remaining amount');
        }

        $data['remaining_amount'] = $remainingAmount - $data['amount'];
        return $this->loanRepaymentRepository->createLoanRepayment($loan, $data);
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function find($id): ?Model
    {
        return $this->loanRepaymentRepository->find($id);
    }
}