<?php

namespace App\Helpers;

class ArrayHelper {

	public static function splitArrayByKey($array, $maxValue, $key) {		
		self::sortArrayByKey($array, $key);
		$splitArray = array();
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