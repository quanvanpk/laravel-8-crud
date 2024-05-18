<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    const OPEN_STATUS = 'Open';
    const APPROVED_STATUS = 'Approved';
    const COMPLETED_STATUS = 'Completed';
    const CANCELLED_STATUS = 'Cancelled';
    const WEEK_REPAYMENT = 'Week';
    const MONTH_REPAYMENT = 'Month';

    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'amount',
        'recurring_payment_amount',
        'remaining_amount',
        'interest_rate',
        'repayment_frequency',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loanRepayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }
}
