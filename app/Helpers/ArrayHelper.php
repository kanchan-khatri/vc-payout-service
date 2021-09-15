<?php

namespace App\Helpers;

use \Exception;

class ArrayHelper {

	public static function splitArrayByKeyThreshold($array, $maxValue, $key) {
		self::sortArrayByKey($array, $key);
		$splitArray = array();
		if($maxValue < $array[0][$key]) {
			throw new Exception('$maxValue can not be less than minimum value of key element');
		}
		$sum = 0;
		$i = 0;
		foreach($array as &$value) {
			$sum += $value[$key];
			if($sum > $maxValue) {
				$sum = $value[$key];
				$i++;
			}
			$splitArray[$i][] = $value;
		}		
		return $splitArray;
	}

	public static function sortArrayByKey(&$array, $key) {
		usort($array, function($a, $b) use ($key) {
			return($a[$key] - $b[$key]);
		});
	}
}
?>