<?php

use App\Models\Loan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Loans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->double('amount');
            $table->double('recurring_payment_amount');
            $table->double('remaining_amount');
            $table->float('interest_rate')->nullable();
            $table->enum('repayment_frequency', [Loan::WEEK_REPAYMENT, Loan::MONTH_REPAYMENT]);
            $table->enum('status', [Loan::OPEN_STATUS, Loan::APPROVED_STATUS, Loan::COMPLETED_STATUS, Loan::CANCELLED_STATUS]);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
