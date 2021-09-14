<?php

namespace App\Handlers;

use App\Helpers\ArrayHelper;
use App\Models\Payout;
use \Illuminate\Validation\ValidationException;
use App\Models\Item;
use App\Models\TransactionConfig;

class PayoutHandler {

	public function createPayoutsBySoldItems($soldItems) {
		$payoutsGroupData = array();
        foreach($soldItems as &$soldItem) {
            // Validate SoldItem Record
            $invalidSoldItemRecordExists = false;
            $invalidSoldItemRecords = array();
            if(!$this->isValidSoldItemRecord($soldItem)) {
                $invalidSoldItemRecordExists = true;
                $invalidSoldItemRecords[] = $soldItem;
            }

            //Form Multi Dimesional Array forming group of currency and seller
        	if(!isset($payoutsGroupData[$soldItem['currency']])) {
        		$payoutsGroupData[$soldItem['currency']] = array();
        	}
            $payoutsGroupData[$soldItem['currency']][$soldItem['seller_id']][] = $soldItem;
        }
        
        //Throw Error if Invalid SoldItem Records found
        if($invalidSoldItemRecordExists) {
            $error = ValidationException::withMessages(['invalidRecords'=>$invalidSoldItemRecords]);            
            // throw $error;
        }

        //Generate Payouts
        $payoutRecords = array();
        $recordIndex = 0;

        foreach($payoutsGroupData as $currencyCode => &$soldItemsForSeller) {
            
            $maxTransactionAmount = TransactionConfig::getMaxTransactionAmount($currencyCode);

        	foreach($soldItemsForSeller as $sellerId => &$soldItems) {
        		$transactions = ArrayHelper::splitArrayByKey($soldItems, $maxTransactionAmount, 'amount');
        		foreach($transactions as &$records) {
        			$payoutRecords[$recordIndex] = [
        				'seller_id'=>$sellerId,
        				'currency_code' => $currencyCode,
        				'amount' => 0
        			];
        			foreach($records as $payoutItem) {
        				$payoutRecords[$recordIndex]['amount'] += $payoutItem['amount'];
        				$payoutRecords[$recordIndex]['item_id'][] = $payoutItem['item_id'];
        			}
        			$recordIndex++;
        		}
        	}
        }        
        Payout::createRecords($payoutRecords);
	}

    public function isValidSoldItemRecord($soldItem)
    {
        $row = [
                'id' => $soldItem['item_id'], 
                'currency_code' => $soldItem['currency'],
                'seller_id' => $soldItem['seller_id']
            ];
        return Item::where($row)->exists();
    }

}
?>