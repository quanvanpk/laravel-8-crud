<?php
namespace App\Http\Controllers\Api;

use App\Http\Resources\LoanRepaymentResources;
use App\Services\LoanRepayment\LoanRepaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

/**
 * Class LoanRepaymentController
 * @package App\Http\Controllers\Api
 */
class LoanRepaymentController extends BaseController
{
    /** @var LoanRepaymentService */
    protected $loanRepaymentService;

    public function __construct(LoanRepaymentService $loanRepaymentService)
    {
        $this->loanRepaymentService = $loanRepaymentService;
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
            'loan_id' => 'required',
            'amount'  => 'numeric|required'
        ]);

        if ($validator->fails()) {
            return $this->responseError(Config::get('constants.message.invalid_validation'), $validator->errors());
        }

        $loanRepaymentResponse = $this->loanRepaymentService->create($user, $data);
        if (isset($loanRepaymentResponse['error']))
        {
            return $this->responseError($loanRepaymentResponse['error']);
        }

        return $this->responseSuccess(Config::get('constants.message.create_success'),
                                      new LoanRepaymentResources($loanRepaymentResponse), 201);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $loanRepayment = $this->loanRepaymentService->find($id);
        if (!$loanRepayment) {
            return $this->responseError(Config::get('constants.message.resource_not_found'), [], 404);
        }
        return $this->responseSuccess('', new LoanRepaymentResources($loanRepayment));
    }

}