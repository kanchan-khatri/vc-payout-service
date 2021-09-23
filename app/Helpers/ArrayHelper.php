<?php

namespace App\Helpers;

use \Exception;

class ArrayHelper {

	public static function splitArrayByKeyThreshold($inputList, $maxValue, $key) {
		$splitArray = array();
		if($maxValue <= 0) {
			throw new Exception('$maxValue can not be <= 0');
		}
		// Handle record value more than maxvalue case. Split by fraction
		$repeatRecords = 0;
		foreach($inputList as &$value) {
			if($value[$key] > $maxValue) {
				$repeatNo = floor($value[$key] / $maxValue);
				$lastRecordValue = ($value[$key] - ($maxValue * $repeatNo));
				$startIndex = count($inputList) - 1;
				$value[$key] = $maxValue;
				$fillSplitRecords = array_fill($startIndex, $repeatNo, $value);
				foreach($fillSplitRecords as $splitRecord) {
					array_push($inputList, $splitRecord);
				}
				$value[$key] = $lastRecordValue;
			}
		}
		// Sort the formed array
		self::sortArrayByKey($inputList, $key);

		$sum = 0;
		$i = 0;
		foreach($inputList as &$value) {
			$sum += $value[$key];
			if($sum > $maxValue) {
				$sum = $value[$key];
				$i++;
			}
			$splitArray[$i][] = $value;
		}
		return $splitArray;
	}

	public static function sortArrayByKey(&$inputList, $key) {
		usort($inputList, function($a, $b) use ($key) {
			return($a[$key] - $b[$key]);
		});
	}
}
?>