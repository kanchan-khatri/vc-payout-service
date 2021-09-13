<?php

namespace App\Helpers;

class ResponseHelper {

	public static function getFailedResponse($errorsMap, $httpStatusCode) {
		$responseData = ['success'=>false, 'error'=>$errorsMap];
		return response()->json($responseData, $httpStatusCode);
	}

	public static function getSuccessResponse($data, $httpStatusCode=201) {
		$responseData = ['success'=>true, 'data'=>$data];
		return response()->json($responseData, $httpStatusCode);
	}

}
?>