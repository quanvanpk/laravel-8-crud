<?php
namespace App\Services\Loan;


use App\Models\Loan;
use App\Repositories\Loan\LoanRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;

class LoanService extends BaseService
{
    /** @var LoanRepository */
    protected $loanRepository;

    /**
     * LoanService constructor.
     * @param LoanRepository $loanRepository
     */
    public function __construct(LoanRepository $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    /**
     * @param $user
     * @param $data
     * @return Model
     */
    public function create($user, $data): Model
    {
        $data['user_id']          = $user->id;
        $data['status']           = Loan::APPROVED_STATUS; //Assuming admin has approved the loan
        $data['interest_rate']    = 0;                     //Assuming interest rate is zero
        $data['recurring_payment_amount'] = $data['amount'] / 4; //Assuming user will pay 4 times
        $data['remaining_amount'] = $data['amount'];
        return $this->loanRepository->create($data);
    }

    /**
     * @param $loan
     * @param $data
     * @return Model
     */
    public function update($loan, $data): Model
    {
        return $this->loanRepository->update($loan, $data);
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function find($id): ?Model
    {
        return $this->loanRepository->find($id);
    }

    /**
     * @param $loan
     * @return bool|mixed|null
     */
    public function delete($loan): ?bool
    {
        return $this->loanRepository->delete($loan);
    }
}