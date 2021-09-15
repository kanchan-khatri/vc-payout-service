<?php

namespace App\Handlers;

use App\Helpers\ArrayHelper;
use App\Models\Payout;
use \Illuminate\Validation\ValidationException;
use App\Models\Item;
use App\Models\TransactionConfig;

class PayoutHandler {

    /**
     * Creates the payouts for given sold items list
     * Categorises payouts for seller and currency and generates payout-records
     * based on the max transaction value configured for each currency
     * Also, maps payout items for every payout transaction
     * Throws Error
     * @return PayoutRecords
     */
	public function createPayoutsBySoldItems($soldItems) {
		$payoutsGroupData = array();
        foreach($soldItems as &$soldItem) {
            
            //Validate SoldItem Record
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
            throw $error;
        }

        //Generate Payouts
        $payoutRecords = array();
        $recordIndex = 0;

        foreach($payoutsGroupData as $currencyCode => &$soldItemsForSeller) {
            
            $maxTransactionAmount = TransactionConfig::getMaxTransactionAmount($currencyCode);

        	foreach($soldItemsForSeller as $sellerId => &$soldItems) {
        		$transactions = ArrayHelper::splitArrayByKeyThreshold($soldItems, $maxTransactionAmount,'amount');
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
        return $payoutRecords;
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