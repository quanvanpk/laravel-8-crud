<?php
namespace App\Http\Controllers\Api;

use App\Http\Resources\LoanResources;
use App\Models\Loan;
use App\Services\Loan\LoanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LoanController extends BaseController
{
    /** @var LoanService */
    protected $loanService;

    /**
     * LoanController constructor.
     * @param LoanService $loanService
     */
    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $loan = $this->loanService->find($id);
        if (!$loan) {
            return $this->responseError(Config::get('constants.message.resource_not_found'), [], 404);
        }

        if (Auth::id() != $loan->user_id) {
            return $this->responseError(Config::get('constants.message.unauthorized'), [], 401);
        }

        return $this->responseSuccess('', new LoanResources($loan));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->all();
        $user = Auth::user();
        $validator = Validator::make($data, [
            'amount'              => 'numeric|required',
            'repayment_frequency' => [ Rule::in(Loan::WEEK_REPAYMENT, Loan::MONTH_REPAYMENT)]
        ]);

        if ($validator->fails()) {
            return $this->responseError(Config::get('constants.message.invalid_validation'), $validator->errors());
        }
        $loan = $this->loanService->create($user, $data);
        return $this->responseSuccess(Config::get('constants.message.create_success'),
                                      new LoanResources($loan), 201);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $loan = $this->loanService->find($id);
        if (!$loan) {
            return $this->responseError(Config::get('constants.message.resource_not_found'), [], 404);
        }

        $data      = $request->all();
        $validator = Validator::make($data, [
            'repayment_frequency' => [Rule::in(Loan::WEEK_REPAYMENT, Loan::MONTH_REPAYMENT)],
            'status' => [Rule::in(Loan::OPEN_STATUS, Loan::CANCELLED_STATUS)]
        ]);

        if ($validator->fails()) {
            return $this->responseError(Config::get('constants.message.invalid_validation'), $validator->errors());
        }

        $loan = $this->loanService->update($loan, $data);
        return $this->responseSuccess(Config::get('constants.message.update_success'), new LoanResources($loan));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $loan = $this->loanService->find($id);
        if (!$loan) {
            return $this->responseError(Config::get('constants.message.resource_not_found'), [], 404);
        }
        $this->loanService->delete($loan); // Should apply delete for open status only
        return $this->responseSuccess(Config::get('constants.message.delete_success'));
    }
}