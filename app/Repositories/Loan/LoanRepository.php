<?php


namespace App\Repositories\Loan;


use App\Models\Loan;
use App\Repositories\BaseRepository;

class LoanRepository extends BaseRepository
{
    /**
     * LoanRepository constructor.
     * @param Loan $loanModel
     */
    public function __construct(Loan $loanModel)
    {
        parent::__construct($loanModel);
    }


}