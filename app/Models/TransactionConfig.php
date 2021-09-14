<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionConfig extends Model
{
    use HasFactory;

    public static function getMaxTransactionAmount($currencyCode) {
        $maxAmountRow = self::select(['max_amount'])
            ->where(['currency_code' => $currencyCode])
            ->first();
        if($maxAmountRow->exists()) {
            return $maxAmountRow->max_amount;
        }
        return config('constants.payout.default_transaction_max_amount');
    }
}
