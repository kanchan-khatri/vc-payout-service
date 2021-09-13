<?php

namespace App\Helpers;

use App\Helpers\ArrayHelper;

class PayoutHelper {

	public static function splitSoldItemsToPayouts($soldItems, $transactionLimit) {
		$payoutsGroupData = array();
        foreach($soldItems as &$soldItem) {
        	if(!isset($payoutsGroupData[$soldItem['currency']])) {
        		$payoutsGroupData[$soldItem['currency']] = array();
        	}
            $payoutsGroupData[$soldItem['currency']][$soldItem['seller_id']][] = $soldItem;
        }
        $payoutRecords = array();
        $recordIndex = 0;
        foreach($payoutsGroupData as $currencyCode => &$soldItemsForSeller) {
        	foreach($soldItemsForSeller as $sellerId => &$soldItems) {
        		$transactions = ArrayHelper::splitArrayByKey($soldItems, $transactionLimit, 'amount');
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
        return $payoutRecords;
	}

}
?>