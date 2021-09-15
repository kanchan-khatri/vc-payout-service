<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payout;
use App\Handlers\PayoutHandler;
use App\Helpers\ResponseHelper;
use \Validator;
use \Exception;
use Illuminate\Validation\Rule;

class PayoutController extends Controller
{
    public $payoutHandlerObj;

    public function __construct() {
      $this->payoutHandlerObj = new PayoutHandler();
    }



    /**
     * Creates the payouts for given sold items list
     * Returns success/failed response
     * @return response
     */
    public function createPayouts(Request $request)
    {
        try {
            
            //Using Validator to validate the input request payload.
            $requestPayload = $request->json()->all();
            $validator = Validator::make($request->all(), [
                'soldItems' => 'required|array|min:1',
                "soldItems.*.item_id" => "required|integer",
                "soldItems.*.amount" => "required|numeric",
                "soldItems.*.currency" => [
                    "required",
                    "string",
                    "size:3", 
                    Rule::In(config('constants.payout.supported_currencies'))
                ],
                "soldItems.*.seller_id" => "required|integer",
            ]);

            if ($validator->fails()) {
                return ResponseHelper::getFailedResponse($validator->messages(), 422);
            }

            $payoutsData = $this->payoutHandlerObj->
                createPayoutsBySoldItems($requestPayload['soldItems']);
            return ResponseHelper::getSuccessResponse($payoutsData);

        } catch (Exception $e) {
            return ResponseHelper::getFailedResponse($e->getMessage(),500);
        }
    }

    /**
     * Get All Payout Records
     *
     * @return void
     */
    public function index()
    {
        return Payout::all();
    }
}