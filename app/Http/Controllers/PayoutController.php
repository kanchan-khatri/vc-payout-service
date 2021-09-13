<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payout;
use App\Helpers\PayoutHelper;
use App\Helpers\ResponseHelper;
use \Validator;
use \Exception;

class PayoutController extends Controller
{
    public function index()
    {
        return Payout::all();
    }

    public function generate(Request $request)
    {
        try {            
            $requestArr = $request->json()->all();
            $validator = Validator::make($request->all(), [
                'soldItems' => 'required|array|min:1',
                "soldItems.*.item_id" => "required|integer",
                "soldItems.*.amount" => "required|numeric",
                "soldItems.*.currency" => "required|string|size:3",
                "soldItems.*.seller_id" => "required|integer",
            ]);
            if ($validator->fails()) {
                return ResponseHelper::getFailedResponse($validator->messages(), 422);
            }
            $transactionLimit = config('constants.payout.transaction_limit');
            $payoutsData = PayoutHelper::splitSoldItemsToPayouts($requestArr['soldItems'], 
                $transactionLimit);
            Payout::createRecords($payoutsData);
            return ResponseHelper::getSuccessResponse($payoutsData);
        } catch (Exception $e) {
            return ResponseHelper::getFailedResponse($e->getMessage(),500);
        }
    }
}